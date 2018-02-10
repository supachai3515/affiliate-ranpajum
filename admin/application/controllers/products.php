<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Products extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        session_cache_limiter('private, must-revalidate');
        session_cache_expire(60);
        session_start();
        
        $this->load->model('products_model');
        $this->load->library('my_upload');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $count = $this->products_model->get_products_count();
            $data['links_pagination'] = $this->pagination_compress("products/index", $count, $this->config->item('pre_page'));
            $data['products_list'] = $this->products_model->get_products($page, $this->config->item('pre_page'));
            $data['brands_list'] = $this->products_model->get_brands();
            $data['type_list'] = $this->products_model->get_type();
            //defalut search
            $data_search['all_promotion'] = "1";
            $data_search['is_active'] = "1";
            $data['data_search'] = $data_search;

            $data['content'] = 'products/products';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data["header"] = $this->get_header("product");
            $this->load->view("template/layout_main", $data);
        }
    }
    //page edit
    public function edit($product_id)
    {
      $data = $this->get_data_check("is_edit");
      if (!is_null($data)) {
            $data['brands_list'] = $this->products_model->get_brands();
            $data['type_list'] = $this->products_model->get_type();
            $data['product_data'] = $this->products_model->get_product($product_id);
            $data['images_list'] = $this->products_model->get_images($product_id);

            $data['content'] = 'products/product_edit';
            //if script file
            $data['script_file']= "js/product_js";
            $data["header"] = $this->get_header("product edit");
            $this->load->view("template/layout_main", $data);
        }
    }
    //page search
    public function search()
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_view']) {
            $return_data = $this->products_model->get_products_search();
            $data['products_list'] = $return_data['result_products'];
            $data['data_search'] = $return_data['data_search'];
            $data['sql'] = $return_data['sql'];

            $data['brands_list'] = $this->products_model->get_brands();
            $data['type_list'] = $this->products_model->get_type();

            $data['content'] = 'products/products';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'Products | '.$this->config->item('sitename'),
                                                                    'description' =>  'Products | '.$this->config->item('tagline'),
                                                                    'author' => $this->config->item('author'),
                                                                    'keyword' => 'Products');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    // insert
    public function add()
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_add']) {
            date_default_timezone_set("Asia/Bangkok");
            //save product
            $product_id ="";
            $product_id = $this->products_model->save_product();
            echo $product_id;

            $image_name = "";
            $dir ='./../uploads/'.date("Ym").'/';
            $dir_insert ='uploads/'.date("Ym").'/';

            if ($product_id!="") {
                $this->my_upload->upload($_FILES["image_field"]);
                if ($this->my_upload->uploaded == true) {
                    $this->my_upload->allowed         = array('image/*');
                    $this->my_upload->file_name_body_pre = 'thumb_';
                    //$this->my_upload->file_new_name_body    = 'image_resized_' . $now;
                    $this->my_upload->image_resize          = true;
                    $this->my_upload->image_x               = 800;
                    $this->my_upload->image_ratio_y         = true;
                    $this->my_upload->process($dir);

                    if ($this->my_upload->processed == true) {
                        $image_name  = $this->my_upload->file_dst_name;
                        $this->products_model->update_img($product_id, $dir_insert.$image_name);

                        $this->my_upload->clean();
                    } else {
                        $data['errors'] = $this->my_upload->error;
                        echo $data['errors'];
                    }
                } else {
                    $data['errors'] = $this->my_upload->error;
                }

                for ($i=1; $i <11 ; $i++) {
                    $this->my_upload->upload($_FILES['image_field_'.$i]);
                    if ($this->my_upload->uploaded == true) {
                        $this->my_upload->allowed   = array('image/*');
                        $this->my_upload->process($dir);

                        if ($this->my_upload->processed == true) {
                            $image_name  = $this->my_upload->file_dst_name;
                            //inset image
                            $this->products_model->insert_productimgs($product_id, $i, $dir_insert.$image_name);

                            $this->my_upload->clean();
                        } else {
                            $data['errors'] = $this->my_upload->error;
                            echo $data['errors'];
                            //inset image
                            $this->products_model->insert_productimgs($product_id, $i, "");
                        }
                    } else {
                        $data['errors'] = $this->my_upload->error;
                        //inset image
                        $this->products_model->insert_productimgs($product_id, $i, "");
                    }
                }
            }
            if ($product_id!="") {
                redirect('products/edit/'.$product_id);
            } else {
                redirect('products');
            }
        } else {
            // access denied
            $this->loadThis();
        }
    }
    // update
    public function update($product_id)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_edit']) {
            date_default_timezone_set("Asia/Bangkok");
            //save product
            $this->products_model->update_product($product_id);

            $dir ='./../uploads/'.date("Ym").'/';
            $dir_insert ='uploads/'.date("Ym").'/';

            if ($product_id !="") {
                $this->my_upload->upload($_FILES["image_field"]);
                if ($this->my_upload->uploaded == true) {
                    $this->my_upload->allowed         = array('image/*');
                    $this->my_upload->file_name_body_pre = 'thumb_';
                    $this->my_upload->image_resize          = true;
                    $this->my_upload->image_x               = 800;
                    $this->my_upload->image_ratio_y         = true;
                    $this->my_upload->process($dir);

                    if ($this->my_upload->processed == true) {
                        $image_name  = $this->my_upload->file_dst_name;
                        //update img
                        $this->products_model->update_img($product_id, $dir_insert.$image_name);
                        $this->my_upload->clean();
                    } else {
                        $data['errors'] = $this->my_upload->error;
                        echo $data['errors'];
                    }
                } else {
                    $data['errors'] = $this->my_upload->error;
                }

                for ($i=1; $i <11 ; $i++) {
                    //update is active
                    $this->products_model->update_productimgs_active($product_id, $i, $this->input->post('is_active_'.$i));
                    $this->my_upload->upload($_FILES['image_field_'.$i]);
                    if ($this->my_upload->uploaded == true) {
                        $this->my_upload->allowed   = array('image/*');
                        $this->my_upload->process($dir);

                        if ($this->my_upload->processed == true) {
                            $image_name  = $this->my_upload->file_dst_name;
                            //update image
                            $this->products_model->update_productimgs($product_id, $i, $dir_insert.$image_name, $this->input->post('is_active_'.$i));

                            $this->my_upload->clean();
                        } else {
                            $data['errors'] = $this->my_upload->error;
                        }
                    } else {
                        $data['errors'] = $this->my_upload->error;
                    }
                }
            }
            if ($product_id!="") {
                redirect('products/edit/'.$product_id);
            } else {
                redirect('products');
            }
        } else {
            // access denied
            $this->loadThis();
        }
    }

    public function runimg()
    {
        $sql ="SELECT * FROM products ";
        $query = $this->db->query($sql);
        $datalist = $query->result_array();


        foreach ($datalist  as $row) {
            $list = $this->products_model->get_images($row['id']);

            for ($i = 1; $i <= 10-count($list); $i++) {
                $this->products_model->insert_productimgs($row['id'], count($list)+$i, "");
                echo count($list)+$i.'<br/>';
            }

            echo $row['name'].'<br/>';
        }
    }

    public function runslug()
    {
        $sql ="SELECT * FROM products ";
        $query = $this->db->query($sql);
        $datalist = $query->result_array();


        foreach ($datalist  as $row) {
            $slug =    $this->Initdata_model->slug($row['name']);

            $data_product = array(
                'slug' => $slug
            );

            $where = "id = '".$row['id']."'";
            $this->db->update("products", $data_product, $where);

            echo $slug.'<br/>';
        }
    }

    public function run_strip()
    {
        $sql ="SELECT * FROM products ";
        $query = $this->db->query($sql);
        $datalist = $query->result_array();


        foreach ($datalist  as $row) {
            $shot_detail =    strip_tags($row['detail']);

            $data_product = array(
                'shot_detail' => $shot_detail
            );

            $where = "id = '".$row['id']."'";
            $this->db->update("products", $data_product, $where);

            echo $shot_detail.'<br/>';
        }
    }



    public function getstock()
    {
        $value = json_decode(file_get_contents("php://input"));
        $data['stock'] =  $this->products_model->getstock_serial($value->product_id);
        print json_encode($data['stock']);
    }

    public function updateprice()
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {

        // Retrieve the posted information
            $item = $this->input->post('productid_p');
            $check = $this->input->post('check_p');
            $data["update"] = "";
            $in_str ="";

            // Cycle true all items and update them
            for ($i=0;$i < count($item);$i++) {
                if (isset($check[$i])) {
                    date_default_timezone_set("Asia/Bangkok");
                    $data_product = array(
                    'price' =>  $this->input->post('price'),
                    'dis_price' => $this->input->post('dis_price'),
                    'member_discount' => $this->input->post('member_discount'),
                    'member_discount_lv1' => $this->input->post('member_discount_lv1'),
                    'modified_date' => date("Y-m-d H:i:s"),
                );
                    $where = "id = '".$check[$i]."'";

                    $this->db->update("products", $data_product, $where);
                    if ($in_str =="") {
                        $in_str  = $check[$i];
                    } else {
                        $in_str = $in_str.",".$check[$i];
                    }

                    $data["update"] = $data["update"].'<li class="list-group-item"><strong>ProductId</strong> : '.$check[$i].', <strong>price</strong> : '.$this->input->post('price').', <strong>Disprice</strong> : '.$this->input->post('dis_price').', <strong>Dealer_price</strong> : '.$this->input->post('member_discount').', <strong> fanshine</strong> : '.$this->input->post('member_discount_lv1').'</li>';
                }
                //echo $this->input->post('price')." , ".$this->input->post('dis_price')." , ".$this->input->post('member_discount')."<br>";
            //echo $item[$i]." , ".$chk."<br>";
            }

            if ($in_str != "") {
                $data['products_list'] = $this->products_model->get_products_in($in_str);
            }

            $data['brands_list'] = $this->products_model->get_brands();
            $data['type_list'] = $this->products_model->get_type();

            //call script
            $data['script_file']= "js/product_add_js";
            $data['content'] = 'products/products';
            $data["header"] = $this->get_header("products");
            $this->load->view("template/layout_main", $data);
        }
    }

    public function export_stock()
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $all = $this->input->post('all_product');

            if (isset($all) && $all == '1') {
                $sql =" SELECT p.id ,p.sku ,p.name product_name,t.name type_name, b.name brand_name, p.stock ,p.price,
		    				p.dis_price discount_price , p.member_discount dealer_price ,p.member_discount_lv1 fanshine_price, p.is_active
					FROM  products p
					LEFT JOIN product_brand b ON p.product_brand_id = b.id
					LEFT JOIN product_type t ON p.product_type_id = t.id
					ORDER BY p.id DESC ";
                $re = $this->db->query($sql);
                //print($sql);
                $data['products_list'] = $re->result_array();
                $this->load->view('products/export_product', $data);
                print("all");
            } else {
                // Retrieve the posted information
                $item = $this->input->post('productid_p');
                $check = $this->input->post('check_p');
                $in_str ="";

                // Cycle true all items and update them
                for ($i=0;$i < count($item);$i++) {
                    if (isset($check[$i])) {
                        if ($in_str =="") {
                            $in_str  = $check[$i];
                        } else {
                            $in_str = $in_str.",".$check[$i];
                        }
                    }
                }

                if ($in_str != "") {
                    $sql =" SELECT p.id ,p.sku ,p.name product_name,t.name type_name, b.name brand_name, p.stock ,p.price,
			    				p.dis_price discount_price , p.member_discount dealer_price ,p.member_discount_lv1 fanshine_price, p.is_active
						FROM  products p
						LEFT JOIN product_brand b ON p.product_brand_id = b.id
						LEFT JOIN product_type t ON p.product_type_id = t.id
						WHERE p.id in(".$in_str.")
						 ORDER BY p.id DESC ";
                    $re = $this->db->query($sql);
                    //print($sql);
                    $data['products_list'] = $re->result_array();
                    $this->load->view('products/export_product', $data);
                }
            }
        }
    }
}

/* End of file prrducts.php */
/* Location: ./application/controllers/prrducts.php */
