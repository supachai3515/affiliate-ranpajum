<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Producttype extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('producttype_model');
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
            $count = $this->producttype_model->get_producttype_count();
            $data['links_pagination'] = $this->pagination_compress("producttype/index", $count, $this->config->item('pre_page'));
            $data['producttype_list'] = $this->producttype_model->get_producttype($page, $this->config->item('pre_page'));
            $data['type_list'] = $this->products_model->get_type();
            $data['content'] = 'producttype/producttype';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Product type | '.$this->config->item('sitename'),
                                              'description' =>  'Product type | '.$this->config->item('tagline'),
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
            $return_data = $this->producttype_model->get_producttype_search();
            $data['producttype_list'] = $return_data['result_producttype'];
            $data['data_search'] = $return_data['data_search'];
            $data['type_list'] = $this->products_model->get_type();
            $data['content'] = 'producttype/producttype';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Product type | '.$this->config->item('sitename'),
                                              'description' =>  'Product type | '.$this->config->item('tagline'),
                                              'author' => $this->config->item('author'),
                                              'keyword' => 'Product type');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    //page edit
    public function edit($producttype_id)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_edit']) {
            $data['producttype_data'] = $this->producttype_model->get_producttype_id($producttype_id);
            $data['content'] = 'producttype/producttype_edit';
            $data['type_list'] = $this->products_model->get_type();
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Product type | '.$this->config->item('sitename'),
                                              'description' =>  'Product type | '.$this->config->item('tagline'),
                                              'author' => $this->config->item('author'),
                                              'keyword' => 'Product type');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    // update
    public function update($producttype_id)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_edit']) {
            date_default_timezone_set("Asia/Bangkok");
            //save producttype
            $this->producttype_model->update_producttype($producttype_id);

            if ($producttype_id!="") {
                redirect('producttype/edit/'.$producttype_id);
            } else {
                redirect('producttype');
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
            $producttype_id ="";
            $producttype_id = $this->producttype_model->save_producttype();

            if ($document_id !="") {
                redirect('producttype/edit/'.$producttype_id);
            } else {
                redirect('producttype');
            }
        } else {
            // access denied
            $this->loadThis();
        }
    }
}

/* End of file producttype.php */
/* Location: ./application/controllers/producttype.php */
