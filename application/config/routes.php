<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Landingpage';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['Artikel/fetch_tag'] = 'Artikel/fetch_tag';
$route['Artikel/(:any)'] = 'Artikel/index/$1';
$route['tag/(:any)'] = 'Artikel/tag/$1';