
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Members_model extends CI_Model
{
    public function get_members($start, $limit)
    {
        $sql =" SELECT *  FROM  members p  ORDER BY p.id DESC LIMIT " . $start . "," . $limit;
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_members_count()
    {
        $sql =" SELECT COUNT(id) as connt_id FROM  members p";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }


    public function get_member($member_id)
    {
        $sql ="SELECT * FROM members WHERE id = '".$member_id."'";

        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }


    public function get_members_search()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_members = array(
            'search' => $this->input->post('search')
        );

        $sql ="SELECT * FROM members WHERE first_name LIKE '%".$data_members['search']."%'
		OR  last_name LIKE '%".$data_members['search']."%'
		OR  address_receipt LIKE '%".$data_members['search']."%'
		OR  email LIKE '%".$data_members['search']."%' ";

        $re = $this->db->query($sql);
        $return_data['result_members'] = $re->result_array();
        $return_data['data_search'] = $data_members;
        $return_data['sql'] = $sql;
        return $return_data;
    }

    public function update_member($member_id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_member = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'company' => $this->input->post('company'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'email' => $this->input->post('email'),
            'tel' => $this->input->post('tel'),
            'mobile' => $this->input->post('mobile'),
            'tax_number' => $this->input->post('tax_number'),
            'address_receipt' => $this->input->post('address_receipt'),
            'address_tax' => $this->input->post('address_tax'),
            'verify' => $this->input->post('verify'),
            'is_lavel1' => $this->input->post('is_lavel1'),
            );
        $where = "id = '".$member_id."'";
        $this->db->update("members", $data_member, $where);
    }
}

/* End of file member_model.php */
/* Location: ./application/models/member_model.php */
