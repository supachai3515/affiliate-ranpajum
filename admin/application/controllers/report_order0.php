<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_order extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('report_model');
		$this->load->library('pagination');
		$this->load->model('products_model');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{
		$data['menus_list'] = $this->initdata_model->get_menu();$searchTxt = $this->input->post();
		/*Search*/
		$searchTxt = $this->input->post();
		$data['resultpost'] = $searchTxt;
		$data['selectDB'] = $this->report_model->getOrder($searchTxt);
		//$data['get_payment'] = $this->report_model->get_sumpayment($searchTxt);

		//call script
		$data['script_file']= "js/report_js";
    $data['menu_id'] ='31';
		$data['content'] = 'reports/report_order';
		$data['header'] = array('title' => 'report_order | '.$this->config->item('sitename'),
								'description' =>  'report_order | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'cyberbatt');
		$this->load->view('template/layout', $data);
	}

	public function report_product(){
		$data['menus_list'] = $this->initdata_model->get_menu();$searchTxt = $this->input->post();
		/*Search*/
		$searchTxt = $this->input->post();
		$data['resultpost'] = $searchTxt;
		$data['selectDB'] = $this->report_model->getProduct($searchTxt);
		//call script
		$data['script_file']= "js/report_js";
        $data['menu_id'] = '32';
		$data['content'] = 'reports/report_product';
		$data['header'] = array('title' => 'report_product | '.$this->config->item('sitename'),
								'description' =>  'report_product | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'cyberbatt');
		$this->load->view('template/layout', $data);
	}

	public function report_price(){
		$data['menus_list'] = $this->initdata_model->get_menu();$searchTxt = $this->input->post();
		/*Search*/
		$searchTxt = $this->input->post();
		$data['resultpost'] = $searchTxt;
		$data['price_report_data'] = $this->report_model->get_price_report($searchTxt);
		//call script
		$data['script_file']= "js/report_js";
        $data['menu_id'] = '33';
		$data['content'] = 'reports/report_price';
		$data['header'] = array('title' => 'report_price | '.$this->config->item('sitename'),
								'description' =>  'report_price | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'cyberbatt');
		$this->load->view('template/layout', $data);
	}

	public function report_purchase_order($inti=''){
		if($inti ==''){
			//defalut search
			$data_search['all_promotion'] = "1";
			$data_search['is_active'] = "1";
			$data['data_search'] = $data_search;
			$data['products_list']= NULL;
		}
		else {
			$return_data = $this->report_model->get_products_search();
			$data['products_list'] = $return_data['result_products'];
			$data['data_search'] = $return_data['data_search'];
			$data['sql'] = $return_data['sql'];
			$is_export = $this->input->post('is_export');

		}

		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['brands_list'] = $this->products_model->get_brands();
		$data['type_list'] = $this->products_model->get_type();
		$searchTxt = $this->input->post();
		/*Search*/
		$searchTxt = $this->input->post();
		$data['resultpost'] = $searchTxt;
		$data['purchase_order_report_data'] = $this->report_model->get_report_purchase_order($data['products_list'], $searchTxt);
		//call script
		$data['script_file']= "js/report_js";
		$data['menu_id'] = '34';
		$data['content'] = 'reports/report_purchase_order';
		$data['header'] = array('title' => 'purchase_order | '.$this->config->item('sitename'),
								'description' =>  'purchase_order | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'cyberbatt');

		if (isset($is_export) && $is_export == '1') {
			$data['products_list'] = $data['purchase_order_report_data'];
			$this->load->view('reports/export_report_purchase_order', $data);
		}

		$this->load->view('template/layout', $data);
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
