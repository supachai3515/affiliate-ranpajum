<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";
class Dashboard extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        //call model inti
        $this->load->model('initdata_model');
        $this->load->model('dasboard_model');
        $this->isLoggedIn();
    }

    public function index()
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $data['get_order_status'] = $this->dasboard_model->get_order_status();
            $data['get_orders'] = $this->dasboard_model->get_orders();
            $data['get_orders_today'] = $this->dasboard_model->get_orders_today();
            $data["content"] = "dashboard";
            $data["header"] = $this->get_header("Dashboard");
            $this->load->view("template/layout_main", $data);
        }
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
