
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class shipping_method_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_shipping_method($start, $limit)
    {
        $sql =" SELECT p.*  FROM  shipping_method p ORDER BY p.id DESC  LIMIT " . $start . "," . $limit;
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_shipping_method_count()
    {
        $sql =" SELECT COUNT(id) as connt_id FROM  shipping_method p";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }


    public function get_shipping_method_id($shipping_method_id)
    {
        $sql ="SELECT * FROM shipping_method WHERE id = '".$shipping_method_id."'";

        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }


    public function get_shipping_method_search()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_shipping_method = array(
            'search' => $this->input->post('search')
        );

        $sql ="SELECT * FROM shipping_method WHERE name LIKE '%".$data_shipping_method['search']."%'";
        $re = $this->db->query($sql);
        $return_data['result_shipping_method'] = $re->result_array();
        $return_data['data_search'] = $data_shipping_method;
        $return_data['sql'] = $sql;
        return $return_data;
    }

    public function update_shipping_method($shipping_method_id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_shipping_method = array(
            'name' => $this->input->post('name'),
            'modified_date' => date("Y-m-d H:i:s"),
            'is_active' => $this->input->post('isactive')
        );
        $where = "id = '".$shipping_method_id."'";
        $this->db->update("shipping_method", $data_shipping_method, $where);
    }

    public function save_shipping_method()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_shipping_method = array(
            'name' => $this->input->post('name'),
            'create_date' => date("Y-m-d H:i:s"),
            'modified_date' => date("Y-m-d H:i:s"),
            'is_active' => $this->input->post('isactive')
        );

        $this->db->insert("shipping_method", $data_shipping_method);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }
}

/* End of file shipping_method_model.php */
/* Location: ./application/models/shipping_method_model.php */
