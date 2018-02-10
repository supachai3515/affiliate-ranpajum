<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class return_receive_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('Initdata_model');
	}

	public function get_return_receive( $start, $limit)
	{

	    $sql ="  SELECT  rr.*,
	    		o.id order_id, o.invoice_docno invoice_no,
	    		o.`name` order_name,
				o.address,
				(SELECT docno FROM credit_note WHERE is_active = 1 AND return_id = rr.id) credit_note_docno,
				(SELECT docno FROM delivery_return WHERE is_active = 1 AND return_id = rr.id) delivery_return_docno ,
				o.date order_date,
				s.serial_number,
				p.id product_id,
				p.name product_name,
				p.sku
				FROM return_receive  rr INNER JOIN orders o ON rr.order_id = o.id
				INNER JOIN products p on p.id = rr.product_id
				LEFT JOIN product_serial s ON s.product_id = rr.product_id  AND s.order_id = o.id AND rr.serial = s.serial_number

				 ORDER BY rr.id DESC  LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_return_receive_count()
	{
		$sql =" SELECT COUNT(id) as connt_id FROM  return_receive p";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];

	}


	public function get_return_receive_id($return_receive_id)
	{
		$sql ="SELECT  rr.*,
	    		o.id order_id, o.invoice_docno invoice_no,
	    		o.`name` order_name,
					od.price,
				o.address,
				(SELECT docno FROM credit_note WHERE is_active = 1 AND return_id = rr.id) credit_note_docno,
				(SELECT docno FROM delivery_return WHERE is_active = 1 AND return_id = rr.id) delivery_return_docno ,
				o.date order_date,
				s.serial_number,
				p.id product_id,
				p.name product_name,
				p.sku
				FROM return_receive  rr INNER JOIN orders o ON rr.order_id = o.id
				INNER JOIN order_detail od ON od.order_id = o.id AND od.product_id = rr.product_id
				INNER JOIN products p on p.id = rr.product_id
				LEFT JOIN product_serial s ON s.product_id = rr.product_id  AND s.order_id = o.id AND rr.serial = s.serial_number
				WHERE rr.id = '".$return_receive_id."'";

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}


  public function get_return_receive_search()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_return_receive = array(
			'search' => $this->input->post('search')
		);

		$sql =" SELECT  rr.*,
	    		o.id order_id, o.invoice_docno invoice_no,
	    		o.`name` order_name,
				o.address,
				(SELECT docno FROM credit_note WHERE is_active = 1 AND return_id = rr.id) credit_note_docno,
				(SELECT docno FROM delivery_return WHERE is_active = 1 AND return_id = rr.id) delivery_return_docno ,
				o.date order_date,
				s.serial_number,
				p.id product_id,
				p.name product_name,
				p.sku
				FROM return_receive  rr INNER JOIN orders o ON rr.order_id = o.id
				INNER JOIN products p on p.id = rr.product_id
				LEFT JOIN product_serial s ON s.product_id = rr.product_id  AND s.order_id = o.id AND rr.serial = s.serial_number
				 WHERE rr.docno LIKE '%".$data_return_receive['search']."%' OR  o.id LIKE '%".$data_return_receive['search']."%'  OR  s.serial_number LIKE '%".$data_return_receive['search']."%'  OR  o.name LIKE '%".$data_return_receive['search']."%' ";
		$re = $this->db->query($sql);
		$return_data['result_return_receive'] = $re->result_array();
		$return_data['data_search'] = $data_return_receive;
		$return_data['sql'] = $sql;
		return $return_data;
	}

	public function update_return_receive($return_receive_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_return_receive = array(
			'comment' => $this->input->post('comment'),
			'modified_date' => date("Y-m-d H:i:s"),
			'is_cut_stock' => $this->input->post('is_cut_stock'),
			'is_active' => $this->input->post('is_active')
		);
		$where = array(
			'id' => $return_receive_id,
		);
		$this->db->update("return_receive", $data_return_receive, $where );

		$is_active = $this->input->post('is_active');
		$is_cut_stock = $this->input->post('is_cut_stock');

		if($is_active){
			if($is_cut_stock == "1")
			{
				$sql =" SELECT COUNT(product_id) as connt_id FROM  stock WHERE  return_receive_id ='".$return_receive_id."' AND is_active = 1 AND number = 1 AND product_id = '".$this->input->post('product_id')."'";
				$query = $this->db->query($sql);
				$r = $query->row_array();

				if( $r['connt_id'] == 0 ) {

					$data_stock = array(
						'product_id' =>  $this->input->post('product_id'),
						'return_receive_id' => $return_receive_id,
						'number'=> 1
					);
					$this->db->insert("stock", $data_stock);

					//update product
					$sql_update ="UPDATE products SET stock = stock+1  WHERE id = '".$this->input->post('product_id')."' ";
					$this->db->query($sql_update);

				}
			}

			$serial = $this->input->post('serial');
			if (isset($serial )) {
				//update history
				date_default_timezone_set("Asia/Bangkok");
				$data_serial_history = array(
						'serial_number' =>$this->input->post('serial'),
						'product_id' => $this->input->post('product_id'),
						'comment' => "ยันยันการรับคืน เลขที่ใบรับคืน #".$this->input->post('docno'),
						'create_date' => date("Y-m-d H:i:s"),
				);
				$this->db->insert("serial_history", $data_serial_history);
			}

		}
		else {

			$serial = $this->input->post('serial');
			if (isset($serial )) {
				//update history
				date_default_timezone_set("Asia/Bangkok");
				$data_serial_history = array(
						'serial_number' =>$this->input->post('serial'),
						'product_id' => $this->input->post('product_id'),
						'comment' => "ยกเลิกการรับคืน เลขที่ใบรับคืน #".$this->input->post('docno'),
						'create_date' => date("Y-m-d H:i:s"),
				);
				$this->db->insert("serial_history", $data_serial_history);
			}


			if($is_cut_stock == "1")
			{
					$sql =" SELECT COUNT(product_id) as connt_id FROM  stock WHERE  return_receive_id ='".$return_receive_id."' AND is_active = 1 AND number = 1 AND product_id = '".$this->input->post('product_id')."'";

					$query = $this->db->query($sql);
					$r = $query->row_array();
					if( $r['connt_id'] > 0 ) {
						$data_stock = array(
						'product_id' =>  $this->input->post('product_id'),
						'return_receive_id' => $return_receive_id ,
						'number'=> 1,
					);

					$this->db->delete("stock", $data_stock);
					//update product
					$sql_update ="UPDATE products SET stock = stock-1 WHERE id = '".$this->input->post('product_id')."' ";
					$this->db->query($sql_update);
				}
			}
		}

	}

	public function save_return_receive()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_return_receive = array(
			'order_id' => $this->input->post('order_id'),
			'product_id' => $this->input->post('product_id'),
			'serial' => $this->input->post('serial'),
			'comment' => $this->input->post('comment'),
			'is_cut_stock' => $this->input->post('is_cut_stock'),
			'create_date' => date("Y-m-d H:i:s"),
			'modified_date' => date("Y-m-d H:i:s"),
			'is_active' => $this->input->post('isactive')
		);

		$this->db->insert("return_receive", $data_return_receive);
		$insert_id = $this->db->insert_id();


		date_default_timezone_set("Asia/Bangkok");
		$data_order = array(
			'docno' => 'RT'.date("ymd").str_pad($insert_id, 4, "0", STR_PAD_LEFT)
		);

		$where = array('id' => $insert_id);
		$this->db->update("return_receive", $data_order, $where);

		$serial = $this->input->post('serial');
		if (isset($serial )) {
			//update history
			date_default_timezone_set("Asia/Bangkok");
			$data_serial_history = array(
					'serial_number' =>$this->input->post('serial'),
					'product_id' => $this->input->post('product_id'),
					'comment' => "ยันยันการรับคืน เลขที่ใบรับคืน #".$data_order['docno'],
					'create_date' => date("Y-m-d H:i:s"),
			);
			$this->db->insert("serial_history", $data_serial_history);
		}


		$is_cut_stock = $this->input->post('is_cut_stock');
		if($is_cut_stock)
		{
			$data_stock = array(
				'product_id' =>  $this->input->post('product_id'),
				'return_receive_id' => $insert_id,
				'number'=> 1
			);
			$this->db->insert("stock", $data_stock);

			//update product
			$sql_update ="UPDATE products SET stock = stock+1  WHERE id = '".$this->input->post('product_id')."' ";
			$this->db->query($sql_update);
		}

   		return  $insert_id;

	}


	public function get_search_order($search_txt)
	{
		$sql =" SELECT * FROM (  SELECT o.id order_id, o.invoice_docno invoice_no,
				o.date order_date,
				o.name order_name,
				d.quantity,
				(SELECT COUNT(product_id) FROM return_receive WHERE is_active = 1 AND product_id = p.id AND order_id = o.id)Count_qty,
				IFNULL(s.serial_number,'') serial_number,
				p.id product_id,
				p.name product_name,
				p.sku

				FROM orders o
				INNER JOIN order_detail d ON o.id = d.order_id
				INNER JOIN products p on p.id = d.product_id
				LEFT JOIN product_serial s ON s.product_id = d.product_id  AND s.order_id = o.id

				WHERE o.id  LIKE '%".$search_txt."%'
					OR o.`name`  LIKE '%".$search_txt."%'
					OR p.`name`  LIKE '%".$search_txt."%'
					OR o.`address`  LIKE '%".$search_txt."%'
					OR o.`email`  LIKE '%".$search_txt."%'
					OR o.`tel`  LIKE '%".$search_txt."%'
					OR o.`invoice_docno`  LIKE '%".$search_txt."%'
					OR p.`id`  LIKE '%".$search_txt."%'
					OR s.serial_number  LIKE '%".$search_txt."%'
					OR p.`sku`  LIKE '%".$search_txt."%'

					) a
			";
		$re = $this->db->query($sql);
		$return_data = $re->result_array();
		return $return_data;
	}
}

/* End of file return_receive_model.php */
/* Location: ./application/models/return_receive_model.php */
