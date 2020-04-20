<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'Petugascontroller@register');
Route::post('login', 'Petugascontroller@login');
    Route::get('/', function(){
        return Auth::user()->level;
    })->middleware('jwt.verify');

    Route::get('user', 'Petugascontroller@getAuthenticatedUser');

Route::post('/simpan_anggota', 'Anggotacontroller@store')->middleware('jwt.verify'); 
Route::put('/ubah_anggota/{id}', 'Anggotacontroller@update')->middleware('jwt.verify');
Route::delete('/hapus_anggota/{id}', 'Anggotacontroller@destroy')->middleware('jwt.verify');
Route::get('/tampil_anggota', 'Anggotacontroller@tampil')->middleware('jwt.verify');

Route::post('/simpan_mobil', 'Mobilcontroller@store')->middleware('jwt.verify');
Route::put('/ubah_mobil/{id}', 'Mobilcontroller@update')->middleware('jwt.verify');
Route::delete('/hapus_mobil/{id}', 'Mobilcontroller@destroy')->middleware('jwt.verify');
Route::get('/tampil_mobil', 'Mobilcontroller@tampil')->middleware('jwt.verify');

Route::post('/simpan_penyewaan', 'Penyewaancontroller@store')->middleware('jwt.verify');
Route::put('/ubah_penyewaan/{id}', 'Penyewaancontroller@update')->middleware('jwt.verify');
Route::delete('/hapus_penyewaan/{id}', 'Penyewaancontroller@destroy')->middleware('jwt.verify');
Route::get('/tampil_penyewaan', 'Penyewaancontroller@tampil')->middleware('jwt.verify');

Route::get('/report/{tgl}/{tgl_kembali}', 'Penyewaancontroller@report')->middleware('jwt.verify');

Route::post('/simpan_detail', 'Penyewaancontroller@simpan')->middleware('jwt.verify');
Route::put('/ubah_detail/{id}', 'Penyewaancontroller@ubah')->middleware('jwt.verify');
Route::delete('/hapus_detail/{id}', 'Penyewaancontroller@hapus')->middleware('jwt.verify');