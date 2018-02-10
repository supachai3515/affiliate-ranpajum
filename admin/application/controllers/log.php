<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}

	//page view
	public function index()
	{
		if($this->input->get('has')=="5e6092a7c5f49c56bbe576f881b8d670") {
			$passData = array(
           "name" => "supachai",
           "email" => "email",
           "password" => "password"
        );
		$url = base_url().'log/test_post';
		//echo '<br><hr><h2>'.$this->postCURL($url, $passData).'</h2><br><hr><br>';
		//echo $this->save_log($date_start,$product_count,$error_message);
		
		$re_json = json_decode($this->postCURL($url, $passData), true);
		$date_start= date("Y-m-d H:i:s");
		// for products insert
		$product_count= "2";
		$error_message= $re_json['name'];
		//save log
		$this->save_log($date_start,$product_count,$error_message);
		}
	}
	
	public function postCURL($_url, $_param){

        $postData = '';
        //create name value pairs seperated by &
        foreach($_param as $k => $v) 
        { 
          $postData .= $k . '='.$v.'&'; 
        }
        rtrim($postData, '&');


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, false); 
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    

        $output=curl_exec($ch);

        curl_close($ch);

        return $output;
    }
	
	public function test_post(){
		$data["name"] = $this->input->post('name');
		$data["email"] = $this->input->post('email');
		$data["password"] = $this->input->post('password');
		echo json_encode($data);
	}
	
	public function save_log($date_start,$product_count,$error_message)
	{
		//delete log date -7
		$sql =" DELETE  FROM log  WHERE DATE(date_start) < (NOW() - INTERVAL 7 DAY) ORDER BY date_start desc";
		$this->db->query($sql);

		date_default_timezone_set("Asia/Bangkok");
		$data_log = array(
			'date_start' => $date_start,
			'date_end' => date("Y-m-d H:i:s"),
			'product_count' => $product_count,  
			'is_error' => "0",
			'error_message' => $error_message,				
		);
		
		$this->db->insert("log", $data_log);
		$insert_id = $this->db->insert_id();
   		return  $insert_id;

	}

}

/* End of file prrducts.php */
/* Location: ./application/controllers/prrducts.php */
