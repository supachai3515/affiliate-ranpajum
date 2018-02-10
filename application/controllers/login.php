<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('account_model');
	}
	
	public function index()
	{
		$data['content'] = 'login';
		$this->load->view('template/layout_login', $data);		
	}
	
	public function cek_login()
	{
		$user = $this->input->post('username');
		$pass = $this->input->post('password');
		if(empty($user) or empty($pass)){
			$this->session->set_flashdata('msg', 'Username or password can\'t be blank');
			redirect('login');
		}
				
		$query = $this->account_model->validasi();
		
		if($query)
		{
			$data = array(
				'username' => $user,
				'is_logged_in' => true
			);
			$this->session->set_userdata($data);
			redirect('dashboard');
		}
		else 
		{
			$this->session->set_flashdata('msg', 'Invalid username and password');
			redirect('login');
		}
	}
	
	public function signup()
	{

	}
		
	public function logout()
	{
		$this->session->sess_destroy();
		$this->index();
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */