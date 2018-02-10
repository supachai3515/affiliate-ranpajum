<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class special_county extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('special_county_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('special_county/index');
		$config['total_rows'] = $this->special_county_model->get_special_county_count();
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
		$data['special_county_list'] = $this->special_county_model->get_special_county($page, $config['per_page']);
		$data['shipping_method_list'] = $this->products_model->get_shipping_method();
		$data['province_list'] = $this->products_model->get_province_list();
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['type_list'] = $this->products_model->get_type();

		//call script
        $data['menu_id'] ='21';
		$data['content'] = 'special_county';
		$data['script_file']= "js/product_add_js";
		$data['header'] = array('title' => 'special_county | '.$this->config->item('sitename'),
								'description' =>  'special_county| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);
	}


	//page search
	public function search()
	{

		$return_data = $this->special_county_model->get_special_county_search();
		$data['special_county_list'] = $return_data['result_special_county'];
		$data['shipping_method_list'] = $this->products_model->get_shipping_method();
		$data['data_search'] = $return_data['data_search'];
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['province_list'] = $this->products_model->get_province_list();

        $data['menu_id'] ='21';
		$data['content'] = 'special_county';
		$data['script_file']= "js/product_add_js";
		$data['header'] = array('title' => 'special_county| '.$this->config->item('sitename'),
								'description' =>  'special_county| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	//page edit
	public function edit($amphur_id,$shipping_method_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['special_county_data'] = $this->special_county_model->get_special_county_id($amphur_id,$shipping_method_id);
		$data['type_list'] = $this->products_model->get_type();
		$data['shipping_method_list'] = $this->products_model->get_shipping_method();
		$data['province_list'] = $this->products_model->get_province_list();
		$data['amphur_list'] = $this->products_model->get_amphur_list_all();
        $data['menu_id'] ='21';
		$data['content'] = 'special_county_edit';
		$data['script_file']= "js/product_add_js";
		$data['header'] = array('title' => 'special_county | '.$this->config->item('sitename'),
								'description' =>  'special_county| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	// update
	public function update($amphur_id,$shipping_method_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save special_county
		$this->special_county_model->update_special_county($amphur_id,$shipping_method_id);

		if($special_county_id!=""){
			redirect('special_county/edit/'.$special_county_id);
		}
		else {
			redirect('special_county');
		}

	}

	// update
	public function delete($amphur_id,$shipping_method_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save special_county
		$this->special_county_model->delete_special_county($amphur_id,$shipping_method_id);
		redirect('special_county');

	}

	// insert
	public function add()
	{
		date_default_timezone_set("Asia/Bangkok");
		//save document
		$special_county_id ="";
		$special_county_id = $this->special_county_model->save_special_county();

		if($document_id !=""){
			redirect('special_county/edit/'.$special_county_id);
		}
		else {
			redirect('special_county');
		}
	}



	public function getProvince()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['amphur_list'] =  $this->products_model->get_amphur_list($value->province_id);
		print json_encode($data['amphur_list']);

	}

	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		$chk_admin =  $this->session->userdata('permission');
		if(!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin'){
			redirect('login');
		}
	}

}

/* End of file special_county.php */
/* Location: ./application/controllers/special_county.php */
