<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //call model inti
        $this->load->model('initdata_model');
        $this->load->library('pagination');
        $this->load->model('cart_model');
        session_start();
    }

    public function index()
    {
        //header meta tag
        $data['header'] = array(
            'title' => 'ตะกร้าสินค้า | ' . $this->config->item('sitename'),
            'description' => 'ตะกร้าสินค้า | ' . $this->config->item('tagline'),
            'author' => $this->config->item('author'),
            'keyword' => 'ตะกร้าสินค้า | ' . $this->config->item('tagline')
        );
        //get menu database
        $this->load->model('initdata_model');
        $data['menus_list']  = $this->initdata_model->get_menu();
        $data['menu_type']   = $this->initdata_model->get_type();
        $data['menu_brands'] = $this->initdata_model->get_brands();
        $data['cart_list'] = $this->initdata_model->get_cart_data();
        //content file view
        $data['content']     = 'cart';
        // if have file script
        //$data['script_file']= "js/product_add_js";
        //load layout
        $this->load->view('template/layout', $data);
    }

    public function get_cart()
    {
        $productResult = array();
        $productResult  = $this->initdata_model->get_cart_data();
        echo json_encode($productResult, JSON_NUMERIC_CHECK);
    }

    public function delete_item($rowid)
    {
        $data = array(
            'rowid' => $rowid,
            'qty' => 0
        );
        $this->cart->update($data);
    }

    public function update_item($rowid, $qty)
    {
        $data = array(
            'rowid' => $rowid,
            'qty' => $qty
        );
        $this->cart->update($data);
    }

    public function add($id)
    {
        $sql   = "SELECT * FROM products WHERE is_active = 1 AND stock > 0 AND id = '" . $id . "'";
        $query = $this->db->query($sql);
        $row   = $query->row_array();
        if (isset($row['id'])) {
            $price  = $row["price"];
            $dis_price  = $row["dis_price"];

            if ($this->session->userdata('is_logged_in') && $this->session->userdata('verify') == "1") {

                if($this->session->userdata('is_lavel1')) {
                    if($row["member_discount_lv1"] > 1){
                        $dis_price = $row["member_discount_lv1"];
                    }
                }
                else {

                    if($row["member_discount"] > 1){
                        $dis_price = $row["member_discount"];
                    }
                }
            }
            if ($dis_price < $price  &&  $dis_price > 0) {
                $price = $dis_price;
            }

            $data = array(
                array(
                    'id' => $row['id'],
                    'sku' => $row['id'],
                    'qty' => 1,
                    'price' => $price,
                    'is_reservations' => 0,
                    'name' => $row['id']
                )
            );
            $this->cart->insert($data);
            redirect('cart','refresh');
        }
        else {
            redirect('products','refresh');
        }
    }

    public function update()
    {
        $i = 1;
        foreach ($this->cart->contents() as $items) {
            $data = array(
                'rowid' => $items['rowid'],
                'qty' => $this->input->post($i . 'qty')
            );
            $this->cart->update($data);
            $i++;
        }
        redirect('cart','refresh');
    }

    public function delete($rowid)
    {
        $data = array(
            'rowid' => $rowid,
            'qty' => 0
        );
        $this->cart->update($data);
        redirect('cart','refresh');
    }

    public function update_cart(){
       $result = $this->cart_model->validate_update_cart();
        $this->session->set_flashdata('msg', $result);
        redirect('cart','refresh');
    }

    public function show_cart(){
        $this->load->view('cart/cart');
    }

    public function empty_cart(){
        $this->cart->destroy();
        redirect('cart');
    }
}
/* End of file cart.php */
/* Location: ./application/controllers/cart.php */
