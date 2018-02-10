<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('home_model');
		$this->load->model('products_model');
		$this->load->library('pagination');

	}

	public function index()
	{

		//header meta tag
		$data['header'] = array('title' => $this->config->item('sitename'),
								'description' =>  $this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  $this->config->item('keyword'));
		//get menu database
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_sub_type'] = $this->initdata_model->get_sub_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();
		$data['brand_oftype'] = $this->initdata_model->get_brand_oftype();

		//get slider list
	    $sql =" SELECT *  FROM  slider p  where p.is_active ='1' ORDER BY p.id   ";
		$re = $this->db->query($sql);
		$data['slider_list'] = $re->result_array();

		//list product

		$data['product_new'] = $this->home_model->get_products_new();//สินค้าใหม่
		$data['product_hot'] = $this->home_model->get_products_hot();//ได้รับความนิยม
		$data['product_sale'] = $this->home_model->get_products_sale();//แนะนำ
		$data['product_promotion'] = $this->home_model->get_products_promotion();//ลดราคา
		//$data['content_wordpress'] = $this->home_model->get_content_wordpress();

        //content file view
		$data['content'] = 'home';
		// if have file script
		//$data['script_file']= "js/product_add_js";
		//load layout
		$this->load->view('template/layout', $data);
		//$this->load->view('home-temp', $data);
	}

	public function getExcerpt($str, $startPos=0, $maxLength=100) {
		if(strlen($str) > $maxLength) {
			$excerpt   = substr($str, $startPos, $maxLength-3);
			$lastSpace = strrpos($excerpt, ' ');
			$excerpt   = substr($excerpt, 0, $lastSpace);
			$excerpt  .= '...';
		} else {
			$excerpt = $str;
		}

		return $excerpt;
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
