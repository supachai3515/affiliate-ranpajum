<?php
defined("BASEPATH") or exit("No direct script access allowed");
require APPPATH . "/libraries/BaseController.php";
class special_county extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model("special_county_model");
        $this->load->model("products_model");
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $count = $this->special_county_model->get_special_county_count();
            $data["links_pagination"] = $this->pagination_compress("special_county/index", $count, $this->config->item("pre_page"));
            $data["special_county_list"] = $this->special_county_model->get_special_county($page, $this->config->item("pre_page"));
            $data["links_pagination"] = $this->pagination->create_links();

            $data["shipping_method_list"] = $this->products_model->get_shipping_method();
            $data["province_list"] = $this->products_model->get_province_list();
            $data["type_list"] = $this->products_model->get_type();

            $data["content"] = "special_county/special_county";
            $data["script_file"]= "js/product_add_js";
            $data["header"] = $this->get_header("Special county");
            $this->load->view("template/layout_main", $data);
        }
    }


    //page search
    public function search()
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $return_data = $this->special_county_model->get_special_county_search();
            $data["special_county_list"] = $return_data["result_special_county"];
            $data["shipping_method_list"] = $this->products_model->get_shipping_method();
            $data["data_search"] = $return_data["data_search"];
            $data["province_list"] = $this->products_model->get_province_list();

            $data["content"] = "special_county/special_county";
            $data["script_file"]= "js/product_add_js";
            $data["header"] = $this->get_header("Special county");
            $this->load->view("template/layout_main", $data);
        }
    }

    //page edit
    public function edit($amphur_id, $shipping_method_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data["special_county_data"] = $this->special_county_model->get_special_county_id($amphur_id, $shipping_method_id);
            $data["type_list"] = $this->products_model->get_type();
            $data["shipping_method_list"] = $this->products_model->get_shipping_method();
            $data["province_list"] = $this->products_model->get_province_list();
            $data["amphur_list"] = $this->products_model->get_amphur_list_all();

            $data["content"] = "special_county/special_county_edit";
            $data["script_file"]= "js/product_add_js";
            $data["header"] = $this->get_header("Special county");
            $this->load->view("template/layout_main", $data);
        }
    }

    // update
    public function update($amphur_id, $shipping_method_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save special_county
            $this->special_county_model->update_special_county($amphur_id, $shipping_method_id);

            if ($special_county_id!="") {
                redirect("special_county/edit/".$special_county_id);
            } else {
                redirect("special_county");
            };
        }
    }

    // update
    public function delete($amphur_id, $shipping_method_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save special_county
            $this->special_county_model->delete_special_county($amphur_id, $shipping_method_id);
            redirect("special_county");
        }
    }

    // insert
    public function add()
    {
        $data = $this->get_data_check("is_add");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save document
            $special_county_id ="";
            $special_county_id = $this->special_county_model->save_special_county();

            if ($document_id !="") {
                redirect("special_county/edit/".$special_county_id);
            } else {
                redirect("special_county");
            }
        }
    }

    public function getProvince()
    {
        $value = json_decode(file_get_contents("php://input"));
        $data["amphur_list"] =  $this->products_model->get_amphur_list($value->province_id);
        print json_encode($data["amphur_list"]);
    }

}

/* End of file special_county.php */
/* Location: ./application/controllers/special_county.php */
