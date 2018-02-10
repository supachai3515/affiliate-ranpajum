<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notfound extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->model('home_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
	}

	public function index()
	{

		//header meta tag 
		$data['header'] = array('title' =>'404 not found'. $this->config->item('sitename'),
								'description' =>  $this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  $this->config->item('keyword'));
								
		//get menu database 
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();
		$data['brand_oftype'] = $this->initdata_model->get_brand_oftype();

		//get slider list
	    $sql =" SELECT *  FROM  slider p  ORDER BY p.id ";
		$re = $this->db->query($sql);
		$data['slider_list'] = $re->result_array();

        //content file view
		$data['content'] = '404';
		// if have file script
		//$data['script_file']= "js/product_add_js";
		//load layout
		$this->load->view('template/layout', $data);	
	}

}

/* End of file 404.php */
/* Location: ./application/controllers/404.php */