<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
		 
	}

	//page view
	public function index($slug)
	{
		$sql ="SELECT p.* ,t.name type_name, b.name brand_name , stock_all , t.id type_id, b.id brand_id,
	    		t.slug type_slug, b.slug brand_slug
				FROM  products p
				LEFT JOIN product_brand b ON p.product_brand_id = b.id
				LEFT JOIN product_type t ON p.product_type_id = t.id
				LEFT JOIN (SELECT product_id, SUM(number) stock_all FROM stock
				GROUP BY product_id) s ON s.product_id = p.id
				WHERE p.slug = '".$slug."' AND p.is_active = 1 ";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		$data['product_detail'] = $row;

		$sql_img ="SELECT * FROM product_images WHERE product_id = '".$row['id']."' AND path !='' ";
		$query_img = $this->db->query($sql_img);
		$row_img = $query_img->result_array();;
		$data['product_images'] = $row_img;

		if(isset($row['id'] ))
		{

			//header meta tag
			$data['header'] = array('title' => $row['name'].' | '.$this->config->item('short_sitename'),
									'description' =>  $row['name'].' | '.$this->config->item('tagline'),
									'author' => $this->config->item('author'),
									'keyword' =>  $row['name'].' | '.$this->config->item('keyword') );
			//get menu database
			$this->load->model('initdata_model');
			$data['menus_list'] = $this->initdata_model->get_menu();
			$data['menu_type'] = $this->initdata_model->get_type();
			$data['menu_sub_type'] = $this->initdata_model->get_sub_type();
			$data['menu_brands'] = $this->initdata_model->get_brands();
			$data['brand_oftype'] = $this->products_model->get_brand_oftype();


	        //content file view
			$data['content'] = 'product_detail';
			// if have file script
			//$data['script_file']= "js/product_add_js";
			//load layout
			$this->load->view('template/layout', $data);
		}
		else{redirect('products');}

	}

}

/* End of file prrducts.php */
/* Location: ./application/controllers/prrducts.php */
