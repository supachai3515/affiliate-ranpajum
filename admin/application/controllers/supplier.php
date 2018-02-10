<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Supplier extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('supplier_model');
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
            $count = $this->supplier_model->get_supplier_count();
            $data['links_pagination'] = $this->pagination_compress("supplier/index", $count, $this->config->item('pre_page'));
            $data['supplier_list'] = $this->supplier_model->get_supplier($page, $this->config->item('pre_page'));
            $data['type_list'] = $this->products_model->get_type();
            $data['content'] = 'supplier/supplier';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Supplier| '.$this->config->item('sitename'),
                                              'description' =>  'Supplier | '.$this->config->item('tagline'),
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
            $return_data = $this->supplier_model->get_supplier_search();
            $data['supplier_list'] = $return_data['result_supplier'];
            $data['data_search'] = $return_data['data_search'];
            $data['type_list'] = $this->products_model->get_type();
            $data['content'] = 'supplier/supplier';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Supplier| '.$this->config->item('sitename'),
                                              'description' =>  'Supplier | '.$this->config->item('tagline'),
                                              'author' => $this->config->item('author'),
                                              'keyword' => 'Product type');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    //page edit
    public function edit($supplier_id)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_edit']) {
            $data['supplier_data'] = $this->supplier_model->get_supplier_id($supplier_id);
            $data['content'] = 'supplier/supplier_edit';
            $data['type_list'] = $this->products_model->get_type();
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Supplier | '.$this->config->item('sitename'),
                                              'description' =>  'Supplier| '.$this->config->item('tagline'),
                                              'author' => $this->config->item('author'),
                                              'keyword' => 'Product type');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    // update
    public function update($supplier_id)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_edit']) {
            date_default_timezone_set("Asia/Bangkok");
            //save supplier
            $this->supplier_model->update_supplier($supplier_id);

            if ($supplier_id!="") {
                redirect('supplier/edit/'.$supplier_id);
            } else {
                redirect('supplier');
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
            $supplier_id ="";
            $supplier_id = $this->supplier_model->save_supplier();

            if ($document_id !="") {
                redirect('supplier/edit/'.$supplier_id);
            } else {
                redirect('supplier');
            }
        } else {
            // access denied
            $this->loadThis();
        }
    }
}

/* End of file supplier.php */
/* Location: ./application/controllers/supplier.php */
