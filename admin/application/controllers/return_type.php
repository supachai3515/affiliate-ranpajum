<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Return_type extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('return_type_model');
        $this->load->model('products_model');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_view']) {
            $count = $this->return_type_model->get_return_type_count();
            $data['links_pagination'] = $this->pagination_compress("return_type/index", $count, $this->config->item('pre_page'));
            $data['return_type_list'] = $this->return_type_model->get_return_type($page, $this->config->item('pre_page'));
            $data['type_list'] = $this->products_model->get_type();
            $data['content'] = 'return_type/return_type';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Return type | '.$this->config->item('sitename'),
                                              'description' =>  'Return type| '.$this->config->item('tagline'),
                                              'author' => $this->config->item('author'),
                                              'keyword' => 'Product type');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }


    //page search
    public function search()
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_view']) {
            $return_data = $this->return_type_model->get_return_type_search();
            $data['return_type_list'] = $return_data['result_return_type'];
            $data['data_search'] = $return_data['data_search'];
            $data['type_list'] = $this->products_model->get_type();
            $data['content'] = 'return_type/return_type';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Return type | '.$this->config->item('sitename'),
                                              'description' =>  'Return type| '.$this->config->item('tagline'),
                                              'author' => $this->config->item('author'),
                                              'keyword' => 'Product type');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    //page edit
    public function edit($return_type_id)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_edit']) {
            $data['return_type_data'] = $this->return_type_model->get_return_type_id($return_type_id);
            $data['content'] = 'return_type/return_type_edit';
            $data['type_list'] = $this->products_model->get_type();
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Return type | '.$this->config->item('sitename'),
                                              'description' =>  'Return type| '.$this->config->item('tagline'),
                                              'author' => $this->config->item('author'),
                                              'keyword' => 'Product type');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    // update
    public function update($return_type_id)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_edit']) {
            date_default_timezone_set("Asia/Bangkok");
            //save return_type
            $this->return_type_model->update_return_type($return_type_id);

            if ($return_type_id!="") {
                redirect('return_type/edit/'.$return_type_id);
            } else {
                redirect('return_type');
            }
        } else {
            // access denied
            $this->loadThis();
        }
    }

    // insert
    public function add()
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_add']) {
            date_default_timezone_set("Asia/Bangkok");
            //save document
            $return_type_id ="";
            $return_type_id = $this->return_type_model->save_return_type();

            if ($document_id !="") {
                redirect('return_type/edit/'.$return_type_id);
            } else {
                redirect('return_type');
            }
        } else {
            // access denied
            $this->loadThis();
        }
    }
}

/* End of file return_type.php */
/* Location: ./application/controllers/return_type.php */
