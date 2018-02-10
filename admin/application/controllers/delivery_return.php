<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class delivery_return extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('delivery_return_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('delivery_return/index');
		$config['total_rows'] = $this->delivery_return_model->get_delivery_return_count();
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
		$data['delivery_return_list'] = $this->delivery_return_model->get_delivery_return($page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['type_list'] = $this->products_model->get_type();

		//call script
        $data['menu_id'] ='27';
		$data['content'] = 'delivery_return';
		$data['script_file']= "js/delivery_return_js";
		$data['header'] = array('title' => 'delivery_return| '.$this->config->item('sitename'),
								'description' =>  'delivery_return| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);
	}


	//page search
	public function search()
	{

		$return_data = $this->delivery_return_model->get_delivery_return_search();
		$data['delivery_return_list'] = $return_data['result_delivery_return'];
		$data['data_search'] = $return_data['data_search'];
		$data['menus_list'] = $this->initdata_model->get_menu();

        $data['menu_id'] ='27';
		$data['content'] = 'delivery_return';
		$data['script_file']= "js/delivery_return_js";
		$data['header'] = array('title' => 'delivery_return| '.$this->config->item('sitename'),
								'description' =>  'delivery_return| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	//page edit
	public function edit($delivery_return_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['delivery_return_data'] = $this->delivery_return_model->get_delivery_return_id($delivery_return_id);
		$data['type_list'] = $this->products_model->get_type();
        $data['menu_id'] ='27';
		$data['content'] = 'delivery_return_edit';
		$data['script_file']= "js/delivery_return_js";
		$data['header'] = array('title' => 'delivery_return| '.$this->config->item('sitename'),
								'description' =>  'delivery_return| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	// update
	public function update($delivery_return_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save delivery_return
		$this->delivery_return_model->update_delivery_return($delivery_return_id);

		if($delivery_return_id!=""){
			redirect('delivery_return/edit/'.$delivery_return_id);
		}
		else {
			redirect('delivery_return');
		}

	}

	// insert
	public function add()
	{
		date_default_timezone_set("Asia/Bangkok");
		//save document
		$delivery_return_id ="";
		$delivery_return_id = $this->delivery_return_model->save_delivery_return();

		if($delivery_return_id !=""){
			redirect('delivery_return/edit/'.$delivery_return_id);
		}
		else {
			redirect('delivery_return');
		}
	}


	public function get_search_order()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['search_order'] =  $this->delivery_return_model->get_search_order($value->search);
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

/* End of file delivery_return.php */
/* Location: ./application/controllers/delivery_return.php */
