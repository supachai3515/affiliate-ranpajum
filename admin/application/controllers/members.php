<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Members extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('members_model');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_view']) {
            $count = $this->members_model->get_members_count();
            $data['links_pagination'] = $this->pagination_compress("members/index", $count, $this->config->item('pre_page'));
            $data['members_list'] = $this->members_model->get_members($page, $this->config->item('pre_page'));

            $data['content'] = 'members/members';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'members | '.$this->config->item('sitename'),
                                    'description' =>  'members | '.$this->config->item('tagline'),
                                    'author' => $this->config->item('author'),
                                    'keyword' => 'members');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    //page search
    public function search()
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_view']) {
            $return_data = $this->members_model->get_members_search();
            $data['members_list'] = $return_data['result_members'];
            $data['data_search'] = $return_data['data_search'];
            $data['content'] = 'members/members';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'members | '.$this->config->item('sitename'),
                                    'description' =>  'members | '.$this->config->item('tagline'),
                                    'author' => $this->config->item('author'),
                                    'keyword' => 'members');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    //page edit
    public function edit($member_id)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_edit']) {
            $data['member_data'] = $this->members_model->get_member($member_id);
            $data['content'] = 'members/members_edit';
            //if script file
            $data['script_file']= "js/product_add_js";
            $data['header'] = array('title' => 'members | '.$this->config->item('sitename'),
                                                                    'description' =>  'members | '.$this->config->item('tagline'),
                                                                    'author' => $this->config->item('author'),
                                                                    'keyword' => 'members');
            $this->load->view('template/layout_main', $data);
        } else {
            // access denied
            $this->loadThis();
        }
    }

    // update
    public function update($member_id)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_edit']) {
            date_default_timezone_set("Asia/Bangkok");
            //save member
            $this->members_model->update_member($member_id);

            if ($member_id!="") {
                redirect('members/edit/'.$member_id);
            } else {
                redirect('members');
            }
        } else {
            // access denied
            $this->loadThis();
        }
    }

    // update
    public function confirm($member_id)
    {
        $data['global'] = $this->global;
        $data['menu_id'] = $this->initdata_model->get_menu_id($this->router->fetch_class());
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        if ($data['access_menu']['is_access']&&$data['access_menu']['is_edit']) {
            if ($member_id!="") {
                date_default_timezone_set("Asia/Bangkok");
                $data_member = array(
                                'verify' => '1'
                        );
                $where = "id = '".$member_id."'";
                $this->db->update("members", $data_member, $where);


                $sql =" SELECT * FROM  members WHERE id= '".$member_id."' ";
                $re = $this->db->query($sql);
                $result_dealer =  $re->row_array();

                //sendmail
                $email_config = array(
                                'protocol'  => 'smtp',
                                'smtp_host' => 'ssl://smtp.googlemail.com',
                                'smtp_port' => '465',
                                'smtp_user' => $this->config->item('email_noreply'),
                                'smtp_pass' => $this->config->item('pass_mail_noreply'),
                                'mailtype'  => 'html',
                                'starttls'  => true,
                                'newline'   => "\r\n"
                        );
                $this->load->library('email', $email_config);


                $this->email->from($this->config->item('email_noreply'), $this->config->item('email_name'));
                $this->email->to($result_dealer["email"]);
                $this->email->subject('ได้ยืนยันการสมัคร Dealer เรียบร้อยแล้ว จาก '.$this->config->item('sitename'));
                $this->email->message("ได้ยืนยันการสมัคร Dealer เรียบร้อยแล้ว จาก ".$this->config->item('sitename'));
                if ($this->email->send()) {
                    redirect('members/edit/'.$member_id);
                } else {
                    show_error($this->email->print_debugger());
                }
            } else {
                redirect('members');
            }
        } else {
            // access denied
            $this->loadThis();
        }
    }

}

/* End of file prrducts.php */
/* Location: ./application/controllers/prrducts.php */
