<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->library('pagination');
		 
	}

	public function index()
	{
		//header meta tag 
		$data['header'] = array('title' => 'แจ้งชำระเงิน | '.$this->config->item('sitename'),
								'description' =>  'แจ้งชำระเงิน | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'แจ้งชำระเงิน | '.$this->config->item('tagline') );

		//get menu database 
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();


		$data['content'] = 'tracking';
		$this->load->view('template/layout', $data);
	}

	public function get_all()
	{
		if($_GET["get"] != 'all'){

		   	$sql ="SELECT  * FROM orders WHERE trackpost IS NOT NULL AND id='".$_GET["get"]."' ORDER BY   date DESC";
			$re = $this->db->query($sql);
			$data['track_list'] = $re->result_array();

		    header('Content-Type: application/json');
			echo json_encode($data['track_list'] );
		}
		else{

		   	$sql ="SELECT  * FROM orders WHERE trackpost IS NOT NULL ORDER BY  date DESC LIMIT 10";
			$re = $this->db->query($sql);
			$data['track_list'] = $re->result_array();

		    header('Content-Type: application/json');
			echo json_encode($data['track_list'] );

		}
	}

}

/* End of file tracking.php */
/* Location: ./application/controllers/tracking.php */