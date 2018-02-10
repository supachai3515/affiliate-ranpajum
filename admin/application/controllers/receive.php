<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receive extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('receive_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('receive/index');
		$config['total_rows'] = $this->receive_model->get_receive_count();
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
		$data['receive_list'] = $this->receive_model->get_receive($page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['type_list'] = $this->products_model->get_type();

		//call script
        $data['menu_id'] ='23';
		$data['content'] = 'receive';
		$data['script_file']= "js/receive_js";
		$data['header'] = array('title' => 'receive| '.$this->config->item('sitename'),
								'description' =>  'receive| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);
	}


	//page search
	public function search()
	{

		$return_data = $this->receive_model->get_receive_search();
		$data['receive_list'] = $return_data['result_receive'];
		$data['data_search'] = $return_data['data_search'];
		$data['menus_list'] = $this->initdata_model->get_menu();

        $data['menu_id'] ='23';
		$data['content'] = 'receive';
		$data['script_file']= "js/product_add_js";
		$data['header'] = array('title' => 'receive| '.$this->config->item('sitename'),
								'description' =>  'receive| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	//page edit
	public function edit($receive_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['receive_data'] = $this->receive_model->get_receive_id($receive_id);
		$data['type_list'] = $this->products_model->get_type();
        $data['menu_id'] ='23';
		$data['content'] = 'receive_edit';
		$data['script_file']= "js/receive_js";
		$data['header'] = array('title' => 'receive| '.$this->config->item('sitename'),
								'description' =>  'receive| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');

		if($data['receive_data']['count_use'] < 1){
			$this->load->view('template/layout', $data);
		}else{

			redirect('receive','refresh');
		}


	}

	public function edit_view($receive_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['receive_data'] = $this->receive_model->get_receive_id($receive_id);
		$data['type_list'] = $this->products_model->get_type();
        $data['menu_id'] ='23';
		$data['content'] = 'receive_view';
		$this->load->view('receive_view', $data);
	}


		//page edit
	public function edit_serial($receive_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['receive_data'] = $this->receive_model->get_receive_id($receive_id);
		$data['type_list'] = $this->products_model->get_type();
        $data['menu_id'] ='23';
		$data['content'] = 'edit_serial';
		$data['script_file']= "js/receive_js";
		$data['header'] = array('title' => 'receive| '.$this->config->item('sitename'),
								'description' =>  'receive| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	// update
	public function update($receive_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save receive
		$this->receive_model->update_receive($receive_id);

		if($receive_id!=""){
			redirect('receive/edit/'.$receive_id);
		}
		else {
			redirect('receive');
		}

	}

	// insert
	public function add()
	{
		date_default_timezone_set("Asia/Bangkok");
		//save document
		$receive_id ="";
		$receive_id = $this->receive_model->save_receive();

		if($document_id !=""){
			redirect('receive/edit/'.$receive_id);
		}
		else {
			redirect('receive');
		}
	}


	public function get_product()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['product'] =  $this->receive_model->get_product($value->sku);
		print json_encode($data['product']);

	}

	public function get_receive_detail()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['product'] =  $this->receive_model->get_receive_detail($value->id);
		print json_encode($data['product']);

	}

	public function get_product_serial()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['serial'] =  $this->receive_model->get_product_serial($value->product_id,$value->receive_id);
		print json_encode($data['serial']);

	}

	public function save_serial()
	{

		try {

		  	$values = json_decode(file_get_contents("php://input"));
			$this->db->trans_start(); # Starting Transaction
			$check_loop = 0 ;
			foreach ($values as $value ) {
				if(trim($value->serial_number) != ""){

					   //DOC_NO
						$sql =" SELECT doc_no  FROM receive  WHERE  id = '".$value->receive_id."'";
						$re = $this->db->query($sql);
						$row_doc_no =  $re->row_array();
						$docno = $row_doc_no['doc_no'];
						//
						if ($check_loop == 0) {
							//check ของเดิม
							$sql =" SELECT * FROM product_serial ps inner join receive r ON r.id = ps.receive_id
							        WHERE ps.receive_id = '".$value->receive_id."'
											AND ps.product_id = '".$value->product_id."'
											AND ( ps.order_id IS NULL OR  ps.order_id  = '' )";

							$re = $this->db->query($sql);
							$row_re =  $re->result_array();

							foreach ($row_re as $r_ow ) {

								date_default_timezone_set("Asia/Bangkok");
								$data_serial_history = array(
									'serial_number' =>$r_ow['serial_number'],
									'product_id' => $r_ow['product_id'],
									'comment' => "ลบออก จากใบรับเข้า : #".$docno ,
									'create_date' => date("Y-m-d H:i:s"),
								);
								$this->db->insert("serial_history", $data_serial_history);

								//ลบ ของเดิม
								$sql =" DELETE FROM product_serial WHERE serial_number = '".$r_ow['serial_number']."'
								AND product_id = '".$value->product_id."' ";
								$re = $this->db->query($sql);
							}

							$check_loop++;

						}

						$count_use = 0;
						if(isset($value->count_use)){
							$count_use =$value->count_use;

						}

						if($count_use != '1'){
							//บันทึกใหม่
							date_default_timezone_set("Asia/Bangkok");
							$data_product_serial = array(
								'serial_number' =>$value->serial_number,
								'line_number' => $value->line_number,
								'product_id' => $value->product_id,
								'receive_id' => $value->receive_id,
								'modified_date' => date("Y-m-d H:i:s"),
								'create_date' => date("Y-m-d H:i:s"),
							);

							$data_serial_history = array(
									'serial_number' =>$value->serial_number,
									'product_id' => $value->product_id,
									'comment' => "บันทึก จากใบรับเข้า : #".$docno,
									'create_date' => date("Y-m-d H:i:s"),
							);

							$db_debug = $this->db->db_debug; //save setting
							$this->db->db_debug = FALSE; //disable debugging for queries
							$this->db->insert("serial_history", $data_serial_history);
							$this->db->insert("product_serial", $data_product_serial);
							$this->db->db_debug = $db_debug; //restore setting

						}



				}
			}

			$this->db->trans_complete(); # Completing transaction
			/*Optional*/

			if ($this->db->trans_status() === FALSE) {
			    # Something went wrong.
			    $this->db->trans_rollback();
			    $res = array('is_error' => true,
			    	'message' => "ข้อมูลซ้ำ ไม่สามารถบันทึกได้ กรุณาตรวจสอบ Serial อีกครั้ง",
			    	);
			    print json_encode( $res);
			   // return FALSE;
			}
			else {
			    # Everything is Perfect.
			    # Committing data to the database.
			    $this->db->trans_commit();

			     $res = array('is_error' => false,
			    	'message' => "บันทึกสำเร็จ",
			    );

			    print json_encode( $res);
			   // return TRUE;
			}
		} catch (Exception $e) {

		  $res = array('is_error' => true,
			    	'message' => $e->getMessage(),
			    	);
			    print json_encode( $res);
		}


	}


	public function line_number()
	{
		$sql ="SELECT receive_id , product_id FROM product_serial GROUP BY receive_id , product_id";
		$query = $this->db->query($sql);
		$re = $query->result_array();
		foreach ($re as $r) {


			$sql ="SELECT *  FROM product_serial WHERE receive_id ='".$r['receive_id']."' AND product_id = '".$r['product_id']."'";
			$query = $this->db->query($sql);
			$re1 = $query->result_array();
			$i= 1;
			foreach ($re1 as $r1) {

			print($i." - ".$r1['serial_number']." - ".$r1['product_id']." - ".$r1['receive_id']."<br/>");

			date_default_timezone_set("Asia/Bangkok");
			$data_update = array(
				'line_number' => $i
			);

			$this->db->update("product_serial", $data_update,"product_id = '".$r1['product_id']."' AND  serial_number = '".$r1['serial_number']."'  AND receive_id = '".$r1['receive_id']."'");
			$i++;

			}
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

/* End of file receive.php */
/* Location: ./application/controllers/receive.php */
