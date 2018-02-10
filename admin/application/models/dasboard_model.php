<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dasboard_model extends CI_Model
{
    public function get_order_status()
    {
        $sql =" SELECT os.name ,COUNT(os.name) count FROM orders o
				INNER JOIN order_status os ON o.order_status_id = os.id
				WHERE os.id != 4
				GROUP BY  os.name ";
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_orders()
    {
        $sql =" SELECT o.* ,os.name status_name FROM orders o
				INNER JOIN order_status os ON o.order_status_id = os.id
				ORDER BY o.date DESC LIMIT 0, 10";
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_orders_today()
    {
        $sql ="	SELECT COUNT(*) count, SUM(total) total  FROM orders
				WHERE DATE(date) = CURDATE()";
        $re = $this->db->query($sql);
        return $re->row_array();
    }

    //po_order
    public function get_po_order_status()
    {
        $sql =" SELECT os.name ,COUNT(os.name) count FROM po_orders o
				INNER JOIN po_order_status os ON o.po_order_status_id = os.id
				WHERE os.id != 4
				GROUP BY  os.name ";
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_po_orders()
    {
        $sql =" SELECT o.* ,os.name status_name FROM po_orders o
				INNER JOIN po_order_status os ON o.po_order_status_id = os.id
				order BY o.date DESC LIMIT 0, 10";
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_po_orders_today()
    {
        $sql ="	SELECT COUNT(*) count, SUM(total) total  FROM po_orders
				WHERE DATE(date) = CURDATE()";
        $re = $this->db->query($sql);
        return $re->row_array();
    }
}

/* End of file dasboard_model.php */
/* Location: ./application/models/dasboard_model.php */
