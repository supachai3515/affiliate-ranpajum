
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sale_orders_model extends CI_Model
{

    // $this->db->escape() ใส่ '' ให้
    // $this->db->escape_str()  ไม่ใส่ '' ให้
    // $this->db->escape_like_str($searchText) like
    public function get_sale_orders($userId, $start, $limit)
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
        WHERE o.userId = ".$this->db->escape($userId)."
        ORDER BY o.date DESC LIMIT " . $start . "," . $limit;
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_sale_orders_count($userId)
    {
        $sql =" SELECT COUNT(id) as connt_id FROM  orders  WHERE userId = ".$this->db->escape($userId)."";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }

    public function get_orders_search($userId)
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_orders = array(
            'search' => $this->input->post('search'),
            'order_id' => $this->input->post('order_id')
        );

        $sql =" SELECT o.* , s.name order_status_name,
        				p.bank_name,
        				p.`comment`,
        				p.member_id,
        				p.amount,
        				DATE_FORMAT(p.inform_date_time,'%Y-%m-%d') inform_date,
        				DATE_FORMAT(p.inform_date_time,'%H:%i') inform_time,
        				p.create_date payment_create_date,
        				sh.create_date status_modified_date ,
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

        				WHERE  o.userId = ".$this->db->escape($userId)." ";

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


}

/* End of file orders_model.php */
/* Location: ./application/models/orders_model.php */
