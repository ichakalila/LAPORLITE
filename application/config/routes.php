<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['main'] = 'welcome/login';
$route['logout/(:any)'] = 'welcome/logout/$1';
$route['daftar/(:any)'] = 'welcome/register/$1';
$route['daftarkan'] = 'welcome/sendregister';
$route['lupapasswordload'] = 'welcome/ingatpasswordload';
$route['lupapassword'] = 'welcome/ingatpassword';
$route['ceksesi'] = 'welcome/ceksesi';
$route['beranda'] = 'laporan';
$route['laporanku'] = 'laporan/stream';
$route['notifications'] = 'laporan/lihatnotif';
$route['kirimkomentar'] = 'laporan/kirimkomentar';
$route['laporanku/(:any)'] = 'laporan/streamnext/$1';
$route['laporan/(:any)'] = 'laporan/bacalaporan/$1';
$route['tindaklanjut/(:any)'] = 'laporan/bacatindaklanjut/$1';
$route['kirimtindaklanjut'] = 'laporan/kirimtindaklanjut';
$route['hapus/(:any)'] = 'laporan/hapuslaporan/$1';
$route['streams/(:any)/(:any)'] = 'laporan/laporanselanjutnya/$1/$2';
$route['dukung/(:any)/(:any)'] = 'laporan/dukung/$1/$2';
$route['send'] = 'laporan/kirimlaporan';
$route['ganti'] = 'laporan/gantiprofil';
$route['test/(:any)'] = 'laporan/test/$1';
$route['profil/(:any)'] = 'laporan/profil/$1';
$route['gantiavatar'] = 'laporan/gantiavatar';
$route['gantipassword'] = 'laporan/gantipassword';
$route['gantiemail'] = 'laporan/gantiemail';
$route['test'] = 'test';
$route['teststring'] = 'laporan/teststring';