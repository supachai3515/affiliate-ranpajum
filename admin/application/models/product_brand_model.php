
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_brand_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_product_brand_count($searchText = '')
    {
        // $this->db->escape() ใส่ '' ให้
        // $this->db->escape_str()  ไม่ใส่ '' ให้
        // $this->db->escape_like_str($searchText) like
        $searchText = $this->db->escape_like_str($searchText);
        $sql =" SELECT COUNT(m.id) as connt_id FROM  product_brand m WHERE 1=1 ";
        if (!empty($searchText)) {
            $sql = $sql." AND (m.id  LIKE '%".$searchText."%'
														OR  m.name  LIKE '%".$searchText."%'
														OR  m.description  LIKE '%".$searchText."%')";
        }
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }

    public function get_product_brand($searchText = '', $page, $segment)
    {
        $searchText = $this->db->escape_like_str($searchText);
        $page = $this->db->escape_str($page);
        $segment = $this->db->escape_str($segment);

        $sql ="SELECT m.* , u1.name create_by_name , u2.name  modified_by_name FROM  product_brand m
						LEFT JOIN tbl_users u1 ON u1.userId = m.create_by
						LEFT JOIN tbl_users u2 ON u2.userId = m.modified_by WHERE 1=1 ";
        if (!empty($searchText)) {
            $sql = $sql." AND (m.id  LIKE '%".$searchText."%'
													OR  m.name  LIKE '%".$searchText."%'
													OR  m.description  LIKE '%".$searchText."%')";
        }
        $sql = $sql." LIMIT ".$page.",".$segment." ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_product_brand_all()
    {
        $sql ="SELECT m.* , u1.name create_by_name , u2.name  modified_by_name FROM  product_brand m
						LEFT JOIN tbl_users u1 ON u1.userId = m.create_by
						LEFT JOIN tbl_users u2 ON u2.userId = m.modified_by WHERE 1=1 ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_id($id)
    {
        $id = $this->db->escape($id);

        $sql ="SELECT m.* , u1.name create_by_name , u2.name  modified_by_name FROM  product_brand m
						LEFT JOIN tbl_users u1 ON u1.userId = m.create_by
						LEFT JOIN tbl_users u2 ON u2.userId = m.modified_by
						WHERE m.id = ".$id;
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function save_product_brand($product_brand_info)
    {
        $this->db->trans_start();
        $this->db->insert('product_brand', $product_brand_info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function update_product_brand($product_brand_info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('product_brand', $product_brand_info);
        return true;
    }
}

/* End of file product_brand_model.php */
/* Location: ./application/models/product_brand_model.php */
