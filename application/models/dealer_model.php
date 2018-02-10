<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dealer_model extends CI_Model {

	
	public function get_orderList($username)
	{

	    $sql =" SELECT d.* FROM orders  d 
				INNER JOIN members m ON m.id = customer_id  
				WHERE m.username ='".$username."' ORDER BY d.date DESC ";
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_po_orderList($username)
	{

	    $sql =" SELECT d.* FROM po_orders  d 
				INNER JOIN members m ON m.id = customer_id  
				WHERE m.username ='".$username."' ORDER BY d.date DESC ";
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_dealerInfo($username)
	{
	    $sql =" SELECT * FROM members WHERE username ='".$username."' ";
		$re = $this->db->query($sql);
		return $re->row_array();
	}

}

/* End of file dealer_model.php */
/* Location: ./application/models/dealer_model.php */