<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_order extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		  session_start();
		$this->load->model('initdata_model');
		$this->load->model('backend_order_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{
		//echo "<pre>";
		//print_r ($data['get_orders']);
		//echo "</pre>";
		$searchText = $this->input->post('searchText');
		$data['searchText'] = $searchText;

		$config['base_url'] = base_url('backend_order/index');
		$config['total_rows'] = $this->backend_order_model->get_products_serach_count($searchText);
		$config['per_page'] = 10;
        /* This Application Must Be Used With BootStrap 3 *  */
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

    $this->pagination->initialize($config);
		$data['products_serach'] = $this->backend_order_model->get_products_serach($searchText,$page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();



		$data['menu_id'] ='28';
		$data['menus_list'] = $this->initdata_model->get_menu();

		//$data['products_serach'] = $this->backend_order_model->get_products_serach($searchText);
		$data['content'] = 'backend_order/backend_order_view';
		$data['header'] = array('title' => 'backend order | '.$this->config->item('sitename'),
								'description' =>  'backend order | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	public function add($id)
	{
		if($this->backend_order_model->add_product($id)){
					redirect('backend_order/list_temp','refresh');
			}
			else {
					redirect('backend_order','refresh');
			}
	}

	public function list_temp()
	{
		$data['menu_id'] ='28';
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['cart_list'] = $this->backend_order_model->get_cart_data();
		$data['content'] = 'backend_order/backend_order_list_view';
		$data['header'] = array('title' => 'backend order | '.$this->config->item('sitename'),
								'description' =>  'backend order | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'xcitehitec');
		$this->load->view('template/layout', $data);

	}

	public function update_cart(){
		  $result = $this->backend_order_model->validate_update_cart();
			$this->session->set_flashdata('msg', $result);
			redirect('backend_order/list_temp','refresh');
	}

	public function delete($rowid)
	{
			$data = array(
					'rowid' => $rowid,
					'qty' => 0
			);
			$this->cart->update($data);
			redirect('backend_order/list_temp','refresh');
	}


	public function save()
	{
		if(count($this->cart->contents())>0) {
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
				$ref_order_id = md5("xcitehitec".date("YmdHis")."xcitehitec_gen");
				$order_id="";
				if($quantity == 0){
					redirect('backend_order/list_temp','refresh');
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
					);

			$this->db->insert('orders', $data);
			$order_id = $this->db->insert_id();
			$linenumber =1;

			foreach ($this->cart->contents() as $items)
			{
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

			if ($this->db->trans_status() === FALSE)
			{
					$this->db->trans_rollback();
					redirect('cart','refresh');
			}
			else
			{
					$this->db->trans_commit();
					$this->cart->destroy();
					redirect('orders/edit/'.$order_id,'refresh');
			}

		}
		else{
			redirect('backend_order/list_temp','refresh');
		}

	}


	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		$chk_admin =  $this->session->userdata('permission');
		if(!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin'){
			redirect('login');
		}
	}

}

/* End of file backend_order.php */
/* Location: ./application/controllers/backend_order.php */
