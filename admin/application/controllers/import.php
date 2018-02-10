<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('products_model');
	}


	public function index()
	{
		
	}

	public function product()
	{

		$data = json_decode(file_get_contents("php://input"));
		date_default_timezone_set("Asia/Bangkok");

		foreach ($data as $value) {

			$sku_str =  str_replace(")","",$value->Id);
			$sku_str =  str_replace("(","-",$sku_str );
			$sku_str =  str_replace("/","-",$sku_str );

			$brand_name = str_replace("/","-",$value->Brand);

			$brand_id ="";

			//check brand 

			$query = $this->db->query(" SELECT COUNT(id) as connt_id FROM  product_brand WHERE name = '".$brand_name."' ");
			$row_n = $query->row_array();
			if($row_n['connt_id']==1)
			{
					$query = $this->db->query(" SELECT id FROM  product_brand WHERE name = '".$brand_name."' ");
					$row_nn = $query->row_array();
					$brand_id = $row_nn['id'];

			}
			else {

				$data_brand = array(
					'name' => $brand_name,
					'is_active' => '1',
					'modified_date' => date("Y-m-d H:i:s")					
				);

				$this->db->insert("product_brand", $data_brand);
				$insert_id = $this->db->insert_id();
		   		$brand_id = $insert_id;
			}


			$data_product = array(
				'sku' => $sku_str,
				'name' => $value->Name,
				'product_type_id' => $value->CategoryId,
				'model' => $value->Model,
				'product_brand_name' => str_replace("/","-",$value->Brand), 
				'product_brand_id' => $brand_id,
				'modified_date' => date("Y-m-d H:i:s")					
			);

			$query = $this->db->query(" SELECT COUNT(id) as connt_id FROM  products WHERE sku ='".$sku_str."' ");
			$row = $query->row_array();
			if($row['connt_id']==1)
			{
				$where = "sku = '".$sku_str."'"; 
				$this->db->update("products", $data_product, $where);
			
			}
			
			else {


				$data_product = array(
					'sku' => $sku_str,
					'name' => $value->Name,
					'product_type_id' => $value->CategoryId,
					'model' => $value->Model,
					'product_brand_name' => str_replace("/","-",$value->Brand), 
					'product_brand_id' => $brand_id,
					'price' => "1",
					'dis_price' => "1",
					'member_discount' => "1",
					'create_date' => date("Y-m-d H:i:s"),
					'modified_date' => date("Y-m-d H:i:s")					
				);


				$this->db->insert("products", $data_product);
				$insert_id = $this->db->insert_id();
		   		for ($i=1; $i <11 ; $i++) { 

			      $this->products_model->insert_productimgs($insert_id, $i, "");
			    }
			}

			print json_encode($data_product);

		}

	}

	public function insert_img()
	{
		$sql ="SELECT id FROM products"; 
		$result = $this->db->query($sql);
		$re_  =  $result->result_array();

		foreach ($re_ as  $value) {

			for ($i=1; $i <11 ; $i++) { 

			      //$this->products_model->insert_productimgs($value['id'], $i, "");
			   }
		}

	}

	public function category()
	{
		$data = json_decode(file_get_contents("php://input"));
		date_default_timezone_set("Asia/Bangkok");

		foreach ($data as $value) {

			$data_product = array(
				'id' => $value->Id,
				'name' => $value->Name,
				'modified_date' => date("Y-m-d H:i:s"),
				'is_active' => '1',

			);

			$query = $this->db->query(" SELECT COUNT(id) as connt_id FROM  product_type WHERE id ='".$value->Id."' ");
			$row = $query->row_array();
			if($row['connt_id']==1)
			{
				$where = "id = '".$value->Id."'"; 
				$this->db->update("product_type", $data_product, $where);
			
			}
			else {

				$this->db->insert("product_type", $data_product);
				//$insert_id = $this->db->insert_id();
		   		//return  $insert_id;
			}

			print json_encode($data_product);

		}

	}
	
	public function stock()
	{

		$data = json_decode(file_get_contents("php://input"));
		date_default_timezone_set("Asia/Bangkok");

		foreach ($data as $value) {

			$sku_str =  str_replace(")","",$value->Id);
			$sku_str =  str_replace("(","-",$sku_str );
			$sku_str =  str_replace("/","-",$sku_str );


			$query = $this->db->query(" SELECT  id  FROM products  WHERE sku = '".$sku_str."' ");
			$row = $query->row_array();

			if(isset($row['id']) AND $row['id'] != "")
			{

				$data_product = array(
					'product_id' => $row['id'],
					'branch_id' => $value->Branch,
					'serial' => $value->Serial,
					'number' => $value->Number,
					'is_active' => '1',
					'modified_date' => date("Y-m-d H:i:s")					
				);


				$query = $this->db->query(" SELECT COUNT(product_id) as connt_id FROM  stock WHERE product_id ='".$row['id']."' AND serial='".$value->Serial."' ");
				$row_n = $query->row_array();
				if($row_n['connt_id']==1)
				{
					$where = "product_id = '".$row['id']."' AND serial='".$value->Serial."'  "; 
					$this->db->update("stock", $data_product, $where);

				}
				else {

					$this->db->insert("stock", $data_product);
				}


			}

		}

	}

	public function removestock()
	{

		$data = json_decode(file_get_contents("php://input"));
		date_default_timezone_set("Asia/Bangkok");

		foreach ($data as $value) {

			$sku_str =  str_replace(")","",$value->Id);
			$sku_str =  str_replace("(","-",$sku_str );
			$sku_str =  str_replace("/","-",$sku_str );


			$query = $this->db->query(" SELECT  id  FROM products  WHERE sku = '".$sku_str."' ");
			$row = $query->row_array();

			if(isset($row['id']) AND $row['id'] != "")
			{

				$query = $this->db->query(" DELETE FROM  stock WHERE product_id ='".$row['id']."' AND  serial = '".$value->Serial."' ");
				
			}

		}

	}


	public function branch()
	{

		$data = json_decode(file_get_contents("php://input"));
		date_default_timezone_set("Asia/Bangkok");

		foreach ($data as $value) {

			$data_branch = array(
				'id' => $value->Id,
				'name' => $value->Name,
				'description' => $value->Address,
				'tel' => $value->Tel,
				'modified_date' => date("Y-m-d H:i:s"),
				'is_active' => '1'
			);

			$query = $this->db->query(" SELECT COUNT(id) as connt_id FROM  branch WHERE id ='".$value->Id."' ");
			$row = $query->row_array();
			if($row['connt_id']==1)
			{
				$where = "id = '".$value->Id."'"; 
				$this->db->update("branch", $data_branch, $where);
			
			}

			else {
					$data_branch = array(
					'id' => $value->Id,
					'name' => $value->Name,
					'description' => $value->Address,
					'tel' => $value->Tel,
					'create_date' => date("Y-m-d H:i:s"),
					'modified_date' => date("Y-m-d H:i:s"),
					'is_active' => '1'
					);

				$this->db->insert("branch", $data_branch);

			}

		}

	}



}

/* End of file import.php */
/* Location: ./application/controllers/import.php */