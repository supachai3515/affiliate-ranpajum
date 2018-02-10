
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function get_purchase_order_count($searchText)
	{
		$searchText = $this->db->escape_like_str($searchText);
		$sql =" SELECT COUNT(r.id) connt_id
						FROM  purchase_order r WHERE 1=1 ";
		if(!empty($searchText)) {
				$sql = $sql." AND (r.id  LIKE '%".$searchText."%'
													OR r.doc_no  LIKE '%".$searchText."%'
													OR r.supplier  LIKE '%".$searchText."%'
													OR r.warranty  LIKE '%".$searchText."%'
													OR  r.`comment`  LIKE '%".$searchText."%')";
		}

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];

	}

	function get_purchase_order($searchText = '', $page, $segment)
	{
		// $this->db->escape() ใส่ '' ให้
		// $this->db->escape_str()  ไม่ใส่ '' ให้
		// $this->db->escape_like_str($searchText) like

		$searchText = $this->db->escape_like_str($searchText);
		$page = $this->db->escape_str($page);
		$segment = $this->db->escape_str($segment);

		$sql =" SELECT r.id , r.doc_no , r.create_date, r.modified_date,r.qty,r.total,r.vat, r.is_active, r.is_success ,r.`comment`,r.supplier,
					COUNT(rd.product_id) product_id, IFNULL(COUNT(re.do_ref),'0') is_to_receive
						FROM  purchase_order r
						INNER JOIN purchase_order_detail rd ON r.id = rd.purchase_order_id
						LEFT JOIN receive re ON re.do_ref = r.doc_no
						WHERE 1=1 ";
		if(!empty($searchText)) {
				$sql = $sql." AND (r.id  LIKE '%".$searchText."%'
													OR r.doc_no  LIKE '%".$searchText."%'
													OR  r.`comment`  LIKE '%".$searchText."%')";
		}
			$sql = $sql."GROUP BY r.id , r.doc_no , r.create_date, r.modified_date,r.qty,r.total,r.vat, r.is_active,r.is_success ,r.supplier,r.`comment` ORDER BY r.id DESC LIMIT ".$page.",".$segment." ";
			$query = $this->db->query($sql);
			$result = $query->result();
			return $result;
	}


	public function get_purchase_order_detail( $id)
	{

	   $sql =" SELECT rd.* ,p.`name` name , p.sku FROM purchase_order_detail  rd INNER JOIN products p ON rd.product_id = p.id where rd.purchase_order_id = '".$this->db->escape_str($id)."'";
		$re = $this->db->query($sql);
		return $re->result_array();

	}



	public function get_purchase_order_id($purchase_order_id)
	{
		$sql ="SELECT * FROM purchase_order WHERE id = ".$this->db->escape_str($purchase_order_id)."";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function get_purchase_order_detail_id($purchase_order_id)
	{
		$sql ="SELECT * FROM purchase_order_detail WHERE purchase_order_id = '".$purchase_order_id."'";
		$re = $this->db->query($sql);
		return $re->result_array();
	}

 public function get_purchase_order_search()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_purchase_order = array(
			'search' => $this->input->post('search')
		);

		$sql =" SELECT r.id , r.doc_no ,r.do_ref, r.create_date,r.modified_date,r.qty,r.total,r.vat, r.is_active,r.`comment`, COUNT(rd.product_id) product_id ,
			(SELECT COUNT(serial_number) serial_number FROM product_serial WHERE (order_id IS NOT NULL OR order_id = '' ) AND  purchase_order_id = r.id ) count_use,
				(SELECT COUNT(serial_number) serial_number FROM product_serial WHERE purchase_order_id = r.id ) serial_number

				FROM  purchase_order r  INNER JOIN purchase_order_detail rd ON r.id = rd.purchase_order_id
				WHERE r.id  LIKE '%".$data_purchase_order['search']."%' OR   r.doc_no LIKE '%".$data_purchase_order['search']."%'
				GROUP BY r.id , r.doc_no ,r.do_ref, r.create_date,r.modified_date,r.qty,r.total,r.vat, r.is_active,r.`comment`
				ORDER BY r.id DESC

				";
		$re = $this->db->query($sql);
		$return_data['result_purchase_order'] = $re->result_array();
		$return_data['data_search'] = $data_purchase_order;
		$return_data['sql'] = $sql;
		return $return_data;
	}

	public function update_purchase_order($purchase_order_id)
	{
		$this->db->trans_start(); # Starting Transaction
		 //DOC_NO
			$sql =" SELECT doc_no  FROM purchase_order  WHERE  id = '".$purchase_order_id."'";
			$re = $this->db->query($sql);
			$row_doc_no =  $re->row_array();
			$purchase_order_docno = $row_doc_no['doc_no'];
			//


		$sku_s = $this->input->post('sku');
		$qty_s =$this->input->post('qty');
		$price_s =$this->input->post('price');

		$is_vat_n = 0;
		$is_vat =  $this->input->post('is_vat');
		if($is_vat == 1)
		{
			$is_vat_n = 1;
		}
		else{
			$is_vat_n = 0;
		}
		$qty_m = 0; $vat_m = 0; $total_m = 0;
		$i = 0;
		foreach( $this->input->post('sku') as $row) {

		  	$qty_m = $qty_m  + $this->input->post('qty')[$i];

		  	if($is_vat_n ==  1){
		  		$vat_m = $vat_m  + (($this->input->post('qty')[$i]  * $this->input->post('price')[$i] ) * 7 /107);
		  	}

		  	$total_m = $total_m  + ($this->input->post('qty')[$i]  * $this->input->post('price')[$i]);
			$i++;
		}

		//purchase_order master
		date_default_timezone_set("Asia/Bangkok");
		$data_purchase_order = array(
			'comment' =>$this->input->post('comment'),
			'supplier' =>$this->input->post('supplier'),
			'warranty' =>$this->input->post('warranty'),
			'qty' => $qty_m,
			'vat' => $vat_m ,
			'total' => $total_m ,
			'modified_date' => date("Y-m-d H:i:s"),
			'is_vat' => $is_vat_n,
			'is_active' => $this->input->post('isactive'),
			'is_success' => $this->input->post('is_success')
		);

		$where = "id = '".$purchase_order_id."'";
		$this->db->update("purchase_order", $data_purchase_order,$where);

  	$this->db-> delete('purchase_order_detail',"purchase_order_id = '".$purchase_order_id."'");
		$i = 0;
		foreach( $this->input->post('sku') as $row) {
		  	$vat = 0;
		  	if($is_vat_n == 1){
		  		$vat = ($this->input->post('qty')[$i]  * $this->input->post('price')[$i] ) * 7 / 107;
		  	}
		  	$total = $this->input->post('qty')[$i]  * $this->input->post('price')[$i];

		  	date_default_timezone_set("Asia/Bangkok");
			$data_purchase_order_detail = array(
				'purchase_order_id' =>$purchase_order_id ,
				'product_id' => $this->input->post('id')[$i],
				'price' => $this->input->post('price')[$i],
				'qty' => $this->input->post('qty')[$i],
				'vat' => $vat,
				'total' => $total,
			);
			$this->db->insert("purchase_order_detail", $data_purchase_order_detail);
			$i++;
		}

		$this->db->trans_complete(); # Completing transaction
		/*Optional*/

		if ($this->db->trans_status() === FALSE) {
		    # Something went wrong.
		    $this->db->trans_rollback();
		   // return FALSE;
		}
		else {
		    # Everything is Perfect.
		    # Committing data to the database.
		    $this->db->trans_commit();
		   // return TRUE;
		}
	}

	public function save_purchase_order()
	{

		$this->db->trans_start(); # Starting Transaction

		$sku_s = $this->input->post('sku');
		$qty_s =$this->input->post('qty');
		$price_s =$this->input->post('price');

		$is_vat_n = 0;
		$is_vat =  $this->input->post('is_vat');
		if($is_vat == 1)
		{
			$is_vat_n = 1;
		}
		else{
			$is_vat_n = 0;
		}
		$qty_m = 0; $vat_m = 0; $total_m = 0;
		$i = 0;
		foreach( $this->input->post('sku') as $row) {

		  	$qty_m = $qty_m  + $this->input->post('qty')[$i];

		  	if($is_vat_n ==  1){
		  		$vat_m = $vat_m  + (($this->input->post('qty')[$i]  * $this->input->post('price')[$i] ) * 7 / 107);
		  	}

		  	$total_m = $total_m  + ($this->input->post('qty')[$i]  * $this->input->post('price')[$i]);
			$i++;
		}

		//purchase_order master
		date_default_timezone_set("Asia/Bangkok");
		$data_purchase_order = array(
			'comment' =>$this->input->post('comment'),
			'supplier' =>$this->input->post('supplier'),
			'warranty' =>$this->input->post('warranty'),
			'doc_no' =>"PO".date("YmdHis"),
			'qty' => $qty_m,
			'vat' => $vat_m ,
			'total' => $total_m ,
			'create_date' => date("Y-m-d H:i:s"),
			'modified_date' => date("Y-m-d H:i:s"),
			'is_vat' => $is_vat_n,
			'is_active' => $this->input->post('isactive')
		);

		$this->db->insert("purchase_order", $data_purchase_order);
		$insert_id = $this->db->insert_id();

		//update docno
		date_default_timezone_set("Asia/Bangkok");
		$docno_gen = 'PO'.date("ymd");
		$docno_gen = $docno_gen.str_pad($insert_id, 4, "0", STR_PAD_LEFT);
		$data_purchase_order_update = array(
			'doc_no' => $docno_gen
		);
		$this->db->update("purchase_order", $data_purchase_order_update, "id = '".$insert_id."'");
    $this->db-> delete('purchase_order_detail',"purchase_order_id = '".$insert_id."'");

		$i = 0;
		foreach( $this->input->post('sku') as $row) {

		  	$vat = 0;
		  	if($is_vat_n == 1){
		  		$vat = ($this->input->post('qty')[$i]  * $this->input->post('price')[$i] ) * 7/107;
		  	}

		  	$total = $this->input->post('qty')[$i]  * $this->input->post('price')[$i];

		  date_default_timezone_set("Asia/Bangkok");
			$data_purchase_order_detail = array(
				'purchase_order_id' =>$insert_id ,
				'product_id' => $this->input->post('id')[$i],
				'price' => $this->input->post('price')[$i],
				'qty' => $this->input->post('qty')[$i],
				'vat' => $vat,
				'total' => $total,
			);
			$this->db->insert("purchase_order_detail", $data_purchase_order_detail);
			$i++;
		}

		$this->db->trans_complete(); # Completing transaction
		/*Optional*/

		if ($this->db->trans_status() === FALSE) {
		    # Something went wrong.
		    $this->db->trans_rollback();
				$this->session->set_flashdata('success', 'Add purchase order created successfully');
		   // return FALSE;
		}
		else {
		    # Everything is Perfect.
		    # Committing data to the database.
		    $this->db->trans_commit();
				$this->session->set_flashdata('error', 'Add purchase order created failed');
		   // return TRUE;
		}
   		return  $insert_id;

	}

	public function get_product($product_id)
	{
		$sql ="SELECT * FROM products WHERE sku = '".$product_id."'";

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

}

/* End of file purchase_order_model.php */
/* Location: ./application/models/purchase_order_model.php */
