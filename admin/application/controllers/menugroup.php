<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Menugroup extends BaseController {

  public function __construct()
  {
    parent::__construct();
    session_start();
		$this->load->model('menugroup_model');
    $this->isLoggedIn();
  }

  function index($page=0)
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='4';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_view'])
    {

      $searchText = $this->input->post('searchText');
      $data['searchText'] = $searchText;
      $count = $this->menugroup_model->get_menugroup_count($searchText);
      $data['links_pagination'] = $this->pagination_compress( "menugroup/index", $count, $this->config->item('pre_page') );
  	  $data['menugroup_list'] = $this->menugroup_model->get_menugroup($searchText, $page, $this->config->item('pre_page'));


      $data['content'] = 'menugroup/menugroup_view';
      //if script file
      $data['script_file'] = 'js/menugroup_js';
  		$data['header'] = array('title' => 'Menu Group | '.$this->config->item('sitename'),
              								'description' =>  'Menu Group | '.$this->config->item('tagline'),
              								'author' => $this->config->item('author'),
              								'keyword' => 'Menu Group');
  		$this->load->view('template/layout_main', $data);
    }
    else {
      // access denied
       $this->loadThis();
    }
  }

  function set_menu($id)
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='4';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_edit'])
    {
        $data['menugroup_data'] = $this->menugroup_model->get_menugroup_id($id);
        $data['menu_group_detail'] = $this->menugroup_model->get_menu_group_detail($id);
        $data['menu'] = $this->menugroup_model->get_menu($id);
        $data['content'] = 'menugroup/set_menu_view';
        //if script file
        $data['script_file'] = 'js/menugroup_js';
  		  $data['header'] = array('title' => 'Menu Group | '.$this->config->item('sitename'),
              								'description' =>  'Menu Group | '.$this->config->item('tagline'),
              								'author' => $this->config->item('author'),
              								'keyword' => 'Menu Group');
  		  $this->load->view('template/layout_main', $data);
    }
    else {
      // access denied
       $this->loadThis();
    }
  }

  function add()
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='4';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_add'])
    {
        $data['content'] = 'menugroup/menugroup_add_view';
        //if script file
        $data['script_file'] = 'js/menugroup_js';
  		  $data['header'] = array('title' => 'Add Menu Group | '.$this->config->item('sitename'),
              								'description' =>  'Add Menu Group | '.$this->config->item('tagline'),
              								'author' => $this->config->item('author'),
              								'keyword' => 'Menu Group');
  		  $this->load->view('template/layout_main', $data);
    }
    else {
      // access denied
       $this->loadThis();
    }
  }

  function view($id=NULL)
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='4';
    $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_view'])
    {

        $data['menugroup_data'] = $this->menugroup_model->get_menugroup_id($id);
        $data['menu_group_detail'] = $this->menugroup_model->get_menu_group_detail($id);
        $data['content'] = 'menugroup/menugroup_info_view';
        //if script file
        $data['script_file'] = 'js/menugroup_js';
        $data['header'] = array('title' => 'View Menu Group | '.$this->config->item('sitename'),
                              'description' =>  'View Menu Group | '.$this->config->item('tagline'),
                              'author' => $this->config->item('author'),
                              'keyword' => 'Menu Group');
        $this->load->view('template/layout_main', $data);
    }
    else {
      // access denied
       $this->loadThis();
    }
  }


  function add_save()
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='4';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_add'])
    {
          $this->load->library('form_validation');
          $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
          $this->form_validation->set_rules('description','description','trim|xss_clean|max_length[128]');
          $this->form_validation->set_rules('is_active','ใช้งาน','');

          if($this->form_validation->run() == FALSE)
          {
              $this->add();
          }
          else
          {
              $name = $this->input->post('name');
              $description = $this->input->post('description');
              $is_active = $this->input->post('is_active');

              $menugroup_info = array('name'=>$name, 'description'=>$description, 'is_active'=>$is_active,
                                      'create_by'=>$this->vendorId, 'create_date'=>date('Y-m-d H:i:s'),
                                      'modified_by'=>$this->vendorId, 'modified_date'=>date('Y-m-d H:i:s'));

              $result = $this->menugroup_model->save_menugroup($menugroup_info);

              if($result > 0)
              {
                  $this->session->set_flashdata('success', 'Add Menu Group created successfully');
              }
              else
              {
                  $this->session->set_flashdata('error', 'User creation failed');
              }
              redirect('menugroup/add');
          }
      }
      else {
           $this->loadThis();
      }
  }

  function edit($id=NULL)
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='4';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_edit'])
    {

        $data['menugroup_data'] = $this->menugroup_model->get_menugroup_id($id);
        $data['content'] = 'menugroup/menugroup_edit_view';
        //if script file
        $data['script_file'] = 'js/menugroup_js';
  		  $data['header'] = array('title' => 'Add Menu Group | '.$this->config->item('sitename'),
              								'description' =>  'Add Menu Group | '.$this->config->item('tagline'),
              								'author' => $this->config->item('author'),
              								'keyword' => 'Menu Group');
  		  $this->load->view('template/layout_main', $data);
    }
    else {
      // access denied
       $this->loadThis();
    }
  }


  function edit_save()
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='4';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_add'])
    {
          $this->load->library('form_validation');
          $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
          $this->form_validation->set_rules('description','description','trim|xss_clean|max_length[128]');
          $this->form_validation->set_rules('is_active','ใช้งาน','');

          if($this->form_validation->run() == FALSE)
          {
              $this->add();
          }
          else
          {
              $name = $this->input->post('name');
              $description = $this->input->post('description');
              $is_active = $this->input->post('is_active');
              $menu_group_id = $this->input->post('menu_group_id');

              $menugroup_info = array('name'=>$name, 'description'=>$description, 'is_active'=>$is_active,
                                      'menu_group_id'=>$menu_group_id,
                                      'modified_by'=>$this->vendorId,
                                      'modified_date'=>date('Y-m-d H:i:s'));

              $result = $this->menugroup_model->update_menugroup($menugroup_info,$menu_group_id);

              if($result > 0)
              {
                  $this->session->set_flashdata('success', 'Add Menu Group Update successfully');
              }
              else
              {
                  $this->session->set_flashdata('error', 'User creation failed');
              }
              redirect('menugroup/edit/'.$menu_group_id);
          }
      }
      else {
           $this->loadThis();
      }
  }

  function get_menu_group_detail()
	{
		$value = json_decode(file_get_contents("php://input"));
    $data['menu_group_detail'] = $this->menugroup_model->get_menu_group_detail($value->menu_group_id);
		print json_encode($data['menu_group_detail']);

	}

  function get_menu()
	{
		$value = json_decode(file_get_contents("php://input"));
    $data['menu'] = $this->menugroup_model->get_menu($value->menu_group_id);
		print json_encode($data['menu']);
	}

  function update_menu_group_detail() {
    $value = json_decode(file_get_contents("php://input"));
    $data['result'] = $this->menugroup_model->update_menu_group_detail($value);
		print json_encode($data['result']);

  }

  function save_menu_group_detail() {
    $value = json_decode(file_get_contents("php://input"));
    $data['result'] = $this->menugroup_model->save_menu_group_detail($value);
    print json_encode($data['result']);

  }

}
