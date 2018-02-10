
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Po_orders_model extends CI_Model {


	public function get_po_orders( $start, $limit)
	{

	    $sql ="  SELECT p.* , os.name po_order_status_name ,os.priority_color , os.icon_font FROM  po_orders p INNER JOIN po_order_status os ON os.id =  p.po_order_status_id  ORDER BY p.id DESC LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_po_orders_count()
	{
		$sql =" SELECT COUNT(id) as connt_id FROM  po_orders p ";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];

	}


	public function get_po_orders_id($po_orders_id)
	{
		$sql =" SELECT p.* , os.name po_order_status_name , os.priority_color , os.icon_font FROM  po_orders p INNER JOIN po_order_status os ON os.id =  p.po_order_status_id
				 WHERE p.id = '".$po_orders_id."'";

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function get_po_orders_detail_id($po_orders_id)
	{
		$sql ="SELECT od.* ,  IFNULL(p.sku,'') sku, IFNULL(p.name,'') product_name FROM po_order_detail od
		LEFT JOIN products p ON od.product_id = p.id WHERE od.po_order_id = '".$po_orders_id."'";

		$query = $this->db->query($sql);
		$row = $query->result_array();
		return $row;
	}

	public function get_po_order_status()
	{
		$sql ="SELECT * FROM po_order_status";

		$query = $this->db->query($sql);
		$row = $query->result_array();
		return $row;
	}

	public function get_po_order_status_history($po_orders_id)
	{
		$sql =" SELECT oh.* , os.name po_order_status_name
				from po_order_status_history  oh
				LEFT JOIN po_order_status os ON oh.po_order_status_id = os.id
				where oh.po_order_id ='".$po_orders_id."' ORDER BY oh.create_date DESC";

		$query = $this->db->query($sql);
		$row = $query->result_array();
		return $row;
	}


	public function update_status($po_orders_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_po_order_status = array(
			'po_order_status_id' => $this->input->post('select_status'),
			'description' => $this->input->post('description'),
			'po_order_id' => $po_orders_id,
			'create_date' => date("Y-m-d H:i:s"),
		);
		$this->db->insert("po_order_status_history", $data_po_order_status);


		$data_order = array(
			'po_order_status_id' => $this->input->post('select_status')
		);

		$where = "id = '".$po_orders_id."'";
		$this->db->update("po_orders", $data_order, $where);



		if($this->input->post('select_status')== "5"){
			// remove stock

			$rows = $this->get_po_orders_detail_id($po_orders_id);
			foreach ($rows as $row) {

				$sql =" SELECT COUNT(product_id) as connt_id FROM  stock WHERE product_id ='".$row['product_id']."' AND po_order_id ='".$po_orders_id."'";

				$query = $this->db->query($sql);
				$r = $query->row_array();
				if( $r['connt_id']==0 ) {
					$data_stock = array(
						'product_id' =>  $row['product_id'],
						'po_order_id' => $po_orders_id,
						'number'=> $row['quantity']
					);
					$this->db->insert("stock", $data_stock);

					//update product
					$sql_update ="UPDATE products SET stock = stock-".$row['quantity']." WHERE id =".$row['product_id']." ";
					$this->db->query($sql_update);
				}
			}
		}

		if($this->input->post('select_status')== "9"){

			$rows = $this->get_po_orders_detail_id($po_orders_id);
			foreach ($rows as $row) {
				$sql =" SELECT COUNT(product_id) as connt_id FROM  stock WHERE product_id ='".$row['product_id']."' AND po_order_id ='".$po_orders_id."'";

				$query = $this->db->query($sql);
				$r = $query->row_array();
				if( $r['connt_id']>0 ) {
					$data_stock = array(
						'product_id' =>  $row['product_id'],
						'po_order_id' => $po_orders_id,
						'number'=> $row['quantity']
					);
					$this->db->delete("stock", $data_stock);

					//update product
					$sql_update ="UPDATE products SET stock = stock+".$row['quantity']." WHERE id =".$row['product_id']." ";
					$this->db->query($sql_update);
				}
			}

		}

	}

	public function update_tracking($po_orders_id)
	{
		$data_order = array(
			'trackpost' => $this->input->post('tracking')
		);

		$where = "id = '".$po_orders_id."'";
		$this->db->update("po_orders", $data_order, $where);

	}

	public function reset_order($po_orders_id)
	{
		$getorder = $this->get_po_orders_id($po_orders_id);
		$getorder_detail = $this->get_po_orders_detail_id($po_orders_id);

		if($getorder['is_tax']!= 1){

			$total = 0;
			$linenumber= 0;
			$quantity= 0;
			//detail
			foreach ($getorder_detail as $detail) {
				$total += $detail['quantity']*$detail['price'];
				$quantity +=$detail['quantity'];

				$data_order_detail = array(
					'vat' => 0,
					'total'=> $detail['quantity']*$detail['price'],
					'linenumber'=> $linenumber+1,
				);

				$where = array('po_order_id' => $po_orders_id, 'product_id' => $detail['product_id']);
				$this->db->update("po_order_detail", $data_order_detail, $where);
			}

			$data_order = array(
				'is_tax' => 0,
				'vat' => 0,
				'quantity' => $quantity,
				'total'=> $total+$getorder['shipping_charge'] ,
			);

			$where = "id = '".$po_orders_id."'";
			$this->db->update("po_orders", $data_order, $where);
		}
		else {

			$total = 0;
			$vat  = 0;
			$linenumber = 0;
			$quantity= 0;
			//detail
			foreach ($getorder_detail as $detail) {

				$vatthis = (($detail['quantity']*$detail['price']) * 7) /107;
				$vat += $vatthis;
				$total += $detail['quantity']*$detail['price'] + ($vatthis);
				$quantity +=$detail['quantity'];

				$data_order_detail = array(
					'vat' => $vatthis,
					'total'=> $detail['quantity']*$detail['price'] +  $vatthis,
					'linenumber'=> $linenumber+1,
				);

				$where = array('po_order_id' => $po_orders_id, 'product_id' => $detail['product_id']);
				$this->db->update("po_order_detail", $data_order_detail, $where);
			}

			$data_order = array(
				'is_tax' => 1,
				'quantity' => $quantity,
				'vat' => $vat,
				'total'=> $total+$getorder['shipping_charge'] ,
			);

			$where = "id = '".$po_orders_id."'";
			$this->db->update("po_orders", $data_order, $where);
		}

	}

	public function update_tax($po_orders_id)
	{
		$data_order = array(
			'is_tax' => $this->input->post('is_tax')
		);

		$where = array('id' => $po_orders_id);
		$this->db->update("po_orders", $data_order, $where);
		$this->reset_order($po_orders_id);
	}



	public function update_invoice($po_orders_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_order = array(
			'is_invoice' => $this->input->post('is_invoice'),
			'invoice_date' => date("Y-m-d H:i:s"),
			'invoice_docno' => 'IN'.date("ymd").str_pad($po_orders_id, 4, "0", STR_PAD_LEFT)
		);

		$where = array('id' => $po_orders_id);
		$this->db->update("po_orders", $data_order, $where);
		$this->reset_order($po_orders_id);
	}


	public function update_order_item($po_orders_id, $po_product_id)
	{
		$data_order_detail = array(
				'product_id' => $po_product_id,
				'quantity'=> $this->input->post('quantity'),
				'price'=> $this->input->post('price'),
			);

			$where = array('po_order_id' => $po_orders_id, 'product_id' => $po_product_id);
			$this->db->update("po_order_detail", $data_order_detail, $where);
			$this->reset_order($po_orders_id);
	}

	public function update_order_add($po_orders_id)
	{

		 $sql ="SELECT * FROM products WHERE  sku LIKE '%".$this->input->post('sku')."%' LIMIT 1";
			$query = $this->db->query($sql);
			$row = $query->row();

			if (isset($row)) {

				$data_order_detail = array(
				'product_id' => $row->id,
				'po_order_id' => $po_orders_id,
				'quantity'=> 0,
				'price'=> 0,
			);
			$where = array('po_order_id' => $po_orders_id, 'product_id' => $po_product_id);
			$this->db->delete("po_order_detail", $where);
			$this->db->insert("po_order_detail", $data_order_detail);
			$this->reset_order($po_orders_id);
			}
	}


	public function update_tax_info($po_orders_id)
	{
		$data_order = array(
			'tax_address' => $this->input->post('tax_address'),
			'tax_id' =>$this->input->post('tax_id'),
			'tax_company'=> $this->input->post('tax_company')
		);

		$where = "id = '".$po_orders_id."'";
		$this->db->update("po_orders", $data_order, $where);
	}

	public function update_info($po_orders_id)
	{
		$data_order = array(
			'address' => $this->input->post('address'),
			'shipping' =>$this->input->post('shipping'),
			'email'=> $this->input->post('email'),
			'tel'=> $this->input->post('tel'),
		);

		$where = "id = '".$po_orders_id."'";
		$this->db->update("po_orders", $data_order, $where);
	}

	public function update_shipping_charge($po_orders_id)
	{
		$data_order = array(
			'shipping_charge' => $this->input->post('shipping_charge'),
		);
		$where = "id = '".$po_orders_id."'";
		$this->db->update("po_orders", $data_order, $where);
		$this->reset_order($po_orders_id);
	}

	public function update_delete_item($po_orders_id, $po_product_id)
	{
		$where = array('po_order_id' => $po_orders_id, 'product_id' => $po_product_id);
		$this->db->delete("po_order_detail",$where);
		$this->reset_order($po_orders_id);
	}

	public function get_po_orders_search()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_po_orders = array(
			'search' => $this->input->post('search'),
			'po_order_id' => $this->input->post('po_order_id')
		);

		$sql ="SELECT p.* , os.name po_order_status_name FROM  po_orders p INNER JOIN po_order_status os ON os.id =  p.po_order_status_id WHERE  1=1 ";

				 if($data_po_orders['po_order_id'] !="")
				 {
				 	$sql = $sql." AND p.id ='".$data_po_orders['po_order_id']."'";
				 }

				 if($this->input->post('select_status') !="0")
				 {
				 	$sql = $sql." AND os.id ='".$this->input->post('select_status')."'";
				 }

				 $sql = $sql." AND (p.name LIKE '%".$data_po_orders['search']."%'
								 OR  p.id LIKE '%".$data_po_orders['search']."%'
								 OR  p.trackpost LIKE '%".$data_po_orders['search']."%') ";



		$re = $this->db->query($sql);
		$return_data['result_po_orders'] = $re->result_array();
		$return_data['data_search'] = $data_po_orders;
		$return_data['sql'] = $sql;
		return $return_data;
	}



}

/* End of file po_orders_model.php */
/* Location: ./application/models/po_orders_model.php */
