<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Class : BaseController
 * Base Class to control over all the classes
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class BaseController extends CI_Controller {
	protected $role = '';
	protected $vendorId = '';
	protected $name = '';
	protected $roleText = '';
	protected $menu_group_id = '';
	protected $global = array ();

	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data
	 *        	Data to output to the user
	 *        	running the script; otherwise, exit
	 */
	public function response($data = NULL) {
		$this->output->set_status_header ( 200 )->set_content_type ( 'application/json', 'utf-8' )->set_output ( json_encode ( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )->_display ();
		exit ();
	}

	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn() {
		$isLoggedIn = $this->session->userdata ( 'isLoggedIn' );

		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( 'login' );
		}
		else {
			$this->role = $this->session->userdata ( 'role' );
			$this->vendorId = $this->session->userdata ( 'userId' );
			$this->name = $this->session->userdata ( 'name' );
			$this->roleText = $this->session->userdata ( 'roleText' );
			$this->menu_group_id = $this->session->userdata ( 'menu_group_id' );

			$this->global ['name'] = $this->name;
			$this->global ['role'] = $this->role;
			$this->global ['menu_group_id'] = $this->menu_group_id;
			$this->global ['role_text'] = $this->roleText;
		}
	}

	/**
	 * This function is used to check the access
	 */
	function isAdmin() {
		if ($this->role != ROLE_ADMIN) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function is used to check the access
	 */
	function isTicketter() {
		if ($this->role != ROLE_ADMIN || $this->role != ROLE_MANAGER) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function is used to load the set of views
	 */
	function loadThis() {
		$data['global'] = $this->global;
		$data['menu_id'] ='0';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
		$data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
		$data['content'] = 'access';
		//if script file
		//$data['script_file'] = '';
		$data['header'] = array('title' => 'Access Denied | '.$this->config->item('sitename'),
														'description' =>  'Access Denied  | '.$this->config->item('tagline'),
														'author' => $this->config->item('author'),
														'keyword' =>  'Dashboard');
		$this->load->view('template/layout_main', $data);

	}

	/**
	 * This function is used to logged out user from system
	 */
	function logout() {
		$this->session->sess_destroy ();

		redirect ( 'login' );
	}

	/**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */
    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){

        $this->load->view('includes/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('includes/footer', $footerInfo);
    }

	/**
	 * This function used provide the pagination resources
	 * @param {string} $link : This is page link
	 * @param {number} $count : This is page count
	 * @param {number} $perPage : This is records per page limit
	 * @return {mixed} $result : This is array of records and pagination data
	 */
	function paginationCompress($link, $count, $perPage = 10) {
		$this->load->library ( 'pagination' );

		$config ['base_url'] = base_url () . $link;
		$config ['total_rows'] = $count;
		$config ['uri_segment'] = SEGMENT;
		$config ['per_page'] = $perPage;
		$config ['num_links'] = 5;
		$config ['full_tag_open'] = '<nav><ul class="pagination">';
		$config ['full_tag_close'] = '</ul></nav>';
		$config ['first_tag_open'] = '<li class="arrow">';
		$config ['first_link'] = 'First';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link'] = 'Previous';
		$config ['prev_tag_open'] = '<li class="arrow">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_link'] = 'Next';
		$config ['next_tag_open'] = '<li class="arrow">';
		$config ['next_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li class="arrow">';
		$config ['last_link'] = 'Last';
		$config ['last_tag_close'] = '</li>';

		$this->pagination->initialize ( $config );
		$page = $config ['per_page'];
		$segment = $this->uri->segment ( SEGMENT );

		return array (
				"page" => $page,
				"segment" => $segment
		);
	}

	function pagination_compress($link, $count, $perPage = 10) {
		$this->load->library ( 'pagination' );
		$config['base_url'] = base_url(). $link;
		$config['total_rows'] = $count;
		$config['per_page'] = $perPage;
				/* This Application Must Be Used With BootStrap 3 *  */
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);
		$links_pagination = $this->pagination->create_links();
		return $links_pagination ;
	}

	function isAccessMenu($menu_list,$menuId)
	{
		$isAccess = array("is_access" => FALSE,
		 									"is_view" => FALSE,
											"is_add" => FALSE,
										  "is_edit" =>FALSE );
    foreach ($menu_list as $menu) {
      if($menu['menu_id'] == $menuId){
					$isAccess['is_access'] = TRUE;
					$isAccess['is_view'] = $menu['is_view'];
					$isAccess['is_add'] = $menu['is_add'];
					$isAccess['is_edit'] = $menu['is_edit'];
          break;
      }
    }
		return $isAccess;
	}
}
