<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->library('pagination');
		$this->load->helper(array('form', 'url'));
		$this->load->library('my_upload');
		$this->load->library('upload');
		 session_start();
	}

	public function index()
	{

		if($this->session->userdata('is_logged_in')){
			redirect('dealer','refresh');

		}


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


		$data['content'] = 'payment';
		$this->load->view('template/layout', $data);
	}

	public function order($ref_id)
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


		$sql ="SELECT
				o.id order_id,
				o.date,
				o.`name`,
				o.address,
				o.tel,
				o.email,
				o.is_tax,
				o.tax_address,
				o.tax_id,
				o.tax_company,
				o.trackpost,
				o.shipping,
				o.shipping_charge,
				o.customer_id,
				o.order_status_id,
				o.is_reservations,
				o.image_slip_own,
				o.image_slip_customer,
				o.reservations_date,
				o.quantity,
				o.vat,
				o.discount,
				o.total,
				o.isactive,
				o.ref_id,
				o.is_sendmail,
				o.is_invoice,
				m.first_name,
				m.last_name,
				m.email,
				m.tel,
				m.mobile,
				p.bank_name,
				p.`comment`,
				p.member_id,
				p.amount,
				p.inform_date_time,
				p.create_date,
				p.modified_date,
				p.is_active,
				m.id,
				m.company,
				m.username,
				m.`password`,
				m.verify,
				m.tax_number,
				m.address_receipt,
				m.address_tax,
				m.date,
				m.is_lavel1,
				m.is_active
				FROM orders o INNER JOIN  members m ON m.id = o.customer_id
				LEFT JOIN payment p ON p.order_id = o.id
				WHERE  o.ref_id = '".$ref_id."'";
		$query = $this->db->query($sql);
		$row = $query->row_array();

		if(count($row) == 0){
			redirect('payment','refresh');
		}else{
			$data['member_order'] = $row;
		}

		$data['content'] = 'payment_order';
		$data['script_file'] = 'js/payment_js';
		//print($ref_id);
		$this->load->view('template/layout', $data);
	}

	public function sendmail()
	{
		$data = json_decode(file_get_contents("php://input"));
	    $txtName = $data->txtName ;
	    $txtTel = $data->txtTel ;
	    $txtOrder = $data->txtOrder ;
	    $txtBank = $data->txtBank ;
	    $txtAmount = $data->txtAmount ;
	    $txtDate = $data->txtDate ;
	    $txtTime = $data->txtTime ;

	    $bodyText = " <p><strong>ชื่อผู้สั่งสินค้า : </strong> ".$txtName.'</p>';
	    $bodyText = $bodyText." <p><strong>เบอร์ติดต่อ : </strong> ".$txtTel.'</p>';
	    $bodyText = $bodyText." <p><strong>เลขที่ใบสั่งซื้อ : </strong> ".$txtOrder.'</p>';
	    $bodyText = $bodyText." <p><strong>ธนาคาร</strong> : ".$txtBank.'</p>';
	    $bodyText = $bodyText." <p><strong>จำนวนเงินที่โอน</strong> : ".$txtAmount.'</p>';
	    $bodyText = $bodyText." <p><strong>วันที่โอน </strong> : ".$txtDate.'</p>';
	    $bodyText = $bodyText." <p><strong>เวลาโอน </strong> : ".$txtTime.'</p>';
	    $bodyText = $bodyText." <p><strong>วันที่แจ้ง </strong> : ".date("Y-m-d H:i:s") .'</p>';


	    if(isset($data->txtName)){
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
	        $this->email->from($this->config->item('email_noreply'), 'แแจ้งการโอนเงินผ่านเว็บ เลขที่ใบสั่งซื้อ : '.$txtOrder);
	        $this->email->to($this->config->item('email_owner'));
	        $this->email->subject( 'คุณ ' . $txtName . ' ได้ทำการโอนเงินผ่านทางเว็บไซต์');
	        $this->email->message($bodyText);
	        if($this->email->send())
		     {
		     		$re['error'] = false;
					$re['message'] = 'เราได้รับการแจ้งเชำระเงินเรียบร้อยแล้ว';
					print json_encode($re);

		     }
		     else
		    {

		       show_error($this->email->print_debugger());
		    }

	    }
	    else{
	    		$re['error'] = true;
				$re['message'] = 'เกิดข้อผิดผลาด กรุณาแจ้งยืนยันอีกครั้ง';
				print json_encode($re);

	    }
	}

	public function save()
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
		$txtName = $this->input->post('txtName');
		if	(isset($txtName))
		{

			$txtName =  $this->input->post('txtName');
		    $txtTel = $this->input->post('txtTel');
		    $txtOrder = $this->input->post('txtOrder');
		    $txtBank = $this->input->post('txtBank');
		    $txtAmount = $this->input->post('txtAmount');
		    $txtDate = $this->input->post('txtDate');
		    $txtTime = $this->input->post('txtTime');

		    $bodyText = "<strong>ชื่อผู้สั่งสินค้า : </strong> ".$txtName.'<br>';
		    $bodyText = $bodyText."<strong>เบอร์ติดต่อ : </strong> ".$txtTel.'<br>';
		    $bodyText = $bodyText."<strong>เลขที่ใบสั่งซื้อ : </strong> ".$txtOrder.'<br>';
		    $bodyText = $bodyText."<strong>ธนาคาร</strong> : ".$txtBank.'<br>';
		    $bodyText = $bodyText."<strong>จำนวนเงินที่โอน</strong> : ".$txtAmount.'<br>';
		    $bodyText = $bodyText."<strong>วันที่โอน </strong> : ".$txtDate.'<br>';
		    $bodyText = $bodyText."<strong>เวลาโอน </strong> : ".$txtTime.'<br>';
		    $bodyText = $bodyText."<strong>วันที่แจ้ง </strong> : ".date("Y-m-d H:i:s") .'<br>';

		}


		$image_name = "";
		$dir ='./uploads/payment/'.date("Ym").'/';
		$dir_insert ='uploads/payment/'.date("Ym").'/';

        $this->my_upload->upload($_FILES["userfile"]);
	    if ( $this->my_upload->uploaded == true  )
	    {
	      $this->my_upload->allowed   = array('image/*');
	      //$this->my_upload->file_name_body_pre = 'thumb_';
	      $this->my_upload->image_resize          = true;
	      $this->my_upload->image_x               = 800;
	      $this->my_upload->image_ratio_y         = true;
	      $this->my_upload->process($dir);

	      if ($this->my_upload->processed == true )
	      {
	      	$data['is_error'] = false;
	      	$image_name  = $this->my_upload->file_dst_name;
            $bodyText = $bodyText.'<img src="'.base_url('/').$dir_insert.$image_name.'" class="img-responsive" alt="Image"width="100%"><br>';
            //$this->load->view('template/layout', $data );

	      }  else {

        	$data['is_error'] = true;
            $data['error'] = $this->my_upload->error;
            $bodyText = $bodyText."<strong>Image Error</strong> : ".$data['error']."<br>";
            //$this->load->view('template/layout', $data );
	      }
	  	} else  {
	        $data['is_error'] = true;
            $data['error'] = $this->my_upload->error;
            $bodyText = $bodyText."<strong>Image Error</strong> : ".$data['error']."<br>";
            //$this->load->view('template/layout', $data );
	    }

	   if(isset($txtName))
	   {
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
	        $this->email->from($this->config->item('email_noreply'), 'แแจ้งการโอนเงินผ่านเว็บ เลขที่ใบสั่งซื้อ : '.$txtOrder);
	        $this->email->to($this->config->item('email_owner'));
	        $this->email->subject( 'คุณ ' . $txtName . ' ได้ทำการโอนเงินผ่านทางเว็บไซต์');
	        $this->email->message($bodyText);
	        if($this->email->send())
		     {
		     		$re['error'] = false;
					$re['message'] = 'เราได้รับการแจ้งเชำระเงินเรียบร้อยแล้ว';
					//print json_encode($re);

		     }
		     else {
		     		$data['is_error'] = true;
			}
	    }

        $data['txt_res'] = $bodyText;
        $data['content'] = 'payment';
        $this->load->view('template/layout', $data );

	}

	public function save_order()
	{
		if(!$this->session->userdata('is_logged_in')){
 		 redirect('dealer','refresh');

 	 }

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



		$image_name = "";
		$dir ='./uploads/payment/'.date("Ym").'/';
		$dir_insert ='uploads/payment/'.date("Ym").'/';

        $this->my_upload->upload($_FILES["userfile"]);
	    if ( $this->my_upload->uploaded == true  )
	    {
	      $this->my_upload->allowed   = array('image/*');
	      //$this->my_upload->file_name_body_pre = 'thumb_';
	      $this->my_upload->image_resize          = true;
	      $this->my_upload->image_x               = 800;
	      $this->my_upload->image_ratio_y         = true;
	      $this->my_upload->process($dir);

	      if ( $this->my_upload->processed == true )
	      {

			$image_name  = $this->my_upload->file_dst_name;
			$data_product = array(
			"image_slip_customer" => $dir_insert.$image_name,
			);
			$where = "id = '".$this->input->post('order_id')."'";
			$this->db->update('orders', $data_product, $where );


			$sql = "DELETE FROM payment WHERE order_id = '".$this->input->post('order_id')."' AND  member_id = '".$this->input->post('member_id')."'";
			$this->db->query($sql);

			date_default_timezone_set("Asia/Bangkok");
			 $data_payment = array(
				"order_id" => $this->input->post('order_id'),
				"member_id" => $this->input->post('member_id'),
				"bank_name" => $this->input->post('bank_name'),
				"comment" => $this->input->post('comment'),
				"amount" => $this->input->post('amount'),
				"inform_date_time" => $this->input->post('inform_date')." ".$this->input->post('inform_time'),
				"create_date" => date("Y-m-d H:i:s"),
				"modified_date" => date("Y-m-d H:i:s"),
				"is_active" => 1,
			);
			$this->db->insert('payment', $data_payment);
			$this->my_upload->clean();
			$data['is_error'] = false;
			$data['error'] = "เราได้รับการแจ้งชำระเงินเรียบร้อยแล้ว";



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

		    $txtOrder = $this->input->post('order_id');
		    $txtBank = $this->input->post('bank_name');
		    $txtAmount = $this->input->post('amount');
		    $txtDate = $this->input->post('inform_date');
		    $txtTime = $this->input->post('inform_time');

			$bodyText = '<h3 class = "text-success">สมาชิก แจ้งชำระเงินใบสั่งซื้อเลขที่ #'.$txtOrder.'</h3>';
		    $bodyText = $bodyText.'<strong class = "text-success"> ธนาคาร</strong> : '.$txtBank.'<br>';
		    $bodyText = $bodyText.'<strong class = "text-success"> จำนวนเงินที่โอน</strong> : '.$txtAmount.'<br>';
		    $bodyText = $bodyText.'<strong class = "text-success"> วันที่โอน </strong> : '.$txtDate.'<br>';
		    $bodyText = $bodyText.'<strong class = "text-success"> เวลาโอน </strong> : '.$txtTime.'<br>';
		    $bodyText = $bodyText.'<strong class = "text-success"> วันที่แจ้ง </strong> : '.date("Y-m-d H:i:s") .'<br><br>';
		    $bodyText = $bodyText.'<img src="'.base_url('/').$dir_insert.$image_name.'" class="img-responsive" alt="Image"width="100%"><br>';
		    $data['txt_res'] = $bodyText;


	        $this->load->library('email', $email_config);
	        $this->email->from($this->config->item('email_noreply'), 'แแจ้งการโอนเงินผ่านเว็บ เลขที่ใบสั่งซื้อ : '.$txtOrder);
	        $this->email->to($this->config->item('email_owner'));
	        $this->email->subject( 'แจ้งชำระเงินใบสั่งซื้อเลขที่ #'.$txtOrder);
	        $this->email->message($bodyText);
	        if($this->email->send())
		     {
		     		$re['error'] = false;
					$re['message'] = 'เราได้รับการแจ้งเชำระเงินเรียบร้อยแล้ว';
					//print json_encode($re);

		     }
		     else {
		     		$data['is_error'] = true;
			}



	      } else {
	        $data['error'] = $this->my_upload->error;
	        //echo $data['errors'];

	        $data['is_error'] = true;

	      }
	    } else  {
	      	$data['error'] = $this->my_upload->error;
	        $data['is_error'] = true;
	    }

        $data['content'] = 'payment_order';
        $this->load->view('template/layout', $data );

	}

}

/* End of file payment.php */
/* Location: ./application/controllers/payment.php */
