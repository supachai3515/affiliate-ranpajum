<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('orders_model');
		$this->load->library('pagination');
		$this->load->helper(array('form', 'url'));
		$this->load->library('my_upload');
		$this->load->library('upload');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('orders/index');
		$config['total_rows'] = $this->orders_model->get_orders_count();
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
		$data['orders_list'] = $this->orders_model->get_orders($page, $config['per_page']);
		$data['order_status_list'] = $this->orders_model->get_order_status();
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();

		//call script
        $data['menu_id'] ='10';
		$data['content'] = 'orders';
		$data['header'] = array('title' => 'orders| '.$this->config->item('sitename'),
								'description' =>  'orders| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);
	}


	//page search
	public function search()
	{

		$return_data = $this->orders_model->get_orders_search();
		$data['orders_list'] = $return_data['result_orders'];
		$data['data_search'] = $return_data['data_search'];
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['order_status_list'] = $this->orders_model->get_order_status();

        $data['menu_id'] ='10';
		$data['content'] = 'orders';
		$data['header'] = array('title' => 'orders| '.$this->config->item('sitename'),
								'description' =>  'orders| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	//page edit
	public function edit($orders_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['orders_data'] = $this->orders_model->get_orders_id($orders_id);
		$data['orders_detail'] = $this->orders_model->get_orders_detail_id($orders_id);
		$data['order_status_list'] = $this->orders_model->get_order_status();
		$data['order_status_history_list'] = $this->orders_model->get_order_status_history($orders_id);

        $data['menu_id'] ='10';
		$data['content'] = 'orders_edit';
		$data['script_file']= "js/order_js";
		$data['header'] = array('title' => 'orders| '.$this->config->item('sitename'),
								'description' =>  'orders| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}


   //update status order
	public function update_status($orders_id)
	{
		$this->is_logged_in();

		$this->orders_model->update_status($orders_id);

		if($orders_id!=""){
			redirect('orders/edit/'.$orders_id);
		}
		else {
			redirect('orders');
		}

	}

	public function update_tracking($orders_id)
	{
		$this->is_logged_in();

		$this->orders_model->update_tracking($orders_id);
		$this->orders_model->update_status($orders_id);

		if($orders_id!=""){

			$sql =" SELECT * FROM  orders WHERE id= '".$orders_id."' ";
			$re = $this->db->query($sql);
			$result_order_email =  $re->row_array();

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
	        $this->email->to($result_order_email["email"]);
	        $this->email->subject($this->config->item('email_name').' ได้ส่งของให้กับ ใบสั่งซื้อเลขที่ #'.$result_order_email["id"]);
	        $this->email->message($this->sendmail_order_tracking($result_order_email["id"]));
	        if($this->email->send())
		    {
		      redirect('orders/edit/'.$orders_id);
		    }

		    else
		    {
		       show_error($this->email->print_debugger());
		    }

			//redirect('orders/edit/'.$orders_id);
		}
		else {
			redirect('orders');
		}
	}


	// update
	public function update($orders_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save orders
		$this->orders_model->update_orders($orders_id);

		if($orders_id!=""){
			redirect('orders/edit/'.$orders_id);
		}
		else {
			redirect('orders');
		}

	}

	// update
	public function update_address($orders_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save orders
		$this->orders_model->update_address($orders_id);

		if($orders_id!=""){
			redirect('orders/edit/'.$orders_id);
		}
		else {
			redirect('orders');
		}

	}





	public function invoice($orders_id,$print_f = 0)
	{
		$this->is_logged_in();

		$data['print_f'] = $print_f;
		$data['orders_tem'] = $this->orders_model->get_orders_id($orders_id);

		if($data['orders_tem']['is_invoice'] == 0){

			$checkDate = 'INV'.date("ymd");
			$sql ="SELECT COUNT(*)+1 connt_id FROM orders WHERE  LEFT(invoice_docno, 7) = LEFT('".$checkDate."', 7)  ";
			$query = $this->db->query($sql);
			$row = $query->row_array();
			$order_inv_count =  $row['connt_id'];

			date_default_timezone_set("Asia/Bangkok");
			$data_order = array(
				'is_invoice' => 1,
				'invoice_date' => date("Y-m-d H:i:s"),
				'invoice_docno' => 'INV'.date("ymd").str_pad($order_inv_count, 4, "0", STR_PAD_LEFT)
			);

			$where = array('id' => $orders_id);
			$this->db->update("orders", $data_order, $where);

		}

		$data['orders_data'] = $this->orders_model->get_orders_id($orders_id);
		$data['orders_detail'] = $this->orders_model->get_orders_detail_id($orders_id);
		$data['order_status_list'] = $this->orders_model->get_order_status();
		$data['order_status_history_list'] = $this->orders_model->get_order_status_history($orders_id);
		$this->load->view('invoice_doc', $data);

	}

	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		$chk_admin =  $this->session->userdata('permission');
		if(!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin'){
			redirect('login');
		}
	}


	public function get_product_serial()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['serial'] =  $this->orders_model->get_product_serial($value->product_id, $value->order_id);
		print json_encode($data['serial']);
	}

	public function save_serial()
	{

		$res = array('is_error' => false,
					 'message' => "",
				);


		try {

			$values = json_decode(file_get_contents("php://input"));
			$this->db->trans_start(); # Starting Transaction
			foreach ($values as $value ) {
				if(trim($value->serial_number) != "") {

						//check ของเดิม ว่ามีการบันทึกไปแล้วหรือยัง
						$sql =" SELECT * FROM product_serial WHERE serial_number = '".$value->serial_number."'
								AND product_id = '".$value->product_id."'  AND order_id != '".$value->order_id."' ";

						$re = $this->db->query($sql);
						$row =  $re->row_array();
						if(count($row) > 0){

							$res['is_error'] =  true;
							$res['message']  = $res['message'].$value->serial_number." : ถูกบันทึกแล้วเลขที่ order : #".$value->order_id;
						}
						else {


							$sql =" SELECT * FROM product_serial WHERE serial_number = '".$value->serial_number."'
								AND product_id = '".$value->product_id."' ";

								$re = $this->db->query($sql);
								$row =  $re->row_array();

								if(count($row) > 0) {
									$res['message']  = "";
								}
								else {

									$res['is_error'] =  true;
									$res['message']  = $res['message'].$value->serial_number." : ไม่มีในระบบ, ";
								}

						}
				}
			}

			if($res['is_error'] == false) {

				//check ของเดิม ว่ามีการบันทึกไปแล้วหรือยัง
				$sql =" SELECT * FROM product_serial WHERE order_id = '".$value->order_id."'
					AND product_id = '".$value->product_id."' ";

				$re = $this->db->query($sql);
				$row_re =  $re->result_array();
				foreach ($row_re as $r_ow )
				{
					date_default_timezone_set("Asia/Bangkok");
					$data_serial_history = array(
						'serial_number' =>$r_ow['serial_number'],
						'product_id' => $r_ow['product_id'],
						'comment' => "แก้ไขจาก เลขที่ใบสั่งซื้อ #".$value->order_id,
						'create_date' => date("Y-m-d H:i:s"),
					);
					$this->db->insert("serial_history", $data_serial_history);

					//update serial
					date_default_timezone_set("Asia/Bangkok");
					$data_product_serial = array(
						'order_id' => NULL,
						'modified_date_order' =>date("Y-m-d H:i:s"),
					);

					$where = "serial_number = '".$r_ow['serial_number']."' AND product_id = '".$r_ow['product_id']."'   ";
					$this->db->update("product_serial", $data_product_serial,$where );

				}

				foreach ($values as $value ) {

					if(trim($value->serial_number) != "")
					{


						//update history
						date_default_timezone_set("Asia/Bangkok");
						$data_serial_history = array(
								'serial_number' =>$value->serial_number,
								'product_id' => $value->product_id,
								'comment' => "ยันยันการขาย เลขที่ใบสั่งซื้อ #".$value->order_id,
								'create_date' => date("Y-m-d H:i:s"),
						);
						$this->db->insert("serial_history", $data_serial_history);

						//update serial
						date_default_timezone_set("Asia/Bangkok");
						$data_product_serial = array(
							'serial_number' =>$value->serial_number,
							'product_id' => $value->product_id,
							'order_id' => $value->order_id,
							'modified_date' => date("Y-m-d H:i:s"),
							'modified_date_order' =>date("Y-m-d H:i:s"),
						);


						$db_debug = $this->db->db_debug; //save setting
						$this->db->db_debug = FALSE; //disable debugging for queries

						$where = "serial_number = '".$value->serial_number."' AND product_id = '".$value->product_id."' ";
						$this->db->update("product_serial", $data_product_serial,$where );

						$this->db->db_debug = $db_debug; //restore setting
					}

				}

			}

			$this->db->trans_complete(); # Completing transaction
			/*Optional*/

			if ($this->db->trans_status() === FALSE) {
			    # Something went wrong.
			    $this->db->trans_rollback();
			    print json_encode( $res);
			    // return FALSE;
			}
			else {
			    # Everything is Perfect.
			    # Committing data to the database.
			    $this->db->trans_commit();

			    if($res['is_error'] == false){
			    	$res['message']  = "บันทึกสำเร็จ";
			    }
			    print json_encode( $res);
			    // return TRUE;
			}
		}
		catch (Exception $e) {

			$res['is_error'] =  true;
			$res['message']  = $e->getMessage();
			print json_encode( $res);
		}

	}

	public function save_slip($order_id)
	{
		$image_name = "";
		$dir ='./../uploads/payment/'.date("Ym").'/';
		$dir_insert ='uploads/payment/'.date("Ym").'/';

		if($order_id!="")
		{


			$sql = "DELETE FROM payment WHERE order_id = '".$order_id."' ";
			$this->db->query($sql);

			 date_default_timezone_set("Asia/Bangkok");
			 $data_payment = array(
				"order_id" => $order_id,
				"credit_note_id" => $this->input->post('credit_note_id'),
				"member_id" => $this->input->post('member_id'),
				"bank_name" => $this->input->post('bank_name'),
				"comment" => $this->input->post('comment'),
				"amount" => $this->input->post('amount'),
				"inform_date_time" => $this->input->post('inform_date')." ".$this->input->post('inform_time'),
				"modified_date" => date("Y-m-d H:i:s"),
				"is_active" => "1",
			);

			$where = "order_id = '".$order_id."'";
			$this->db->insert('payment', $data_payment, $where);
			print($where );


			$this->my_upload->upload($_FILES["image_field"]);
		    if ( $this->my_upload->uploaded == true  )
		    {
		      $this->my_upload->allowed   = array('image/*');
		      //$this->my_upload->file_name_body_pre = 'thumb_';
		      $this->my_upload->image_resize          = true;
		      $this->my_upload->image_x               = 800;
		      $this->my_upload->image_ratio_y         = true;
		      $this->my_upload->process($dir);

		      if ( $this->my_upload->processed == true ) {

		        $image_name  = $this->my_upload->file_dst_name;
		        $data_product = array(
					"image_slip_customer" => $dir_insert.$image_name,
				);
				$where = "id = '".$order_id."'";
				$this->db->update('orders', $data_product, $where );


		        $this->my_upload->clean();
		      } else {
		        $data['errors'] = $this->my_upload->error;
		        echo $data['errors'];
		      }
		    } else  {
		      $data['errors'] = $this->my_upload->error;
		    }

		    $this->my_upload->upload($_FILES["image_field1"]);
		    if ( $this->my_upload->uploaded == true  )
		    {
		      $this->my_upload->allowed   = array('image/*');
		      //$this->my_upload->file_name_body_pre = 'thumb_';
		      $this->my_upload->image_resize          = true;
		      $this->my_upload->image_x               = 800;
		      $this->my_upload->image_ratio_y         = true;
		      $this->my_upload->process($dir);

		      if ( $this->my_upload->processed == true ) {

		        $image_name  = $this->my_upload->file_dst_name;
		        $data_product = array(
					"image_slip_own" => $dir_insert.$image_name,
				);
				$where = "id = '".$order_id."'";
				$this->db->update('orders', $data_product, $where );



		        $this->my_upload->clean();
		      } else {
		        $data['errors'] = $this->my_upload->error;
		        echo $data['errors'];
		      }
		    } else  {
		      $data['errors'] = $this->my_upload->error;
		    }
		}


		if($order_id!=""){
			redirect('orders/edit/'.$order_id);
		}
		else {
			redirect('orders');
		}

	}

	public function get_search_credit_note()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['search_credit_note'] =  $this->orders_model->get_search_credit_note($value->search);
		print json_encode($data['search_credit_note']);
	}

	function sendmail_order_tracking($orderId)
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
							        <td style="padding: 8px;text-align: left;border-bottom: 1px solid #000;">@shipping_price บาท</td>
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


		$sql =" SELECT * FROM  orders WHERE id= '".$orderId."' ";
		$re = $this->db->query($sql);
		$result_order =  $re->row_array();

		$date1=date_create($result_order['date']);
		$header_str ='
					<td style="padding-bottom:20px;">
						<div style="background-color:#9BCA94;padding:20px;">
					       <h2 class="aligncenter">ทางเราได้จัดส่งสินค้า tracking number : '.$result_order['trackpost'].'</h2>
					       <p>เลขที่ใบสั่งซื้อ #'.$result_order['id'].'<br/>
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


		$sql_detail ="SELECT * ,r.price price_order FROM order_detail r INNER JOIN  products p ON r.product_id = p.id
						WHERE r.order_id ='".$result_order['id']."' ORDER BY r.linenumber ";
		$re = $this->db->query($sql_detail);
		$order_detail = $re->result_array();

		 $orderList="";

		foreach ($order_detail as  $value) {

			  $orderList = $orderList.'

			   <tr>
                <td style="padding: 8px;text-align: left;border-bottom: 1px solid #ddd;">
                    sku : '.$value["sku"].'<br/>
                    <a target="_blank" href="'.$this->config->item('url_img').'product/'.$value['slug'].'">
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

			$result =  str_replace("@linkstatus", base_url('status/'.$result_order['ref_id']),$result);
			$result =  str_replace("@header",$header_str,$result);
			$result =  str_replace("@reservations","",$result);
			$result =  str_replace("@address",$address,$result);
			$result =  str_replace("@listOrder",$orderList,$result);
			$result =  str_replace("@vat",$vatstr,$result);
			$result =  str_replace("@_vat_address",$vat_address,$result);
			$result =  str_replace("@shipping_price", $result_order['shipping']." ".number_format($result_order['shipping_charge'],2),$result);
			$result =  str_replace("@sumtotal",number_format($result_order['total'],2),$result);

			return $result;
	}

}

/* End of file orders.php */
/* Location: ./application/controllers/orders.php */
