
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_return_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('Initdata_model');
	}

	public function get_delivery_return( $start, $limit)
	{

	    $sql =" SELECT  dr.*,
	    		o.id order_id, o.invoice_docno invoice_no,
				rr.docno return_docno,
				o.date order_date,
				o.`name` order_name,
				o.address,
				s.serial_number,
				p.id product_id,
				p.name product_name,
				p.sku
				FROM delivery_return  dr INNER JOIN return_receive rr ON dr.return_id = rr.id
				INNER JOIN orders o ON o.id = rr.order_id
				INNER JOIN products p on p.id = rr.product_id
				LEFT JOIN product_serial s ON s.product_id = rr.product_id  AND s.serial_number = rr.serial
				ORDER BY dr.id DESC  LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_delivery_return_count()
	{
		$sql =" SELECT COUNT(id) as connt_id FROM  delivery_return p"; 
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];
	
	}


	public function get_delivery_return_id($delivery_return_id)
	{
		$sql ="SELECT  dr.*,
	    		o.id order_id, o.invoice_docno invoice_no,
				rr.docno return_docno,
				o.date order_date,
				s.serial_number,
				o.`name` order_name,
				o.address,
				p.id product_id,
				p.name product_name,
				p.sku
				FROM delivery_return  dr INNER JOIN return_receive rr ON dr.return_id = rr.id
				INNER JOIN orders o ON o.id = rr.order_id
				INNER JOIN products p on p.id = rr.product_id
				LEFT JOIN product_serial s ON s.product_id = rr.product_id  AND s.serial_number = rr.serial
				 WHERE dr.id = '".$delivery_return_id."'"; 

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}


    public function get_delivery_return_search()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_delivery_return = array(
			'search' => $this->input->post('search')		
		);

		$sql ="SELECT  dr.*,
	    		o.id order_id, o.invoice_docno invoice_no,
				rr.docno return_docno,
				o.date order_date,
				s.serial_number,
				o.`name` order_name,
				o.address,
				p.id product_id,
				p.name product_name,
				p.sku
				FROM delivery_return  dr INNER JOIN return_receive rr ON dr.return_id = rr.id
				INNER JOIN orders o ON o.id = rr.order_id
				INNER JOIN products p on p.id = rr.product_id
				LEFT JOIN product_serial s ON s.product_id = rr.product_id  AND s.serial_number = rr.serial
				 WHERE dr.docno LIKE '%".$data_delivery_return['search']."%' OR  o.id LIKE '%".$data_delivery_return['search']."%'  OR  s.serial_number LIKE '%".$data_delivery_return['search']."%' OR o.name LIKE '%".$data_delivery_return['search']."%'  ";
		$re = $this->db->query($sql);
		$return_data['result_delivery_return'] = $re->result_array();
		$return_data['data_search'] = $data_delivery_return;
		$return_data['sql'] = $sql;
		return $return_data;
	}

	public function update_delivery_return($delivery_return_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_delivery_return = array(
			'tracking' => $this->input->post('tracking'),
			'comment' => $this->input->post('comment'),
			'modified_date' => date("Y-m-d H:i:s"),
			'is_active' => $this->input->post('is_active')						
		);
		$where = array(
			'id' => $delivery_return_id,				
		);
		$this->db->update("delivery_return", $data_delivery_return, $where );


		$is_active = $this->input->post('is_active');
		if($is_active){
	
			$serial = $this->input->post('serial');
			if (isset($serial )) {
				//update history
				date_default_timezone_set("Asia/Bangkok");
				$data_serial_history = array(
						'serial_number' =>$this->input->post('serial'),
						'product_id' => $this->input->post('product_id'),
						'comment' => "ยันยันใบส่งคืน เลขที่ใบส่งคืน #".$this->input->post('docno'),
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
						'comment' => "ยกเลิกใบส่งคืน เลขที่ใบส่งคืน #".$this->input->post('docno'),
						'create_date' => date("Y-m-d H:i:s"),				
				);
				$this->db->insert("serial_history", $data_serial_history);
			}
		}

	}

	public function save_delivery_return()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_delivery_return = array(
			'return_id' => $this->input->post('return_id'),
			'order_id' => $this->input->post('order_id'),
			'product_id' => $this->input->post('product_id'),
			'serial' => $this->input->post('serial'),
			'tracking' => $this->input->post('tracking'),
			'comment' => $this->input->post('comment'),
			'create_date' => date("Y-m-d H:i:s"),
			'modified_date' => date("Y-m-d H:i:s"),
			'is_active' => $this->input->post('isactive')						
		);
		
		$this->db->insert("delivery_return", $data_delivery_return);
		$insert_id = $this->db->insert_id();


		date_default_timezone_set("Asia/Bangkok");
		$data_order = array(
			'docno' => 'DR'.date("ymd").str_pad($insert_id, 4, "0", STR_PAD_LEFT)	
		);

		$where = array('id' => $insert_id);
		$this->db->update("delivery_return", $data_order, $where);


		$where = array('id' => $insert_id);
		$this->db->update("credit_note", $data_order, $where);

		$serial = $this->input->post('serial');
		if (isset($serial )) {
			//update history
			date_default_timezone_set("Asia/Bangkok");
			$data_serial_history = array(
					'serial_number' =>$this->input->post('serial'),
					'product_id' => $this->input->post('product_id'),
					'comment' => "ยันยันใบลดหนี้ เลขที่ใบลดหนี้ #".$data_order['docno'],
					'create_date' => date("Y-m-d H:i:s"),				
			);
			$this->db->insert("serial_history", $data_serial_history);
		}

   		
   		return  $insert_id;

	}


	public function get_search_order($search_txt)
	{
		$sql =" SELECT rr.order_id, 
				rr.id return_id,
				rr.docno return_docno,
				o.invoice_docno invoice_no,
				rr.create_date create_date,
				rr.serial serial_number,
				p.id product_id,
				p.name product_name,
				p.sku,
				(SELECT COUNT(return_id) FROM credit_note WHERE is_active = 1 AND return_id = rr.id) is_credit_note,
				(SELECT COUNT(return_id) FROM delivery_return WHERE is_active = 1 AND return_id = rr.id) is_delivery_return 
				FROM return_receive rr 
				INNER JOIN orders o ON o.id = rr.order_id
				INNER JOIN products p on p.id = rr.product_id

				WHERE o.id  LIKE '%".$search_txt."%'
					OR o.`name`  LIKE '%".$search_txt."%'
					OR p.`name`  LIKE '%".$search_txt."%'
					OR o.`address`  LIKE '%".$search_txt."%'
					OR o.`email`  LIKE '%".$search_txt."%'
					OR o.`tel`  LIKE '%".$search_txt."%'
					OR o.`invoice_docno`  LIKE '%".$search_txt."%'
					OR p.`id`  LIKE '%".$search_txt."%'
					OR rr.serial  LIKE '%".$search_txt."%'
					OR p.`sku`  LIKE '%".$search_txt."%' 
			
			";
		$re = $this->db->query($sql);
		$return_data = $re->result_array();
		return $return_data;
	}

}

/* End of file delivery_return_model.php */
/* Location: ./application/models/delivery_return_model.php */