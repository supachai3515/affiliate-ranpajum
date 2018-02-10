
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Return_type_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Initdata_model');
    }

    public function get_return_type($start, $limit)
    {
        $sql =" SELECT p.*  FROM  return_type p  ORDER BY p.id DESC  LIMIT " . $start . "," . $limit;
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_return_type_count()
    {
        $sql =" SELECT COUNT(id) as connt_id FROM  return_type p";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }


    public function get_return_type_id($return_type_id)
    {
        $sql ="SELECT * FROM return_type WHERE id = '".$return_type_id."'";

        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }


    public function get_return_type_search()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_return_type = array(
            'search' => $this->input->post('search')
        );

        $sql ="SELECT * FROM return_type WHERE name LIKE '%".$data_return_type['search']."%' OR  description LIKE '%".$data_return_type['search']."%' ";
        $re = $this->db->query($sql);
        $return_data['result_return_type'] = $re->result_array();
        $return_data['data_search'] = $data_return_type;
        $return_data['sql'] = $sql;
        return $return_data;
    }

    public function update_return_type($return_type_id)
    {
        $slug = $slug =$this->input->post('slug');
        if ($this->input->post('slug') == "") {
            $slug =$this->input->post('name');
        }


        date_default_timezone_set("Asia/Bangkok");
        $data_return_type = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'modified_date' => date("Y-m-d H:i:s"),
            'is_active' => $this->input->post('isactive')
        );
        $where = "id = '".$return_type_id."'";
        $this->db->update("return_type", $data_return_type, $where);
    }

    public function save_return_type()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_return_type = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'create_date' => date("Y-m-d H:i:s"),
            'modified_date' => date("Y-m-d H:i:s"),
            'is_active' => $this->input->post('isactive')
        );

        $this->db->insert("return_type", $data_return_type);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }


}

/* End of file return_type_model.php */
/* Location: ./application/models/return_type_model.php */
