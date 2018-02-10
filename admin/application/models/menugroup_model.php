
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menugroup_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_menugroup_count($searchText = '')
    {
        $searchText = $this->db->escape_like_str($searchText);
        $sql =" SELECT COUNT(r.menu_group_id) as connt_id FROM  menu_group r WHERE 1=1 ";
        if (!empty($searchText)) {
            $sql = $sql." AND (r.menu_group_id  LIKE '%".$searchText."%' OR  r.name  LIKE '%".$searchText."%' OR  r.description  LIKE '%".$searchText."%')";
        }
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }

    public function get_menugroup($searchText = '', $page, $segment)
    {
        $searchText = $this->db->escape_like_str($searchText);
        $page = $this->db->escape_str($page);
        $segment = $this->db->escape_str($segment);

        $sql ="SELECT r.* , u1.name create_by_name , u2.name  modified_by_name FROM  menu_group r
						LEFT JOIN tbl_users u1 ON u1.userId = r.create_by
						LEFT JOIN tbl_users u2 ON u2.userId = r.modified_by WHERE 1=1 ";
        if (!empty($searchText)) {
            $sql = $sql." AND (r.menu_group_id  LIKE '%".$searchText."%' OR  r.name  LIKE '%".$searchText."%' OR  r.description  LIKE '%".$searchText."%')";
        }
        $sql = $sql." LIMIT ".$page.",".$segment." ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_menugroup_all()
    {
        $sql ="SELECT r.* , u1.name create_by_name , u2.name  modified_by_name FROM  menu_group r
						LEFT JOIN tbl_users u1 ON u1.userId = r.create_by
						LEFT JOIN tbl_users u2 ON u2.userId = r.modified_by WHERE 1=1 ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_menugroup_id($id)
    {
        $id = $this->db->escape_str($id);
        $sql ="SELECT r.* , u1.name create_by_name , u2.name  modified_by_name FROM  menu_group r
						LEFT JOIN tbl_users u1 ON u1.userId = r.create_by
						LEFT JOIN tbl_users u2 ON u2.userId = r.modified_by
						 WHERE r.menu_group_id = '".$id."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function save_menugroup($menugroup_info)
    {
        $this->db->trans_start();
        $this->db->insert('menu_group', $menugroup_info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function update_menugroup($menugroup_info, $id)
    {
        $this->db->where('menu_group_id', $id);
        $this->db->update('menu_group', $menugroup_info);
        return true;
    }

    public function get_menu_group_detail($id)
    {
        $id = $this->db->escape_str($id);
        $sql ="SELECT m.menu_id,m.`name`, md.is_add ,md.is_edit, md.is_view, md.is_active
				FROM menu m
				LEFT JOIN menu_group_detail md ON m.menu_id = md.menu_id
				WHERE md.menu_group_id = ".$id."";

        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_menu($id)
    {
        $id = $this->db->escape_str($id);
        $sql ="SELECT m.* FROM menu m
				WHERE is_active = 1  AND  m.menu_id NOT IN (SELECT menu_id FROM  menu_group_detail WHERE menu_group_id = ".$id." ) ";
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function save_menu_group_detail($value)
    {
        $sql ="INSERT INTO `menu_group_detail` (`menu_id`, `menu_group_id`, `is_add`, `is_view`, `is_edit`) VALUES ('".$value->menu_id."', '".$value->menu_group_id."','0', '1', '0') ";
        $this->db->query($sql);
    }

    public function update_menu_group_detail($value)
    {
        $sql = "UPDATE menu_group_detail SET ".$value->case_update." =  '".$value->edit_valus."'  WHERE menu_id  = '".$value->menu_id."' AND  menu_group_id = '".$value->menu_group_id."' ";
        $this->db->query($sql);
    }
}

/* End of file menugroup_model.php */
/* Location: ./application/models/menugroup_model.php */
