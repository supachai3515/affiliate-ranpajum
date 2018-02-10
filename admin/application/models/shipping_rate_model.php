
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shipping_rate_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_shipping_rate($start, $limit)
    {
        $sql =" SELECT p.*  , s.name shipping_method_name FROM  shipping_rate p INNER JOIN  shipping_method s  on p.shipping_method_id = s.id ORDER BY p.id DESC  LIMIT " . $start . "," . $limit;
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_shipping_rate_count()
    {
        $sql =" SELECT COUNT(id) as connt_id FROM  shipping_rate p";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }


    public function get_shipping_rate_id($shipping_rate_id)
    {
        $sql ="SELECT * FROM shipping_rate WHERE id = '".$shipping_rate_id."'";

        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }


    public function get_shipping_rate_search()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_shipping_rate = array(
            'search' => $this->input->post('search')
        );

        $sql ="SELECT p.*  , s.name shipping_method_name FROM  shipping_rate p INNER JOIN  shipping_method s  on p.shipping_method_id = s.id
								WHERE p.shipping_method_id LIKE '%".$data_shipping_rate['search']."%' OR  s.name LIKE '%".$data_shipping_rate['search']."%' ";
        $re = $this->db->query($sql);
        $return_data['result_shipping_rate'] = $re->result_array();
        $return_data['data_search'] = $data_shipping_rate;
        $return_data['sql'] = $sql;
        return $return_data;
    }

    public function update_shipping_rate($shipping_rate_id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_shipping_rate = array(
            'shipping_method_id'=> $this->input->post('shipping_method_id'),
            'description'=> $this->input->post('description'),
            'from_weight'=> $this->input->post('from_weight'),
            'to_weight'=> $this->input->post('to_weight'),
            'price'=> $this->input->post('price'),
            'modified_date' => date("Y-m-d H:i:s"),
            'is_active' => $this->input->post('isactive')
        );
        $where = "id = '".$shipping_rate_id."'";
        $this->db->update("shipping_rate", $data_shipping_rate, $where);
    }

    public function save_shipping_rate()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_shipping_rate = array(
            'shipping_method_id'=> $this->input->post('shipping_method_id'),
            'description'=> $this->input->post('description'),
            'from_weight'=> $this->input->post('from_weight'),
            'to_weight'=> $this->input->post('to_weight'),
            'price'=> $this->input->post('price'),
            'create_date' => date("Y-m-d H:i:s"),
            'modified_date' => date("Y-m-d H:i:s"),
            'is_active' => $this->input->post('isactive')
        );

        $this->db->insert("shipping_rate", $data_shipping_rate);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }
}

/* End of file shipping_rate_model.php */
/* Location: ./application/models/shipping_rate_model.php */
