<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('initdata_model');
        $this->load->model('user_model');

        $this->load->model('menugroup_model');
        $this->load->library('pagination');
        $this->load->helper(array('form', 'url','cias_helper'));
        $this->load->library('my_upload');
        $this->load->library('upload');
        $this->is_logged_in();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $data['menus_list'] = $this->initdata_model->get_menu();
        $data['menu_id'] ='36';
        $data['content'] = 'dashboard';
        //if script file
        //$data['script_file'] = '';
        $data['header'] = array('title' => 'Dashboard | '.$this->config->item('sitename'),
                                                  'description' =>  'Dashboard | '.$this->config->item('tagline'),
                                                  'author' => $this->config->item('author'),
                                                  'keyword' =>  'Dashboard');

        $this->load->view('template/layout', $data);
    }

    /**
     * This function is used to load the user list
     */
    public function userListing()
    {
        $data['menus_list'] = $this->initdata_model->get_menu();
        $data['menu_id'] ='36';

        $this->load->model('user_model');
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;
        $this->load->library('pagination');
        $count = $this->user_model->userListingCount($searchText);
        $returns = $this->paginationCompress("userListing/", $count, 5);
        $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
        $data['content'] = 'users';
        //if script file
        //$data['script_file'] = '';
        $data['header'] = array('title' => 'list users | '.$this->config->item('sitename'),
                                'description' =>  'list users  | '.$this->config->item('tagline'),
                                'author' => $this->config->item('author'),
                                'keyword' =>  'Dashboard');
        $this->load->view('template/layout', $data);
    }

    /**
     * This function is used to load the add new form
     */
    public function addNew()
    {
        $data['menus_list'] = $this->initdata_model->get_menu();
        $data['menu_id'] ='36';
        $this->load->model('user_model');
        $data['roles'] = $this->user_model->getUserRoles();
        $data['menu_group'] = $this->menugroup_model->get_menugroup_all();
        $data['content'] = 'addNew';
        $data['header'] = array('title' => 'Add New User | '.$this->config->item('sitename'),
                                    'description' =>  'Add New User | '.$this->config->item('tagline'),
                                    'author' => $this->config->item('author'),
                                    'keyword' =>  'Dashboard');
        $this->load->view('template/layout', $data);
    }

    /**
     * This function is used to check whether email already exist or not
     */
    public function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if (empty($userId)) {
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if (empty($result)) {
            echo("true");
        } else {
            echo("false");
        }
    }

    /**
     * This function is used to add new user to the system
     */
    public function addNewUser()
    {
        $data['menus_list'] = $this->initdata_model->get_menu();
        $data['menu_id'] ='36';

        $this->load->library('form_validation');

        $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|max_length[128]');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]|max_length[20]');
        $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');
        $this->form_validation->set_rules('menu_group_id', 'Menu Group', 'trim|required|numeric');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]|xss_clean');

        if ($this->form_validation->run() == false) {
            $this->addNew();
        } else {
            $name = ucwords(strtolower($this->input->post('fname')));
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $roleId = $this->input->post('role');
            $mobile = $this->input->post('mobile');
            $menu_group_id = $this->input->post('menu_group_id');

            $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,'menu_group_id'=> $menu_group_id,
                                    'mobile'=>$mobile, 'createdBy'=>'1', 'createdDtm'=>date('Y-m-d H:i:s'));

            $this->load->model('user_model');
            $result = $this->user_model->addNewUser($userInfo);

            if ($result > 0) {
                $this->session->set_flashdata('success', 'New User created successfully');
            } else {
                $this->session->set_flashdata('error', 'User creation failed');
            }

            redirect('addNew');
        }
    }

    public function editOld($userId = null)
    {
        $data['menus_list'] = $this->initdata_model->get_menu();
        $data['menu_id'] ='36';
        if ($userId == null) {
            redirect('userListing');
        }

        $data['roles'] = $this->user_model->getUserRoles();
        $data['menu_group'] = $this->menugroup_model->get_menugroup_all();
        $data['userInfo'] = $this->user_model->getUserInfo($userId);

        $data['content'] = 'editOld';
        $data['header'] = array('title' => 'Edit User | '.$this->config->item('sitename'),
                                    'description' =>  'Edit User | '.$this->config->item('tagline'),
                                    'author' => $this->config->item('author'),
                                    'keyword' =>  'Dashboard');
        $this->load->view('template/layout', $data);
    }


    /**
     * This function is used to edit the user information
     */
    public function editUser()
    {
        $data['menus_list'] = $this->initdata_model->get_menu();
        $data['menu_id'] ='36';

        $this->load->library('form_validation');

        $userId = $this->input->post('userId');

        $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|max_length[128]');
        $this->form_validation->set_rules('password', 'Password', 'matches[cpassword]|max_length[20]');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'matches[password]|max_length[20]');
        $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');
        $this->form_validation->set_rules('menu_group_id', 'Menu Group', 'trim|required|numeric');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]|xss_clean');

        if ($this->form_validation->run() == false) {
            $this->editOld($userId);
        } else {
            $name = ucwords(strtolower($this->input->post('fname')));
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $roleId = $this->input->post('role');
            $mobile = $this->input->post('mobile');
            $menu_group_id = $this->input->post('menu_group_id');

            $userInfo = array();

            if (empty($password)) {
                $userInfo = array('email'=>$email, 'roleId'=>$roleId, 'name'=>$name,'menu_group_id'=>$menu_group_id,
                                    'mobile'=>$mobile, 'updatedBy'=>'1', 'updatedDtm'=>date('Y-m-d H:i:s'));
            } else {
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'menu_group_id'=>$menu_group_id,
                        'name'=>ucwords($name), 'mobile'=>$mobile, 'updatedBy'=>'1',
                        'updatedDtm'=>date('Y-m-d H:i:s'));
            }

            $result = $this->user_model->editUser($userInfo, $userId);

            if ($result == true) {
                $this->session->set_flashdata('success', 'User updated successfully');
            } else {
                $this->session->set_flashdata('error', 'User updation failed');
            }

            redirect('userListing');
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    public function deleteUser()
    {
        $userId = $this->input->post('userId');
        $userInfo = array('isDeleted'=>1,'updatedBy'=>'1', 'updatedDtm'=>date('Y-m-d H:i:s'));

        $result = $this->user_model->deleteUser($userId, $userInfo);

        if ($result > 0) {
            echo(json_encode(array('status'=>true)));
        } else {
            echo(json_encode(array('status'=>false)));
        }
    }

    /**
     * This function is used to load the change password screen
     */
    public function loadChangePass()
    {
        $data['menus_list'] = $this->initdata_model->get_menu();
        $data['menu_id'] ='36';
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        $data['content'] = 'changePassword';
        $data['header'] = array('title' => 'Change Password | '.$this->config->item('sitename'),
                                'description' =>  'Change Password | '.$this->config->item('tagline'),
                                'author' => $this->config->item('author'),
                                'keyword' =>  'Dashboard');
        $this->load->view('template/layout', $data);
    }


    /**
     * This function is used to change the password of the user
     */
    public function changePassword()
    {
        $data['menus_list'] = $this->initdata_model->get_menu();
        $data['menu_id'] ='36';
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPassword', 'Old password', 'required|max_length[20]');
        $this->form_validation->set_rules('newPassword', 'New password', 'required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword', 'Confirm new password', 'required|matches[newPassword]|max_length[20]');

        if ($this->form_validation->run() == false) {
            $this->loadChangePass();
        } else {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');

            $resultPas = $this->user_model->matchOldPassword('1', $oldPassword);

            if (empty($resultPas)) {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('loadChangePass');
            } else {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>'1',
                                'updatedDtm'=>date('Y-m-d H:i:s'));

                $result = $this->user_model->changePassword('1', $usersData);

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'Password updation successful');
                } else {
                    $this->session->set_flashdata('error', 'Password updation failed');
                }

                redirect('loadChangePass');
            }
        }
    }

    public function pageNotFound()
    {
        $data['menus_list'] = $this->initdata_model->get_menu();
        $data['menu_id'] ='36';
        $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
        $data['access_menu'] = $this->isAccessMenu($data['menu_list'], $data['menu_id']);
        $data['content'] = '404';
        $data['header'] = array('title' => '404 - Page Not Found | '.$this->config->item('sitename'),
                              'description' =>  '404 - Page Not Found | '.$this->config->item('tagline'),
                              'author' => $this->config->item('author'),
                              'keyword' =>  'Dashboard');
        $this->load->view('template/layout', $data);
    }

    public function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        $chk_admin =  $this->session->userdata('permission');
        if (!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin') {
            redirect('login');
        }
    }
}
