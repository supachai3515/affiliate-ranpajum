<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('members_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('members/index');
		$config['total_rows'] = $this->members_model->get_members_count();
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
		$data['members_list'] = $this->members_model->get_members($page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();

		//call script
		$data['script_file']= "js/product_add_js";
        $data['menu_id'] ='9';
		$data['content'] = 'members';
		$data['header'] = array('title' => 'members | '.$this->config->item('sitename'),
								'description' =>  'members | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);
	}

	//page search
	public function search()
	{

		$return_data = $this->members_model->get_members_search();
		$data['members_list'] = $return_data['result_members'];
		$data['data_search'] = $return_data['data_search'];
		$data['menus_list'] = $this->initdata_model->get_menu();

        $data['menu_id'] ='9';
		$data['content'] = 'members';
		$data['header'] = array('title' => 'members | '.$this->config->item('sitename'),
								'description' =>  'members | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	//page edit
	public function edit($member_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['member_data'] = $this->members_model->get_member($member_id);
        $data['menu_id'] ='9';
		$data['content'] = 'members_edit';
		$data['header'] = array('title' => 'members | '.$this->config->item('sitename'),
								'description' =>  'members | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	// update
	public function update($member_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save member
		$this->members_model->update_member($member_id);

		if($member_id!=""){
			redirect('members/edit/'.$member_id);
		}
		else {
			redirect('members');
		}

	}

		// update
	public function confirm($member_id)
	{

		if($member_id!=""){

			date_default_timezone_set("Asia/Bangkok");
			$data_member = array(
				'verify' => '1'
			);
			$where = "id = '".$member_id."'";
			$this->db->update("members", $data_member, $where);


			$sql =" SELECT * FROM  members WHERE id= '".$member_id."' ";
			$re = $this->db->query($sql);
			$result_dealer =  $re->row_array();

			 //sendmail
		    $email_config = Array(
	            'protocol'  => 'smtp',
	            'smtp_host' => 'ssl://smtp.googlemail.com',
	            'smtp_port' => '465',
	            'smtp_user' => $this->config->item('email_noreply'),
	            'smtp_pass' => $this->config->item('pass_mail_noreply'),
	            'mailtype'  => 'html',
	            'starttls'  => true,
	            'newline'   => "\r\n"
	        );
	        $this->load->library('email', $email_config);


	        $this->email->from($this->config->item('email_noreply'), $this->config->item('email_name'));
	        $this->email->to($result_dealer["email"]);
	        $this->email->subject('ได้ยืนยันการสมัคร Dealer เรียบร้อยแล้ว จาก '.$this->config->item('sitename'));
	        $this->email->message("ได้ยืนยันการสมัคร Dealer เรียบร้อยแล้ว จาก ".$this->config->item('sitename'));
	        if($this->email->send())
		    {
		    	redirect('members/edit/'.$member_id);
		    }

		    else
		    {
		       show_error($this->email->print_debugger());
		    }


		}
		else {
			redirect('members');
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

/* End of file prrducts.php */
/* Location: ./application/controllers/prrducts.php */
