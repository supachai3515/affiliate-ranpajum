<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Po_checkout extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->library('pagination');
		$this->load->model('dealer_model');
		 session_start();
	}

	public function index()
	{
		$username_login = array();
		$isUsername =0;
		
		if($this->session->userdata('is_logged_in')) {
			$data['orderList'] =  $this->dealer_model->get_orderList($this->session->userdata('username'));
			$data['dealerInfo'] =  $this->dealer_model->get_dealerInfo($this->session->userdata('username'));

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


        //content file view
		$data['content'] = 'po_checkout';
		// if have file script
		$data['script_file']= "template/app_po";
		//load layout
		$this->load->view('template/layout', $data);
	}

	public function save()
	{
		if($this->session->userdata('is_logged_in')) {
				$dealerInfo  =  $this->dealer_model->get_dealerInfo($this->session->userdata('username'));
				$sql1 ="SELECT qty, product_id, price, total FROM po_cart WHERE member_id ='".$dealerInfo['id']."' ";
				$query1 = $this->db->query($sql1);
		        $row1 = $query1->result_array();

		    if(count($row1) > 0)
		    {
			    $name =  $this->input->post('txtName');
			    $address =  $this->input->post('txtAddress');
			    $tel =  $this->input->post('txtTel');
			    $email =  $this->input->post('txtEmail');	    
			    $shipping  =  $this->input->post('txtTransport');

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
			    else { $is_tax = 0 ;}


			    $customer_id = "";

			    if($this->session->userdata('is_logged_in')) {
			    	$customer_id = $this->session->userdata('id');

			    }

				$order_status_id  = "1";
				$quantity  = 0;
				$vat  = 0;
				$discount  = 0;
				$total  = 0;

			    foreach ($row1 as $items) {

			    	$quantity  = $quantity + $items['qty'];
					$total  = $total + ($items['price']* $items['qty']);
				}
				

				if($is_tax ==1)
				{
					$vat  = ($total * 7) / 100;
				}

				$total  = ($total + $vat) + 90;


			    $this->db->trans_begin();
			    $ref_order_id = md5("cyberbatt".date("YmdHis")."cyberbatt_gen_order_id");
			    $order_id="";
			    if($quantity == 0){
			    	redirect('dealer_po','refresh');
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
					'shipping_charge' => 90 ,
					'is_tax' =>   $is_tax ,
					'customer_id' =>   $customer_id ,
					'po_order_status_id' =>   $order_status_id ,
					'quantity' =>   $quantity ,
					'vat' =>   $vat ,
					'discount' =>   $discount ,
					'total' =>   $total,
					'ref_id' =>   $ref_order_id ,
		            );

				$this->db->insert('po_orders', $data);
				$order_id = $this->db->insert_id();
				$linenumber =1;

			    foreach ($row1 as $items)
				{
					$total_detail  = $items['price'] * $items['qty'];
					$vat_detail  = 0;

					if($is_tax == 1)
					{
						$vat_detail  = ($total_detail * 7) / 100;
						
					}

					$total_detail  = $total_detail + $vat_detail;

			    	$data_detail = array(
				    	'po_order_id' =>   $order_id ,
						'product_id' =>   $items['product_id'],
						'linenumber' =>   $linenumber,				
						'quantity' =>   $items['qty'],
						'price' =>   $items['price'] ,
						'discount' =>   0 ,
						'vat' =>   $vat_detail ,
						'total' =>   $total_detail 
		            );

			    	$this->db->insert('po_order_detail', $data_detail); 
			    	$linenumber++;
				}
				
				if ($this->db->trans_status() === FALSE)
				{
				    $this->db->trans_rollback();
				    redirect('dealer_po','refresh');
				}
				else
				{
				    $this->db->trans_commit();

				    if($this->session->userdata('is_logged_in')){
						$dealerInfo  =  $this->dealer_model->get_dealerInfo($this->session->userdata('username'));
						$this->db->delete('po_cart', array('member_id' => $dealerInfo['id'])); 
				    }

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
			        $sub ="ใบเสนอราคา #".$order_id;

			        $this->email->from($this->config->item('email_noreply'), $this->config->item('email_name'));
			        $this->email->to($email);
			        $this->email->subject($sub);
			        $this->email->message($this->sendmail_order($order_id));
			        if($this->email->send())
				     {
				     	$this->email->from($this->config->item('email_noreply'), $this->config->item('email_name'));
			        	$this->email->to($this->config->item('email_owner'));
			        	$this->email->subject('ได้รับใบเสนอราคา '.$sub);
			        	$this->email->message($this->sendmail_order($order_id));
			         	$this->email->send();
				      	redirect('po_status/'.$ref_order_id );
				     }

				    else
				    {
				    	redirect('po_status/'.$ref_order_id );
				       //show_error($this->email->print_debugger());
				    }
		    
				}
		    }
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
							        <td style="padding: 5px 10px;background-color: #215A6D;color: #fff;">90 บาท</td>
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


		$sql =" SELECT * FROM  po_orders WHERE id= '".$orderId."' ";
		$re = $this->db->query($sql);
		$result_order =  $re->row_array();

		$date1=date_create($result_order['date']);
		$header_str ='
					<td>
				       <h2 class="aligncenter">ขอบคุณสำหรับการขอใบเสนอราคา ('.$this->config->item('sitename').')</h2>
				       <p>ใบเสนอราคา #'.$result_order['id'].'<br/> 
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


		$sql_detail ="SELECT * ,r.price price_order FROM po_order_detail r INNER JOIN  products p ON r.product_id = p.id
						WHERE r.po_order_id ='".$result_order['id']."' ORDER BY r.linenumber ";
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

			$result =  str_replace("@linkstatus", base_url('po_status/'.$result_order['ref_id']),$result);
			$result =  str_replace("@header",$header_str,$result);
			$result =  str_replace("@reservations","",$result);
			$result =  str_replace("@payment",$this->config->item('payment_transfer'),$result); 
			
			
			$result =  str_replace("@address",$address,$result);
			$result =  str_replace("@listOrder",$orderList,$result);
			$result =  str_replace("@vat",$vatstr,$result);
			$result =  str_replace("@_vat_address",$vat_address,$result);
			$result =  str_replace("@sumtotal",number_format($result_order['total'],2),$result);

			return $result;
	}


}

/* End of file checkout.php */
/* Location: ./application/controllers/checkout.php */