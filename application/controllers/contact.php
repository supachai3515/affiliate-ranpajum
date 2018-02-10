<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->library('pagination');
		 
	}


	public function index()
	{
		//header meta tag 
		$data['header'] = array('title' => 'ติดต่อเรา | '.$this->config->item('sitename'),
								'description' =>  'ติดต่อเรา | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'ติดต่อเรา | '.$this->config->item('tagline') );

		//get menu database 
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();


		$data['content'] = 'contact';
		$this->load->view('template/layout', $data);
	}

}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */