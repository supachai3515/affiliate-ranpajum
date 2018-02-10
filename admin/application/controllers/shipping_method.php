<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipping_method extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('shipping_method_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('shipping_method/index');
		$config['total_rows'] = $this->shipping_method_model->get_shipping_method_count();
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
		$data['shipping_method_list'] = $this->shipping_method_model->get_shipping_method($page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['type_list'] = $this->products_model->get_type();

		//call script
        $data['menu_id'] ='19';
		$data['content'] = 'shipping_method';
		$data['script_file']= "js/product_add_js";
		$data['header'] = array('title' => 'shipping_method| '.$this->config->item('sitename'),
								'description' =>  'shipping_method| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);
	}


	//page search
	public function search()
	{

		$return_data = $this->shipping_method_model->get_shipping_method_search();
		$data['shipping_method_list'] = $return_data['result_shipping_method'];
		$data['data_search'] = $return_data['data_search'];
		$data['menus_list'] = $this->initdata_model->get_menu();

        $data['menu_id'] ='19';
		$data['content'] = 'shipping_method';
		$data['script_file']= "js/product_add_js";
		$data['header'] = array('title' => 'shipping_method| '.$this->config->item('sitename'),
								'description' =>  'shipping_method| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	//page edit
	public function edit($shipping_method_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['shipping_method_data'] = $this->shipping_method_model->get_shipping_method_id($shipping_method_id);
		$data['type_list'] = $this->products_model->get_type();
        $data['menu_id'] ='19';
		$data['content'] = 'shipping_method_edit';
		$data['script_file']= "js/product_add_js";
		$data['header'] = array('title' => 'shipping_method| '.$this->config->item('sitename'),
								'description' =>  'shipping_method| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	// update
	public function update($shipping_method_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save shipping_method
		$this->shipping_method_model->update_shipping_method($shipping_method_id);

		if($shipping_method_id!=""){
			redirect('shipping_method/edit/'.$shipping_method_id);
		}
		else {
			redirect('shipping_method');
		}

	}

	// insert
	public function add()
	{
		date_default_timezone_set("Asia/Bangkok");
		//save document
		$shipping_method_id ="";
		$shipping_method_id = $this->shipping_method_model->save_shipping_method();

		if($document_id !=""){
			redirect('shipping_method/edit/'.$shipping_method_id);
		}
		else {
			redirect('shipping_method');
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

/* End of file shipping_method.php */
/* Location: ./application/controllers/shipping_method.php */
