
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

	public function get_sumpayment($obj = '' ) {

		date_default_timezone_set("Asia/Bangkok");
		$date_from = date("Y-m-d");
		$date_to = date("Y-m-d");

		if(empty( $obj['dateStart'] != '' && $obj['dateEnd'] == '')){
			$date_from = $obj['dateStart'];
		}elseif(empty($obj['dateStart'] != '' && $obj['dateEnd'] != '')){
			$date_from = $obj['dateStart'];
			$date_to = $obj['dateEnd'];
		}

		if(empty($obj['list_category']) == 1){
			$sql = "SELECT DATE_FORMAT(pm.inform_date_time ,'%Y-%m-%d') inform_date ,pm.bank_name, SUM(pm.amount) amount
				FROM payment pm
				INNER JOIN orders o ON o.id = pm.order_id
				WHERE o.order_status_id = 4
				AND DATE_FORMAT(pm.inform_date_time ,'%Y-%m-%d')Between '".$date_from."' and '".$date_to."'
				GROUP BY  pm.bank_name , DATE_FORMAT(pm.inform_date_time ,'%Y-%m-%d')
				ORDER BY DATE_FORMAT(pm.inform_date_time ,'%Y-%m-%d') DESC"	;

				$re = $this->db->query($sql);
				return $re->result_array();

		}
		else {
			$sql = "SELECT DATE_FORMAT(pm.inform_date_time ,'%Y-%m-%d') inform_date ,pm.bank_name, SUM(pm.amount) amount
				FROM payment pm
				INNER JOIN orders o ON o.id = pm.order_id
				WHERE o.order_status_id = 4
				AND DATE_FORMAT(pm.inform_date_time ,'%Y-%m-%d')Between '".$date_from."' and '".$date_to."'
				GROUP BY  pm.bank_name , DATE_FORMAT(pm.inform_date_time ,'%Y-%m-%d')
				ORDER BY DATE_FORMAT(pm.inform_date_time ,'%Y-%m-%d') DESC"	;

				$re = $this->db->query($sql);
				return $re->result_array();
		}


	}


	public function getOrder($obj = ''){

		if($obj == ''){
			date_default_timezone_set("Asia/Bangkok");
			$obj['dateStart'] = date("Y-m-d");
			$obj['dateEnd'] = date("Y-m-d");
		}


		if(empty($obj['list_category']) == 1 && $obj['dateStart'] == '' && $obj['dateEnd'] == ''){
			$dataSearch = "and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".DATE."' and '".DATE."'";
		}elseif(empty($obj['list_category']) == 1 && $obj['dateStart'] != '' && $obj['dateEnd'] == ''){
			$dataSearch = "and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".DATE."'";
		}elseif(empty($obj['list_category']) == 1 && $obj['dateStart'] != '' && $obj['dateEnd'] != ''){
			$dataSearch = "and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".$obj['dateEnd']."'";
		}elseif(empty($obj['list_category']) != 1 && $obj['dateStart'] == '' && $obj['dateEnd'] == ''){
			$dataSearch = "and payment.bank_name = '".strip_tags(trim($obj['list_category']))."' and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".DATE."' and '".DATE."'";
		}elseif(empty($obj['list_category']) != 1 && $obj['dateStart'] != '' && $obj['dateEnd'] == ''){
			$dataSearch = "and payment.bank_name = '".strip_tags(trim($obj['list_category']))."' and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".DATE."'";
		}elseif(empty($obj['list_category']) != 1 && $obj['dateStart'] != '' && $obj['dateEnd'] != ''){
			$dataSearch = "and payment.bank_name = '".strip_tags(trim($obj['list_category']))."' and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".$obj['dateEnd']."'";
		}

		/*CheckBank*/
		$check = $this->input->post("checkbank");
		if($check == 0){
			$search = ',sum(payment.amount) as sum';
			$checkBank = 'group by payment.bank_name';
		}else{
			$search = '';
			$checkBank = '';
		}


		if($this->input->get("method") == 'post'){
			$query = $this->db->query("select *".$search." from payment left join orders on(orders.id = payment.order_id) where orders.order_status_id = 4 ".$dataSearch." ".$checkBank."")->result_array();
		}else{
			$query = $this->db->query("select *".$search." from payment left join orders on(orders.id = payment.order_id) where orders.order_status_id = 4 and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".DATE."' and '".DATE."' ".$checkBank."")->result_array();
		}
		return $query;

	}


	function get_product_report($obj = ''){


		if($obj == ''){
			date_default_timezone_set("Asia/Bangkok");
			$date  = strtotime('-7 days');
			$obj['dateStart'] = date("Y-m-d",$date );
			$obj['dateEnd'] = date("Y-m-d");
		}
		else {

			if($obj['dateStart'] != ''){
				$obj['dateStart'] = $obj['dateStart'];
			} else {
				$obj['dateEnd'] = date("Y-m-d");
			}

			if($obj['dateEnd'] != ''){
				$obj['dateEnd'] = $obj['dateEnd'];
			} else {
				$obj['dateEnd'] = date("Y-m-d");
			}

		}

		$sql = "SELECT DATE_FORMAT(o.date,'%Y-%m-%d') date,SUM(o.quantity) quantity, SUM(o.vat)vat, SUM(o.shipping_charge) shipping_charge,SUM(o.total) total,
					SUM(
						CASE
						  WHEN o.is_invoice = 1 THEN o.total - o.shipping_charge
						  WHEN o.is_invoice = 0 THEN 0
						 END ) as total_invat
					WHERE DATE_FORMAT(o.date,'%Y-%m-%d')  BETWEEN '".$obj['dateStart']."' AND '".$obj['dateEnd']."' AND o.order_status_id = 4
					GROUP BY DATE_FORMAT(o.date,'%Y-%m-%d')
					ORDER BY DATE_FORMAT(o.date,'%Y-%m-%d') DESC";
		$re = $this->db->query($sql);
		return $re->result_array();
	}


	function getProduct($obj = ''){

		if($obj == ''){
			date_default_timezone_set("Asia/Bangkok");
			$obj['dateStart'] = date("Y-m-d");
			$obj['dateEnd'] = date("Y-m-d");
		}


		if($obj['dateStart'] == '' && $obj['dateEnd'] == ''){
			$dataSearch = "and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".DATE."' and '".DATE."'";
		}elseif($obj['dateStart'] != '' && $obj['dateEnd'] == ''){
			$dataSearch = "and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".DATE."'";
		}elseif($obj['dateStart'] != '' && $obj['dateEnd'] != ''){
			$dataSearch = "and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".$obj['dateEnd']."'";
		}

		if($this->input->get("method") == 'post'){
			$query = $this->db->query("select *,sum(order_detail.total) as sum_total,avg(order_detail.total/order_detail.quantity) as avgtotal,sum(order_detail.quantity) as ordetailsQTY,products.name as proname,order_detail.vat as ordetailsVAC,order_detail.total as ordetailstotal,product_type.name as typename,product_brand.name as brandname from order_detail left join products on(products.id = order_detail.product_id) left join orders on(orders.id = order_detail.order_id) left join product_type on(product_type.id = products.product_type_id) left join product_brand on(product_brand.id = products.product_brand_id) where orders.order_status_id = 4 ".$dataSearch." group by order_detail.product_id order by ordetailsQTY DESC")->result_array();
		}else{
			$query = $this->db->query("select *,sum(order_detail.total) as sum_total,avg(order_detail.total/order_detail.quantity) as avgtotal,sum(order_detail.quantity) as ordetailsQTY,products.name as proname,order_detail.vat as ordetailsVAC,order_detail.total as ordetailstotal,product_type.name as typename,product_brand.name as brandname from order_detail left join products on(products.id = order_detail.product_id) left join orders on(orders.id = order_detail.order_id) left join product_type on(product_type.id = products.product_type_id) left join product_brand on(product_brand.id = products.product_brand_id) where orders.order_status_id = 4 and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".DATE."' and '".DATE."' group by order_detail.product_id order by ordetailsQTY DESC")->result_array();
		}
		return $query;
	}


	  public function get_products_search()
		{
			date_default_timezone_set("Asia/Bangkok");
			$data_product = array(
				'search' => $this->input->post('search'),
				'product_type_id' => $this->input->post('select_type'),
				'product_brand_id' => $this->input->post('select_brand'),
				'branch_id' => $this->input->post('select_branch'),
				'from_stock' => $this->input->post('from_stock'),
				'to_stock' =>  $this->input->post('to_stock'),
				'all_promotion' => $this->input->post('all_promotion'),
				'is_hot' => $this->input->post('is_hot'),
				'is_promotion' => $this->input->post('is_promotion'),
				'is_sale' => $this->input->post('is_sale'),
				'is_active' => $this->input->post('isactive')
			);

			 $sql ="SELECT pc.search , p.* ,t.name type_name, b.name brand_name ,p.stock stock_number
					FROM products p
					INNER JOIN (
					SELECT CONCAT(IFNULL(name,''),IFNULL(model,''),IFNULL(shot_detail,''),IFNULL(sku,'')) search ,id FROM
					products
					)
					pc ON p.id = pc.id
					LEFT JOIN product_brand b ON p.product_brand_id = b.id
					LEFT JOIN product_type t ON p.product_type_id = t.id ";
			 //where
			$sql = $sql." WHERE 1=1 ";
			if($data_product['search'] != "") {
				$sql = $sql."AND pc.search LIKE '%".trim($data_product['search'])."%'";
			}
			if($data_product['product_type_id'] != "") {
				$sql = $sql."AND (p.product_type_id = '".$data_product['product_type_id']."')";
			}

			if($data_product['product_brand_id'] != "") {
				$sql = $sql."AND (p.product_brand_id = '".$data_product['product_brand_id']."')";
			}

			//$sql = $sql."AND (IFNULL(p.stock,0) BETWEEN '".$data_product['from_stock']."' AND '".$data_product['to_stock']."' )";

			if($data_product['all_promotion'] == "") {
				if($data_product['is_hot'] =='' ){$data_product['is_hot']= "0";}
				if($data_product['is_promotion'] =='' ){$data_product['is_promotion']= "0";}
				if($data_product['is_sale'] =='' ){$data_product['is_sale']= "0";}

				if($data_product['is_hot']=="1")
				{
					$sql = $sql."AND (p.is_hot = '".$data_product['is_hot']."')";
				}
				if ($data_product['is_promotion'] =='1') {
					$sql = $sql."AND (p.is_promotion = '".$data_product['is_promotion']."')";
				}
				if ($data_product['is_sale'] =='1') {
					$sql = $sql."AND (p.is_sale = '".$data_product['is_sale']."')";
				}
			}
			if($data_product['is_active'] =='' ){$data_product['is_active']= "0";}
			$sql = $sql."AND (p.is_active = '".$data_product['is_active']."')";


			$re = $this->db->query($sql);
			$return_data['result_products'] = $re->result_array();
			$return_data['data_search'] = $data_product;
			$return_data['sql'] = $sql;
			return $return_data;
		}

	function get_report_purchase_order($search_list, $obj = '') {
		$in = 0;
		$in_str = "";
		$join =" INNER JOIN ";
		if(count($search_list)>0){
			$join =" LEFT JOIN ";
			foreach ($search_list as $row) {
				$in = $in.",".$row['id'];

			}

			if($in != "0"){
				//str_replace("0,","",$not_in).")
				$in_str = " AND  p.id in (".str_replace("0,","",$in).")";
			}
		}

		if($obj == ''){
			date_default_timezone_set("Asia/Bangkok");
			$date  = strtotime('-7 days');
			$obj['dateStart'] = date("Y-m-d",$date );
			$obj['dateEnd'] = date("Y-m-d");


			$obj['from_purchase_order_qty'] = 0;
			$obj['to_purchase_order_qty'] = 9999;
			$obj['from_order_qty'] = 1;
			$obj['to_order_qty'] = 9999;
			$obj['from_stock'] = 0;
			$obj['to_stock'] = 9999;
		}
		else {

			if($obj['dateStart'] != ''){
				$obj['dateStart'] = $obj['dateStart'];
			} else {
				$obj['dateEnd'] = date("Y-m-d");
			}

			if($obj['dateEnd'] != ''){
				$obj['dateEnd'] = $obj['dateEnd'];
			} else {
				$obj['dateEnd'] = date("Y-m-d");
			}

		}

		$sql= " SELECT p.stock product_stock, IFNULL(o.order_qty,0) order_qty, IFNULL(po.purchase_order_qty,0) purchase_order_qty , pc.search , p.* ,t.name type_name, b.name brand_name , s.stock_all
						FROM products p
						INNER JOIN ( SELECT CONCAT(IFNULL(name,''), IFNULL(model,''), IFNULL(shot_detail,''), IFNULL(sku,'')) search , id FROM products )
						pc ON p.id = pc.id LEFT JOIN product_brand b ON p.product_brand_id = b.id
						LEFT JOIN (SELECT product_id, SUM(number) stock_all FROM stock GROUP BY product_id) s ON s.product_id = p.id
						LEFT JOIN product_type t ON p.product_type_id = t.id
						LEFT JOIN
						(
							SELECT  SUM(rd.qty) purchase_order_qty, rd.product_id FROM  purchase_order r
							INNER JOIN purchase_order_detail rd ON r.id = rd.purchase_order_id
							WHERE r.is_success = 0
							GROUP BY rd.product_id
						)po ON po.product_id = p.id
						".$join."
							(
								SELECT IFNULL(SUM(od.quantity),0) order_qty , od.product_id FROM orders o INNER JOIN order_detail od ON o.id = od.order_id
								WHERE o.order_status_id = 4 AND  DATE_FORMAT(o.date,'%Y-%m-%d')  BETWEEN '".$obj['dateStart']."' AND '".$obj['dateEnd']."'
								GROUP BY od.product_id
							) o ON o.product_id = p.id
						WHERE 1=1  ".$in_str."
						AND (IFNULL(po.purchase_order_qty,0) BETWEEN ".$obj['from_purchase_order_qty']." AND ".$obj['to_purchase_order_qty'].")
						AND (IFNULL(o.order_qty,0) BETWEEN ".$obj['from_order_qty']." AND ".$obj['to_order_qty'].")
						AND (IFNULL(p.stock,0) BETWEEN ".$obj['from_stock']." AND ".$obj['to_stock'].")
							";

		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;

	}


	function get_price_report($obj = ''){

		$date_v = "o.date";

		if($obj == ''){
			date_default_timezone_set("Asia/Bangkok");
			$date  = strtotime('-7 days');
			$obj['dateStart'] = date("Y-m-d",$date );
			$obj['dateEnd'] = date("Y-m-d");
		}
		else {

				if($obj['select_date'] == 2){
					$date_v = "o.invoice_date";
				}

			if($obj['dateStart'] != ''){
				$obj['dateStart'] = $obj['dateStart'];
			} else {
				$obj['dateEnd'] = date("Y-m-d");
			}

			if($obj['dateEnd'] != ''){
				$obj['dateEnd'] = $obj['dateEnd'];
			} else {
				$obj['dateEnd'] = date("Y-m-d");
			}

		}

		$sql = "SELECT DATE_FORMAT(".$date_v.",'%Y-%m-%d') date,SUM(o.quantity) quantity, SUM(o.vat)vat, SUM(o.shipping_charge) shipping_charge,SUM(o.total) total,
		SUM(
				CASE
				  WHEN o.is_invoice = 1 THEN o.total -o.shipping_charge
				  WHEN o.is_invoice = 0 THEN 0
				 END )as total_invat
					FROM orders o
					WHERE DATE_FORMAT(".$date_v.",'%Y-%m-%d')  BETWEEN '".$obj['dateStart']."' AND '".$obj['dateEnd']."' AND o.order_status_id = 4
					GROUP BY DATE_FORMAT(".$date_v.",'%Y-%m-%d')
					ORDER BY DATE_FORMAT(".$date_v.",'%Y-%m-%d') DESC";
		$re = $this->db->query($sql);
		return $re->result_array();
	}


	function getPrice($obj = ''){

		if($obj == ''){
			date_default_timezone_set("Asia/Bangkok");
			$obj['dateStart'] = date("Y-m-d");
			$obj['dateEnd'] = date("Y-m-d");
		}

		if($obj['dateStart'] == '' && $obj['dateEnd'] == ''){
			$dataSearch = "and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".DATE."' and '".DATE."'";
		}elseif($obj['dateStart'] != '' && $obj['dateEnd'] == ''){
			$dataSearch = "and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".DATE."'";
		}elseif($obj['dateStart'] != '' && $obj['dateEnd'] != ''){
			$dataSearch = "and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".$obj['dateEnd']."'";
		}

		if($this->input->get("method") == 'post'){
			$query = $this->db->query("select *,DATE_FORMAT(orders.date,'%Y-%m-%d') as orDATE,sum(orders.total) as sum_total,sum(orders.quantity) as orQTY,sum(orders.vat) as orVAT from orders where orders.order_status_id = 4 ".$dataSearch." group by DATE_FORMAT(orders.date,'%Y-%m-%d')")->result_array();
		}else{
			$query = $this->db->query("select *,sum(orders.total) as sum_total from orders where orders.order_status_id = 4 and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".DATE."' and '".DATE."' group by DATE_FORMAT(orders.date,'%Y-%m-%d')")->result_array();
		}
		return $query;
	}

	/*select *,sum(orders.total) as sum_total,sum(orders.quantity) as quantity,sum(orders.vat) as vat
from orders
left join order_status_history on(order_status_history.order_id = orders.order_status_id)
where order_status_history.order_status_id = 4 and
DATE_FORMAT(orders.date,'%Y-%m-%d') Between '2017-05-05' and '2017-05-10' group by orders.date*/

}
