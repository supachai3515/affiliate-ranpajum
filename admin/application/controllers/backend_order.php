<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";
class Backend_order extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('backend_order_model');
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

            $count =  $this->backend_order_model->get_products_serach_count($searchText);
            $data["links_pagination"] = $this->pagination_compress("backend_order/index", $count, $this->config->item("pre_page"));
            $data['products_serach'] = $this->backend_order_model->get_products_serach($searchText, $page, $this->config->item("pre_page"));

            $data["content"] = "backend_order/backend_order_view";
            $data["header"] = $this->get_header("backend order");
            $this->load->view("template/layout_main", $data);
        }
    }

    public function add($id)
    {
        $data = $this->get_data_check("is_add");
        if (!is_null($data)) {
            if ($this->backend_order_model->add_product($id)) {
                redirect('backend_order/list_temp', 'refresh');
            } else {
                redirect('backend_order', 'refresh');
            }
        }
    }

    public function list_temp()
    {
        $data = $this->get_data_check("is_add");
        if (!is_null($data)) {
            $data['cart_list'] = $this->backend_order_model->get_cart_data();
            $data["content"] = "backend_order/backend_order_list_view";
            $data["header"] = $this->get_header("backend order");
            $this->load->view("template/layout_main", $data);
        }
    }

    public function update_cart()
    {
        $data = $this->get_data_check("is_add");
        if (!is_null($data)) {
            $result = $this->backend_order_model->validate_update_cart();
            redirect('backend_order/list_temp', 'refresh');
        }
    }

    public function delete($rowid)
    {
        $data = $this->get_data_check("is_add");
        if (!is_null($data)) {
            $data = array(
                    'rowid' => $rowid,
                    'qty' => 0
            );
            $this->cart->update($data);
            redirect('backend_order/list_temp', 'refresh');
        }
    }


    public function save()
    {
        $data = $this->get_data_check("is_add");
        if (!is_null($data)) {
            if (count($this->cart->contents())>0) {
                $shipping =  $this->input->post('txtShipping');
                $shipping_charge =  $this->input->post('txtShipping_charge');
                $name =  $this->input->post('txtName');
                $quantity = 0;
                $total = 0;

                foreach ($this->cart->contents() as $items) {
                    $quantity  = $quantity + $items['qty'];
                    $total  = $total + ($items['price']* $items['qty']);
                }
                //net total
                $total  = $total + $shipping_charge;

                $this->db->trans_begin();
                $ref_order_id = md5("cyberbatt".date("YmdHis")."cyberbatt_gen");
                $order_id="";
                if ($quantity == 0) {
                    redirect('backend_order/list_temp', 'refresh');
                }

                date_default_timezone_set("Asia/Bangkok");
                $data = array(
                        'date' => date("Y-m-d H:i:s"),
                        'name' => $name ,
                        'address' =>  '',
                        'tel' =>  '' ,
                        'email' =>  '' ,
                        'order_status_id' =>'1',
                        'shipping' =>   $shipping ,
                        'shipping_charge' => $shipping_charge ,
                        'is_tax' =>   0 ,
                        'quantity' =>   $quantity ,
                        'vat' =>  0 ,
                        'discount' =>  0 ,
                        'total' =>   $total,
                        'ref_id' =>   $ref_order_id ,
                        'userId' =>   $this->vendorId ,

                    );

                $this->db->insert('orders', $data);
                $order_id = $this->db->insert_id();
                $linenumber =1;

                foreach ($this->cart->contents() as $items) {
                    $total_detail  = $items['price'] * $items['qty'];
                    $vat_detail  = 0;

                    $data_detail = array(
                        'order_id' =>   $order_id ,
                        'product_id' =>   $items['id'],
                        'linenumber' =>   $linenumber,
                        'quantity' =>   $items['qty'],
                        'price' =>   $items['price'] ,
                        'discount' =>   0 ,
                        'vat' =>   $vat_detail ,
                        'total' =>   $total_detail
                    );

                    $this->db->insert('order_detail', $data_detail);
                    $linenumber++;
                }

                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    redirect('cart', 'refresh');
                } else {
                    $this->db->trans_commit();
                    $this->cart->destroy();
                    redirect('sale_orders', 'refresh');
                }
            } else {
                redirect('backend_order/list_temp', 'refresh');
            }
        }
    }
}

/* End of file backend_order.php */
/* Location: ./application/controllers/backend_order.php */
