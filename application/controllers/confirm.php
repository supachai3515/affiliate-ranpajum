<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirm extends CI_Controller {

	public function index()
	{
		if($this->input->get("ref_id")  != null){
	
				$sql =" SELECT o.id , r.wating_date FROM  orders o INNER JOIN order_reservations r 
				WHERE o.ref_id ='".$this->input->get("ref_id")."' ";
				$re = $this->db->query($sql);
				$row_order =  $re->row_array();


				if(isset($row_order['id'])){
					date_default_timezone_set("Asia/Bangkok");
					 $sql =" UPDATE order_reservations SET is_confirm='1' , start_date = NOW() ,
					 	expirtdate = NOW()  + INTERVAL ".$row_order['wating_date']." DAY
					  WHERE order_id ='".$row_order['id']."' ";
					  $this->db->query($sql);

					redirect('status/'.$this->input->get("ref_id"),'refresh');

				}
				else{
					redirect('products');


				}
			 
		}
		else{
			print("fail");
		}
		
	}

}

/* End of file confirm.php */
/* Location: ./application/controllers/confirm.php */