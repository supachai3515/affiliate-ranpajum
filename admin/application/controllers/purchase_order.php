<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('purchase_order_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{
		$searchText = $this->input->post('searchText');
		$data['searchText'] = $searchText;

		$config['base_url'] = base_url('purchase_order/index');
		$config['total_rows'] = $this->purchase_order_model->get_purchase_order_count($searchText);
		$config['per_page'] = 10;
        /* This Application Must Be Used With BootStrap 3 *  */
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

    $this->pagination->initialize($config);
		$data['purchase_order_list'] = $this->purchase_order_model->get_purchase_order( $searchText, $page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['type_list'] = $this->products_model->get_type();

		//call script
    $data['menu_id'] ='34';
		$data['content'] = 'purchase_order/purchase_order_view.php';
		//$data['script_file']= "js/purchase_order_js";
		$data['header'] = array('title' => 'purchase_order| '.$this->config->item('sitename'),
								'description' =>  'purchase_order| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);
	}


	//page edit
	public function view($purchase_order_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['purchase_order_data'] = $this->purchase_order_model->get_purchase_order_id($purchase_order_id);
		$data['purchase_order_detail_data'] = $this->purchase_order_model->get_purchase_order_detail($purchase_order_id);
		$data['type_list'] = $this->products_model->get_type();
    //$data['menu_id'] ='34';
		//$data['content'] = 'purchase_order/purchase_order_info_view';
		$data['script_file']= "js/purchase_order_js";
		$data['header'] = array('title' => 'purchase_order| '.$this->config->item('sitename'),
								'description' =>  'purchase_order| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');

	$this->load->view('purchase_order/purchase_order_info_view', $data);
	}


	//page search
	public function add()
	{

		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['type_list'] = $this->products_model->get_type();

		//call script
    $data['menu_id'] ='34';
		$data['script_file']= "js/purchase_order_js";
		$data['content'] = 'purchase_order/purchase_order_add_view.php';
		//$data['script_file']= "js/purchase_order_js";
		$data['header'] = array('title' => 'purchase_order| '.$this->config->item('sitename'),
								'description' =>  'purchase_order| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	//page edit
	public function edit($purchase_order_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['purchase_order_data'] = $this->purchase_order_model->get_purchase_order_id($purchase_order_id);
		$data['type_list'] = $this->products_model->get_type();
        $data['menu_id'] ='34';
		$data['content'] = 'purchase_order/purchase_order_edit_view';
		$data['script_file']= "js/purchase_order_js";
		$data['header'] = array('title' => 'purchase_order| '.$this->config->item('sitename'),
								'description' =>  'purchase_order| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');

			$this->load->view('template/layout', $data);
	}

	// update
	public function update($purchase_order_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save purchase_order
		$this->purchase_order_model->update_purchase_order($purchase_order_id);

		if($purchase_order_id!=""){
			redirect('purchase_order/edit/'.$purchase_order_id);
		}
		else {
			redirect('purchase_order');
		}

	}

	// update
	public function transfer_save($purchase_order_id)
	{

		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['purchase_order_data'] = $this->purchase_order_model->get_purchase_order_id($purchase_order_id);
		$data['type_list'] = $this->products_model->get_type();
				$data['menu_id'] ='34';
		$data['content'] = 'purchase_order/purchase_order_transfer_view';
		$data['script_file']= "js/purchase_order_js";
		$data['header'] = array('title' => 'purchase_order| '.$this->config->item('sitename'),
								'description' =>  'purchase_order| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');

			$this->load->view('template/layout', $data);

	}

	// insert
	public function add_save()
	{
		date_default_timezone_set("Asia/Bangkok");
		//save document
		$purchase_order_id ="";
		$purchase_order_id = $this->purchase_order_model->save_purchase_order();

		if($document_id !=""){
			redirect('purchase_order/edit/'.$purchase_order_id);
		}
		else {
			redirect('purchase_order');
		}
	}


	public function get_product()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['product'] =  $this->purchase_order_model->get_product($value->sku);
		print json_encode($data['product']);

	}

	public function get_purchase_order_detail()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['product'] =  $this->purchase_order_model->get_purchase_order_detail($value->id);
		print json_encode($data['product']);

	}


	public function line_number()
	{
		$sql ="SELECT purchase_order_id , product_id FROM product_serial GROUP BY purchase_order_id , product_id";
		$query = $this->db->query($sql);
		$re = $query->result_array();
		foreach ($re as $r) {


			$sql ="SELECT *  FROM product_serial WHERE purchase_order_id ='".$r['purchase_order_id']."' AND product_id = '".$r['product_id']."'";
			$query = $this->db->query($sql);
			$re1 = $query->result_array();
			$i= 1;
			foreach ($re1 as $r1) {

			print($i." - ".$r1['serial_number']." - ".$r1['product_id']." - ".$r1['purchase_order_id']."<br/>");

			date_default_timezone_set("Asia/Bangkok");
			$data_update = array(
				'line_number' => $i
			);

			$this->db->update("product_serial", $data_update,"product_id = '".$r1['product_id']."' AND  serial_number = '".$r1['serial_number']."'  AND purchase_order_id = '".$r1['purchase_order_id']."'");
			$i++;

			}
		}
	}


	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		$chk_admin =  $this->session->userdata('permission');
		if(!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin'){
			redirect('login');
		}
	}

}

/* End of file purchase_order.php */
/* Location: ./application/controllers/purchase_order.php */
