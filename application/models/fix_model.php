<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fix_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('Initdata_model');
	}

	public function get_fix( $start, $limit)
	{

	    $sql =" SELECT * FROM fix  WHERE is_active = 1 ORDER BY orderby , modified_date LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}
	public function get_fix_count()
	{

		$sql =" SELECT COUNT(p.id) as connt_id FROM  fix p 
				WHERE p.is_active  = 1 "; 
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];
	
	}

	public function whereSqlConcat($keyArray)
	{
		$countKey = count($keyArray);
		$sqlString=" SELECT pc.search , p.* 
					FROM fix p 
					INNER JOIN (
					SELECT CONCAT(IFNULL(name,''), IFNULL(description,'')) search ,id FROM fix
					)
					pc ON p.id = pc.id 
					 WHERE  p.is_active= '1'  AND";
		if($countKey >1){
			$checkLine = 0;
			$sqlString = $sqlString." ( ";
		
			foreach ($keyArray as $key) {
				$checkLine++;
				if($checkLine != $countKey)
				{
					$sqlString  = $sqlString." pc.search like UPPER('%" . $key . "%') AND ";
				}
				
				else {
					$sqlString  = $sqlString." pc.search like UPPER('%" . $key . "%')";
				}
			}
			$sqlString = $sqlString." ) ";
		}
		 
		return $sqlString;
	}


	public function get_fix_search_count($sql)
	{
		$query = $this->db->query($sql);
		return  $rowcount = $query->num_rows();
	}


	public function get_fix_search( $sql, $start, $limit)
	{
	    $sql = $sql." LIMIT ". $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();
	}

}

/* End of file fix_model.php */
/* Location: ./application/models/fix_model.php */