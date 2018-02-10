<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fullinvoice extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->library('pagination');
		$this->load->model('orders_model');
		 
	}

	public function index($ref_order_id="")
	{
		if($ref_order_id != ""){


	    $sql ="  SELECT p.*  FROM  orders p   WHERE ref_id ='".$ref_order_id."' ";
		$re = $this->db->query($sql);
		$row = $re->row_array();
		$orders_id = $row["id"];

		$data['orders_data'] = $this->orders_model->get_orders_id($orders_id);
		$data['orders_detail'] = $this->orders_model->get_orders_detail_id($orders_id);
		$data['order_status_list'] = $this->orders_model->get_order_status();
		$data['order_status_history_list'] = $this->orders_model->get_order_status_history($orders_id);
		$this->load->view('fullinvoice', $data);

		}
		else{
			echo "fail";
		}
	
	}

}

/* End of file fullinvoice.php */
/* Location: ./application/controllers/fullinvoice.php */