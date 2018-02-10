<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

	public function get_products_new()  
	{
		$sql =" SELECT  p.*, b.name brand_name, t.name type_name  , stock_all FROM  products p 
				LEFT JOIN product_brand b ON p.product_brand_id = b.id
				LEFT JOIN product_type t ON p.product_type_id = t.id 
				LEFT JOIN (SELECT product_id, SUM(number) stock_all FROM stock  GROUP BY product_id) s ON s.product_id = p.id 
				WHERE p.is_active= '1' AND t.is_active='1'
				ORDER BY p.id DESC LIMIT 0,15"; 
		$result = $this->db->query($sql);
		return  $result->result_array();
	}
	
	public function get_products_hot()
	{
		$sql =" SELECT  p.*, b.name brand_name, t.name type_name , stock_all FROM  products p 
				LEFT JOIN product_brand b ON p.product_brand_id = b.id
				LEFT JOIN product_type t ON p.product_type_id = t.id 
				LEFT JOIN (SELECT product_id, SUM(number) stock_all FROM stock  GROUP BY product_id) s ON s.product_id = p.id 
				WHERE p.is_active= '1' AND t.is_active='1' AND is_hot = 1
				ORDER BY p.id LIMIT 0,15"; 
		$result = $this->db->query($sql);
		return  $result->result_array();
	}

	public function get_products_sale()
	{
		$sql =" SELECT  p.*, b.name brand_name, t.name type_name , stock_all FROM  products p 
				LEFT JOIN product_brand b ON p.product_brand_id = b.id
				LEFT JOIN product_type t ON p.product_type_id = t.id 
				LEFT JOIN (SELECT product_id, SUM(number) stock_all FROM stock  GROUP BY product_id) s ON s.product_id = p.id 
				WHERE p.is_active= '1' AND t.is_active='1' AND is_sale = 1
				ORDER BY p.id LIMIT 0,15"; 
		$result = $this->db->query($sql);
		return  $result->result_array();
	}

	public function get_products_promotion()
	{
		$sql =" SELECT  p.*, b.name brand_name, t.name type_name , stock_all FROM  products p 
				LEFT JOIN product_brand b ON p.product_brand_id = b.id
				LEFT JOIN product_type t ON p.product_type_id = t.id 
				LEFT JOIN (SELECT product_id, SUM(number) stock_all FROM stock  GROUP BY product_id) s ON s.product_id = p.id 
				WHERE p.is_active= '1' AND t.is_active='1' AND is_promotion = 1
				ORDER BY p.id LIMIT 0,15"; 
		$result = $this->db->query($sql);
		return  $result->result_array();
	}


	public function get_content_wordpress()
	{
		$sql ="SELECT DISTINCT m.* ,pm.meta_value as image_file, u.display_name FROM (
				SELECT 
				ID, p.post_author,p.post_content, post_title AS title, p.guid link, post_excerpt AS excerpt ,p.post_date, pm.meta_key ,pm.meta_value as id_file
				FROM wp_posts p
				JOIN wp_term_relationships tr ON (p.ID = tr.object_id)
				JOIN wp_term_taxonomy tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
				JOIN wp_terms t ON (tt.term_id = t.term_id)
				LEFT JOIN wp_postmeta pm on  p.ID = pm.post_id
				WHERE p.post_type='post'
				AND p.post_status = 'publish'
				AND pm.meta_key = '_thumbnail_id' ORDER BY  p.post_date DESC LIMIT 10) m 
				LEFT JOIN wp_posts p ON p.ID = m.id_file
				LEFT JOIN wp_postmeta pm on  m.id_file = pm.post_id
				LEFT JOIN wp_users u ON u.ID = m.post_author 
				WHERE pm.meta_key = '_wp_attached_file'

				";
		$result = $this->db->query($sql);
		return  $result->result_array();

		
	}


}

/* End of file home_model.php */
/* Location: ./application/models/home_model.php */