<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
	}

	public function index()
	{

		$username_login = array();
		$isUsername =0;

		if($this->session->userdata('is_logged_in')) {
			if($this->session->userdata('permission')=='2' )
			{
				$isUsername = 1;
			    $sql = "SELECT * FROM members WHERE username = '".$this->session->userdata('username')."' ";
				$query = $this->db->query($sql);
				$row = $query->row_array();
	            $username_login = array(
	                'FullName' => $row['first_name'],
	                'LastName' => $row['last_name'],
	                'ARecieve' => $row['address_receipt'],
	                'Company' => $row['company'],
	                'AVat' => $row['address_tax'],
	                'Mobile' => $row['mobile'],
	                'Nid' => $row['tax_number'],
	                'Email' => $row['email']
	            );
			}

		}
		$data['username_login'] = $username_login;
		$data['isUsername'] = $isUsername;

		//header meta tag
		$data['header'] = array('title' => 'ยืนยันการสั่งซื้อ | '.$this->config->item('sitename'),
								'description' =>  'ยืนยันการสั่งซื้อ | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'ยืนยันการสั่งซื้อ | '.$this->config->item('tagline') );
		//get menu database
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();

		$data['shipping_method'] = $this->initdata_model->get_shipping_method();
		$data['province_list'] = $this->initdata_model->get_province_list();
		$data['is_tax'] = 0;


        //content file view
		$data['content'] = 'checkout';
		// if have file script
		//$data['script_file']= "js/product_add_js";
		//load layout
		$this->load->view('template/layout', $data);
	}

	public function tax()
	{

		$username_login = array();
		$isUsername =0;

		if($this->session->userdata('is_logged_in')) {
			if($this->session->userdata('permission')=='2' )
			{
				$isUsername = 1;
			    $sql = "SELECT * FROM members WHERE username = '".$this->session->userdata('username')."' ";
				$query = $this->db->query($sql);
				$row = $query->row_array();
	            $username_login = array(
	                'FullName' => $row['first_name'],
	                'LastName' => $row['last_name'],
	                'ARecieve' => $row['address_receipt'],
	                'Company' => $row['company'],
	                'AVat' => $row['address_tax'],
	                'Mobile' => $row['mobile'],
	                'Nid' => $row['tax_number'],
	                'Email' => $row['email']
	            );
			}

		}
		$data['username_login'] = $username_login;
		$data['isUsername'] = $isUsername;

		//header meta tag
		$data['header'] = array('title' => 'ยืนยันการสั่งซื้อ | '.$this->config->item('sitename'),
								'description' =>  'ยืนยันการสั่งซื้อ | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'ยืนยันการสั่งซื้อ | '.$this->config->item('tagline') );
		//get menu database
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();
		$data['is_tax'] = 1;


        //content file view
		$data['content'] = 'checkout';
		// if have file script
		//$data['script_file']= "js/product_add_js";
		//load layout
		$this->load->view('template/layout', $data);
	}


	public function get_shipping_method()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['shipping_method'] =  $this->initdata_model->get_shipping_method();
		print json_encode($data['shipping_method']);

	}


	public function get_province_list()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['province_list'] =  $this->initdata_model->get_province_list();
		print json_encode($data['province_list']);

	}

	public function getProvince()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['amphur_list'] =  $this->initdata_model->get_amphur_list($value->province_id);
		print json_encode($data['amphur_list']);

	}

	public function getShipping()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['shipping_price'] =  $this->initdata_model->get_sipping($value->shipping_id);
		print json_encode($data['shipping_price']);

	}

	public function getSpecialCounty()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['county_price'] =  $this->initdata_model->get_sipping_spcial($value->amphur_id);
		print json_encode($data['county_price']);

	}


	public function save()
	{
		if(count($this->cart->contents())>0){
			$name =  $this->input->post('txtName');
		    $address =  $this->input->post('txtAddress');
		    $tel =  $this->input->post('txtTel');
		    $email =  $this->input->post('txtEmail');
		    $shipping  =  $this->input->post('txtTransport');
		    $shipping_price  =  $this->input->post('shipping_price');

		    $shipping_method = $this->initdata_model->get_shipping_method();
		    foreach ($shipping_method  as $row) {
		    	if($row['id']== $shipping)
		    		$shipping = $row['name'];
		    }


		    $tax_id =  "";
		    $tax_address =  "";
		    $tax_company = "";

		    $is_tax =  $this->input->post('purchase');
		    if( $is_tax =="on"){
		    	$is_tax =1 ;
		    	$tax_id =  $this->input->post('IDCARD');
		    	$tax_address =  $this->input->post('purchase_address');
		    	$tax_company =  $this->input->post('company');
		    }
		    else{ $is_tax = 0 ;}


		    $customer_id = "";

		    if($this->session->userdata('is_logged_in')) {
		    	$customer_id = $this->session->userdata('id');

		    }

			$order_status_id  = "1";
			$quantity  = 0;
			$vat  = 0;
			$discount  = 0;
			$total  = 0;

		    foreach ($this->cart->contents() as $items) {

		    	$quantity  = $quantity + $items['qty'];
				$total  = $total + ($items['price']* $items['qty']);
			}

			$vat  = ($total * 7) /107;
			$total  = $total + $shipping_price;


		    $this->db->trans_begin();
		    $ref_order_id = md5("xcitehitec".date("YmdHis")."xcitehitec_gen");
		    $order_id="";
		    if($quantity == 0){
		    	redirect('cart','refresh');
		    }

		    date_default_timezone_set("Asia/Bangkok");
	        $data = array(
	        	'date' => date("Y-m-d H:i:s"),
				'name' => $name ,
				'address' =>  $address,
				'tel' =>  $tel ,
				'email' =>  $email ,
				'tax_id' =>   $tax_id ,
				'tax_address' =>   $tax_address,
				'tax_company' =>   $tax_company ,
				'shipping' =>   $shipping ,
				'shipping_charge' => $shipping_price ,
				'is_tax' =>   $is_tax ,
				'customer_id' =>   $customer_id ,
				'order_status_id' =>   $order_status_id ,
				'quantity' =>   $quantity ,
				'vat' =>   $vat ,
				'discount' =>   $discount ,
				'total' =>   $total,
				'ref_id' =>   $ref_order_id ,
	            );

			$this->db->insert('orders', $data);
			$order_id = $this->db->insert_id();
			$linenumber =1;

			foreach ($this->cart->contents() as $items)
			{

				$total_detail  = $items['price'] * $items['qty'];
				$vat_detail  = 0;

				if($is_tax == 1)
				{
					$vat_detail  = ($total_detail * 7) / 107;
				}

		    	$data_detail = array(
			    	'order_id' =>   $order_id ,
					'product_id' =>   $items['id'],
					'linenumber' =>   $linenumber,
					'quantity' =>   $items['qty'],
					'price' =>   $items['price'] ,
					'discount' =>   0 ,
					'vat' =>   $vat_detail ,
					'total' =>   $total_detail
	            );

		    	$this->db->insert('order_detail', $data_detail);
		    	$linenumber++;
			}

			if ($this->db->trans_status() === FALSE)
			{
			    $this->db->trans_rollback();
			    redirect('cart','refresh');
			}
			else
			{
			    $this->db->trans_commit();
			    $this->cart->destroy();

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
		        $sub ="เลขที่ใบสั่งซื้อ #".$order_id;

		        $this->email->from($this->config->item('email_noreply'), $this->config->item('email_name'));
		        $this->email->to($email);
		        $this->email->subject($sub);
		        $this->email->message($this->sendmail_order($order_id));
		        if($this->email->send())
			     {
			     	$this->email->from($this->config->item('email_noreply'), $this->config->item('email_name'));
		        	$this->email->to($this->config->item('email_owner'));
		        	$this->email->subject('ได้รับการสั่งซื้อ '.$sub);
		        	$this->email->message($this->sendmail_order($order_id));
		         	$this->email->send();
			      	redirect('status/'.$ref_order_id );
			     }

			    else
			    {
			    	redirect('status/'.$ref_order_id );
			       //show_error($this->email->print_debugger());
			    }

			}

		}
		else{
			redirect('products','refresh');
		}

	}

	function sendmail_order($orderId)
	{

		$result='
				<table class="main" width="100%">
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
				           <table style="width: 100%;">
	                            <tr  style = "padding: 5px 10px;background-color: #2D2D29;color: #fff;">
	                                <th style="padding: 5px 10px;background-color: #215A6D;color: #fff;">รายละเอียด</th>
	                                <th style="padding: 5px 10px;background-color: #215A6D;color: #fff;">ราคาต่อชิ้น</th>
	                                <th style="padding: 5px 10px;background-color: #215A6D;color: #fff;">จำนวน</th>
	                                <th style="padding: 5px 10px;background-color: #215A6D;color: #fff;">ราคารวม</th>
	                            </tr>
	                            @listOrder
	                        </table>
				        </td>
				    </tr>
				    <tr>
				        <td>
				            <table style="float: right">
							    <tr>
							        <td style="padding: 5px 10px;background-color: #215A6D;color: #fff;">ค่าจัดส่ง</td>
							        <td style="padding: 5px 10px;background-color: #215A6D;color: #fff;">@shipping_price</td>
							    </tr>
							    @vat
							    <tr>
							        <td style="padding: 5px 10px;background-color: #215A6D;color: #fff;">รามราคาสุทธิ</td>
							        <td style="padding: 5px 10px;background-color: #215A6D;color: #fff;">@sumtotal บาท</td>
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


		$sql =" SELECT * FROM  orders WHERE id= '".$orderId."' ";
		$re = $this->db->query($sql);
		$result_order =  $re->row_array();

		$date1=date_create($result_order['date']);
		$header_str ='
					<td>
				       <h2 class="aligncenter">ขอบคุณสำหรับการสั่งซื้อ ('.$this->config->item('sitename').')</h2>
				       <p>เลขที่ใบสั่งซื้อ #'.$result_order['id'].'<br/>
				        วันที่สั่งซื้อ : '.date_format($date1,"d/m/Y H:i").'</p>
				    </td>
		';


		$address = '
				<strong>ชื่อ: </strong>'.$result_order["name"].'<br>
	            <strong>ที่อยู่: </strong>'.$result_order['address'].'<br>
	            <strong>เบอร์ติดต่อ: </strong>'.$result_order["tel"].'<br>
	            <strong>อีเมล์: </strong>'.$result_order["email"].'<br>
	            <strong>ประเภทการจัดส่ง: </strong>'.$result_order["shipping"].'<br>
			';


		$sql_detail ="SELECT * ,r.price price_order FROM order_detail r INNER JOIN  products p ON r.product_id = p.id
						WHERE r.order_id ='".$result_order['id']."' ORDER BY r.linenumber ";
		$re = $this->db->query($sql_detail);
		$order_detail = $re->result_array();

		 $orderList="";

		foreach ($order_detail as  $value) {

			  $orderList = $orderList.'

			   <tr>
                <td style="padding: 5px 10px;background-color: #92C7A3;color: #fff;">
                    SKU : '.$value["sku"].'<br/>
                    <a target="_blank" href="'.base_url("product/".$value["slug"]).'">
                        '.$value["name"].'
                    </a>
                </td>
                <td style="padding: 5px 10px;background-color: #92C7A3;color: #fff;">
                    '.number_format($value["price_order"],2).'
                </td>
                <td style="padding: 5px 10px;background-color: #92C7A3;color: #fff;">'.$value["quantity"].'</td>
                <td style="padding: 5px 10px;background-color: #92C7A3;color: #fff;">'.number_format($value["price_order"]*$value["quantity"],2).'</td>
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
					   <td style="padding: 5px 10px;background-color: #215A6D;color: #fff;">ภาษีมูลค่าเพิ่ม 7%</td>
					   <td style="padding: 5px 10px;background-color: #215A6D;color: #fff;">'.number_format($result_order['vat'],2).' บาท</td>
					</tr>';
			}

			$result =  str_replace("@name", $result_order["name"],$result);
			$result =  str_replace("@orderId", $result_order['id'] ,$result);
			$result =  str_replace("@orderDate",date("Y-m-d H:i:s"),$result);

			$result =  str_replace("@linkstatus", base_url('status/'.$result_order['ref_id']),$result);
			$result =  str_replace("@header",$header_str,$result);
			$result =  str_replace("@reservations","",$result);
			$result =  str_replace("@payment",$this->config->item('payment_transfer'),$result);


			$result =  str_replace("@address",$address,$result);
			$result =  str_replace("@listOrder",$orderList,$result);
			$result =  str_replace("@vat",$vatstr,$result);
			$result =  str_replace("@_vat_address",$vat_address,$result);
			$result =  str_replace("@shipping_price", $result_order['shipping']." ".number_format($result_order['shipping_charge'],2),$result);
			$result =  str_replace("@sumtotal",number_format($result_order['total'],2),$result);

			return $result;
	}


}

/* End of file checkout.php */
/* Location: ./application/controllers/checkout.php */
