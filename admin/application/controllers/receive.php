<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";
class Receive extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('receive_model');
        $this->load->model('products_model');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $count = $this->receive_model->get_receive_count();
            $data["links_pagination"] = $this->pagination_compress("receive/index", $count, $this->config->item("pre_page"));
            $data["receive_list"] = $this->receive_model->get_receive($page, $this->config->item("pre_page"));
            $data["links_pagination"] = $this->pagination->create_links();
            $data['script_file']= "js/receive_js";
            $data["content"] = "receive/receive";
            $data["header"] = $this->get_header("receive");
            $this->load->view("template/layout_main", $data);
        }
    }


    //page search
    public function search()
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $return_data = $this->receive_model->get_receive_search();
            $data['receive_list'] = $return_data['result_receive'];
            $data['data_search'] = $return_data['data_search'];
            $data['script_file']= "js/receive_js";
            $data["content"] = "receive/receive";
            $data["header"] = $this->get_header("receive");
            $this->load->view("template/layout_main", $data);
        }
    }

    //page edit
    public function edit($receive_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['receive_data'] = $this->receive_model->get_receive_id($receive_id);
            $data['type_list'] = $this->products_model->get_type();
            $data['script_file']= "js/receive_js";
            $data["content"] = "receive/receive_edit";
            $data["header"] = $this->get_header("receive");
            if ($data['receive_data']['count_use'] < 1) {
                $this->load->view("template/layout_main", $data);
            } else {
                redirect('receive', 'refresh');
            }
        }
    }

    public function edit_view($receive_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['receive_data'] = $this->receive_model->get_receive_id($receive_id);
            $data['type_list'] = $this->products_model->get_type();
            $data['script_file']= "js/receive_js";
            $data["content"] = "receive/receive_view_edit";
            $data["header"] = $this->get_header("receive");
            $this->load->view("receive/receive_view_edit", $data);

        }

    }

    public function view($receive_id)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $data['receive_data'] = $this->receive_model->get_receive_id($receive_id);
            $data['type_list'] = $this->products_model->get_type();
            $data['script_file']= "js/receive_js";
            $data["content"] = "receive/receive_view";
            $data["header"] = $this->get_header("receive");
            $this->load->view("receive/receive_view", $data);

        }
    }


    //page edit
    public function edit_serial($receive_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['receive_data'] = $this->receive_model->get_receive_id($receive_id);
            $data['type_list'] = $this->products_model->get_type();
            $data['script_file']= "js/receive_js";
            $data["content"] = "receive/edit_serial";
            $data["header"] = $this->get_header("receive");
            $this->load->view("template/layout_main", $data);
        }
    }

    // update
    public function update($receive_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save receive
            $this->receive_model->update_receive($receive_id);
            if ($receive_id!="") {
                redirect('receive/edit/'.$receive_id);
            } else {
                redirect('receive');
            }
        }
    }

    // insert
    public function add()
    {
        $data = $this->get_data_check("is_add");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save document
            $receive_id ="";
            $receive_id = $this->receive_model->save_receive();

            if ($document_id !="") {
                redirect('receive/edit/'.$receive_id);
            } else {
                redirect('receive');
            }
        }
    }


    public function get_product()
    {
        $value = json_decode(file_get_contents("php://input"));
        $data['product'] =  $this->receive_model->get_product($value->sku);
        print json_encode($data['product']);
    }

    public function get_compare_serial()
    {

      $method = $_SERVER['REQUEST_METHOD'];

      if ($method != 'POST') {
          json_output(400, array('status' => 400,'message' => 'Bad request.'));
      } else {
            $data_info = json_decode(file_get_contents("php://input"));
          //$data_info = json_decode($json_str);
          if ($data_info) {
              $result = $this->receive_model->get_compare_serial($data_info->receive_id);
              if ($result) {
                  json_output(200, array('status' => 200,'message' => $result));
              } else {
                  json_output(400, array('status' => 400,'message' => 'error'));
              }
          }
      }
    }

    public function get_receive_detail()
    {
        $value = json_decode(file_get_contents("php://input"));
        $data['product'] =  $this->receive_model->get_receive_detail($value->id);
        print json_encode($data['product']);
    }

    public function get_product_serial()
    {
        $value = json_decode(file_get_contents("php://input"));
        $data['serial'] =  $this->receive_model->get_product_serial($value->product_id, $value->receive_id);
        print json_encode($data['serial']);
    }

    public function save_serial()
    {
        try {
            $values = json_decode(file_get_contents("php://input"));
            $this->db->trans_start(); # Starting Transaction
            $check_loop = 0 ;
            foreach ($values as $value) {
                if (trim($value->serial_number) != "") {

                       //DOC_NO
                    $sql =" SELECT doc_no  FROM receive  WHERE  id = '".$value->receive_id."'";
                    $re = $this->db->query($sql);
                    $row_doc_no =  $re->row_array();
                    $docno = $row_doc_no['doc_no'];
                    //
                    if ($check_loop == 0) {
                        //check ของเดิม
                        $sql =" SELECT * FROM product_serial ps inner join receive r ON r.id = ps.receive_id
							        WHERE ps.receive_id = '".$value->receive_id."'
											AND ps.product_id = '".$value->product_id."'
											AND ( ps.order_id IS NULL OR  ps.order_id  = '' )";

                        $re = $this->db->query($sql);
                        $row_re =  $re->result_array();

                        foreach ($row_re as $r_ow) {
                            date_default_timezone_set("Asia/Bangkok");
                            $data_serial_history = array(
                                    'serial_number' =>$r_ow['serial_number'],
                                    'product_id' => $r_ow['product_id'],
                                    'comment' => "ลบออก จากใบรับเข้า : #".$docno ,
                                    'create_date' => date("Y-m-d H:i:s"),
                                );
                            $this->db->insert("serial_history", $data_serial_history);

                            //ลบ ของเดิม
                            $sql =" DELETE FROM product_serial WHERE serial_number = '".$r_ow['serial_number']."'
								AND product_id = '".$value->product_id."' ";
                            $re = $this->db->query($sql);
                        }

                        $check_loop++;
                    }

                    $count_use = 0;
                    if (isset($value->count_use)) {
                        $count_use =$value->count_use;
                    }

                    if ($count_use != '1') {
                        //บันทึกใหม่
                        date_default_timezone_set("Asia/Bangkok");
                        $data_product_serial = array(
                                'serial_number' =>$value->serial_number,
                                'line_number' => $value->line_number,
                                'product_id' => $value->product_id,
                                'receive_id' => $value->receive_id,
                                'modified_date' => date("Y-m-d H:i:s"),
                                'create_date' => date("Y-m-d H:i:s"),
                            );

                        $data_serial_history = array(
                                    'serial_number' =>$value->serial_number,
                                    'product_id' => $value->product_id,
                                    'comment' => "บันทึก จากใบรับเข้า : #".$docno,
                                    'create_date' => date("Y-m-d H:i:s"),
                            );

                        $db_debug = $this->db->db_debug; //save setting
                            $this->db->db_debug = false; //disable debugging for queries
                            $this->db->insert("serial_history", $data_serial_history);
                        $this->db->insert("product_serial", $data_product_serial);
                        $this->db->db_debug = $db_debug; //restore setting
                    }
                }
            }

            $this->db->trans_complete(); # Completing transaction
            /*Optional*/

            if ($this->db->trans_status() === false) {
                # Something went wrong.
                $this->db->trans_rollback();
                $res = array('is_error' => true,
                    'message' => "ข้อมูลซ้ำ ไม่สามารถบันทึกได้ กรุณาตรวจสอบ Serial อีกครั้ง",
                    );
                print json_encode($res);
                // return FALSE;
            } else {
                # Everything is Perfect.
                # Committing data to the database.
                $this->db->trans_commit();

                $res = array('is_error' => false,
                    'message' => "บันทึกสำเร็จ",
                );

                print json_encode($res);
                // return TRUE;
            }
        } catch (Exception $e) {
            $res = array('is_error' => true,
                    'message' => $e->getMessage(),
                    );
            print json_encode($res);
        }
    }


    public function line_number()
    {
        $sql ="SELECT receive_id , product_id FROM product_serial GROUP BY receive_id , product_id";
        $query = $this->db->query($sql);
        $re = $query->result_array();
        foreach ($re as $r) {
            $sql ="SELECT *  FROM product_serial WHERE receive_id ='".$r['receive_id']."' AND product_id = '".$r['product_id']."'";
            $query = $this->db->query($sql);
            $re1 = $query->result_array();
            $i= 1;
            foreach ($re1 as $r1) {
                print($i." - ".$r1['serial_number']." - ".$r1['product_id']." - ".$r1['receive_id']."<br/>");

                date_default_timezone_set("Asia/Bangkok");
                $data_update = array(
                'line_number' => $i
            );

                $this->db->update("product_serial", $data_update, "product_id = '".$r1['product_id']."' AND  serial_number = '".$r1['serial_number']."'  AND receive_id = '".$r1['receive_id']."'");
                $i++;
            }
        }
    }
}

/* End of file receive.php */
/* Location: ./application/controllers/receive.php */
