<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";
class Sale_orders extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('sale_orders_model');
        $this->load->model('orders_model');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
      $data = $this->get_data_check("is_view");
      if (!is_null($data)) {
          $count = $this->sale_orders_model->get_sale_orders_count($this->vendorId);
          $data["links_pagination"] = $this->pagination_compress("sale_orders/index", $count, $this->config->item("pre_page"));
          $data["sale_orders_list"] = $this->sale_orders_model->get_sale_orders($this->vendorId,$page, $this->config->item("pre_page"));
          $data["links_pagination"] = $this->pagination->create_links();

          $data['order_status_list'] = $this->orders_model->get_order_status();

          $data["content"] = "sale_orders/sale_orders";
          $data["header"] = $this->get_header("sale orders");
          $this->load->view("template/layout_main", $data);
      }
    }

    //page search
    public function search()
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $return_data = $this->sale_orders_model->get_orders_search($this->vendorId);
            $data['sale_orders_list'] = $return_data['result_orders'];
            $data['data_search'] = $return_data['data_search'];
            $data['order_status_list'] = $this->orders_model->get_order_status();
            $data["content"] = "sale_orders/sale_orders";
            $data["header"] = $this->get_header("sale orders");
            $this->load->view("template/layout_main", $data);
        }
    }
}
