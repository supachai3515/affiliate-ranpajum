<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";
class Purchase_order extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('purchase_order_model');
        $this->load->model('products_model');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $count = $this->purchase_order_model->get_purchase_order_count($searchText);
            $data["links_pagination"] = $this->pagination_compress("purchase_order/index", $count, $this->config->item("pre_page"));
            $data["purchase_order_list"] = $this->purchase_order_model->get_purchase_order($searchText, $page, $this->config->item("pre_page"));
            $data["links_pagination"] = $this->pagination->create_links();
            $data["content"] = "purchase_order/purchase_order_view";
            $data["header"] = $this->get_header("Purchase order");
            $this->load->view("template/layout_main", $data);
        }
    }


    //view_edit
    public function edit_view($purchase_order_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['purchase_order_data'] = $this->purchase_order_model->get_purchase_order_id($purchase_order_id);
            $data['purchase_order_detail_data'] = $this->purchase_order_model->get_purchase_order_detail($purchase_order_id);
            $data['type_list'] = $this->products_model->get_type();

            $data['script_file']= "js/purchase_order_js";
            $data["header"] = $this->get_header("Purchase order");
            $this->load->view("purchase_order/purchase_order_info_view_edit", $data);
        }
    }

    //page edit
    public function view($purchase_order_id)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $data['purchase_order_data'] = $this->purchase_order_model->get_purchase_order_id($purchase_order_id);
            $data['purchase_order_detail_data'] = $this->purchase_order_model->get_purchase_order_detail($purchase_order_id);
            $data['type_list'] = $this->products_model->get_type();

            $data['script_file']= "js/purchase_order_js";
            $data["header"] = $this->get_header("Purchase order");
            $this->load->view("purchase_order/purchase_order_info_view", $data);
        }
    }


    //page search
    public function add()
    {
        $data = $this->get_data_check("is_add");
        if (!is_null($data)) {
            $data['type_list'] = $this->products_model->get_type();
            $data['script_file']= "js/purchase_order_js";
            $data["content"] = "purchase_order/purchase_order_add_view";
            $data["header"] = $this->get_header("Purchase order");
            $this->load->view("template/layout_main", $data);
        }
    }

    //page edit
    public function edit($purchase_order_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['purchase_order_data'] = $this->purchase_order_model->get_purchase_order_id($purchase_order_id);
            $data['type_list'] = $this->products_model->get_type();
            $data['script_file']= "js/purchase_order_js";
            $data["content"] = "purchase_order/purchase_order_edit_view";
            $data["header"] = $this->get_header("Purchase order");
            $this->load->view("template/layout_main", $data);
        }
    }

    // update
    public function update($purchase_order_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save purchase_order
            $this->purchase_order_model->update_purchase_order($purchase_order_id);

            if ($purchase_order_id!="") {
                redirect('purchase_order/edit/'.$purchase_order_id);
            } else {
                redirect('purchase_order');
            }
        }
    }

    // update
    public function transfer_save($purchase_order_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['purchase_order_data'] = $this->purchase_order_model->get_purchase_order_id($purchase_order_id);
            $data['type_list'] = $this->products_model->get_type();
            $data['script_file']= "js/purchase_order_js";
            $data["content"] = "purchase_order/purchase_order_transfer_view";
            $data["header"] = $this->get_header("purchase order transfer");
            $this->load->view("template/layout_main", $data);
        }
    }

    // insert
    public function add_save()
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save document
            $purchase_order_id ="";
            $purchase_order_id = $this->purchase_order_model->save_purchase_order();

            if ($document_id !="") {
                redirect('purchase_order/edit/'.$purchase_order_id);
            } else {
                redirect('purchase_order');
            }
        }
    }

    public function get_product()
    {
        $value = json_decode(file_get_contents("php://input"));
        $data['product'] =  $this->purchase_order_model->get_product($value->sku);
        print json_encode($data['product']);
    }

    public function get_purchase_order_detail()
    {
        $value = json_decode(file_get_contents("php://input"));
        $data['product'] =  $this->purchase_order_model->get_purchase_order_detail($value->id);
        print json_encode($data['product']);
    }


    public function line_number()
    {
        $sql ="SELECT purchase_order_id , product_id FROM product_serial GROUP BY purchase_order_id , product_id";
        $query = $this->db->query($sql);
        $re = $query->result_array();
        foreach ($re as $r) {
            $sql ="SELECT *  FROM product_serial WHERE purchase_order_id ='".$r['purchase_order_id']."' AND product_id = '".$r['product_id']."'";
            $query = $this->db->query($sql);
            $re1 = $query->result_array();
            $i= 1;
            foreach ($re1 as $r1) {
                print($i." - ".$r1['serial_number']." - ".$r1['product_id']." - ".$r1['purchase_order_id']."<br/>");

                date_default_timezone_set("Asia/Bangkok");
                $data_update = array(
                'line_number' => $i
            );

                $this->db->update("product_serial", $data_update, "product_id = '".$r1['product_id']."' AND  serial_number = '".$r1['serial_number']."'  AND purchase_order_id = '".$r1['purchase_order_id']."'");
                $i++;
            }
        }
    }
}

/* End of file purchase_order.php */
/* Location: ./application/controllers/purchase_order.php */
