<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Report_order extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('report_model');
        $this->load->model('products_model');
        $this->load->model('return_receive_model');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data = $this->get_data_check_name("is_view", "report_order/report_order");
        if (!is_null($data)) {
            $searchTxt = $this->input->post();
            $data['resultpost'] = $searchTxt;
            $data['selectDB'] = $this->report_model->getOrder($searchTxt);

            $data['content'] = 'reports/report_order';
            //if script file
            $data['script_file'] = 'js/report_js';
            $data["header"] = $this->get_header("report_order");
            $this->load->view('template/layout_main', $data);
        } else {
            //access denied
            $this->loadThis();
        }
    }

    public function report_product()
    {
        $data = $this->get_data_check_name("is_view", "report_order/report_product");
        if (!is_null($data)) {
            $searchTxt = $this->input->post();
            $data['resultpost'] = $searchTxt;
            $data['selectDB'] = $this->report_model->getProduct($searchTxt);
            $data['content'] = 'reports/report_product';
            //if script file
            $data['script_file'] = 'js/report_js';
            $data["header"] = $this->get_header("report_product");
            $this->load->view('template/layout_main', $data);
        } else {
            //access denied
            $this->loadThis();
        }
    }

    public function report_price()
    {
        $data = $this->get_data_check_name("is_view", "report_order/report_price");
        if (!is_null($data)) {
            $searchTxt = $this->input->post();
            $data['resultpost'] = $searchTxt;
            $data['price_report_data'] = $this->report_model->get_price_report($searchTxt);
            $data['content'] = 'reports/report_price';
            //if script file
            $data['script_file'] = 'js/report_js';
            $data["header"] = $this->get_header("report_price");
            $this->load->view('template/layout_main', $data);
        } else {
            //access denied
            $this->loadThis();
        }
    }

    public function report_purchase_order($inti='')
    {
        $data = $this->get_data_check_name("is_view", "report_order/report_purchase_order");
        if (!is_null($data)) {
            if ($inti =='') {
                //defalut search
                $data_search['all_promotion'] = "1";
                $data_search['is_active'] = "1";
                $data['data_search'] = $data_search;
                $data['products_list']= null;
            } else {
                $return_data = $this->report_model->get_products_search();
                $data['products_list'] = $return_data['result_products'];
                $data['data_search'] = $return_data['data_search'];
                $data['sql'] = $return_data['sql'];
                $is_export = $this->input->post('is_export');
            }

            $data['brands_list'] = $this->products_model->get_brands();
            $data['type_list'] = $this->products_model->get_type();

            /*Search*/
            $searchTxt = $this->input->post();
            $data['resultpost'] = $searchTxt;
            $data['purchase_order_report_data'] = $this->report_model->get_report_purchase_order($data['products_list'], $searchTxt);
            //call script
            $data['script_file']= "js/report_js";
            $data['content'] = 'reports/report_purchase_order';
            $data["header"] = $this->get_header("report purchase order");

            if (isset($is_export) && $is_export == '1') {
                $data['products_list'] = $data['purchase_order_report_data'];
                $this->load->view('reports/export_report_purchase_order', $data);
            }

            $this->load->view('template/layout_main', $data);
        } else {
            //access denied
            $this->loadThis();
        }
    }


  public function report_return_receive($inti='')
 {

    $data = $this->get_data_check_name("is_view", "report_order/report_return_receive");
    if (!is_null($data)) {
        if ($inti =='') {
          //
        } else {
            $is_export = $this->input->post('is_export');
        }

        $data['brands_list'] = $this->products_model->get_brands();
        $data['type_list'] = $this->products_model->get_type();
        $data['supplier_list'] = $this->return_receive_model->get_supplier();
        $data['return_type_list'] = $this->return_receive_model->get_return_type();

        /*Search*/
        $searchTxt = $this->input->post();
        $data['resultpost'] = $searchTxt;
        $data['return_receive_report_data'] = $this->report_model->get_report_return_receive($searchTxt);
        //call script
        $data['script_file']= "js/report_js";
        $data['content'] = 'reports/report_return_receive';
        $data["header"] = $this->get_header("report return receive");

        if (isset($is_export) && $is_export == '1') {
            $this->load->view('reports/export_report_return_receive', $data);
        }

        $this->load->view('template/layout_main', $data);
    } else {
        //access denied
        $this->loadThis();
    }
}

}

/* End of file prrducts.php */
/* Location: ./application/controllers/prrducts.php */
