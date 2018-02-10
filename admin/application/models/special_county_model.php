
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class special_county_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('Initdata_model');
	}

	public function get_special_county( $start, $limit)
	{

	    $sql =" SELECT p.*  , s.name shipping_method_name ,a.amphur_name , v.province_id , v.province_name
				FROM  special_county p 
				INNER JOIN  shipping_method s  on p.shipping_method_id = s.id
				INNER JOIN amphur a ON a.amphur_id = p.amphur_id
				INNER JOIN province v ON v.province_id = a.province_id ORDER BY p.shipping_method_id DESC  LIMIT " . $start . "," . $limit;
						$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_special_county_count()
	{
		$sql =" SELECT COUNT(shipping_method_id) as connt_id FROM  special_county p"; 
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];
	
	}


	public function get_special_county_id($amphur_id,$shipping_method_id)
	{
		$sql ="SELECT p.*  , s.name shipping_method_name ,a.amphur_name , v.province_id , v.province_name
				FROM  special_county p 
				INNER JOIN  shipping_method s  on p.shipping_method_id = s.id
				INNER JOIN amphur a ON a.amphur_id = p.amphur_id
				INNER JOIN province v ON v.province_id = a.province_id  WHERE a.amphur_id = '".$amphur_id."' AND p.shipping_method_id ='".$shipping_method_id."' "; 

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}


    public function get_special_county_search()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_special_county = array(
			'search' => $this->input->post('search')		
		);

		$sql ="SELECT p.*  , s.name shipping_method_name ,a.amphur_name , v.province_id , v.province_name
				FROM  special_county p 
				INNER JOIN  shipping_method s  on p.shipping_method_id = s.id
				INNER JOIN amphur a ON a.amphur_id = p.amphur_id
				INNER JOIN province v ON v.province_id = a.province_id  WHERE s.name LIKE '%".$data_special_county['search']."%'";
		$re = $this->db->query($sql);
		$return_data['result_special_county'] = $re->result_array();
		$return_data['data_search'] = $data_special_county;
		$return_data['sql'] = $sql;
		return $return_data;
	}

	public function update_special_county($amphur_id,$shipping_method_id)
	{
		
		date_default_timezone_set("Asia/Bangkok");
		$data_special_county = array(
			'shipping_method_id'=> $this->input->post('shipping_method_id'),
			'amphur_id'=> $this->input->post('amphur_id'),
			'price'=> $this->input->post('price'),
			'description'=> $this->input->post('description'),
			'modified_date' => date("Y-m-d H:i:s"),
			'is_active' => $this->input->post('isactive')						
		);
		$where = "amphur_id = '".$amphur_id."' AND shipping_method_id = '".$shipping_method_id."' "; 
		$this->db->update("special_county", $data_special_county, $where);

	}

	public  function delete_special_county($amphur_id,$shipping_method_id){

		$sql ="DELETE FROM special_county WHERE amphur_id ='".$amphur_id."' AND  shipping_method_id='".$shipping_method_id."'";
		$query = $this->db->query($sql);
	}

	public function save_special_county()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_special_county = array(
			'shipping_method_id'=> $this->input->post('shipping_method_id'),
			'amphur_id'=> $this->input->post('amphur_id'),
			'price'=> $this->input->post('price'),
			'description'=> $this->input->post('description'),
			'create_date' => date("Y-m-d H:i:s"),
			'modified_date' => date("Y-m-d H:i:s"),
			'is_active' => $this->input->post('isactive')						
		);
		
		$this->db->insert("special_county", $data_special_county);
		$insert_id = $this->db->insert_id();
   		return  $insert_id;

	}


}

/* End of file special_county_model.php */
/* Location: ./application/models/special_county_model.php */