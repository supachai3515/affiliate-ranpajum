
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documents_model extends CI_Model {


	public function get_documents( $start, $limit)
	{

	    $sql =" SELECT *  FROM  documents p  ORDER BY p.id DESC LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_documents_count()
	{
		$sql =" SELECT COUNT(id) as connt_id FROM  documents p"; 
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];
	
	}


	public function get_document($document_id)
	{
		$sql ="SELECT * FROM documents WHERE id = '".$document_id."'"; 

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}


    public function get_documents_search()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_documents = array(
			'search' => $this->input->post('search')		
		);

		$sql ="SELECT * FROM documents WHERE name LIKE '%".$data_documents['search']."%' OR  description LIKE '%".$data_documents['search']."%' ";
		$re = $this->db->query($sql);
		$return_data['result_documents'] = $re->result_array();
		$return_data['data_search'] = $data_documents;
		$return_data['sql'] = $sql;
		return $return_data;
	}

	public function save_document()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_document = array(
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
			'type_name' => $this->input->post('type_name'),  
			'link_1' => $this->input->post('link_1'),
			'link_2' => $this->input->post('link_2'),
			'create_date' => date("Y-m-d H:i:s"),
			'modified_date' => date("Y-m-d H:i:s"),
			'is_active' => $this->input->post('isactive')						
		);
		
		$this->db->insert("documents", $data_document);
		$insert_id = $this->db->insert_id();
   		return  $insert_id;

	}


	public function update_document($document_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_document = array(
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
			'type_name' => $this->input->post('type_name'),  
			'link_1' => $this->input->post('link_1'),
			'link_2' => $this->input->post('link_2'),
			'modified_date' => date("Y-m-d H:i:s"),
			'is_active' => $this->input->post('isactive')					
		);
		$where = "id = '".$document_id."'"; 
		$this->db->update("documents", $data_document, $where);

	}

}

/* End of file document_model.php */
/* Location: ./application/models/document_model.php */