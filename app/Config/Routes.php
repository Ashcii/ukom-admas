<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/login', 'MasyarakatLogin::login');
$routes->post('/login', 'MasyarakatLogin::loginAuth');
$routes->get('/daftar', 'MasyarakatLogin::daftar');
$routes->post('/daftar', 'MasyarakatLogin::daftarAuth');
$routes->get('/logout', 'MasyarakatLogin::logout');

$routes->get('/profil', 'User::profil');
$routes->post('/profil/edit', 'User::editProfil');
$routes->post('/profil/ganti-password', 'User::gantiPassword');

$routes->get('/', 'Pengaduan::index');
$routes->get('/(:num)', 'Pengaduan::profil/$1');
$routes->get('/buat-pengaduan', 'Pengaduan::buatPengaduan', ['filter' => 'masyarakat']);
$routes->post('/buat-pengaduan/tambah', 'Pengaduan::tambahPengaduan', ['filter' => 'masyarakat']);
$routes->get('/detail/(:num)', 'Pengaduan::detailPengaduan/$1');
$routes->post('/detail/edit/(:num)', 'Pengaduan::editPengaduan/$1', ['filter' => 'masyarakat']);
$routes->post('/detail/hapus/(:num)', 'Pengaduan::hapusPengaduan/$1', ['filter' => 'masyarakat']);

$routes->get('/laporan-belum', 'Pengaduan::laporanBelum');
$routes->get('/laporan-belum/xls', 'Pengaduan::xlsBelum');
$routes->get('/laporan-semua', 'Pengaduan::laporanSemua');
$routes->get('/laporan-semua/xls', 'Pengaduan::xlsSemua');
$routes->get('/laporan-proses', 'Pengaduan::laporanProses');
$routes->get('/laporan-proses/xls', 'Pengaduan::xlsProses');
$routes->get('/laporan-selesai', 'Pengaduan::laporanSelesai');
$routes->get('/laporan-selesai/xls', 'Pengaduan::xlsSelesai');
$routes->post('/detail/ubah-status/(:num)', 'Pengaduan::ubahStatus/$1');
$routes->post('/detail/tambah-tanggapan/(:num)', 'Pengaduan::tambahTanggapan/$1');
$routes->post('/detail/hapus-tanggapan/(:num)', 'Pengaduan::hapusTanggapan/$1');

$routes->get('/manajemen-user', 'Admin::manajemenUser');
$routes->post('/manajemen-user/tambah-masyarakat', 'Admin::tambahMasyarakat');
$routes->post('/manajemen-user/tambah-petugas', 'Admin::tambahPetugas');
$routes->post('/manajemen-user/tambah-admin', 'Admin::tambahAdmin');
$routes->post('/manajemen-user/masyarakat-hapus/(:num)', 'Admin::hapusMasyarakat/$1');
$routes->post('/manajemen-user/masyarakat-edit/(:num)', 'Admin::editMasyarakat/$1');
$routes->post('/manajemen-user/petugas-edit/(:num)', 'Admin::editPetugas/$1');
$routes->post('/manajemen-user/petugas-hapus/(:num)', 'Admin::hapusPetugas/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
