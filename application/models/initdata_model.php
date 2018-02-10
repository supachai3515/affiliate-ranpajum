
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Initdata_model extends CI_Model {

	public function __construct() {
	    parent::__construct();
	}

	public function get_menu()
	{
		$sqlmenu ="SELECT * FROM menu WHERE is_active ='1' ORDER BY order_by ";
		$reMenus = $this->db->query($sqlmenu);
		return  $reMenus->result_array();
	}

	public function get_brands()
	{
		$sql =" SELECT pb.id, pb.name, pb.slug, pt.id type_id, COUNT(p.id) count_product FROM product_brand pb
				INNER JOIN products p ON p.product_brand_id = pb.id
				INNER JOIN product_type  pt  ON p.product_type_id = pt.id
				WHERE pb.is_active = 1 AND p.is_active= '1' AND  pt.is_active = 1 GROUP BY  pb.id, pb.name , pb.slug
				HAVING COUNT(p.id) > 0
				ORDER BY pb.name ";
		$result = $this->db->query($sql);
		return  $result->result_array();
	}

	public function get_type()
	{
		//$sql ="SELECT pt.id, pt.name, pt.slug ,COUNT(p.id) count_product FROM product_type  pt
		//INNER JOIN products p ON p.product_type_id = pt.id
		//WHERE pt.is_active = 1 AND p.is_active= '1'  GROUP BY  pt.id, pt.name ,pt.slug
		//HAVING COUNT(p.id) > 0
		//ORDER BY pt.name";

		$sql ="SELECT pt.id, pt.name, pt.slug
				FROM product_type  pt
						WHERE pt.is_active = 1   AND pt.parenttype_id = 0
				GROUP BY  pt.id, pt.name ,pt.slug
						ORDER BY pt.name;";
		$result = $this->db->query($sql);
		return  $result->result_array();
	}
	public function get_sub_type()
	{

		$sql = "SELECT pt.id, pt.name, pt.slug ,pt.parenttype_id ,COUNT(p.id) count_product
				FROM product_type  pt
						LEFT JOIN products p ON p.product_type_id = pt.id
						WHERE pt.is_active = 1   AND pt.parenttype_id != 0
				GROUP BY  pt.id, pt.name ,pt.slug
						ORDER BY pt.name";
		$result = $this->db->query($sql);
		return  $result->result_array();
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

	public function get_type_by_id($id)
	{
		$sql ="SELECT * FROM product_type
		WHERE id = '".$id."'";
		$result = $this->db->query($sql);
		return  $result->row_array();
	}

	public function get_brand_by_id($id)
	{
		$sql ="SELECT * FROM product_brand
		WHERE id = '".$id."'";
		$result = $this->db->query($sql);
		return  $result->row_array();
	}

	public function get_type_by_slug($slug)
	{
		$sql ="SELECT * FROM product_type
		WHERE slug = '".$slug."'";
		$result = $this->db->query($sql);
		return  $result->row_array();
	}

	public function get_brand_by_slug($slug)
	{
		$sql ="SELECT * FROM product_brand
		WHERE slug = '".$slug."'";
		$result = $this->db->query($sql);
		return  $result->row_array();
	}

		public function get_province_list()
	{
		$sql ="SELECT province_id id, province_name name FROM province WHERE  province_name NOT LIKE '%*%' ORDER BY province_name ";
		$result = $this->db->query($sql);
		return  $result->result_array();
	}

	public function get_shipping_method()
	{
		$sql ="SELECT * FROM shipping_method WHERE is_active = 1 ORDER BY name";
		$result = $this->db->query($sql);
		return  $result->result_array();
	}

	public function get_amphur_list($province_id)
	{
		$sql ="SELECT amphur_id id, amphur_name name FROM amphur WHERE province_id ='".$province_id."' AND amphur_name NOT LIKE '%*%' ORDER BY amphur_name ";
		$result = $this->db->query($sql);
		return  $result->result_array();
	}

	public function get_amphur_list_all()
	{
		$sql ="SELECT amphur_id id, amphur_name name FROM amphur
				WHERE amphur_name NOT LIKE '%*%'
				ORDER BY amphur_name  ";
		$result = $this->db->query($sql);
		return  $result->result_array();
	}

	public function get_cart_data()
	{
        $productResult = array();
        foreach ($this->cart->contents() as $items) {
            $sql   = "SELECT p.* ,t.name type_name, b.name brand_name
                FROM  products p
                LEFT JOIN product_brand b ON p.product_brand_id = b.id
                LEFT JOIN product_type t ON p.product_type_id = t.id  WHERE
                p.is_active = 1 AND p.stock > 0 AND p.id = '" . $items['id'] . "'";
            $query = $this->db->query($sql);
            $row   = $query->row_array();
            if (isset($row['id'])) {
                $price  = $row["price"];
                $dis_price  = $row["dis_price"];

                if ($this->session->userdata('is_logged_in') && $this->session->userdata('verify') == "1") {

                    if($this->session->userdata('is_lavel1')) {
                        if($row["member_discount_lv1"] > 1){
                            $dis_price = $row["member_discount_lv1"];
                        }
                    }
                    else {

                        if($row["member_discount"] > 1){
                            $dis_price = $row["member_discount"];
                        }
                    }
                }

                if ($dis_price < $price  &&  $dis_price > 0) {
	                $price = $dis_price;
	            }


                $image_url = "";
                if ($row['image'] != "") {
                    $image_url = $this->config->item('url_img') . $row['image'];
                } else {
                    $image_url = $this->config->item('no_url_img');
                }
                $productResult[] = array(
                    'id' => $items['id'],
                    'sku' => $row['sku'],
                    'slug' => $row['slug'],
                    'name' => $row['name'],
                    'img' => $image_url,
                    'price' => $price,
                    'qty' => $items['qty'],
                    'rowid' => $items['rowid'],
                    'model' => $row['model'],
                    'brand' => $row['brand_name'],
                    'is_reservations' => $items['is_reservations'],
                    'type' => $row['type_name']
                );
            }
        }

        return $productResult;
    }

    public function get_sipping($shipping_id)
	{
        $weigth = 0;

        foreach ($this->cart->contents() as $items) {
            $sql   = "SELECT p.* ,t.name type_name, b.name brand_name
                FROM  products p
                LEFT JOIN product_brand b ON p.product_brand_id = b.id
                LEFT JOIN product_type t ON p.product_type_id = t.id  WHERE
                p.is_active = 1 AND p.stock > 0 AND p.id = '" . $items['id'] . "'";
            $query = $this->db->query($sql);
            $row   = $query->row_array();
            	 $weigth =  $weigth + ($row['weight']*$items['qty']);
         }

        if($weigth > 0){

        	  $sql = "SELECT price shipping_price FROM shipping_rate
				WHERE shipping_method_id = '".$shipping_id."'
				AND '".$weigth."' BETWEEN  from_weight AND to_weight";

			$result = $this->db->query($sql);

			$result_row = $result->row_array();
			if (isset($result_row['shipping_price']) ){
				return  $result->row_array();
			}
			else{

				return array( 'shipping_price' => 0);
			}

        }
        else
        {
        	return array( 'shipping_price' => 0);
        }
    }

    public function get_sipping_spcial($amphur_id)
	{

		$sql = "SELECT price  spcial_price FROM special_county
				WHERE amphur_id = '".$amphur_id."'  AND shipping_method_id = '2' ";
		$result = $this->db->query($sql);

		$result_row = $result->row_array();
		if (isset($result_row['spcial_price']) ){
			return  $result->row_array();
		}
		else {
			return array( 'spcial_price' => 0);
		}

    }


}

/* End of file initdata */
/* Location: ./application/models/initdata */
