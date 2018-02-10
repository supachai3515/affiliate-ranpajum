<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

	public function get_products_count()
	{

		$sql =" SELECT COUNT(p.id) as connt_id FROM  products p
				LEFT JOIN product_brand b ON p.product_brand_id = b.id
				LEFT JOIN product_type t ON p.product_type_id = t.id
				WHERE p.is_active= '1'AND t.is_active = 1 ";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];

	}


	public function get_products( $start, $limit)
	{

	    $sql =" SELECT p.* ,t.name type_name, b.name brand_name, t.id type_id, b.id brand_id,
	    		t.slug type_slug, b.slug brand_slug
				FROM  products p
				LEFT JOIN product_brand b ON p.product_brand_id = b.id
				LEFT JOIN product_type t ON p.product_type_id = t.id
				WHERE p.is_active= '1' AND t.is_active = 1  ORDER BY p.id DESC LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function check_cat($slug)
	{
		$sql =" SELECT COUNT(id) as connt_id FROM product_type
				WHERE   is_active = '1' AND slug = '".$slug."' ";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];
	}

	public function get_products_search_count($sql)
	{
		$query = $this->db->query($sql);
		return  $rowcount = $query->num_rows();
	}


	public function get_products_search( $sql, $start, $limit)
	{
	    $sql = $sql." LIMIT ". $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();
	}


	public function whereSqlConcat($keyArray)
	{
		$countKey = count($keyArray);
		$sqlString=" SELECT pc.search , p.* ,t.name type_name, b.name brand_name, t.id type_id, b.id brand_id
					FROM products p
					INNER JOIN (
					SELECT CONCAT(IFNULL(name,''), IFNULL(model,''), IFNULL(detail,''), IFNULL(sku,'')) search ,id FROM products
					)
					pc ON p.id = pc.id
					LEFT JOIN product_brand b ON p.product_brand_id = b.id
					LEFT JOIN product_type t ON p.product_type_id = t.id  WHERE  p.is_active= '1' AND  t.is_active = '1' AND";
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

	public function get_brand_oftype()
	{
		$sql ="SELECT pt.id product_type_id , pt.name product_type_name ,  pb.id product_brand_id ,
				pb.name product_brand_name ,pt.slug  product_type_slug,pb.slug product_brand_slug,  COUNT(p.id)
				FROM  products p
				LEFT JOIN  product_type pt ON p.product_type_id = pt.id
				LEFT JOIN  product_brand pb ON p.product_brand_id = pb.id
				WHERE  p.is_active= '1' AND  pt.is_active = '1'
				GROUP BY  pt.id  , pt.name  ,  pb.id  , pb.name  , pt.slug , pb.slug
				HAVING COUNT(p.id) > 0 ";
		$re = $this->db->query($sql);
		return $re->result_array();
	}


	public function get_products_category_brand_count($category,$brand)
	{

		$sql =" SELECT COUNT(p.id) as connt_id
				FROM  products p
				LEFT JOIN product_brand b ON p.product_brand_id = b.id
				LEFT JOIN product_type t ON p.product_type_id = t.id
				WHERE  p.is_active= '1' AND  t.is_active = '1' AND t.slug ='".$category."' AND b.slug ='".$brand."'";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];

	}


	public function get_products_category_brand( $category, $brand, $start, $limit)
	{

	    $sql =" SELECT p.* ,t.name type_name, b.name brand_name , t.id type_id, b.id brand_id
				FROM  products p
				LEFT JOIN product_brand b ON p.product_brand_id = b.id
				LEFT JOIN product_type t ON p.product_type_id = t.id
				WHERE  p.is_active= '1' AND  t.is_active = '1' AND t.slug ='".$category."' AND b.slug ='".$brand."'
				ORDER BY p.id DESC LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_products_category_count($category)
	{

		$sql =" SELECT * FROM product_type
				WHERE   is_active = '1' AND slug = '".$category."' ";

			$query = $this->db->query($sql);
			$row = $query->row();

			if (isset($row) && count($row) > 0)
			{

			        	$sql =" SELECT COUNT(p.id) connt_id
						FROM  products p
						LEFT JOIN product_brand b ON p.product_brand_id = b.id
						LEFT JOIN product_type t ON p.product_type_id = t.id

						WHERE  p.is_active= '1' AND  t.is_active = '1'
						AND t.id  IN (SELECT t2.id FROM product_type t2 WHERE t2.id IN (
							SELECT t1.id FROM product_type t1
							WHERE t1.id = '".$row->id."' OR t1.parenttype_id = '".$row->id."'
							) OR  t2.parenttype_id IN (
							SELECT t1.id FROM product_type t1
							WHERE t1.id = '".$row->id."' OR t1.parenttype_id = '".$row->id."'
							)
						)
						OR t.slug ='".$category."'  AND p.is_active = 1";
					$query = $this->db->query($sql);
					$re = $query->row_array();
					return  $re['connt_id'];
			}
		return 0;

	}


	public function get_products_category( $category, $start, $limit)
	{
		  $sql =" SELECT * FROM product_type
				WHERE   is_active = '1' AND slug = '".$category."' ";

			$query = $this->db->query($sql);
			$row = $query->row();

			if (isset($row) && count($row) > 0)
			{

			        	$sql ="SELECT p.* ,t.name type_name, b.name brand_name , t.id type_id, b.id brand_id
						FROM  products p
						LEFT JOIN product_brand b ON p.product_brand_id = b.id
						LEFT JOIN product_type t ON p.product_type_id = t.id

						WHERE  p.is_active= '1' AND  t.is_active = '1'
						AND t.id  IN (SELECT t2.id FROM product_type t2 WHERE t2.id IN (
							SELECT t1.id FROM product_type t1
							WHERE t1.id = '".$row->id."' OR t1.parenttype_id = '".$row->id."' AND t1.is_active = 1
							) OR  t2.parenttype_id IN (
							SELECT t1.id FROM product_type t1
							WHERE t1.id = '".$row->id."' OR t1.parenttype_id = '".$row->id."' AND t2.is_active = 1
							)
						)
						OR t.slug ='".$category."' AND p.is_active = 1
						ORDER BY p.id DESC LIMIT " . $start . "," . $limit;
						$re = $this->db->query($sql);
						return $re->result_array();

			}
	}


	public function get_products_category_all( $category, $start, $limit)
	{
		  $sql =" SELECT * FROM product_type
				WHERE   is_active = '1' AND slug = '".$category."' ";

			$query = $this->db->query($sql);
			$row = $query->row();

			if (isset($row) && count($row) > 0)
			{
			        if ($row->parenttype_id == 0) {
			        	$sql ="SELECT p.* ,t.name type_name, b.name brand_name , t.id type_id, b.id brand_id
						FROM  products p
						LEFT JOIN product_brand b ON p.product_brand_id = b.id
						LEFT JOIN product_type t ON p.product_type_id = t.id

						WHERE  p.is_active= '1' AND  t.is_active = '1'
						AND t.id  IN (SELECT id FROM product_type WHERE parenttype_id = '".$row->id."')
						OR t.slug ='".$category."'
						ORDER BY p.id DESC LIMIT " . $start . "," . $limit;
						$re = $this->db->query($sql);
						return $re->result_array();
			        }
			        else{

			        	 $sql =" SELECT p.* ,t.name type_name, b.name brand_name , t.id type_id, b.id brand_id
						FROM  products p
						LEFT JOIN product_brand b ON p.product_brand_id = b.id
						LEFT JOIN product_type t ON p.product_type_id = t.id

						WHERE  p.is_active= '1' AND  t.is_active = '1' AND t.slug ='".$category."' ORDER BY p.id DESC LIMIT " . $start . "," . $limit;
						$re = $this->db->query($sql);
						return $re->result_array();

			        }

			}
	}


	public function get_products_brand_count($brand)
	{

		$sql =" SELECT COUNT(p.id) as connt_id FROM  products p
				LEFT JOIN product_brand b ON p.product_brand_id = b.id
				LEFT JOIN product_type t ON p.product_type_id = t.id
				WHERE p.is_active= '1' AND  t.is_active = '1' AND   b.slug ='".$brand."'";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];

	}


	public function get_products__brand($brand, $start, $limit)
	{

	    $sql =" SELECT p.* ,t.name type_name, b.name brand_name
				FROM  products p
				LEFT JOIN product_brand b ON p.product_brand_id = b.id
				LEFT JOIN product_type t ON p.product_type_id = t.id
				WHERE p.is_active= '1' AND  t.is_active = '1' AND  b.slug ='".$brand."'
				ORDER BY p.id DESC LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}

}

/* End of file products_model.php */
/* Location: ./application/models/products_model.php */
