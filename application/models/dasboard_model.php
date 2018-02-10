<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dasboard_model extends CI_Model {

	public function get_order_status()
	{

	    $sql =" SELECT o.is_reservations ,os.name ,COUNT(os.name) count FROM orders o 
				INNER JOIN order_status os ON o.order_status_id = os.id
				WHERE os.id != 4
				GROUP BY o.is_reservations, os.name ";
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




}

/* End of file dasboard_model.php */
/* Location: ./application/models/dasboard_model.php */