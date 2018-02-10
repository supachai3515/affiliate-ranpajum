<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fixmac extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->model('home_model');
		$this->load->model('fix_model');
		$this->load->model('fix_model');
		$this->load->library('pagination');
	}

	public function index($page=0)
	{

		$data['total_fix'] = $this->fix_model->get_fix_count();
		$data['page_fix'] = $page+1;
		

		$config['base_url'] = base_url('fixmac/');
		$config['total_rows'] = $data['total_fix'] ;
		$config['per_page'] = 50;
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
		$data['fix_list'] = $this->fix_model->get_fix($page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();


		//header meta tag 
		$data['header'] = 
		array('title' => 'ส่งเครื่องมาซ่อม ซ่อมโน๊ตบุ๊ค เปลี่ยนชิพการ์ดจอ(Chip VGA) ซ่อมเมนบอร์ด(Mainboard) | '.$this->config->item('sitename'),
			  'description' =>  'ซ่อมโน๊ตบุ๊ค เปลี่ยนชิพการ์ดจอ(Chip VGA) ซ่อมเมนบอร์ด(Mainboard) ซ่อมโน๊ตบุ๊ค,รับซ่อม Macbook,รับซ่อม iMac, เปลี่ยนจอ iphone ipad '.$this->config->item('tagline'),
			  'author' => $this->config->item('author'),
			  'keyword' =>  'ซ่อมโน๊ตบุ๊ค,รับซ่อม Macbook,รับซ่อม iMac,เปลี่ยนจอ iphone ipad');
		//get menu database 
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();
		$data['brand_oftype'] = $this->initdata_model->get_brand_oftype();

        //content file view
		$data['content'] = 'fixmac';
		// if have file script
		//$data['script_file']= "js/fix_add_js";
		//load layout
		$this->load->view('template/layout', $data);	
	}

	//page search
	public function search($page=0)
	{
		$get_searchText = $this->input->get('search');
	    $sqlString = "";
	    $data   = preg_split('/\s+/', $get_searchText);

	    $sqlString = $sqlString.$this->fix_model->whereSqlConcat($data);
	    $countSql = count($data);
	    
	    $sql = "";
	    if($countSql < 2)
	    {
	        $sql   = "SELECT pc.search , p.* 
					FROM fix p 
					INNER JOIN (
					SELECT CONCAT(IFNULL(name,''), IFNULL(description,'')) search ,id FROM fix
					)
					pc ON p.id = pc.id WHERE  p.is_active= '1'  AND  pc.search like UPPER('%".$get_searchText."%')";

	    }
	    else {

	        $sql  = $sqlString;
	       
	    }

	    $data['title_tag'] = $get_searchText;
		$data['fix_list'] = $this->fix_model->get_fix_search($sql, $page, 10000000);
		//$data['links_pagination'] = $this->pagination->create_links();

		$data['header'] = array('title' => 'ค้นหา '. $get_searchText .' | '.$this->config->item('sitename'),
								'description' =>  'ค้นหา '. $get_searchText .' | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' => 'ค้นหา '. $get_searchText .' | '.$this->config->item('tagline') );
		//get menu database 
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		//content file view
		$data['content'] = 'fixmac';
		// if have file script
		//$data['script_file']= "js/fix_add_js";
		//load layout
		$this->load->view('template/layout', $data);
	}

}

/* End of file repair.php */
/* Location: ./application/controllers/repair.php */