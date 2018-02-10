<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";
class Credit_note extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('initdata_model');
        $this->load->model('credit_note_model');
        $this->load->model('products_model');
        $this->load->library('my_upload');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $count = $this->credit_note_model->get_credit_note_count();
            $data["links_pagination"] = $this->pagination_compress("credit_note/index", $count, $this->config->item("pre_page"));
            $data["credit_note_list"] = $this->credit_note_model->get_credit_note($page, $this->config->item("pre_page"));
            $data["links_pagination"] = $this->pagination->create_links();
            $data['type_list'] = $this->products_model->get_type();
            $data["content"] = "credit_note/credit_note";
            $data['script_file']= "js/credit_note_js";
            $data["header"] = $this->get_header("credit_note");
            $this->load->view("template/layout_main", $data);
        }
    }


    //page search
    public function search()
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $return_data = $this->credit_note_model->get_credit_note_search();
            $data['credit_note_list'] = $return_data['result_credit_note'];
            $data['data_search'] = $return_data['data_search'];
            $data["content"] = "credit_note/credit_note";
            $data['script_file']= "js/credit_note_js";
            $data["header"] = $this->get_header("credit note");
            $this->load->view("template/layout_main", $data);
        }
    }

    //page edit
    public function edit($credit_note_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['credit_note_data'] = $this->credit_note_model->get_credit_note_id($credit_note_id);
            $data['credit_note_detail'] = $this->credit_note_model->get_credit_note_detail($credit_note_id);
            $data['type_list'] = $this->products_model->get_type();
            $data["content"] = "credit_note/credit_note_edit";
            $data['script_file']= "js/credit_note_js";
            $data["header"] = $this->get_header("credit note");
            $this->load->view("template/layout_main", $data);
        }
    }

    public function edit_view($credit_note_id, $print_f = 0)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $data['print_f'] = $print_f;
            $data['credit_note_data'] = $this->credit_note_model->get_credit_note_id($credit_note_id);
            $data['credit_note_detail'] = $this->credit_note_model->get_credit_note_detail($credit_note_id);
            $data['type_list'] = $this->products_model->get_type();
            $data["content"] = "credit_note/credit_note_view";
            $data['script_file']= "js/credit_note_js";
            $data["header"] = $this->get_header("credit note");
            $this->load->view("credit_note/credit_note_view", $data);
        }
    }

    // update
    public function update($credit_note_id)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            date_default_timezone_set("Asia/Bangkok");
            //save credit_note
            $this->credit_note_model->update_credit_note($credit_note_id);

            $image_name = "";
            $dir ='./../uploads/credit_note/'.date("Ym").'/';
            $dir_insert ='uploads/credit_note/'.date("Ym").'/';

            if ($credit_note_id != "") {
                if ($this->input->post('is_refund') == 1) {
                    $this->my_upload->upload($_FILES["image_fieldedit"]);
                    if ($this->my_upload->uploaded == true) {
                        $this->my_upload->allowed         = array('image/*');
                        $this->my_upload->file_name_body_pre = 'thumb_';
                        //$this->my_upload->file_new_name_body    = 'image_resized_' . $now;
                        $this->my_upload->image_resize          = true;
                        $this->my_upload->image_x               = 800;
                        $this->my_upload->image_ratio_y         = true;
                        $this->my_upload->process($dir);

                        if ($this->my_upload->processed == true) {
                            $image_name  = $this->my_upload->file_dst_name;
                            $this->credit_note_model->update_img($credit_note_id, $dir_insert.$image_name);

                            $this->my_upload->clean();
                        } else {
                            $data['errors'] = $this->my_upload->error;
                            echo $data['errors'];
                        }
                    } else {
                        $data['errors'] = $this->my_upload->error;
                    }
                } else {
                    $this->credit_note_model->update_img($credit_note_id, '');
                }
            }

            if ($credit_note_id!="") {
                redirect('credit_note/edit/'.$credit_note_id);
            } else {
                redirect('credit_note');
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
            $credit_note_id ="";
            $credit_note_id = $this->credit_note_model->save_credit_note();

            $image_name = "";
            $dir ='./../uploads/credit_note/'.date("Ym").'/';
            $dir_insert ='uploads/credit_note/'.date("Ym").'/';

            if ($credit_note_id != "") {
                if ($this->input->post('is_refund') == 1) {
                    $this->my_upload->upload($_FILES["image_field"]);
                    if ($this->my_upload->uploaded == true) {
                        $this->my_upload->allowed         = array('image/*');
                        $this->my_upload->file_name_body_pre = 'thumb_';
                        //$this->my_upload->file_new_name_body    = 'image_resized_' . $now;
                        $this->my_upload->image_resize          = true;
                        $this->my_upload->image_x               = 800;
                        $this->my_upload->image_ratio_y         = true;
                        $this->my_upload->process($dir);

                        if ($this->my_upload->processed == true) {
                            $image_name  = $this->my_upload->file_dst_name;
                            $this->credit_note_model->update_img($credit_note_id, $dir_insert.$image_name);

                            $this->my_upload->clean();
                        } else {
                            $data['errors'] = $this->my_upload->error;
                            echo $data['errors'];
                        }
                    } else {
                        $data['errors'] = $this->my_upload->error;
                    }
                }
            }

            if ($credit_note_id !="") {
                redirect('credit_note/edit/'.$credit_note_id);
            } else {
                redirect('credit_note');
            }
        }
    }


    public function get_search_order()
    {
        $value = json_decode(file_get_contents("php://input"));
        $data['search_order'] =  $this->credit_note_model->get_search_order($value->search);
        print json_encode($data['search_order']);
    }

}

/* End of file credit_note.php */
/* Location: ./application/controllers/credit_note.php */
