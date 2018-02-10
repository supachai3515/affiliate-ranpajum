<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

	public function __construct(){
	parent::__construct();
	//call model inti 
	$this->load->model('initdata_model');
	$this->load->library('pagination');
	}

	public function index()
	{
		//header meta tag 
		$data['header'] = array('title' => 'download | '.$this->config->item('sitename'),
								'description' =>  'download | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'download | '.$this->config->item('tagline') );

		//get menu database 
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();



		$sql ="SELECT  * FROM documents WHERE is_active =1 ORDER BY create_date DESC";
		$re = $this->db->query($sql);
		$data['doc_list'] = $re->result_array();


		$data['content'] = 'download';
		$this->load->view('template/layout', $data);
		
	}

	public function get_all()
	{
		   	$sql ="SELECT  * FROM documents WHERE is_active =1 ORDER BY create_date DESC";
			$re = $this->db->query($sql);
			$data['doc_list'] = $re->result_array();

		    header('Content-Type: application/json');
			echo json_encode($data['doc_list'] );
	}

}

/* End of file download.php */
/* Location: ./application/controllers/download.php */