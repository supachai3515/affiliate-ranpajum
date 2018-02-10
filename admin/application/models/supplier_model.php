
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Initdata_model');
    }

    public function get_supplier($start, $limit)
    {
        $sql =" SELECT p.*  FROM  supplier p  ORDER BY p.id DESC  LIMIT " . $start . "," . $limit;
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_supplier_count()
    {
        $sql =" SELECT COUNT(id) as connt_id FROM  supplier p";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }


    public function get_supplier_id($supplier_id)
    {
        $sql ="SELECT * FROM supplier WHERE id = '".$supplier_id."'";

        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }


    public function get_supplier_search()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_supplier = array(
            'search' => $this->input->post('search')
        );

        $sql ="SELECT * FROM supplier WHERE name LIKE '%".$data_supplier['search']."%' OR  description LIKE '%".$data_supplier['search']."%' ";
        $re = $this->db->query($sql);
        $return_data['result_supplier'] = $re->result_array();
        $return_data['data_search'] = $data_supplier;
        $return_data['sql'] = $sql;
        return $return_data;
    }

    public function update_supplier($supplier_id)
    {
        $slug = $slug =$this->input->post('slug');
        if ($this->input->post('slug') == "") {
            $slug =$this->input->post('name');
        }


        date_default_timezone_set("Asia/Bangkok");
        $data_supplier = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'modified_date' => date("Y-m-d H:i:s"),
            'is_active' => $this->input->post('isactive')
        );
        $where = "id = '".$supplier_id."'";
        $this->db->update("supplier", $data_supplier, $where);
    }

    public function save_supplier()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_supplier = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'create_date' => date("Y-m-d H:i:s"),
            'modified_date' => date("Y-m-d H:i:s"),
            'is_active' => $this->input->post('isactive')
        );

        $this->db->insert("supplier", $data_supplier);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }


}

/* End of file supplier_model.php */
/* Location: ./application/models/supplier_model.php */
