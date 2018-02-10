<?php
defined("BASEPATH") or exit("No direct script access allowed");
require APPPATH . "/libraries/BaseController.php";
class Productbrand extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model("productbrand_model");
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data["global"] = $this->global;
        $data["menu_id"] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data["menu_list"] = $this->initdata_model->get_menu($data["global"]["menu_group_id"]);
        $data["access_menu"] = $this->isAccessMenu($data["menu_list"], $data["menu_id"]);
        if ($data["access_menu"]["is_access"]&&$data["access_menu"]["is_view"]) {
            $count = $this->productbrand_model->get_productbrand_count();
            $data["links_pagination"] = $this->pagination_compress("productbrand/index", $count, $this->config->item("pre_page"));
            $data["productbrand_list"] = $this->productbrand_model->get_productbrand($page, $this->config->item("pre_page"));

            $data["content"] = "productbrand/productbrand";
            //if script file
            $data["script_file"]= "js/product_add_js";
            $data["header"] = array("title" => "Product Brand | ".$this->config->item("sitename"),
                                              "description" =>  "Product Brand | ".$this->config->item("tagline"),
                                              "author" => $this->config->item("author"),
                                              "keyword" => "Product Brand");
            $this->load->view("template/layout_main", $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }


    //page search
    public function search()
    {
        $data["global"] = $this->global;
        $data["menu_id"] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data["menu_list"] = $this->initdata_model->get_menu($data["global"]["menu_group_id"]);
        $data["access_menu"] = $this->isAccessMenu($data["menu_list"], $data["menu_id"]);
        if ($data["access_menu"]["is_access"]&&$data["access_menu"]["is_view"]) {
            $return_data = $this->productbrand_model->get_productbrand_search();
            $data["productbrand_list"] = $return_data["result_productbrand"];
            $data["data_search"] = $return_data["data_search"];

            $data["content"] = "productbrand/productbrand";
            //if script file
            $data["script_file"]= "js/product_add_js";
            $data["header"] = array("title" => "Product Brand | ".$this->config->item("sitename"),
                                              "description" =>  "Product Brand | ".$this->config->item("tagline"),
                                              "author" => $this->config->item("author"),
                                              "keyword" => "Product Brand");
            $this->load->view("template/layout_main", $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    //page edit
    public function edit($productbrand_id)
    {
        $data["global"] = $this->global;
        $data["menu_id"] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data["menu_list"] = $this->initdata_model->get_menu($data["global"]["menu_group_id"]);
        $data["access_menu"] = $this->isAccessMenu($data["menu_list"], $data["menu_id"]);
        if ($data["access_menu"]["is_access"]&&$data["access_menu"]["is_edit"]) {
            $data["productbrand_data"] = $this->productbrand_model->get_productbrand_id($productbrand_id);
            $data["content"] = "productbrand/productbrand_edit";
            //if script file
            $data["script_file"]= "js/product_add_js";
            $data["header"] = array("title" => "Product Brand | ".$this->config->item("sitename"),
                                              "description" =>  "Product Brand | ".$this->config->item("tagline"),
                                              "author" => $this->config->item("author"),
                                              "keyword" => "Product Brand");
            $this->load->view("template/layout_main", $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    // update
    public function update($productbrand_id)
    {
        $data["global"] = $this->global;
        $data["menu_id"] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data["menu_list"] = $this->initdata_model->get_menu($data["global"]["menu_group_id"]);
        $data["access_menu"] = $this->isAccessMenu($data["menu_list"], $data["menu_id"]);
        if ($data["access_menu"]["is_access"]&&$data["access_menu"]["is_edit"]) {
            date_default_timezone_set("Asia/Bangkok");
            //save productbrand
            $this->productbrand_model->update_productbrand($productbrand_id);

            if ($productbrand_id!="") {
                redirect("productbrand/edit/".$productbrand_id);
            } else {
                redirect("productbrand");
            }
        } else {
            // access denied
            $this->loadThis();
        }
    }

    // insert
    public function add()
    {
        $data["global"] = $this->global;
        $data["menu_id"] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data["menu_list"] = $this->initdata_model->get_menu($data["global"]["menu_group_id"]);
        $data["access_menu"] = $this->isAccessMenu($data["menu_list"], $data["menu_id"]);
        if ($data["access_menu"]["is_access"]&&$data["access_menu"]["is_add"]) {
            date_default_timezone_set("Asia/Bangkok");
            //save document
            $productbrand_id ="";
            $productbrand_id = $this->productbrand_model->save_productbrand();

            if ($document_id !="") {
                redirect("productbrand/edit/".$productbrand_id);
            } else {
                redirect("productbrand");
            }
        } else {
            // access denied
            $this->loadThis();
        }
    }
}

/* End of file productbrand.php */
/* Location: ./application/controllers/productbrand.php */
