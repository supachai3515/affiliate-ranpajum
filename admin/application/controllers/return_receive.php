<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Return_receive extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('return_receive_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('return_receive/index');
		$config['total_rows'] = $this->return_receive_model->get_return_receive_count();
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
		$data['return_receive_list'] = $this->return_receive_model->get_return_receive($page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['type_list'] = $this->products_model->get_type();

		//call script
        $data['menu_id'] ='25';
		$data['content'] = 'return_receive';
		$data['script_file']= "js/return_receive_js";
		$data['header'] = array('title' => 'return_receive| '.$this->config->item('sitename'),
								'description' =>  'return_receive| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);
	}


	//page search
	public function search()
	{

		$return_data = $this->return_receive_model->get_return_receive_search();
		$data['return_receive_list'] = $return_data['result_return_receive'];
		$data['data_search'] = $return_data['data_search'];
		$data['menus_list'] = $this->initdata_model->get_menu();

        $data['menu_id'] ='25';
		$data['content'] = 'return_receive';
		$data['script_file']= "js/return_receive_js";
		$data['header'] = array('title' => 'return_receive| '.$this->config->item('sitename'),
								'description' =>  'return_receive| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	//page edit
	public function edit($return_receive_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['return_receive_data'] = $this->return_receive_model->get_return_receive_id($return_receive_id);
		$data['type_list'] = $this->products_model->get_type();
        $data['menu_id'] ='25';
		$data['content'] = 'return_receive_edit';
		$data['script_file']= "js/return_receive_js";
		$data['header'] = array('title' => 'return_receive| '.$this->config->item('sitename'),
								'description' =>  'return_receive| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	// update
	public function update($return_receive_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save return_receive
		$this->return_receive_model->update_return_receive($return_receive_id);

		if($return_receive_id!=""){
			redirect('return_receive/edit/'.$return_receive_id);
		}
		else {
			redirect('return_receive');
		}

	}

	// insert
	public function add()
	{
		date_default_timezone_set("Asia/Bangkok");
		//save document
		$return_receive_id ="";
		$return_receive_id = $this->return_receive_model->save_return_receive();

		if($return_receive_id !=""){
			redirect('return_receive/edit/'.$return_receive_id);
		}
		else {
			redirect('return_receive');
		}
	}


	public function get_search_order()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['search_order'] =  $this->return_receive_model->get_search_order($value->search);
		print json_encode($data['search_order']);

	}


	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		$chk_admin =  $this->session->userdata('permission');
		if(!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin'){
			redirect('login');
		}
	}

}

/* End of file return_receive.php */
/* Location: ./application/controllers/return_receive.php */
