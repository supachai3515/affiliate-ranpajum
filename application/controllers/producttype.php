<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producttype extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->model('producttype_model');
		$this->load->library('pagination');
		
		$this->is_logged_in();


	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('producttype/index');
		$config['total_rows'] = $this->producttype_model->get_producttype_count();
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
		$data['producttype_list'] = $this->producttype_model->get_producttype($page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();

		//call script
        $data['menu_id'] ='1';
		$data['content'] = 'producttype';
		$data['header'] = array('title' => 'producttype| '.$this->config->item('sitename'),
								'description' =>  'producttype| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'bboyxcitehitec');
		$this->load->view('template/layout', $data);	
	}


	//page search
	public function search()
	{

		$return_data = $this->producttype_model->get_producttype_search();
		$data['producttype_list'] = $return_data['result_producttype'];
		$data['data_search'] = $return_data['data_search'];
		$data['menus_list'] = $this->initdata_model->get_menu();

        $data['menu_id'] ='1';
		$data['content'] = 'producttype';
		$data['header'] = array('title' => 'producttype| '.$this->config->item('sitename'),
								'description' =>  'producttype| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'bboyxcitehitec');
		$this->load->view('template/layout', $data);	

	}

	//page edit
	public function edit($producttype_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['producttype_data'] = $this->producttype_model->get_producttype_id($producttype_id);
        $data['menu_id'] ='1';
		$data['content'] = 'producttype_edit';
		$data['header'] = array('title' => 'producttype| '.$this->config->item('sitename'),
								'description' =>  'producttype| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'bboyxcitehitec');
		$this->load->view('template/layout', $data);	

	}

	// update
	public function update($producttype_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save producttype
		$this->producttype_model->update_producttype($producttype_id);

		if($producttype_id!=""){
			redirect('producttype/edit/'.$producttype_id);
		}
		else {
			redirect('producttype');
		}

	} 
	
	// insert
	public function add()
	{
		date_default_timezone_set("Asia/Bangkok");
		//save document
		$producttype_id ="";
		$producttype_id = $this->producttype_model->save_producttype();

		if($document_id !=""){
			redirect('producttype/edit/'.$producttype_id);
		}
		else {
			redirect('producttype');
		}	
	}  

	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true){
			redirect('login');		
		}		
	}

}

/* End of file producttype.php */
/* Location: ./application/controllers/producttype.php */