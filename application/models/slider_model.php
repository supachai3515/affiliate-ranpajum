
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class slider_model extends CI_Model {


	public function get_slider( $start, $limit)
	{

	    $sql =" SELECT *  FROM  slider p  ORDER BY p.id  LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_slider_count()
	{
		$sql =" SELECT COUNT(id) as connt_id FROM  slider p"; 
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];
	
	}


	public function get_slider_id($slider_id)
	{
		$sql ="SELECT * FROM slider WHERE id = '".$slider_id."'"; 

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}


	public function update_slider($slider_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_slider = array(
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
			'description1' => $this->input->post('description1'),
			'name_link' => $this->input->post('name_link'),
			'image' => $this->input->post('image'),
			'link' => $this->input->post('link'),
			'modified_date' => date("Y-m-d H:i:s"),
			'is_active' => $this->input->post('isactive')						
		);
		$where = "id = '".$slider_id."'"; 
		$this->db->update("slider", $data_slider, $where);

	}

}

/* End of file slider_model.php */
/* Location: ./application/models/slider_model.php */