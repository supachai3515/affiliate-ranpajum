<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Po_orders extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->model('po_orders_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('po_orders/index');
		$config['total_rows'] = $this->po_orders_model->get_po_orders_count();
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
		$data['po_orders_list'] = $this->po_orders_model->get_po_orders($page, $config['per_page']);
		$data['po_order_status_list'] = $this->po_orders_model->get_po_order_status();
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();

		//call script
        $data['menu_id'] ='16';
		$data['content'] = 'po_orders';
		$data['header'] = array('title' => 'po_orders| '.$this->config->item('sitename'),
								'description' =>  'po_orders| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);	
	}


	//page search
	public function search()
	{

		$return_data = $this->po_orders_model->get_po_orders_search();
		$data['po_orders_list'] = $return_data['result_po_orders'];
		$data['data_search'] = $return_data['data_search'];
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['po_order_status_list'] = $this->po_orders_model->get_po_order_status();

        $data['menu_id'] ='16';
		$data['content'] = 'po_orders';
		$data['header'] = array('title' => 'po_orders| '.$this->config->item('sitename'),
								'description' =>  'po_orders| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);	

	}

	//page edit
	public function edit($po_orders_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['po_orders_data'] = $this->po_orders_model->get_po_orders_id($po_orders_id);
		$data['po_orders_detail'] = $this->po_orders_model->get_po_orders_detail_id($po_orders_id);
		$data['po_order_status_list'] = $this->po_orders_model->get_po_order_status();
		$data['po_order_status_history_list'] = $this->po_orders_model->get_po_order_status_history($po_orders_id);
		
        $data['menu_id'] ='16';
		$data['content'] = 'po_orders_edit';
		$data['header'] = array('title' => 'po_orders| '.$this->config->item('sitename'),
								'description' =>  'po_orders| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);	

	}



	public function update_status($po_orders_id)
	{
		$this->is_logged_in();

		$this->po_orders_model->update_status($po_orders_id);

		if($po_orders_id!=""){
			redirect('po_orders/edit/'.$po_orders_id);
		}
		else {
			redirect('po_orders');
		}

	}
	public function update_tax($po_orders_id)
	{
		$this->is_logged_in();

		$this->po_orders_model->update_tax($po_orders_id);

		if($po_orders_id!=""){
			redirect('po_orders/edit/'.$po_orders_id);
		}
		else {
			redirect('po_orders');
		}

	}
	public function update_invoice($po_orders_id)
	{
		$this->is_logged_in();
		$this->po_orders_model->update_invoice($po_orders_id);

		if($this->input->post('is_invoice'))
		{

			$sql =" SELECT * FROM  po_orders WHERE id= '".$po_orders_id."' ";
			$re = $this->db->query($sql);
			$result_po_order_email =  $re->row_array();

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
	        $this->email->to($result_po_order_email["email"]);
	        $this->email->subject($this->config->item('email_name').'ใบสั่งซื้อเลขที่ #'.$result_po_order_email["invoice_docno"]);
	        $this->email->message($this->sendmail_update_invoice($result_po_order_email["id"]));
	        $this->email->send();
	    }

		if($po_orders_id!=""){
			redirect('po_orders/edit/'.$po_orders_id);
		}
		else {
			redirect('po_orders');
		}

	}
	

	public function update_tax_info($po_orders_id)
	{
		$this->is_logged_in();

		$this->po_orders_model->update_tax_info($po_orders_id);

		if($po_orders_id!=""){
			redirect('po_orders/edit/'.$po_orders_id);
		}
		else {
			redirect('po_orders');
		}

	}


	public function update_info($po_orders_id)
	{
		$this->is_logged_in();

		$this->po_orders_model->update_info($po_orders_id);

		if($po_orders_id!=""){
			redirect('po_orders/edit/'.$po_orders_id);
		}
		else {
			redirect('po_orders');
		}

	}
	public function update_order_item($po_orders_id,$po_product_id)
	{
		$this->is_logged_in();

		$this->po_orders_model->update_order_item($po_orders_id,$po_product_id);

		if($po_orders_id!=""){
			redirect('po_orders/edit/'.$po_orders_id);
		}
		else {
			redirect('po_orders');
		}

	}
	public function update_order_add($po_orders_id)
	{
		$this->is_logged_in();

		$this->po_orders_model->update_order_add($po_orders_id);

		if($po_orders_id!=""){
			redirect('po_orders/edit/'.$po_orders_id);
		}
		else {
			redirect('po_orders');
		}

	}
	public function update_shipping_charge($po_orders_id)
	{
		$this->is_logged_in();

		$this->po_orders_model->update_shipping_charge($po_orders_id);

		if($po_orders_id!=""){
			redirect('po_orders/edit/'.$po_orders_id);
		}
		else {
			redirect('po_orders');
		}

	}
	public function update_delete_item($po_orders_id,$po_product_id)
	{
		$this->is_logged_in();

		$this->po_orders_model->update_delete_item($po_orders_id,$po_product_id);
		if($po_orders_id!=""){
			redirect('po_orders/edit/'.$po_orders_id);
		}
		else {
			redirect('po_orders');
		}

	}
	
	public function update_tracking($po_orders_id)
	{
		$this->is_logged_in();

		$this->po_orders_model->update_tracking($po_orders_id);

		if($po_orders_id!=""){

			$sql =" SELECT * FROM  po_orders WHERE id= '".$po_orders_id."' ";
			$re = $this->db->query($sql);
			$result_po_order_email =  $re->row_array();

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
	        $this->email->to($result_po_order_email["email"]);
	        $this->email->subject($this->config->item('email_name').' ได้ส่งของให้กับ ใบสั่งซื้อเลขที่ #'.$result_po_order_email["invoice_docno"]);
	        $this->email->message($this->sendmail_po_order_tracking($result_po_order_email["id"]));
	        if($this->email->send())
		    {
		      redirect('po_orders/edit/'.$po_orders_id);
		    }

		    else
		    {
		       show_error($this->email->print_debugger());
		    }

			//redirect('po_orders/edit/'.$po_orders_id);
		}
		else {
			redirect('po_orders');
		}
	}


	// update
	public function update($po_orders_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save po_orders
		$this->po_orders_model->update_po_orders($po_orders_id);

		if($po_orders_id!=""){
			redirect('po_orders/edit/'.$po_orders_id);
		}
		else {
			redirect('po_orders');
		}

	}  

	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		$chk_admin =  $this->session->userdata('permission');
		if(!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin'){
			redirect('login');		
		}		
	}

	function sendmail_po_order_tracking($orderId)
	{
			
		$result='
				<table class="main" width="100%" cellpadding="0" cellspacing="0" style="color:#000;">
				    <tr>
				        @header
				    </tr>
				    <tr>
				        <td>
				            <b>ที่อยู่จัดส่งสินค้า<b><br><br>
				            @address
							<br><br>
							@_vat_address
				       </td>
				    </tr>
				    <tr style="padding: 20px;">
				        <td>
				           <table cellpadding="0" cellspacing="0" style="border-collapse: collapse;width: 100%;">
	                            <tr>
	                                <th style="text-align: left;padding: 8px;background-color: #000;color: white;">รายละเอียด</th>
	                                <th style="text-align: left;padding: 8px;background-color: #000;color: white;">ราคาต่อชิ้น</th>
	                                <th style="text-align: left;padding: 8px;background-color: #000;color: white;">จำนวน</th>
	                                <th style="text-align: left;padding: 8px;background-color: #000;color: white;">ราคารวม</th>
	                            </tr>
	                            @listOrder
	                        </table>
				        </td>
				    </tr>
				    <tr>
				        <td>
				            <table style="border-collapse: collapse;width: 100%;">
							    <tr>
							        <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">ค่าจัดส่ง</td>
							        <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">90 บาท</td>
							    </tr>
							    @vat
							    <tr>
							        <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">รามราคาสุทธิ</td>
							        <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">@sumtotal บาท</td>
							    </tr>
							</table>
				        </td>
				    </tr>
				</table>
				'; 


		$sql =" SELECT * FROM  po_orders WHERE id= '".$orderId."' ";
		$re = $this->db->query($sql);
		$result_order =  $re->row_array();

		$date1=date_create($result_order['date']);
		$header_str ='
					<td style="padding-bottom:20px;">
						<div style="background-color:#c4aa76;color:#fff;padding:20px;">
					       <h2 class="aligncenter">ทางเราได้จัดส่งสินค้า tracking number : '.$result_order['trackpost'].'</h2>
					       <p>เลขที่ใบสั่งซื้อ #'.$result_order['invoice_docno'].'<br/> 
					        วันที่สั่งซื้อ : '.date_format($date1,"d/m/Y H:i").'</p>
				        </div>
				    </td>
		';

	
		$address = '
				<strong>ชื่อ: </strong>'.$result_order["name"].'<br>
	            <strong>ที่อยู่: </strong>'.$result_order['address'].'<br>
	            <strong>เบอร์ติดต่อ: </strong>'.$result_order["tel"].'<br>
	            <strong>อีเมล์: </strong>'.$result_order["email"].'<br>
	            <strong>ประเภทการจัดส่ง: </strong>'.$result_order["shipping"].'<br>
			';


		$sql_detail ="SELECT * ,r.price price_order FROM po_order_detail r INNER JOIN  products p ON r.product_id = p.id
						WHERE r.po_order_id ='".$result_order['id']."' ORDER BY r.linenumber ";
		$re = $this->db->query($sql_detail);
		$po_order_detail = $re->result_array();

		 $orderList="";

		foreach ($po_order_detail as  $value) {

			  $orderList = $orderList.'

			   <tr>
                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">
                    sku : '.$value["sku"].'<br/>
                    <a target="_blank" href="'.$this->config->item('weburl')."product/".$value["slug"].'">
                        '.$value["name"].'
                    </a>
                </td>
                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">
                    '.number_format($value["price_order"],2).'
                </td>
                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">'.$value["quantity"].'</td>
                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">'.number_format($value["price_order"]*$value["quantity"],2).'</td>
              </tr>
			  ';
		}

		$vat_address = "";
		$vatstr = "";

		if($result_order['vat'] > 0)
		{

			$vat_address = '
				<b>ที่อยู่ใบกำกับภาษี<b><br><br>
				<strong>ร้าน / บริษัท: </strong>'.$result_order["tax_company"].'<br>
	            <strong>ที่อยู่ใบกำกับภาษี: </strong>'.$result_order["tax_address"].'<br>
	            <strong>เลขที่ผู้เสียภาษี: </strong>'.$result_order["tax_id"].'<br>
	            <strong>อีเมล์: </strong>'.$result_order["email"].'<br>
	            <br><br>
			';

			$vatstr = '<tr>
					   <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">ภาษีมูลค่าเพิ่ม 7%</td>
					   <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">'.number_format($result_order['vat'],2).' บาท</td>
					</tr>';
			}

			$result =  str_replace("@name", $result_order["name"],$result);
			$result =  str_replace("@orderId", $result_order['id'] ,$result);
			$result =  str_replace("@orderDate",date("Y-m-d H:i:s"),$result);

			$result =  str_replace("@linkstatus", $this->config->item('weburl').'status/'.$result_order['ref_id'],$result);
			$result =  str_replace("@header",$header_str,$result);
			$result =  str_replace("@reservations","",$result);	
			$result =  str_replace("@address",$address,$result);
			$result =  str_replace("@listOrder",$orderList,$result);
			$result =  str_replace("@vat",$vatstr,$result);
			$result =  str_replace("@_vat_address",$vat_address,$result);
			$result =  str_replace("@sumtotal",number_format($result_order['total'],2),$result);

			return $result;
	}

	function sendmail_update_invoice($orderId)
	{
			
		$result='
				<table class="main" width="100%" cellpadding="0" cellspacing="0" style="color:#000;">
				    <tr>
				        @header
				    </tr>
				    <tr>
				        <td>
				            <b>ที่อยู่จัดส่งสินค้า<b><br><br>
				            @address
							<br><br>
							@_vat_address
				       </td>
				    </tr>
				    <tr style="padding: 20px;">
				        <td>
				           <table cellpadding="0" cellspacing="0" style="border-collapse: collapse;width: 100%;">
	                            <tr>
	                                <th style="text-align: left;padding: 8px;background-color: #000;color: white;">รายละเอียด</th>
	                                <th style="text-align: left;padding: 8px;background-color: #000;color: white;">ราคาต่อชิ้น</th>
	                                <th style="text-align: left;padding: 8px;background-color: #000;color: white;">จำนวน</th>
	                                <th style="text-align: left;padding: 8px;background-color: #000;color: white;">ราคารวม</th>
	                            </tr>
	                            @listOrder
	                        </table>
				        </td>
				    </tr>
				    <tr>
				        <td>
				            <table style="border-collapse: collapse;width: 100%;">
							    <tr>
							        <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">ค่าจัดส่ง</td>
							        <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">90 บาท</td>
							    </tr>
							    @vat
							    <tr>
							        <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">รามราคาสุทธิ</td>
							        <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">@sumtotal บาท</td>
							    </tr>
							</table>
				        </td>
				    </tr>
				    <tr>
				        <td>
				            
				            <h4>วิธีการชำระเงิน และแจ้งการโอนเงิน :</h4>
				            <p style="text-align:left">
				            @payment
							</p>
							<p>ตรวจสอบสถานะการสั่งซื้อ  <a href="@linkstatus" target="_blank"> ที่นี่</a></p>
				        </td>
				    </tr>
				</table>
				'; 


		$sql =" SELECT * FROM  po_orders WHERE id= '".$orderId."' ";
		$re = $this->db->query($sql);
		$result_order =  $re->row_array();

		$date1=date_create($result_order['date']);
		$header_str ='
					<td style="padding-bottom:20px;">
						<div style="background-color:#c4aa76;color:#fff;padding:20px;">
					       <h2 class="aligncenter">เลขที่ใบสั่งซื้อ : #'.$result_order['invoice_docno'].'</h2>
					       <p>อ้างอิงจากใบเสนอราคา : #'.$orderId.'<br/> 
					        วันที่เสนอราคา : '.date_format($date1,"d/m/Y H:i").'</p>
				        </div>
				    </td>
		';

	
		$address = '
				<strong>ชื่อ: </strong>'.$result_order["name"].'<br>
	            <strong>ที่อยู่: </strong>'.$result_order['address'].'<br>
	            <strong>เบอร์ติดต่อ: </strong>'.$result_order["tel"].'<br>
	            <strong>อีเมล์: </strong>'.$result_order["email"].'<br>
	            <strong>ประเภทการจัดส่ง: </strong>'.$result_order["shipping"].'<br>
			';


		$sql_detail ="SELECT * ,r.price price_order FROM po_order_detail r INNER JOIN  products p ON r.product_id = p.id
						WHERE r.po_order_id ='".$result_order['id']."' ORDER BY r.linenumber ";
		$re = $this->db->query($sql_detail);
		$po_order_detail = $re->result_array();

		 $orderList="";

		foreach ($po_order_detail as  $value) {

			  $orderList = $orderList.'

			   <tr>
                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">
                    sku : '.$value["sku"].'<br/>
                    <a target="_blank" href="'.$this->config->item('weburl')."product/".$value["slug"].'">
                        '.$value["name"].'
                    </a>
                </td>
                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">
                    '.number_format($value["price_order"],2).'
                </td>
                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">'.$value["quantity"].'</td>
                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">'.number_format($value["price_order"]*$value["quantity"],2).'</td>
              </tr>
			  ';
		}

		$vat_address = "";
		$vatstr = "";

		if($result_order['vat'] > 0)
		{

			$vat_address = '
				<b>ที่อยู่ใบกำกับภาษี<b><br><br>
				<strong>ร้าน / บริษัท: </strong>'.$result_order["tax_company"].'<br>
	            <strong>ที่อยู่ใบกำกับภาษี: </strong>'.$result_order["tax_address"].'<br>
	            <strong>เลขที่ผู้เสียภาษี: </strong>'.$result_order["tax_id"].'<br>
	            <strong>อีเมล์: </strong>'.$result_order["email"].'<br>
	            <br><br>
			';

			$vatstr = '<tr>
					   <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">ภาษีมูลค่าเพิ่ม 7%</td>
					   <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">'.number_format($result_order['vat'],2).' บาท</td>
					</tr>';
			}

			$result =  str_replace("@name", $result_order["name"],$result);
			$result =  str_replace("@orderId", $result_order['id'] ,$result);
			$result =  str_replace("@orderDate",date("Y-m-d H:i:s"),$result);

			$result =  str_replace("@linkstatus",$this->config->item('weburl').'po_status/'.$result_order['ref_id'],$result);
			$result =  str_replace("@payment",$this->config->item('payment_transfer'),$result);
			$result =  str_replace("@header",$header_str,$result);
			$result =  str_replace("@reservations","",$result);	
			$result =  str_replace("@address",$address,$result);
			$result =  str_replace("@listOrder",$orderList,$result);
			$result =  str_replace("@vat",$vatstr,$result);
			$result =  str_replace("@_vat_address",$vat_address,$result);
			$result =  str_replace("@sumtotal",number_format($result_order['total'],2),$result);

			return $result;
	}

}

/* End of file po_orders.php */
/* Location: ./application/controllers/po_orders.php */