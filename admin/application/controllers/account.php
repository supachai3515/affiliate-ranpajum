<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->model('account_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('account/index');
		$config['total_rows'] = $this->account_model->get_account_count();
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
		$data['account_list'] = $this->account_model->get_account($page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['type_list'] = $this->products_model->get_type();

		//call script
        $data['menu_id'] ='17';
		$data['content'] = 'account';
		$data['script_file']= "js/product_add_js";
		$data['header'] = array('title' => 'account| '.$this->config->item('sitename'),
								'description' =>  'account| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);	
	}

	//page edit
	public function edit($account_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['account_data'] = $this->account_model->get_account_id($account_id);
		$data['type_list'] = $this->products_model->get_type();
        $data['menu_id'] ='17';
		$data['content'] = 'account_edit';
		$data['script_file']= "js/product_add_js";
		$data['header'] = array('title' => 'account| '.$this->config->item('sitename'),
								'description' =>  'account| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);	

	}

	// update
	public function update($account_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save account
		$this->account_model->update_account($account_id);

		if($account_id!=""){
			redirect('account/edit/'.$account_id);
		}
		else {
			redirect('account');
		}

	} 
	
	// insert
	public function add()
	{
		date_default_timezone_set("Asia/Bangkok");
		//save document
		$account_id ="";
		$account_id = $this->account_model->save_account();

		if($document_id !=""){
			redirect('account/edit/'.$account_id);
		}
		else {
			redirect('account');
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

/* End of file account.php */
/* Location: ./application/controllers/account.php */