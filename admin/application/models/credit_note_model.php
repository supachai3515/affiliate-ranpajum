
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Credit_note_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_credit_note($start, $limit)
    {
        $sql ="SELECT  rr.*,
	    		o.id order_id, o.invoice_docno invoice_no,
					o.date order_date,
					s.serial_number,
					o.`name` order_name,
					o.address,
					s.serial_number,
					p.id product_id,
					p.name product_name,
					p.sku,
					o1.id order_id_new,
						o1.invoice_docno invoice_docno_new,
					o1.`name` order_name_new,
					o1.address	order_address_new,
					pm.create_date payment_date
					FROM credit_note  rr INNER JOIN orders o ON rr.order_id = o.id
					INNER JOIN products p on p.id = rr.product_id
					LEFT JOIN product_serial s ON s.product_id = rr.product_id  AND s.order_id = o.id AND rr.serial = s.serial_number
					LEFT JOIN payment pm ON pm.credit_note_id = rr.id
					LEFT JOIN orders o1 ON o1.id = pm.order_id
				 	ORDER BY rr.id DESC  LIMIT " . $start . "," . $limit;
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_credit_note_count()
    {
        $sql =" SELECT COUNT(id) as connt_id FROM  credit_note p";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }


    public function get_credit_note_id($credit_note_id)
    {
        $sql ="SELECT cr.*,
					o.invoice_docno,
					o.is_tax,
					o.tax_company,
					o.tax_address,
					o.tel,
					o.email,
					o.tax_id,
					o.name,
					o.address,
					o.customer_id
					FROM credit_note  cr
					INNER JOIN orders o ON cr.order_id = o.id
					WHERE cr.id = '".$credit_note_id."'";

        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function get_credit_note_detail($credit_note_id)
    {
        $sql ="SELECT  cr.product_id,
					p.sku,
					p.slug,
				  p.`name` product_name,
					od.price,
					od.price total
					FROM credit_note  cr
					INNER JOIN order_detail od ON cr.product_id = od.product_id AND cr.order_id = od.order_id
					INNER JOIN products p ON  p.id = cr.product_id
					WHERE cr.id = '".$credit_note_id."'";

        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }


    public function get_credit_note_search()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_credit_note = array(
            'search' => $this->input->post('search')
        );

        $sql ="SELECT  rr.*,
	    		o.id order_id, o.invoice_docno invoice_no,
					o.date order_date,
					s.serial_number,
					o.`name` order_name,
					o.address,
					s.serial_number,
					p.id product_id,
					p.name product_name,
					p.sku,
					o1.id order_id_new,
						o1.invoice_docno invoice_docno_new,
					o1.`name` order_name_new,
					o1.address	order_address_new,
					pm.create_date payment_date
					FROM credit_note  rr INNER JOIN orders o ON rr.order_id = o.id
					INNER JOIN products p on p.id = rr.product_id
					LEFT JOIN product_serial s ON s.product_id = rr.product_id  AND s.order_id = o.id AND rr.serial = s.serial_number
					LEFT JOIN payment pm ON pm.credit_note_id = rr.id
					LEFT JOIN orders o1 ON o1.id = pm.order_id
			 WHERE rr.docno LIKE '%".$data_credit_note['search']."%' OR  o.id LIKE '%".$data_credit_note['search']."%'  OR  s.serial_number LIKE '%".$data_credit_note['search']."%'  OR o.name LIKE '%".$data_credit_note['search']."%'  ";
        $re = $this->db->query($sql);
        $return_data['result_credit_note'] = $re->result_array();
        $return_data['data_search'] = $data_credit_note;
        $return_data['sql'] = $sql;
        return $return_data;
    }

    public function update_credit_note($credit_note_id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_credit_note = array(
            'serial' => $this->input->post('serial'),
            'comment' => $this->input->post('comment'),
            'modified_date' => date("Y-m-d H:i:s"),
            'is_active' => $this->input->post('is_active'),
            'is_refund' => $this->input->post('is_refund')
        );
        $where = array(
            'id' => $credit_note_id,
        );
        $this->db->update("credit_note", $data_credit_note, $where);

        $is_active = $this->input->post('is_active');
        if ($is_active) {
            $serial = $this->input->post('serial');
            if (isset($serial)) {
                //update history
                date_default_timezone_set("Asia/Bangkok");
                $data_serial_history = array(
                        'serial_number' =>$this->input->post('serial'),
                        'product_id' => $this->input->post('product_id'),
                        'comment' => "ยันยันใบลดหนี้ เลขที่ใบลดหนี้ #".$this->input->post('docno'),
                        'create_date' => date("Y-m-d H:i:s"),
                );
                $this->db->insert("serial_history", $data_serial_history);
            }
        } else {
            $serial = $this->input->post('serial');
            if (isset($serial)) {
                //update history
                date_default_timezone_set("Asia/Bangkok");
                $data_serial_history = array(
                        'serial_number' =>$this->input->post('serial'),
                        'product_id' => $this->input->post('product_id'),
                        'comment' => "ยกเลิกใบลดหนี้ เลขที่ใบลดหนี้ #".$this->input->post('docno'),
                        'create_date' => date("Y-m-d H:i:s"),
                );
                $this->db->insert("serial_history", $data_serial_history);
            }
        }
    }

    public function save_credit_note()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_credit_note = array(
            'return_id' => $this->input->post('return_id'),
            'order_id' => $this->input->post('order_id'),
            'product_id' => $this->input->post('product_id'),
            'serial' => $this->input->post('serial'),
            'comment' => $this->input->post('comment'),
            'create_date' => date("Y-m-d H:i:s"),
            'modified_date' => date("Y-m-d H:i:s"),
            'is_active' => $this->input->post('isactive'),
            'is_refund' => $this->input->post('is_refund')
        );

        $this->db->insert("credit_note", $data_credit_note);
        $insert_id = $this->db->insert_id();


        date_default_timezone_set("Asia/Bangkok");
        $data_order = array(
            'docno' => 'CN'.date("ymd").str_pad($insert_id, 4, "0", STR_PAD_LEFT)
        );

        $where = array('id' => $insert_id);
        $this->db->update("credit_note", $data_order, $where);

        $serial = $this->input->post('serial');
        if (isset($serial)) {
            //update history
            date_default_timezone_set("Asia/Bangkok");
            $data_serial_history = array(
                    'serial_number' =>$this->input->post('serial'),
                    'product_id' => $this->input->post('product_id'),
                    'comment' => "ยันยันใบลดหนี้ เลขที่ใบลดหนี้ #".$data_order['docno'],
                    'create_date' => date("Y-m-d H:i:s"),
            );
            $this->db->insert("serial_history", $data_serial_history);
        }

        return  $insert_id;
    }

    public function update_img($id, $image_name)
    {
        $sql ="SELECT note_img FROM credit_note WHERE  id ='".$id."' ";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if (isset($row["note_img"])) {
            unlink($row["note_img"]);
        }


        $dataIMG = array(
            'note_img' => $img_path.$image_name
        );
        $where = "id = '".$id."'";
        $this->db->update('credit_note', $dataIMG, $where);
    }

    public function get_search_order($search_txt)
    {
        $sql =" SELECT rr.order_id,
				rr.id return_id,
				rr.docno return_docno,
				o.invoice_docno invoice_no,
				o.name order_name,
				rr.create_date create_date,
				rr.serial serial_number,
				p.id product_id,
				p.name product_name,
				p.sku,
				od.price product_price,
				(SELECT COUNT(return_id) FROM credit_note WHERE is_active = 1 AND return_id = rr.id) is_credit_note,
				(SELECT COUNT(return_id) FROM delivery_return WHERE is_active = 1 AND return_id = rr.id) is_delivery_return
				FROM return_receive rr
				INNER JOIN orders o ON o.id = rr.order_id
				INNER JOIN products p on p.id = rr.product_id
				INNER JOIN order_detail od ON od.order_id = o.id AND od.product_id = rr.product_id


				WHERE o.id  LIKE '%".$search_txt."%'
					OR o.`name`  LIKE '%".$search_txt."%'
					OR p.`name`  LIKE '%".$search_txt."%'
					OR o.`address`  LIKE '%".$search_txt."%'
					OR o.`email`  LIKE '%".$search_txt."%'
					OR o.`tel`  LIKE '%".$search_txt."%'
					OR o.`invoice_docno`  LIKE '%".$search_txt."%'
					OR p.`id`  LIKE '%".$search_txt."%'
					OR rr.serial  LIKE '%".$search_txt."%'
					OR p.`sku`  LIKE '%".$search_txt."%'

			";
        $re = $this->db->query($sql);
        $return_data = $re->result_array();
        return $return_data;
    }
}

/* End of file credit_note_model.php */
/* Location: ./application/models/credit_note_model.php */
