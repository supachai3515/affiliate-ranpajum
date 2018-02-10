<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Initprogram extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->is_logged_in();
	}

	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true){
			$this->session->set_flashdata('msg', 'Access denied! You don\'t have permission to access this page or session has expired. Please use login form!');
			redirect('login');		
		}		
	}

}

/* End of file initprogram.php */
/* Location: ./application/libraries/initprogram.php */
