<?php
defined("BASEPATH") or exit("No direct script access allowed");
require APPPATH . "/libraries/BaseController.php";
class Shipping_rate extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model("shipping_rate_model");
        $this->load->model("products_model");
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $count = $this->shipping_rate_model->get_shipping_rate_count();
            $data["links_pagination"] = $this->pagination_compress("shipping_rate/index", $count, $this->config->item("pre_page"));
            $data["shipping_rate_list"] = $this->shipping_rate_model->get_shipping_rate($page, $this->config->item("pre_page"));
            $data["links_pagination"] = $this->pagination->create_links();

            $data["shipping_method_list"] = $this->products_model->get_shipping_method();
            $data["type_list"] = $this->products_model->get_type();

            $data["content"] = "shipping_rate/shipping_rate";
            $data["script_file"]= "js/product_add_js";
            $data["header"] = $this->get_header("Shipping rate");
            $this->load->view("template/layout_main", $data);
        }
    }


    //page search
    public function search()
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $return_data = $this->shipping_rate_model->get_shipping_rate_search();
            $data["shipping_rate_list"] = $return_data["result_shipping_rate"];
            $data["shipping_method_list"] = $this->products_model->get_shipping_method();
            $data["data_search"] = $return_data["data_search"];
            $data["content"] = "shipping_rate/shipping_rate";
            $data["script_file"]= "js/product_add_js";
            $data["header"] = $this->get_header("Shipping rate");
            $this->load->view("template/layout_main", $data);
        }
    }

    //page edit
    public function edit($shipping_rate_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data["shipping_rate_data"] = $this->shipping_rate_model->get_shipping_rate_id($shipping_rate_id);
            $data["type_list"] = $this->products_model->get_type();
            $data["shipping_method_list"] = $this->products_model->get_shipping_method();
            $data["content"] = "shipping_rate/shipping_rate_edit";
            $data["script_file"]= "js/product_add_js";
            $data["header"] = $this->get_header("Shipping rate");
            $this->load->view("template/layout_main", $data);
        }
    }

    // update
    public function update($shipping_rate_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save shipping_rate
            $this->shipping_rate_model->update_shipping_rate($shipping_rate_id);

            if ($shipping_rate_id!="") {
                redirect("shipping_rate/edit/".$shipping_rate_id);
            } else {
                redirect("shipping_rate");
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
            $shipping_rate_id ="";
            $shipping_rate_id = $this->shipping_rate_model->save_shipping_rate();
            if ($document_id !="") {
                redirect("shipping_rate/edit/".$shipping_rate_id);
            } else {
                redirect("shipping_rate");
            }
        }
    }
}

/* End of file shipping_rate.php */
/* Location: ./application/controllers/shipping_rate.php */
