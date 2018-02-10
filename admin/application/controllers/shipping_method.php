<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Shipping_method extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('shipping_method_model');
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
            $count = $this->shipping_method_model->get_shipping_method_count();
            $data['links_pagination'] = $this->pagination_compress("shipping_method/index", $count, $this->config->item('pre_page'));
            $data['shipping_method_list'] = $this->shipping_method_model->get_shipping_method($page, $this->config->item('pre_page'));

            $data['content'] = 'shipping_method/shipping_method';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Shipping method | '.$this->config->item('sitename'),
                                                                                        'description' =>  'Shipping method | '.$this->config->item('tagline'),
                                                                                        'author' => $this->config->item('author'),
                                                                                        'keyword' => 'Shipping method');
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
            $return_data = $this->shipping_method_model->get_shipping_method_search();
            $data['shipping_method_list'] = $return_data['result_shipping_method'];
            $data['data_search'] = $return_data['data_search'];

            $data['content'] = 'shipping_method/shipping_method';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Shipping method | '.$this->config->item('sitename'),
                                                                                        'description' =>  'Shipping method | '.$this->config->item('tagline'),
                                                                                        'author' => $this->config->item('author'),
                                                                                        'keyword' => 'Shipping method');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    //page edit
    public function edit($shipping_method_id)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_edit']) {
            $data['shipping_method_data'] = $this->shipping_method_model->get_shipping_method_id($shipping_method_id);
            $data['type_list'] = $this->products_model->get_type();

            $data['content'] = 'shipping_method/shipping_method_edit';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Shipping method | '.$this->config->item('sitename'),
                                                                                                                                                                            'description' =>  'Shipping method | '.$this->config->item('tagline'),
                                                                                                                                                                            'author' => $this->config->item('author'),
                                                                                                                                                                            'keyword' => 'Shipping method');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    // update
    public function update($shipping_method_id)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_edit']) {
            date_default_timezone_set("Asia/Bangkok");
            //save shipping_method
            $this->shipping_method_model->update_shipping_method($shipping_method_id);

            if ($shipping_method_id!="") {
                redirect('shipping_method/edit/'.$shipping_method_id);
            } else {
                redirect('shipping_method');
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
            $shipping_method_id ="";
            $shipping_method_id = $this->shipping_method_model->save_shipping_method();

            if ($document_id !="") {
                redirect('shipping_method/edit/'.$shipping_method_id);
            } else {
                redirect('shipping_method');
            }
        } else {
            // access denied
            $this->loadThis();
        }
    }
}

/* End of file shipping_method.php */
/* Location: ./application/controllers/shipping_method.php */
