<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dealer_po extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->library('pagination');
		$this->load->model('dealer_model');
		 session_start();
	}

	public function index()
	{
		if($this->session->userdata('is_logged_in')){
			$data['orderList'] =  $this->dealer_model->get_orderList($this->session->userdata('username'));
			$data['dealerInfo'] =  $this->dealer_model->get_dealerInfo($this->session->userdata('username'));
			
		}

		//header meta tag 
		$data['header'] = array('title' => 'สมาชิก dealer | '.$this->config->item('sitename'),
								'description' => 'สมาชิก dealer | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' => 'สมาชิก dealer | '.$this->config->item('tagline') );
		//get menu database 
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();

        //content file view
		$data['content'] = 'dealer_po';
		// if have file script
		$data['script_file']= "template/app_po";
		//load layout
		$this->load->view('template/layout', $data);
	}

	public function po_list()
	{
		if($this->session->userdata('is_logged_in')){
			$data['orderList'] =  $this->dealer_model->get_orderList($this->session->userdata('username'));
			$data['dealerInfo'] =  $this->dealer_model->get_dealerInfo($this->session->userdata('username'));
			$data['po_orderList'] =  $this->dealer_model->get_po_orderList($this->session->userdata('username'));
			
		}

		//header meta tag 
		$data['header'] = array('title' => 'สมาชิก dealer | '.$this->config->item('sitename'),
								'description' => 'สมาชิก dealer | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' => 'สมาชิก dealer | '.$this->config->item('tagline') );
		//get menu database 
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();

        //content file view
		$data['content'] = 'dealer_po_list';
		// if have file script
		//$data['script_file']= "js/product_add_js";
		//load layout
		$this->load->view('template/layout', $data);
	}

	public function add($id)
	{
		if($this->session->userdata('is_logged_in')){
			$dealerInfo  =  $this->dealer_model->get_dealerInfo($this->session->userdata('username'));

			$sql =" SELECT * FROM po_cart WHERE member_id ='".$dealerInfo['id']."' AND product_id = '".$id."'";
			$re = $this->db->query($sql);

			$rowcount = $re->num_rows();
			if ($rowcount == 0) {
					$price  = $this->re_price($id);
					$data = array(
				        'member_id' => $dealerInfo['id'],
				        'product_id' => $id,
				        'qty' => '1',
				        'price' => $price,
				        'total' => $price
				);

				$this->db->insert('po_cart', $data);
			}
			redirect('dealer_po','refresh');
		}
		else {
			redirect('dealer','refresh');
		}
	}

	public function get_cart()
    {
    	if($this->session->userdata('is_logged_in')) {
			$dealerInfo  =  $this->dealer_model->get_dealerInfo($this->session->userdata('username'));
			$sql1 ="SELECT qty, product_id FROM po_cart WHERE member_id ='".$dealerInfo['id']."' ";
			$query1 = $this->db->query($sql1);
	        $row1 = $query1->result_array();
		
	        $productResult = array();
	        foreach ($row1 as $items) {

	            $sql = "SELECT p.* ,t.name type_name, b.name brand_name
	                FROM  products p 
	                LEFT JOIN product_brand b ON p.product_brand_id = b.id
	                LEFT JOIN product_type t ON p.product_type_id = t.id  WHERE
	                p.is_active = 1 AND p.id = '".$items['product_id']."'";
	            $query = $this->db->query($sql);
	            $row = $query->row_array();
	            if (isset($row['id'])) {
	                $price  = $this->re_price($row['id']);
	                $image_url = "";
	                if ($row['image'] != "") {
	                    $image_url = $this->config->item('url_img') . $row['image'];
	                } else {
	                    $image_url = $this->config->item('no_url_img');
	                }

	               array_push($productResult ,array(
	                    'id' => $row['id'],
	                    'sku' => $row['sku'],
	                    'name' => $row['name'],
	                    'img' => $image_url,
	                    'price' => $price,
	                    'qty' => $items['qty'],
	                    'model' => $row['model'],
	                    'brand' => $row['brand_name'],
	                    'type' => $row['type_name']
	                ));

	            }
	        }
	        echo json_encode($productResult, JSON_NUMERIC_CHECK);
	    }
	}

    public function delete_item($id)
    {
       if($this->session->userdata('is_logged_in')){
			$dealerInfo  =  $this->dealer_model->get_dealerInfo($this->session->userdata('username'));
			$this->db->delete('po_cart', array('product_id' => $id, 'member_id' => $dealerInfo['id'])); 
	    }
    }

    public function update_item($id, $qty)
    {
        if($this->session->userdata('is_logged_in')) {
			$dealerInfo  =  $this->dealer_model->get_dealerInfo($this->session->userdata('username'));
			$price  = $this->re_price($id);
			$data = array(
			        'product_id' => $id,
			        'qty' =>  $qty,
			        'price' => $price,
			        'total' => $price * $qty
			);

			$this->db->where(array('product_id' => $id, 'member_id' => $dealerInfo['id']));
			$this->db->update('po_cart', $data);
	    }
    }

    public function re_price($id){
		$sql1 =" SELECT * FROM products WHERE id = '".$id."'";
		$query = $this->db->query($sql1);
		$row = $query->row_array();
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

        if ($dis_price < $price ) {
            $price = $dis_price;
        }
        return $price ;
    }
}

/* End of file dealer.php */
/* Location: ./application/controllers/dealer.php */