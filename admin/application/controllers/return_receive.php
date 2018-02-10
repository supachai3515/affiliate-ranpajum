<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";
class Return_receive extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('return_receive_model');
        $this->load->model('products_model');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $count = $this->return_receive_model->get_return_receive_count();
            $data["links_pagination"] = $this->pagination_compress("return_receive/index", $count, $this->config->item("pre_page"));
            $data["return_receive_list"] = $this->return_receive_model->get_return_receive($page, $this->config->item("pre_page"));
            $data["links_pagination"] = $this->pagination->create_links();

            $data['type_list'] = $this->products_model->get_type();
            $data['supplier_list'] = $this->return_receive_model->get_supplier();
            $data['return_type_list'] = $this->return_receive_model->get_return_type();

            $data['content'] = 'return_receive/return_receive';
            $data['script_file']= "js/return_receive_js";
            $data["header"] = $this->get_header("return_receive");
            $this->load->view("template/layout_main", $data);

        }
    }

    //page search
    public function search()
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $return_data = $this->return_receive_model->get_return_receive_search();
            $data['return_receive_list'] = $return_data['result_return_receive'];
            $data['data_search'] = $return_data['data_search'];

            $data['script_file']= "js/return_receive_js";
            $data["content"] = "return_receive/return_receive";
            $data["header"] = $this->get_header("return_receive");
            $this->load->view("template/layout_main", $data);
        }
    }

    //page edit
    public function edit($return_receive_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['return_receive_data'] = $this->return_receive_model->get_return_receive_id($return_receive_id);
            $data['type_list'] = $this->products_model->get_type();
            $data['supplier_list'] = $this->return_receive_model->get_supplier();
            $data['return_type_list'] = $this->return_receive_model->get_return_type();

            $data['script_file']= "js/return_receive_js";
            $data["content"] = "return_receive/return_receive_edit";
            $data["header"] = $this->get_header("return_receive");
            $this->load->view("template/layout_main", $data);
        }
    }

    //page edit
    public function view($return_receive_id)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $data['return_receive_data'] = $this->return_receive_model->get_return_receive_id($return_receive_id);
            $data['type_list'] = $this->products_model->get_type();
            $data['supplier_list'] = $this->return_receive_model->get_supplier();
            $data['return_type_list'] = $this->return_receive_model->get_return_type();

            $data['script_file']= "js/return_receive_js";
            $data["content"] = "return_receive/return_receive_view";
            $data["header"] = $this->get_header("return_receive");
            $this->load->view("template/layout_main", $data);
        }
    }

    // update
    public function update($return_receive_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save return_receive
            $this->return_receive_model->update_return_receive($return_receive_id);

            if ($return_receive_id!="") {
                redirect('return_receive/edit/'.$return_receive_id);
            } else {
                redirect('return_receive');
            }
        }
    }

    // insert
    public function add()
    {
        $data = $this->get_data_check("is_add");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save document
            $return_receive_id ="";
            $return_receive_id = $this->return_receive_model->save_return_receive();

            if ($return_receive_id !="") {
                redirect('return_receive/edit/'.$return_receive_id);
            } else {
                redirect('return_receive');
            }
        }
    }


    public function get_search_order()
    {
        $value = json_decode(file_get_contents("php://input"));
        $data['search_order'] =  $this->return_receive_model->get_search_order($value->search);
        print json_encode($data['search_order']);
    }


    public function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        $chk_admin =  $this->session->userdata('permission');
        if (!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin') {
            redirect('login');
        }
    }
}

/* End of file return_receive.php */
/* Location: ./application/controllers/return_receive.php */
