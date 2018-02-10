<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";
class delivery_return extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('delivery_return_model');
        $this->load->model('products_model');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $count = $this->delivery_return_model->get_delivery_return_count();
            $data["links_pagination"] = $this->pagination_compress("delivery_return/index", $count, $this->config->item("pre_page"));
            $data["delivery_return_list"] = $this->delivery_return_model->get_delivery_return($page, $this->config->item("pre_page"));
            $data["links_pagination"] = $this->pagination->create_links();
            $data['type_list'] = $this->products_model->get_type();
            $data['script_file']= "js/delivery_return_js";
            $data["content"] = "delivery_return/delivery_return";
            $data["header"] = $this->get_header("Delivery return");
            $this->load->view("template/layout_main", $data);
        }
    }


    //page search
    public function search()
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $return_data = $this->delivery_return_model->get_delivery_return_search();
            $data['delivery_return_list'] = $return_data['result_delivery_return'];
            $data['data_search'] = $return_data['data_search'];
            $data['script_file']= "js/delivery_return_js";
            $data["content"] = "delivery_return/delivery_return";
            $data["header"] = $this->get_header("Delivery return");
            $this->load->view("template/layout_main", $data);
        }
    }

    //page edit
    public function edit($delivery_return_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['delivery_return_data'] = $this->delivery_return_model->get_delivery_return_id($delivery_return_id);
            $data['type_list'] = $this->products_model->get_type();
            $data['script_file']= "js/delivery_return_js";
            $data["content"] = "delivery_return/delivery_return_edit";
            $data["header"] = $this->get_header("Delivery return");
            $this->load->view("template/layout_main", $data);
        }
    }

    // update
    public function update($delivery_return_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save delivery_return
            $this->delivery_return_model->update_delivery_return($delivery_return_id);

            if ($delivery_return_id!="") {
                redirect('delivery_return/edit/'.$delivery_return_id);
            } else {
                redirect('delivery_return');
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
            $delivery_return_id ="";
            $delivery_return_id = $this->delivery_return_model->save_delivery_return();

            if ($delivery_return_id !="") {
                redirect('delivery_return/edit/'.$delivery_return_id);
            } else {
                redirect('delivery_return');
            }
        }
    }

    public function get_search_order()
    {
        $value = json_decode(file_get_contents("php://input"));
        $data['search_order'] =  $this->delivery_return_model->get_search_order($value->search);
        print json_encode($data['search_order']);
    }
}

/* End of file delivery_return.php */
/* Location: ./application/controllers/delivery_return.php */
