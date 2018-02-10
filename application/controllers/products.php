<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
		 
	}

	//page view
	public function index($page=0)
	{
		$data['total_product'] = $this->products_model->get_products_count();
		$data['page_product'] = $page+1;


		$config['base_url'] = base_url('products/index');
		$config['total_rows'] = $data['total_product'] ;
		$config['per_page'] = 15;
		$page = ($page!='')? $page : 0;
    	$config["cur_page"] = $page;
		//config for bootstrap pagination class integration
        /* This Application Must Be Used With BootStrap 3 *  */
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current-pag"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';


        $this->pagination->initialize($config);
		$data['product_list'] = $this->products_model->get_products($page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();



		$data['header'] = array('title' => 'สินค้า | '.$this->config->item('sitename'),
								'description' =>  'สินค้า | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'bboyxcitehitec');
		//get menu database
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_sub_type'] = $this->initdata_model->get_sub_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();
		$data['brand_oftype'] = $this->products_model->get_brand_oftype();


        //content file view
		$data['content'] = 'products';
		// if have file script
		//$data['script_file']= "js/product_add_js";
		//load layout
		$this->load->view('template/layout', $data);

	}

	//page view
	public function category_brand($type, $brand, $page=0)
	{

		$type = urldecode($type);
		$brand = urldecode($brand);

		$data['total_product'] = $this->products_model->get_products_category_brand_count($type, $brand);
		$data['page_product'] = $page+1;

		$config['base_url'] = base_url('products/category_brand/'.$type.'/'.$brand);
		$config['total_rows'] = $data['total_product'] ;
		$config['per_page'] = 15;
		$page = ($page!='')? $page : 0;
    	$config["cur_page"] = $page;
		//config for bootstrap pagination class integration
        /* This Application Must Be Used With BootStrap 3 *  */
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current-pag"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
		$data['product_list'] = $this->products_model->get_products_category_brand($type, $brand, $page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$type_all = $this->initdata_model->get_type_by_slug($type);
		$brand_all = $this->initdata_model->get_brand_by_slug($brand);

		$data['title_tag'] ='หมวดสินค้า : '.$type_all['name'].' - '.$brand_all['name'];

		$data['header'] = array('title' => $type_all['name'] .$brand_all['name'].' | '.$this->config->item('sitename'),
								'description' =>  $type_all['name'] .$brand_all['name'].' | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>   $type_all['name'] .$brand_all['name'].' | '.$this->config->item('keyword') );
		//get menu database
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_sub_type'] = $this->initdata_model->get_sub_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();
		$data['brand_oftype'] = $this->products_model->get_brand_oftype();


        //content file view
		$data['content'] = 'products';
		// if have file script
		//$data['script_file']= "js/product_add_js";
		//load layout
		$this->load->view('template/layout', $data);

	}

	//page view
	public function category($type,$page=0)
	{

		if($this->products_model->check_cat($type) == 0) {
			redirect('products','refresh');

		}

		$data['total_product'] = $this->products_model->get_products_category_count($type);
		$data['page_product'] = $page+1;


		$config['base_url'] = base_url('products/category/'.$type);
		$config['total_rows'] = $data['total_product'] ;
		$config['per_page'] = 15;

		$page = ($page!='')? $page : 0;
    	$config["cur_page"] = $page;
		//config for bootstrap pagination class integration
        /* This Application Must Be Used With BootStrap 3 *  */
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current-pag"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

    	$this->pagination->initialize($config);
		$data['product_list'] = $this->products_model->get_products_category($type, $page, $config['per_page']);


		$data['links_pagination'] = $this->pagination->create_links();


		$data['detail'] = $type_all = $this->initdata_model->get_type_by_slug($type);

		$data['title_tag'] ='หมวดสินค้า : '.$type_all['name'].'';

		$data['header'] = array('title' => $type_all['name'] .' | '.$this->config->item('sitename'),
								'description' =>  $type_all['name'] .' | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>   $type_all['name'] .' | '.$this->config->item('keyword') );
		//get menu database
		//get menu database
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_sub_type'] = $this->initdata_model->get_sub_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();
		$data['brand_oftype'] = $this->products_model->get_brand_oftype();


        //content file view
		$data['content'] = 'products';
		// if have file script
		//$data['script_file']= "js/product_add_js";
		//load layout
		$this->load->view('template/layout', $data);

	}

	//page view
	public function brand($brand,$page=0)
	{

		$brand = urldecode($brand);

		$data['total_product'] = $this->products_model->get_products_brand_count($brand);
		$data['page_product'] = $page+1;


		$config['base_url'] = base_url('products/brand/'.$brand);
		$config['total_rows'] = $data['total_product'] ;
		$config['per_page'] = 15;

		$page = ($page!='')? $page : 0;
    	$config["cur_page"] = $page;
		//config for bootstrap pagination class integration
        /* This Application Must Be Used With BootStrap 3 *  */
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current-pag"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';;

        $this->pagination->initialize($config);
		$data['product_list'] = $this->products_model->get_products__brand($brand, $page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$data['detail'] = $brand_all = $this->initdata_model->get_brand_by_slug($brand);
		$data['title_tag'] ='ยี่ห้อสินค้า : '.$brand_all['name'];

		$data['header'] = array('title' => $brand_all['name'].' | '.$this->config->item('sitename'),
								'description' => $brand_all['name'].' | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' => $brand_all['name'].' | '.$this->config->item('keyword') );
		//get menu database
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_sub_type'] = $this->initdata_model->get_sub_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();
		$data['brand_oftype'] = $this->products_model->get_brand_oftype();

        //content file view
		$data['content'] = 'products';
		// if have file script
		//$data['script_file']= "js/product_add_js";
		//load layout
		$this->load->view('template/layout', $data);

	}


	//page search
	public function search($page=0)
	{
		$get_searchText = $this->input->get('search');
	    $sqlString = "";
	    $data   = preg_split('/\s+/', $get_searchText);

	    $sqlString = $sqlString.$this->products_model->whereSqlConcat($data);
	    $countSql = count($data);

		$sql   ="";
	    if($countSql < 2)
	    {
	        $sql   = "SELECT pc.search , p.* ,t.name type_name, b.name brand_name , s.stock_all FROM products p
					INNER JOIN ( SELECT CONCAT(IFNULL(name,''), IFNULL(model,''), IFNULL(shot_detail,''), IFNULL(sku,'')) search , id FROM products )
					pc ON p.id = pc.id LEFT JOIN product_brand b ON p.product_brand_id = b.id
					LEFT JOIN (SELECT product_id, SUM(number) stock_all FROM stock GROUP BY product_id) s ON s.product_id = p.id
					LEFT JOIN product_type t ON p.product_type_id = t.id
					WHERE  p.is_active = '1' AND t.is_active = '1' AND  pc.search like UPPER('%".$get_searchText."%')";

	    }
	    else {

	        $sql  = $sqlString;

	    }
		$data['title_tag'] ='ค้นหา "'.$get_searchText.'"';
		$data['product_list'] = $this->products_model->get_products_search($sql, $page, 10000000);
		//$data['links_pagination'] = $this->pagination->create_links();

		$data['header'] = array('title' => 'ค้นหา '. $get_searchText .' | '.$this->config->item('sitename'),
								'description' =>  'ค้นหา '. $get_searchText .' | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' => 'ค้นหา '. $get_searchText .' | '.$this->config->item('keyword') );
		//get menu database
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_sub_type'] = $this->initdata_model->get_sub_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();
		$data['brand_oftype'] = $this->products_model->get_brand_oftype();

        //content file view
		$data['content'] = 'products';
		// if have file script
		//$data['script_file']= "js/product_add_js";
		//load layout
		$this->load->view('template/layout', $data);
	}

}

/* End of file prrducts.php */
/* Location: ./application/controllers/prrducts.php */
