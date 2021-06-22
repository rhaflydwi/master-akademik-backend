<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'auth'], function() use($router) {
    $router->delete('/users/{id}', 'UserController@destroy');
    $router->put('/users/{id}', 'UserController@update');
    $router->get('/users/login', 'UserController@getUserLogin');
    $router->get('/users/{id}', 'UserController@edit');
    $router->get('/users', 'UserController@index');
    $router->post('/users', 'UserController@store');
    $router->post('/logout', 'UserController@logout');
    $router->get('/useradmin', 'UserController@admin');
    $router->get('/userguru', 'UserController@guru');
    $router->get('/usersiswa', 'UserController@siswa');
    $router->get('/userpetugas_tata_usaha', 'UserController@petugas_tata_usaha');
    $router->get('/userpetugas_laboratorium', 'UserController@petugas_laboratorium');
    $router->get('/userpetugas_perpustakaan', 'UserController@petugas_perpustakaan');
    $router->get('/userkepala_sekolah', 'UserController@kepala_sekolah');
    // routes buku
    $router->get('/buku/login', 'UserController@getBukuLogin');
    $router->get('/buku/{id}', 'BukuController@edit');
    $router->get('/buku', 'BukuController@index'); 
    $router->post('/buku', 'BukuController@store');
    $router->delete('/buku/{id}', 'BukuController@destroy');
    $router->put('/buku/{id}', 'BukuController@update');
    $router->get('/count', 'UserController@count');

    // routes Jadwal Siswa
    $router->get('/jadwalsiswa', 'JadwalSiswaController@index');
    $router->post('/jadwalsiswa', 'JadwalSiswaController@store');
    $router->delete('/jadwalsiswa/{id}', 'JadwalSiswaController@destroy');
    $router->put('/jadwalsiswa/{id}', 'JadwalSiswaController@update');
    $router->get('/jadwalsiswa/{id}', 'JadwalSiswaController@edit');
    $router->get('/jadwalsiswavii', 'JadwalSiswaController@kelasvii');
    $router->get('/jadwalsiswaviii', 'JadwalSiswaController@kelasviii');
    $router->get('/jadwalsiswaix', 'JadwalSiswaController@kelasix');

    //laboratorium
    $router->get('/laboratorium/{id}', 'LaboratoriumController@edit');
    $router->get('/laboratorium', 'LaboratoriumController@index'); 
    $router->post('/laboratorium', 'LaboratoriumController@store');
    $router->delete('/laboratorium/{id}', 'LaboratoriumController@destroy');
    $router->put('/laboratorium/{id}', 'LaboratoriumController@update');

    //presensi siswa

    $router->get('/presensi/{id}','PresensiController@index');
    $router->get('/presensi','PresensiController@all');
    $router->post('/presensi/absen-masuk','PresensiController@absenMasuk');

    //presensi guru

    $router->get('/presensiguru/{id}','PresensiGuruController@index');
    $router->get('/presensiguru','PresensiGuruController@all');
    $router->post('/presensiguru/absen-masuk','PresensiGuruController@absenMasuk');

    // Data Nilai
    $router->post('/datanilai/masuk','NilaiSiswaController@store');
    $router->get('/datanilai/{id}','NilaiSiswaController@index');
    $router->get('/datanilai/a/kelasvii', 'NilaiSiswaController@kelasvii');
    $router->get('/datanilai/a/kelasviii', 'NilaiSiswaController@kelasviii');
    $router->get('/datanilai/a/kelasxi', 'NilaiSiswaController@kelasxi');
    $router->get('/datanilai','NilaiSiswaController@all');
    $router->put('/datanilai/{id}', 'NilaiSiswaController@update');
    $router->get('/datanilai/{id}', 'NilaiSiswaController@edit');
    $router->delete('/datanilai/delete/{id}', 'NilaiSiswaController@destroy');

        
        

    
    // // routes buku
    // $router->get('/buku/{id}', 'BukuController@edit');
    // $router->get('/buku', 'BukuController@index'); 
    // $router->post('/buku', 'BukuController@store');
    // $router->delete('/buku/{id}', 'BukuController@destroy');
    // $router->put('/buku/{id}', 'BukuController@update');


});
$router->post('/login', 'UserController@login');
$router->post('/reset', 'UserController@sendResetToken');
$router->put('/reset/{token}', 'UserController@verifyResetPassword');

