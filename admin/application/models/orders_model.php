
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders_model extends CI_Model
{
    public function get_orders($start, $limit)
    {
        $sql =" SELECT o.* , s.name order_status_name,
				p.bank_name,
				p.`comment`,
				p.member_id,
				p.amount,
				DATE_FORMAT(p.inform_date_time,'%Y-%m-%d') inform_date,
				DATE_FORMAT(p.inform_date_time,'%H:%i') inform_time,
				p.create_date payment_create_date,
        u.`name` user_name
				FROM  orders o
				LEFT JOIN order_status s ON s.id =  o.order_status_id
				LEFT JOIN  members m ON m.id = o.customer_id
				LEFT JOIN payment p ON p.order_id = o.id
        LEFT JOIN tbl_users u ON u.userId = o.userId
        ORDER BY o.date DESC LIMIT " . $start . "," . $limit;
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_orders_count()
    {
        $sql =" SELECT COUNT(id) as connt_id FROM  orders ";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }


    public function get_orders_id($orders_id)
    {
        $sql =" SELECT o.* , s.name order_status_name,
				p.bank_name,
				p.`comment`,
				p.member_id,
				p.amount,
				p.credit_note_id,
				c.docno credit_note_docno,
				DATE_FORMAT(p.inform_date_time,'%Y-%m-%d') inform_date,
				DATE_FORMAT(p.inform_date_time,'%H:%i') inform_time,
				p.create_date payment_create_date,
				c.docno credit_note_docno,
        u.`name` user_name
				FROM  orders o
				LEFT JOIN order_status s ON s.id =  o.order_status_id
				LEFT JOIN  members m ON m.id = o.customer_id
				LEFT JOIN payment p ON p.order_id = o.id
				LEFT JOIN credit_note c ON c.id = p.credit_note_id
        LEFT JOIN tbl_users u ON u.userId = o.userId
			  WHERE o.id = '".$orders_id."'";

        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function get_orders_detail_id($orders_id)
    {
        $sql ="SELECT od.* ,  IFNULL(p.sku,'') sku, IFNULL(p.name,'') product_name , p.slug FROM order_detail od
		LEFT JOIN products p ON od.product_id = p.id WHERE od.order_id = '".$orders_id."'";

        $query = $this->db->query($sql);
        $row = $query->result_array();
        return $row;
    }

    public function get_order_status()
    {
        $sql ="SELECT * FROM order_status";

        $query = $this->db->query($sql);
        $row = $query->result_array();
        return $row;
    }//

    public function get_order_status_history($orders_id)
    {
        $sql =" SELECT oh.* , os.name order_status_name
				from order_status_history  oh
				LEFT JOIN order_status os ON oh.order_status_id = os.id
				where oh.order_id ='".$orders_id."' ORDER BY oh.create_date DESC";

        $query = $this->db->query($sql);
        $row = $query->result_array();
        return $row;
    }

    public function update_address($orders_id)
    {
        $data_order = array(
            'address' => $this->input->post('address'),
            'shipping' =>$this->input->post('shipping'),
            'email'=> $this->input->post('email'),
            'tel'=> $this->input->post('tel'),
        );

        $where = "id = '".$orders_id."'";
        $this->db->update("orders", $data_order, $where);


        $is_tax = $this->input->post('is_tax');
        if (isset($is_tax) && $is_tax == "1") {
            $data_order = array(
            'is_tax' => $this->input->post('is_tax'),
            'tax_address' => $this->input->post('tax_address'),
            'tax_id' =>$this->input->post('tax_id'),
            'tax_company'=> $this->input->post('tax_company')
            );

            $where = "id = '".$orders_id."'";
            $this->db->update("orders", $data_order, $where);
        } else {
            $data_order = array(
            'is_tax' => 0,
            );
            $where = "id = '".$orders_id."'";
            $this->db->update("orders", $data_order, $where);
        }

        if (isset($is_tax) && $is_tax == "1") {
            $sql = " UPDATE orders set vat = cast( (((total-shipping_charge) *7) /107) as decimal(11,4))  WHERE  id = ". $this->db->escape($orders_id);
            $this->db->query($sql);
            $sql = " UPDATE order_detail set vat = cast( (((total) *7) /107) as decimal(11,4))  WHERE order_id  = ".$this->db->escape($orders_id);
            $this->db->query($sql);
        } else {
            $sql = " UPDATE orders set vat = 0  WHERE  id = ". $this->db->escape($orders_id);
            $this->db->query($sql);
            $sql = "UPDATE order_detail set vat = 0  WHERE order_id  = ".$this->db->escape($orders_id);
            $this->db->query($sql);
        }
    }


    public function update_status($orders_id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_order_status = array(
            'order_status_id' => $this->input->post('select_status'),
            'description' => $this->input->post('description'),
            'order_id' => $orders_id,
            'create_date' => date("Y-m-d H:i:s"),
        );
        $this->db->insert("order_status_history", $data_order_status);


        $data_order = array(
            'order_status_id' => $this->input->post('select_status')
        );

        $where = "id = '".$orders_id."'";
        $this->db->update("orders", $data_order, $where);



        if ($this->input->post('select_status')== "2") {
            // remove stock

            $rows = $this->get_orders_detail_id($orders_id);
            foreach ($rows as $row) {
                $sql =" SELECT COUNT(product_id) as connt_id FROM  stock WHERE product_id ='".$row['product_id']."' AND order_id ='".$orders_id."'";

                $query = $this->db->query($sql);
                $r = $query->row_array();
                if ($r['connt_id']==0) {
                    $data_stock = array(
                        'product_id' =>  $row['product_id'],
                        'order_id' => $orders_id,
                        'number'=> $row['quantity']
                    );
                    $this->db->insert("stock", $data_stock);

                    //update product
                    $sql_update ="UPDATE products SET stock = stock-".$row['quantity']." WHERE id =".$row['product_id']." ";
                    $this->db->query($sql_update);
                }
            }
        }

        if ($this->input->post('select_status')== "6") {
            $rows = $this->get_orders_detail_id($orders_id);
            foreach ($rows as $row) {
                $sql =" SELECT COUNT(product_id) as connt_id FROM  stock WHERE product_id ='".$row['product_id']."' AND order_id ='".$orders_id."'";

                $query = $this->db->query($sql);
                $r = $query->row_array();
                if ($r['connt_id']>0) {
                    $data_stock = array(
                        'product_id' =>  $row['product_id'],
                        'order_id' => $orders_id,
                        'number'=> $row['quantity']
                    );
                    $this->db->delete("stock", $data_stock);

                    //update product
                    $sql_update ="UPDATE products SET stock = stock+".$row['quantity']." WHERE id =".$row['product_id']." ";
                    $this->db->query($sql_update);
                }
            }
        }
    }

    public function update_tracking($orders_id)
    {
        $data_order = array(
            'trackpost' => $this->input->post('tracking')
        );

        $where = "id = '".$orders_id."'";
        $this->db->update("orders", $data_order, $where);
    }



    public function get_orders_search()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_orders = array(
            'search' => $this->input->post('search'),
            'order_id' => $this->input->post('order_id')
        );

        $sql ="

		SELECT o.* , s.name order_status_name,
				p.bank_name,
				p.`comment`,
				p.member_id,
				p.amount,
				DATE_FORMAT(p.inform_date_time,'%Y-%m-%d') inform_date,
				DATE_FORMAT(p.inform_date_time,'%H:%i') inform_time,
				p.create_date payment_create_date,
				sh.create_date status_modified_date,
        u.`name` user_name
				FROM  orders o
				LEFT JOIN order_status s ON s.id =  o.order_status_id
				LEFT JOIN  members m ON m.id = o.customer_id
				LEFT JOIN payment p ON p.order_id = o.id
        LEFT JOIN tbl_users u ON u.userId = o.userId
				LEFT JOIN order_status_history sh ON sh.order_id = o.id AND sh.create_date =

        		(
						SELECT MAX(create_date)
						FROM order_status_history AS b
						WHERE b.order_id = o.id
				)

				WHERE  1=1";

        if ($data_orders['order_id'] !="") {
            $sql = $sql." AND o.id ='".$data_orders['order_id']."'";
        }

        if ($this->input->post('select_status') !="0") {
            $sql = $sql." AND s.id ='".$this->input->post('select_status')."'";
        }

        $sql = $sql." AND (o.name LIKE '%".$data_orders['search']."%'
								 OR  o.id LIKE '%".$data_orders['search']."%'
								 OR  o.trackpost LIKE '%".$data_orders['search']."%')

								 ORDER BY sh.create_date DESC , o.date DESC
								 ";



        $re = $this->db->query($sql);
        $return_data['result_orders'] = $re->result_array();
        $return_data['data_search'] = $data_orders;
        $return_data['sql'] = $sql;
        return $return_data;
    }


    public function get_product_serial($product_id, $receive_id)
    {
        $sql =" SELECT ps.* , p.`name` product_name ,p.sku FROM product_serial ps INNER JOIN products p ON p.id = ps.product_id
				where ps.product_id = '".$product_id."'
				AND ps.order_id = '".$receive_id."'
				AND ps.is_active = 1
		        ORDER BY ps.line_number ;";
        $re = $this->db->query($sql);
        return $re->result_array();
    }




    public function update_img($order_id, $image_name, $feild)
    {
        $data_product = array(
            $feild => $image_name,
        );

        $where = "id = '".$order_id."'";
        $this->db->update('orders', $data_product, $where);
    }


    public function update_invoice($po_orders_id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_order = array(
            'is_invoice' => $this->input->post('is_invoice'),
            'invoice_date' => date("Y-m-d H:i:s"),
            'invoice_docno' => 'IN'.date("ym").str_pad($po_orders_id, 4, "0", STR_PAD_LEFT)
        );

        $where = array('id' => $po_orders_id);
        $this->db->update("orders", $data_order, $where);
        $this->reset_order($po_orders_id);
    }

    public function get_search_credit_note($search_txt)
    {
        $sql =" SELECT cn.order_id,
				cn.id credit_note_id,
				cn.docno credit_note_docno,
				o.invoice_docno invoice_no,
				cn.create_date create_date,
				cn.serial serial_number,
				p.id product_id,
				p.name product_name,
				p.sku,
				(SELECT COUNT(credit_note_id) FROM payment WHERE is_active = 1 AND credit_note_id = cn.id) is_payment
				FROM credit_note cn
				INNER JOIN orders o ON o.id = cn.order_id
				INNER JOIN products p on p.id = cn.product_id

				WHERE cn.id  LIKE '%".$search_txt."%'
					OR o.`name`  LIKE '%".$search_txt."%'
					OR p.`name`  LIKE '%".$search_txt."%'
					OR o.`address`  LIKE '%".$search_txt."%'
					OR o.`email`  LIKE '%".$search_txt."%'
					OR o.`tel`  LIKE '%".$search_txt."%'
					OR o.`invoice_docno`  LIKE '%".$search_txt."%'
					OR p.`id`  LIKE '%".$search_txt."%'
					OR cn.serial  LIKE '%".$search_txt."%'
					OR p.`sku`  LIKE '%".$search_txt."%'
			";
        $re = $this->db->query($sql);
        $return_data = $re->result_array();
        return $return_data;
    }
}

/* End of file orders_model.php */
/* Location: ./application/models/orders_model.php */
