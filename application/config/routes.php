<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['products'] = "products/index";
$route['product/(:any)'] = "product/index/$1";
$route['products/add'] = "products/add";
$route['search'] = "products/search";  

$route['invoice/(:any)'] = "invoice/index/$1";
$route['fullinvoice/(:any)'] = "fullinvoice/index/$1";
$route['po_invoice/(:any)'] = "po_invoice/index/$1";
$route['status/(:any)'] = "status/index/$1";
$route['po_status/(:any)'] = "po_status/index/$1";        

$route['dashboard'] = "dashboard/index";
$route['signout'] = "login/logout";
$route['signin'] = "login/cek_login";
$route['login'] = "login";

$route['fixmac'] = "fixmac/index";
$route['fixmac/(:any)'] = "fixmac/index/$1";
$route['searchfix'] = "fixmac/search";  


$route['default_controller'] = 'home';
$route['404_override'] = 'notfound';
$route['translate_uri_dashes'] = TRUE;

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8


/* End of file routes.php */
/* Location: ./application/config/routes.php */