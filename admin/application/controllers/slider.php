<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";
class Slider extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('slider_model');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $count = $this->slider_model->get_slider_count();
            $data["links_pagination"] = $this->pagination_compress("slider/index", $count, $this->config->item("pre_page"));
            $data["slider_list"] = $this->slider_model->get_slider($page, $this->config->item("pre_page"));
            $data["links_pagination"] = $this->pagination->create_links();
            $data["content"] = "slider/slider";
            $data["header"] = $this->get_header("Slider");
            $this->load->view("template/layout_main", $data);
        }
    }

    //page edit
    public function edit($slider_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $count = $this->slider_model->get_slider_count();
            $data['slider_data'] = $this->slider_model->get_slider_id($slider_id);
            $data['script_file']= "js/slider_js";
            $data["content"] = "slider/slider_edit";
            $data["header"] = $this->get_header("Sliders Edit");
            $this->load->view("template/layout_main", $data);
        }
    }

    // update
    public function update($slider_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save slider
            $this->slider_model->update_slider($slider_id);

            if ($slider_id!="") {
                redirect('slider/edit/'.$slider_id);
            } else {
                redirect('slider');
            }
        }
    }
}

/* End of file slider.php */
/* Location: ./application/controllers/slider.php */
