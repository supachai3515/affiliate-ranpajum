<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dealer extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->library('pagination');
		$this->load->model('dealer_model');
		 
	}

	public function index()
	{
		if($this->session->userdata('is_logged_in')){
			$data['orderList'] =  $this->dealer_model->get_orderList($this->session->userdata('username'));
			$data['dealerInfo'] =  $this->dealer_model->get_dealerInfo($this->session->userdata('username'));
			
		}

		//header meta tag 
		$data['header'] = array('title' => 'สมาชิก dealer | '.$this->config->item('sitename'),
								'description' => 'สมาชิก dealer | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' => 'สมาชิก dealer | '.$this->config->item('tagline') );
		//get menu database 
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();

        //content file view
		$data['content'] = 'dealer';
		// if have file script
		//$data['script_file']= "js/product_add_js";
		//load layout
		$this->load->view('template/layout', $data);
	}

	public function register()
	{
		$value = json_decode(file_get_contents("php://input"));

		$phone ="";
		$nid = "";
		$addressVat =""; 

		if(isset($value->phone))
		{
			$phone = $value->phone;
		}
		if(isset($value->nid))
		{
			$nid = $value->nid;
		}
		if(isset($value->addressVat))
		{
			$addressVat = $value->addressVat;
		}

		if($value->password != $value->confirm_password){
			$data['error'] = true;
				$data['message'] = ' ใส่รหัสผ่านไม่ตรงกัน';
				print json_encode($data);
				return;

		}
		

		date_default_timezone_set("Asia/Bangkok");
			$data_member = array(
				'first_name' => $value->name,
				'last_name' => $value->lastname,
				'company' => $value->shop,
				'username' => $value->email,
				'password' => $value->password,
				'email' => $value->email,
				'tel' => $phone,
				'mobile' => $value->mobile,
				'verify' => '0',
				'tax_number' => $nid,
				'address_receipt' => $value->address,
				'address_tax' => $addressVat,
				'date' => date("Y-m-d H:i:s"),
				'is_active' => '1',

			);

			$query = $this->db->query(" SELECT COUNT(email) as connt_id FROM  members WHERE email ='".$value->email."' ");
			$row = $query->row_array();
			if($row['connt_id']==1)
			{
				$data['error'] = true;
				$data['message'] = $value->email.' มีการสมัครแล้ว';
				print json_encode($data);
				//$where = "id = '".$sku_str."'"; 
				//$this->db->update("product_type", $data_product, $where);
			
			}
			else {

				 $this->db->insert("members", $data_member);
				 $insert_id = $this->db->insert_id();
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
		        $sub ="ขอบคุณการสมัคร Dealer - ".$value->name .' '.$value->lastname;

		        $this->email->from($this->config->item('email_noreply'), $this->config->item('email_name'));
		        $this->email->to($value->email.','.$this->config->item('email_owner'));
		        $this->email->subject($sub);
		        $this->email->message($this->sendmail_dealer($insert_id));
		        $this->email->send();
			     
				//$insert_id = $this->db->insert_id();
		   		//return  $insert_id;
			}
	
	}
	function sendmail_dealer($dealer_id)
	{

		$sql =" SELECT *FROM members WHERE id= '".$dealer_id."' ";
		$re = $this->db->query($sql);
		$result_dealer =  $re->row_array();
		 $result = '<h4>รายละเอียดสมาชิก</h4>
			 <p>
			 	<strong>ชื่อ : </strong>	'.$result_dealer['first_name'].' '.$result_dealer['last_name'].'<br/>
			 	<strong>ชื่อร้าน / บริษัท : </strong>	'.$result_dealer['company'].'<br/>
			 	<strong>username : </strong>	'.$result_dealer['username'].'<br/>
			 	<strong>password : </strong>	'.$result_dealer['password'].'<br/>
			 	<strong>email : </strong>	'.$result_dealer['email'].'<br/>
			 	<strong>เบอร์โทร : </strong>	'.$result_dealer['tel'].' '.$result_dealer['mobile'].'<br/>
			 	<strong>เลขที่ผู้เสียภาษี : </strong>	'.$result_dealer['tax_number'].'<br/>
			 	<strong>ที่อยู่จัดส่งสินค้า : </strong>	'.$result_dealer['address_receipt'].'<br/>
			 	<strong>ที่อยู่ออกใบกำกับภาษี : </strong>	'.$result_dealer['address_tax'].'<br/>
			 	<strong>วันที่สมัคร : </strong>	'.$result_dealer['date'].'<br/>
			 	<h4>หลักฐานทะเบียนการค้า</h4> 
                <p>เอกสารที่ต้องใช้ ให้แนปไฟล์ส่งมาที่<br><span> Email: '.$this->config->item('email_owner').'</span></p>
                  <ul>
                  <li> 1. สำเนาใบทะเบียนพาณิชย์ ให้เซ็นชื่อสำเนาถูกต้อง 1 ฉบับ</li>
                    <li> 2. สำเนาบัตรประชาชน ให้เซ็นชื่อสำ เนาถูกต้อง 1 ฉบับ</li>
                  </ul>
                  <div style=" background-color: #eaeaea;">"รอการตรวจสอบจากทางร้าน ถ้าตรวจสอบแล้ว จะแจ้งทางอีเมลล์"
                  </div> 
			 </p>
		 ';
	
		return $result;

	}

	public function edit()
	{
		if($this->session->userdata('is_logged_in')) {
			$value = json_decode(file_get_contents("php://input"));
			date_default_timezone_set("Asia/Bangkok");
			$data_member = array(
				'first_name' => $value->first_name,
				'last_name' => $value->last_name,
				'company' => $value->company,
				'username' => $value->email,
				'password' => $value->password,
				'email' => $value->email,
				'tel' => $value->tel,
				'mobile' => $value->mobile,
				'tax_number' => $value->tax_number,
				'address_receipt' => $value->address_receipt,
				'address_tax' => $value->address_tax,
				'date' => date("Y-m-d H:i:s")
			);

			$query = $this->db->query(" SELECT COUNT(email) as connt_id FROM  members WHERE username ='".$this->session->userdata('username')."' ");
			$row = $query->row_array();
			if($row['connt_id']==1)
			{
				$where = "username = '".$this->session->userdata('username')."'"; 
				$this->db->update("members", $data_member, $where);
			}
			else {
				$data['error'] = true;
				$data['message'] = $value->email.' อีเมลล์นี้ถูกใช้แล้ว';
				print json_encode($data);

				//$insert_id = $this->db->insert_id();
		   		//return  $insert_id;
			}
			
		}

	}

	public function login()
	{
		$user = $this->input->post('username');
		$pass = $this->input->post('password');
		if(empty($user) or empty($pass)){
			$this->session->set_flashdata('msg', 'ชื่อผู้ใช้หรือรหัสผ่านไม่สามารถว่างได้');
			redirect('dealer');
		}
				
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', $this->input->post('password'));
		$query = $this->db->get("members");
		
		if($query->num_rows() == 1)
		{
			$dealerInfo =  $this->dealer_model->get_dealerInfo($this->input->post('username'));

			$data = array(
				'username' => $user,
				'permission' => 2,
				'verify' => $dealerInfo['verify'],
				'id' => $dealerInfo['id'],
				'is_lavel1' => $dealerInfo['is_lavel1'],
				'is_logged_in' => true
			);
			$this->session->set_userdata($data);
			redirect('dealer');
		}
		else 
		{
			$this->session->set_flashdata('msg', 'ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง');
			redirect('dealer');
		}

	}

	public function getdealer()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['dealerInfo'] =  $this->dealer_model->get_dealerInfo($value->name_dealer);
		print json_encode($data['dealerInfo']);

	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('dealer');
	}

}

/* End of file dealer.php */
/* Location: ./application/controllers/dealer.php */