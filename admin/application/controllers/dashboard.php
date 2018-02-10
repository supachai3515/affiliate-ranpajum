<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('dasboard_model');
	}

	public function index()
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
    $data['menu_id'] ='8';
		$data['content'] = 'dashboard';
		$data['header'] = array('title' => 'Dashboard | '.$this->config->item('sitename'),
								'description' =>  'Dashboard | '.$this->config->item('tagline'),
								'author' => 'www.wisadev.com',
								'keyword' =>  'wisadev e-commerce');


		$data['get_order_status'] = $this->dasboard_model->get_order_status();
		$data['get_orders'] = $this->dasboard_model->get_orders();
		$data['get_orders_today'] = $this->dasboard_model->get_orders_today();

		$this->load->view('template/layout', $data);
	}

	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		$chk_admin =  $this->session->userdata('permission');
		if(!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin'){
			redirect('login');
		}
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
