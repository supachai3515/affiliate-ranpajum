<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model {
	
	private $table_name = 'account';
	private $pk = 'username';
	
	public function validasi()
	{
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get($this->table_name);
		
		if($query->num_rows() == 1)
		{
			return true;
		}		
	}
	
	public function buat_akun()
	{
		$data_baru = array(
			'first_name' => $this->input->post('fname'),
			'last_name' => $this->input->post('lname'),
			'email_address' => $this->input->post('email'),			
			'username' => $this->input->post('uname'),
			'password' => md5($this->input->post('pass'))						
		);
		
		$simpan_data = $this->db->insert($this->table_name, $data_baru);
		return $simpan_data;
	}
	
	public function lihat_data($username){
		$query = $this->db->get_where($this->table_name, array($this->pk => $username));
		return $query->row_array();
	}

	public function get_account( $start, $limit)
	{

	    $sql =" SELECT p.*  FROM  account p ORDER BY p.id DESC  LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_account_count()
	{
		$sql =" SELECT COUNT(id) as connt_id FROM  account p"; 
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];
	
	}


	public function get_account_id($account_id)
	{
		$sql ="SELECT * FROM account WHERE id = '".$account_id."'"; 

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}


	public function update_account($account_id)
	{
		

		date_default_timezone_set("Asia/Bangkok");
		$data_account = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email_address' => $this->input->post('email_address'),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
			'permission_id' => $this->input->post('permission_id')					
		);
		$where = "id = '".$account_id."'"; 
		$this->db->update("account", $data_account, $where);

	}

	public function save_account()
	{
		$query = $this->db->query(" SELECT COUNT(username) as connt_id FROM  account WHERE username ='".$this->input->post('username')."' ");
			$row = $query->row_array();
			if($row['connt_id']==1)
			{
				return  "Error";
			}
			else {

			$data_account = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email_address' => $this->input->post('email_address'),
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'permission_id' => $this->input->post('permission_id')
								
			);
			
			$this->db->insert("account", $data_account);
			$insert_id = $this->db->insert_id();
	   		return  $insert_id;
	   	}

	}

	public function get_user($username){
		$sql ="SELECT * FROM account WHERE username = '".$username."'"; 

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	
}
/* End of file account_model.php */
/* Location: ./application/models/account_model.php */