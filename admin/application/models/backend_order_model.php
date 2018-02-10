<?php
defined('BASEPATH') or exit('No direct script access allowed');
class backend_order_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_products_serach_count($searchText = '')
    {
        $searchText = $this->db->escape_like_str($searchText);
        $sqlString = "";
        $data   = preg_split('/\s+/', $searchText);

        $sqlString = $sqlString.$this->whereSqlConcat_count($data);
        $countSql = count($data);

        $sql   ="";
        if ($countSql < 2) {
            $sql   = "SELECT COUNT(p.id) as connt_id FROM products p
					INNER JOIN ( SELECT CONCAT(IFNULL(name,''), IFNULL(model,''), IFNULL(shot_detail,''), IFNULL(sku,'')) search , id FROM products )
					pc ON p.id = pc.id LEFT JOIN product_brand b ON p.product_brand_id = b.id
					LEFT JOIN (SELECT product_id, SUM(number) stock_all FROM stock GROUP BY product_id) s ON s.product_id = p.id
					LEFT JOIN product_type t ON p.product_type_id = t.id
					WHERE  p.is_active = '1' AND t.is_active = '1' AND  pc.search like UPPER('%".$searchText."%')";
        } else {
            $sql  = $sqlString ;
        }
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }

    public function get_products_serach($searchText = '', $start, $limit)
    {
        // $this->db->escape() ใส่ '' ให้
        // $this->db->escape_str()  ไม่ใส่ '' ให้
        // $this->db->escape_like_str($searchText) like
        $searchText = $this->db->escape_like_str($searchText);
        $sqlString = "";
        $data   = preg_split('/\s+/', $searchText);

        $sqlString = $sqlString.$this->whereSqlConcat($data);
        $countSql = count($data);

        $sql   ="";
        if ($countSql < 2) {
            $sql   = "SELECT pc.search , p.* ,t.name type_name, b.name brand_name , s.stock_all FROM products p
						INNER JOIN ( SELECT CONCAT(IFNULL(name,''), IFNULL(model,''), IFNULL(shot_detail,''), IFNULL(sku,'')) search , id FROM products )
						pc ON p.id = pc.id LEFT JOIN product_brand b ON p.product_brand_id = b.id
						LEFT JOIN (SELECT product_id, SUM(number) stock_all FROM stock GROUP BY product_id) s ON s.product_id = p.id
						LEFT JOIN product_type t ON p.product_type_id = t.id
						WHERE  p.is_active = '1' AND t.is_active = '1' AND  pc.search like UPPER('%".$searchText."%') LIMIT ". $this->db->escape_str($start).",". $this->db->escape_str($limit);
        } else {
            $sql  = $sqlString ."LIMIT ". $this->db->escape_str($start).",". $this->db->escape_str($limit);
        }

        //$data['product_list'] = $this->products_model->get_products_search($sql, $page, 10000000);
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function whereSqlConcat_count($keyArray)
    {
        $countKey = count($keyArray);
        $sqlString=" SELECT COUNT(p.id) as connt_id
						FROM products p
						INNER JOIN (
						SELECT CONCAT(IFNULL(name,''), IFNULL(model,''), IFNULL(detail,''), IFNULL(sku,'')) search ,id FROM products
						)
						pc ON p.id = pc.id
						LEFT JOIN product_brand b ON p.product_brand_id = b.id
						LEFT JOIN product_type t ON p.product_type_id = t.id  WHERE  p.is_active= '1' AND  t.is_active = '1' AND";
        if ($countKey >1) {
            $checkLine = 0;
            $sqlString = $sqlString." ( ";

            foreach ($keyArray as $key) {
                $checkLine++;
                if ($checkLine != $countKey) {
                    $sqlString  = $sqlString." pc.search like UPPER('%" . $key . "%') AND ";
                } else {
                    $sqlString  = $sqlString." pc.search like UPPER('%" . $key . "%')";
                }
            }
            $sqlString = $sqlString." ) ";
        }

        return $sqlString;
    }

    public function whereSqlConcat($keyArray)
    {
        $countKey = count($keyArray);
        $sqlString=" SELECT pc.search , p.* ,t.name type_name, b.name brand_name, t.id type_id, b.id brand_id
						FROM products p
						INNER JOIN (
						SELECT CONCAT(IFNULL(name,''), IFNULL(model,''), IFNULL(detail,''), IFNULL(sku,'')) search ,id FROM products
						)
						pc ON p.id = pc.id
						LEFT JOIN product_brand b ON p.product_brand_id = b.id
						LEFT JOIN product_type t ON p.product_type_id = t.id  WHERE  p.is_active= '1' AND  t.is_active = '1' AND";
        if ($countKey >1) {
            $checkLine = 0;
            $sqlString = $sqlString." ( ";

            foreach ($keyArray as $key) {
                $checkLine++;
                if ($checkLine != $countKey) {
                    $sqlString  = $sqlString." pc.search like UPPER('%" . $key . "%') AND ";
                } else {
                    $sqlString  = $sqlString." pc.search like UPPER('%" . $key . "%')";
                }
            }
            $sqlString = $sqlString." ) ";
        }

        return $sqlString;
    }

    public function get_cart_data()
    {
        $productResult = array();
        foreach ($this->cart->contents() as $items) {
            $sql   = "SELECT p.* ,t.name type_name, b.name brand_name
									FROM  products p
									LEFT JOIN product_brand b ON p.product_brand_id = b.id
									LEFT JOIN product_type t ON p.product_type_id = t.id  WHERE
									p.is_active = 1 AND p.id = '" . $items['id'] . "'";
            $query = $this->db->query($sql);
            $row   = $query->row_array();
            if (isset($row['id'])) {
                $price  = $row["price"];
                $dis_price  = $row["dis_price"];
                $image_url = "";
                if ($row['image'] != "") {
                    $image_url = $this->config->item('url_img') . $row['image'];
                } else {
                    $image_url = $this->config->item('no_url_img');
                }
                $productResult[] = array(
                                            'id' => $items['id'],
                                            'sku' => $row['sku'],
                                            'slug' => $row['slug'],
                                            'name' => $row['name'],
                                            'img' => $image_url,
                                            'price' => $price,
                                            'qty' => $items['qty'],
                                            'rowid' => $items['rowid'],
                                            'model' => $row['model'],
                                            'brand' => $row['brand_name'],
                                            'is_reservations' => $items['is_reservations'],
                                            'type' => $row['type_name']
                                    );
            }
        }

        return $productResult;
    }


    public function add_product($id)
    {
        $sql   = "SELECT * FROM products WHERE is_active = 1  AND id = ".$this->db->escape($id);
        $query = $this->db->query($sql);
        $row   = $query->row_array();
        if (isset($row['id'])) {
            $price  = $row["price"];
            $dis_price  = $row["dis_price"];
            $data = array(
                                    array(
                                            'id' => $row['id'],
                                            'sku' => $row['id'],
                                            'qty' => 1,
                                            'price' => round($price),
                                            'is_reservations' => 0,
                                            'name' => $row['id']
                                    )
                            );
            $this->cart->insert($data);
            return true;
        } else {
            return false;
        }
    }

    // Updated the shopping cart
    public function validate_update_cart()
    {
        // Get the total number of items in cart
        $total = $this->cart->total_items();

        // Retrieve the posted information
        $item = $this->input->post('rowid');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');
        $product_id = $this->input->post('product_id');
        $return_str ="";

        // Cycle true all items and update them
        for ($i=0;$i < count($product_id);$i++) {
            // Create an array with the products rowid's and quantities.
            $data = array(
                           'rowid' => $item[$i],
                           'qty'   => $qty[$i],
                           'price'  => (int)$price[$i],
                      );
            // Update the cart with the new information
            $this->cart->update($data);
            // $data = array(
            //               'id' => $product_id[$i],
            //               'sku' => $product_id[$i],
            //               'qty' => $qty[$i],
            //               'price' =>$price[$i],
            //               'is_reservations' => 0,
            //               'name' => $product_id[$i]
            //
            //         );
            // $this->cart->insert($data);

        }
    }
}
