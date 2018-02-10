<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";
class Product_serial extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('product_serial_model');
        $this->load->model('products_model');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {

			$data = $this->get_data_check("is_view");
			if (!is_null($data)) {
					$count = $this->product_serial_model->get_product_serial_count();
					$data["links_pagination"] = $this->pagination_compress("product_serial/index", $count, $this->config->item("pre_page"));
					$data["product_serial_list"] = $this->product_serial_model->get_product_serial($page, $this->config->item("pre_page"));
					$data["links_pagination"] = $this->pagination->create_links();
					$data['script_file']= "js/serial_js";
					$data["content"] = "product_serial/product_serial";
					$data["header"] = $this->get_header("product serial");
					$this->load->view("template/layout_main", $data);
			}
    }

    //page search
    public function search()
    {

			$data = $this->get_data_check("is_view");
			if (!is_null($data)) {
				$return_data = $this->product_serial_model->get_product_serial_search();
				$data['product_serial_list'] = $return_data['result_product_serial'];
				$data['data_search'] = $return_data['data_search'];
        $data['sql'] = $return_data['sql'];

					$data['script_file']= "js/serial_js";
					$data["content"] = "product_serial/product_serial";
					$data["header"] = $this->get_header("product serial");
					$this->load->view("template/layout_main", $data);
			}

    }

    public function get_product_serial_history()
    {
        $value = json_decode(file_get_contents("php://input"));
        $data['serial'] =  $this->product_serial_model->get_product_serial_history($value->product_id, $value->serial_number);
        print json_encode($data['serial']);
    }

}

/* End of file product_serial.php */
/* Location: ./application/controllers/product_serial.php */
