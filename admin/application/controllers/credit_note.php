<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credit_note extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('credit_note_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
		$this->load->library('my_upload');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('credit_note/index');
		$config['total_rows'] = $this->credit_note_model->get_credit_note_count();
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
		$data['credit_note_list'] = $this->credit_note_model->get_credit_note($page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['type_list'] = $this->products_model->get_type();

		//call script
        $data['menu_id'] ='26';
		$data['content'] = 'credit_note';
		$data['script_file']= "js/credit_note_js";
		$data['header'] = array('title' => 'credit_note| '.$this->config->item('sitename'),
								'description' =>  'credit_note| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);
	}


	//page search
	public function search()
	{

		$return_data = $this->credit_note_model->get_credit_note_search();
		$data['credit_note_list'] = $return_data['result_credit_note'];
		$data['data_search'] = $return_data['data_search'];
		$data['menus_list'] = $this->initdata_model->get_menu();

        $data['menu_id'] ='26';
		$data['content'] = 'credit_note';
		$data['script_file']= "js/credit_note_js";
		$data['header'] = array('title' => 'credit_note| '.$this->config->item('sitename'),
								'description' =>  'credit_note| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	//page edit
	public function edit($credit_note_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['credit_note_data'] = $this->credit_note_model->get_credit_note_id($credit_note_id);
		$data['credit_note_detail'] = $this->credit_note_model->get_credit_note_detail($credit_note_id);
		$data['type_list'] = $this->products_model->get_type();
        $data['menu_id'] ='26';
		$data['content'] = 'credit_note_edit';
		$data['script_file']= "js/credit_note_js";
		$data['header'] = array('title' => 'credit_note| '.$this->config->item('sitename'),
								'description' =>  'credit_note| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	public function edit_view($credit_note_id,$print_f = 0)
	{
		$this->is_logged_in();
		$data['print_f'] = $print_f;
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['credit_note_data'] = $this->credit_note_model->get_credit_note_id($credit_note_id);
		$data['credit_note_detail'] = $this->credit_note_model->get_credit_note_detail($credit_note_id);
		$data['type_list'] = $this->products_model->get_type();
        $data['menu_id'] ='26';
		$data['content'] = 'credit_note_view';
		$this->load->view('credit_note_view', $data);
	}

	// update
	public function update($credit_note_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save credit_note
		$this->credit_note_model->update_credit_note($credit_note_id);

		$image_name = "";
		$dir ='./../uploads/credit_note/'.date("Ym").'/';
		$dir_insert ='uploads/credit_note/'.date("Ym").'/';

		if($credit_note_id != "")
		{
			if($this->input->post('is_refund') == 1){
				$this->my_upload->upload($_FILES["image_fieldedit"]);
				if ( $this->my_upload->uploaded == true  ) {
				  $this->my_upload->allowed         = array('image/*');
				  $this->my_upload->file_name_body_pre = 'thumb_';
				  //$this->my_upload->file_new_name_body    = 'image_resized_' . $now;
				  $this->my_upload->image_resize          = true;
				  $this->my_upload->image_x               = 800;
				  $this->my_upload->image_ratio_y         = true;
				  $this->my_upload->process($dir);

				  if ( $this->my_upload->processed == true ) {

					$image_name  = $this->my_upload->file_dst_name;
					$this->credit_note_model->update_img($credit_note_id, $dir_insert.$image_name);

					$this->my_upload->clean();
				  } else {
					$data['errors'] = $this->my_upload->error;
					echo $data['errors'];
				  }
				} else  {
				  $data['errors'] = $this->my_upload->error;
				}
			}else{
				$this->credit_note_model->update_img($credit_note_id, '');
			}
		}

		if($credit_note_id!=""){
			redirect('credit_note/edit/'.$credit_note_id);
		}
		else {
			redirect('credit_note');
		}

	}

	// insert
	public function add()
	{
		date_default_timezone_set("Asia/Bangkok");
		//save document
		$credit_note_id ="";
		$credit_note_id = $this->credit_note_model->save_credit_note();

		$image_name = "";
		$dir ='./../uploads/credit_note/'.date("Ym").'/';
		$dir_insert ='uploads/credit_note/'.date("Ym").'/';

		if($credit_note_id != "")
		{
			if($this->input->post('is_refund') == 1){
				$this->my_upload->upload($_FILES["image_field"]);
				if ( $this->my_upload->uploaded == true  ) {
				  $this->my_upload->allowed         = array('image/*');
				  $this->my_upload->file_name_body_pre = 'thumb_';
				  //$this->my_upload->file_new_name_body    = 'image_resized_' . $now;
				  $this->my_upload->image_resize          = true;
				  $this->my_upload->image_x               = 800;
				  $this->my_upload->image_ratio_y         = true;
				  $this->my_upload->process($dir);

				  if ( $this->my_upload->processed == true ) {

					$image_name  = $this->my_upload->file_dst_name;
					$this->credit_note_model->update_img($credit_note_id, $dir_insert.$image_name);

					$this->my_upload->clean();
				  } else {
					$data['errors'] = $this->my_upload->error;
					echo $data['errors'];
				  }
				} else  {
				  $data['errors'] = $this->my_upload->error;
				}
			}
		}

		if($credit_note_id !=""){
			redirect('credit_note/edit/'.$credit_note_id);
		}
		else {
			redirect('credit_note');
		}
	}


	public function get_search_order()
	{
		$value = json_decode(file_get_contents("php://input"));
		$data['search_order'] =  $this->credit_note_model->get_search_order($value->search);
		print json_encode($data['search_order']);

	}


	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		$chk_admin =  $this->session->userdata('permission');
		if(!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin'){
			redirect('login');
		}
	}

}

/* End of file credit_note.php */
/* Location: ./application/controllers/credit_note.php */
