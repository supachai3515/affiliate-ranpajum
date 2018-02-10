<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Po_status extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->library('pagination');
		$this->load->model('dealer_model');
		 
	}

	public function index($ref_order_id="")
	{
		if($ref_order_id != ""){

		//header meta tag 
		$data['header'] = array('title' => 'สถานะสินค้า | '.$this->config->item('sitename'),
								'description' =>  'สถานะสินค้า | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'สถานะสินค้า | '.$this->config->item('tagline') );

		//get menu database 
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();

		$sql =" SELECT o.* ,  s.name status_name , s.id status_id ,s.icon_font FROM po_orders o LEFT JOIN  po_order_status s 	 ON o.po_order_status_id = s.id WHERE ref_id= '".$ref_order_id."'"; 
		$query = $this->db->query($sql);
		$row = $query->row_array();

		if(count($row) == 0){
			redirect('product','refresh');
		}
		$data['order'] = $row;

		$sql_detail ="SELECT * ,r.price price_order FROM po_order_detail r INNER JOIN  products p ON r.product_id = p.id
						WHERE r.po_order_id ='".$row['id']."' ORDER BY r.linenumber ";
		$re = $this->db->query($sql_detail);
		$data['order_detail'] = $re->result_array();


		$data['content'] = 'po_status';
		$this->load->view('template/layout', $data);
		}
		else{
			redirect('product','refresh');
		}
	
	}
}
/* End of file status.php */
/* Location: ./application/controllers/status.php */