
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receive_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('Initdata_model');
	}

	public function get_receive( $start, $limit)
	{

	    $sql =" SELECT r.id , r.doc_no ,r.do_ref, r.create_date,r.modified_date,r.qty,r.total,r.vat, r.is_active,r.`comment`, COUNT(rd.product_id) product_id ,
			(SELECT COUNT(serial_number) serial_number FROM product_serial WHERE (order_id IS NOT NULL OR order_id = '' ) AND  receive_id = r.id ) count_use,
				(SELECT COUNT(serial_number) serial_number FROM product_serial WHERE receive_id = r.id ) serial_number

				FROM  receive r  INNER JOIN receive_detail rd ON r.id = rd.receive_id
				GROUP BY r.id , r.doc_no ,r.do_ref, r.create_date,r.modified_date,r.qty,r.total,r.vat, r.is_active,r.`comment`
				ORDER BY r.id DESC

				LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_receive_detail( $id)
	{

	    $sql =" SELECT rd.* ,p.`name` name , p.sku FROM receive_detail  rd INNER JOIN products p ON rd.product_id = p.id where rd.receive_id = '".$id."'";
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_product_serial($product_id , $receive_id)
	{

		$sql =" SELECT ps.* , p.`name` product_name ,p.sku ,
						(SELECT COUNT(serial_number) serial_number FROM product_serial
						WHERE (order_id IS NOT NULL OR order_id = '' ) AND  receive_id = ps.receive_id AND product_id = '".$product_id."' AND  serial_number = ps.serial_number) count_use
				FROM product_serial ps INNER JOIN products p ON p.id = ps.product_id
				where ps.product_id = '".$product_id."'
				AND ps.receive_id = '".$receive_id."' ;";
		$re = $this->db->query($sql);
		return $re->result_array();
	}

	public function get_receive_count()
	{
		$sql =" SELECT COUNT(id) as connt_id FROM  receive p";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];

	}


	public function get_receive_id($receive_id)
	{
		$sql ="SELECT *,(SELECT COUNT(serial_number) serial_number FROM product_serial
						WHERE (order_id IS NOT NULL OR order_id = '' ) AND  receive_id = '".$receive_id."') count_use
			   FROM receive WHERE id = '".$receive_id."' ";


		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function get_receive_detail_id($receive_id)
	{
		$sql ="SELECT * FROM receive_detail WHERE receive_id = '".$receive_id."'";
		$re = $this->db->query($sql);
		return $re->result_array();
	}


    public function get_receive_search()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_receive = array(
			'search' => $this->input->post('search')
		);

		$sql =" SELECT r.id , r.doc_no ,r.do_ref, r.create_date,r.modified_date,r.qty,r.total,r.vat, r.is_active,r.`comment`, COUNT(rd.product_id) product_id ,
			(SELECT COUNT(serial_number) serial_number FROM product_serial WHERE (order_id IS NOT NULL OR order_id = '' ) AND  receive_id = r.id ) count_use,
				(SELECT COUNT(serial_number) serial_number FROM product_serial WHERE receive_id = r.id ) serial_number

				FROM  receive r  INNER JOIN receive_detail rd ON r.id = rd.receive_id
				WHERE r.id  LIKE '%".$data_receive['search']."%' OR   r.doc_no LIKE '%".$data_receive['search']."%'
				GROUP BY r.id , r.doc_no ,r.do_ref, r.create_date,r.modified_date,r.qty,r.total,r.vat, r.is_active,r.`comment`
				ORDER BY r.id DESC

				";
		$re = $this->db->query($sql);
		$return_data['result_receive'] = $re->result_array();
		$return_data['data_search'] = $data_receive;
		$return_data['sql'] = $sql;
		return $return_data;
	}

	public function update_receive($receive_id)
	{
		$this->db->trans_start(); # Starting Transaction
		 //DOC_NO
			$sql =" SELECT doc_no  FROM receive  WHERE  id = '".$receive_id."'";
			$re = $this->db->query($sql);
			$row_doc_no =  $re->row_array();
			$receive_docno = $row_doc_no['doc_no'];
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

		//receive master
		date_default_timezone_set("Asia/Bangkok");
		$data_receive = array(
			'comment' =>$this->input->post('comment'),
			'supplier' =>$this->input->post('supplier'),
			'warranty' =>$this->input->post('warranty'),
			'do_ref' => $this->input->post('do_ref'),
			'qty' => $qty_m,
			'vat' => $vat_m ,
			'total' => $total_m ,
			'modified_date' => date("Y-m-d H:i:s"),
			'is_vat' => $is_vat_n,
			'is_active' => $this->input->post('isactive')
		);

		$where = "id = '".$receive_id."'";
		$this->db->update("receive", $data_receive,$where);


		//befor delete is update stock
		$rowstock = $this->get_receive_detail_id($receive_id);
			foreach ($rowstock as $row) {
				$sql =" SELECT COUNT(product_id) as connt_id FROM  stock WHERE product_id ='".$row['product_id']."' AND receive_id ='".$receive_id."' AND is_active = 1";

				$query = $this->db->query($sql);
				$r = $query->row_array();
				if( $r['connt_id']>0 ) {
					$data_stock = array(
						'product_id' =>  $row['product_id'],
						'receive_id' => $receive_id ,
						'number'=> $row['qty'],
					);
					$this->db->delete("stock", $data_stock);
					//update product
					$sql_update ="UPDATE products SET stock = stock-".$row['qty']." WHERE id =".$row['product_id']." ";
					$this->db->query($sql_update);

				}
			}


  		$this->db-> delete('receive_detail',"receive_id = '".$receive_id."'");
		$i = 0;
		$not_in ="0";

		foreach( $this->input->post('sku') as $row) {
		  	$vat = 0;
		  	if($is_vat_n == 1){
		  		$vat = ($this->input->post('qty')[$i]  * $this->input->post('price')[$i] ) * 7 / 107;
		  	}
		  	$total = $this->input->post('qty')[$i]  * $this->input->post('price')[$i];

		  	date_default_timezone_set("Asia/Bangkok");
			$data_receive_detail = array(
				'receive_id' =>$receive_id ,
				'product_id' => $this->input->post('id')[$i],
				'price' => $this->input->post('price')[$i],
				'qty' => $this->input->post('qty')[$i],
				'vat' => $vat,
				'total' => $total,
			);

			$this->db->insert("receive_detail", $data_receive_detail);

			//update stock
			date_default_timezone_set("Asia/Bangkok");
			$data_update_stock = array(
				'product_id' =>$this->input->post('id')[$i],
				'number' => $this->input->post('qty')[$i],
				'receive_id' => $receive_id,
				'is_active' => $this->input->post('isactive'),
				'modified_date' => date("Y-m-d H:i:s"),
			);

			$this->db->insert("stock", $data_update_stock);

			$is_active = $this->input->post('isactive');
			if($is_active)
			{
				//update product stock
				$sql_update ="UPDATE products SET stock = stock+".$this->input->post('qty')[$i]." WHERE id =".$this->input->post('id')[$i]." ";
				$this->db->query($sql_update);


				//update product stock
				$sql_update ="UPDATE product_serial SET is_active = 1  WHERE product_id =".$this->input->post('id')[$i]."
							AND receive_id = '".$receive_id."';";
				$this->db->query($sql_update);

			}
			else {

				//update product stock
				$sql_update ="UPDATE product_serial SET is_active = 0  WHERE product_id =".$this->input->post('id')[$i]."
							AND receive_id = '".$receive_id."';";
				$this->db->query($sql_update);

			}

			$not_in = $not_in.",".$this->input->post('id')[$i];
			$i++;
		}

		//serial number
		$ch_is_active = 2;
		$comment = "";
		$is_active = $this->input->post('isactive');
		if($is_active){
				$ch_is_active = 4;
				$comment = "แก้ไขใบรับสินค้า : ".$receive_docno;
		} else{
				$ch_is_active = 2;
				$comment = "ทำการยกเลิกใบรับ : ".$receive_docno;
		}

		$sql =" SELECT * FROM product_serial WHERE receive_id = '".$receive_id."' ";
		$re = $this->db->query($sql);
		$row_re =  $re->result_array();
		foreach ($row_re as $row ) {
			date_default_timezone_set("Asia/Bangkok");
			$data_serial_history = array(
				'serial_number' => $row['serial_number'] ,
				'product_id' => $row['product_id'] ,
				'comment' => $comment,
				'create_date' => date("Y-m-d H:i:s"),
			);
			$this->db->insert("serial_history", $data_serial_history);
		}

		if($not_in != "0"){

			$sql = " SELECT * FROM product_serial WHERE product_id NOT in (".str_replace("0,","",$not_in).") AND receive_id = '".$receive_id."' ";
			$re = $this->db->query($sql);
			$row_re =  $re->result_array();
			foreach ($row_re as $row ) {
				date_default_timezone_set("Asia/Bangkok");
				$data_serial_history = array(
					'serial_number' => $row['serial_number'] ,
					'product_id' => $row['product_id'] ,
					'comment' => "ลบออกจากใบรับ : ".$receive_docno,
					'create_date' => date("Y-m-d H:i:s"),
				);
				$this->db->insert("serial_history", $data_serial_history);
			}


			$sql =" DELETE FROM product_serial WHERE product_id NOT in (".str_replace("0,","",$not_in).") AND receive_id = '".$receive_id."' ";
			$re = $this->db->query($sql);

		}
		else {

			$sql =" SELECT * FROM product_serial WHERE receive_id = '".$receive_id."' ";
			$re = $this->db->query($sql);
			$row_re =  $re->result_array();
			foreach ($row_re as $row ) {
				date_default_timezone_set("Asia/Bangkok");
				$data_product_serial = array(
					'serial_number' => $row['serial_number'] ,
					'product_id' => $row['product_id'] ,
					'comment' => "ลบออก",
					'create_date' => date("Y-m-d H:i:s"),
				);
				$this->db->insert("serial_history", $data_product_serial);
			}

			$sql =" DELETE FROM product_serial WHERE receive_id = '".$receive_id."' ";
			$re = $this->db->query($sql);

		}
		//end searial number


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

	public function save_receive()
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

		//receive master
		date_default_timezone_set("Asia/Bangkok");
		$data_receive = array(
			'comment' =>$this->input->post('comment'),
			'supplier' =>$this->input->post('supplier'),
			'warranty' =>$this->input->post('warranty'),
			'do_ref' => $this->input->post('do_ref'),
			'doc_no' =>"RE".date("YmdHis"),
			'qty' => $qty_m,
			'vat' => $vat_m ,
			'total' => $total_m ,
			'create_date' => date("Y-m-d H:i:s"),
			'modified_date' => date("Y-m-d H:i:s"),
			'is_vat' => $is_vat_n,
			'is_active' => $this->input->post('isactive')
		);

		$this->db->insert("receive", $data_receive);
		$insert_id = $this->db->insert_id();

		//update docno
		date_default_timezone_set("Asia/Bangkok");
		$docno_gen = 'RE'.date("ymd");
		$docno_gen = $docno_gen.str_pad($insert_id, 4, "0", STR_PAD_LEFT);
		$data_receive_update = array(
			'doc_no' => $docno_gen
		);
		$this->db->update("receive", $data_receive_update, "id = '".$insert_id."'");
  		$this->db-> delete('receive_detail',"receive_id = '".$insert_id."'");


		$i = 0;
		foreach( $this->input->post('sku') as $row) {

		  	$vat = 0;
		  	if($is_vat_n == 1){
		  		$vat = ($this->input->post('qty')[$i]  * $this->input->post('price')[$i] ) * 7/107;
		  	}

		  	$total = $this->input->post('qty')[$i]  * $this->input->post('price')[$i];

		  	date_default_timezone_set("Asia/Bangkok");
			$data_receive_detail = array(
				'receive_id' =>$insert_id ,
				'product_id' => $this->input->post('id')[$i],
				'price' => $this->input->post('price')[$i],
				'qty' => $this->input->post('qty')[$i],
				'vat' => $vat,
				'total' => $total,
			);

			$this->db->insert("receive_detail", $data_receive_detail);

			//update stock
			date_default_timezone_set("Asia/Bangkok");
			$data_update_stock = array(
				'product_id' =>$this->input->post('id')[$i],
				'number' => $this->input->post('qty')[$i],
				'receive_id' => $insert_id ,
				'modified_date' => date("Y-m-d H:i:s"),
			);

			$this->db->insert("stock", $data_update_stock);

			//update product stock
			$sql_update ="UPDATE products SET stock = stock+".$this->input->post('qty')[$i]." WHERE id =".$this->input->post('id')[$i]." ";
			$this->db->query($sql_update);

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

/* End of file receive_model.php */
/* Location: ./application/models/receive_model.php */
