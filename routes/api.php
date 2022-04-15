<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Web App
Route::post('login', 'Api\AuthController@login');

//Mobile App
Route::post('loginPemilik', 'Api\PemilikController@login');
Route::post('loginPenyewa', 'Api\PenyewaController@login');

Route::group(['middleware' => 'auth:api'], function()
{
    ////Web App
        //Route Untuk Pegawai
        Route::get('staff', 'Api\PegawaiController@read');
        Route::get('staff/{id}', 'Api\PegawaiController@search');
        Route::post('staff', 'Api\PegawaiController@add');
        Route::put('staffEdtPass/{id}', 'Api\PegawaiController@editPassword');
        Route::put('staffEdtOtority/{id}', 'Api\PegawaiController@editStOtoritas');
        Route::put('staffEdtSt/{id}', 'Api\PegawaiController@editStatus');
        Route::delete('staff/{id}', 'Api\PegawaiController@delete');

        //Route Untuk Properti
        Route::get('property', 'Api\PropertiController@read');
        Route::get('property/{id}', 'Api\PropertiController@search');
        Route::post('property', 'Api\PropertiController@add');
        Route::put('property/{id}', 'Api\PropertiController@edit');
        Route::put('propertyEdtDenda/{id}', 'Api\PropertiController@editJmlhDenda');
        Route::put('propertyEdtSt/{id}', 'Api\PropertiController@editStatus');

        //Route Untuk Pemilik
        Route::get('owner', 'Api\PemilikController@read');
        Route::get('owner/{id}', 'Api\PemilikController@search');
        Route::post('owner', 'Api\PemilikController@add');
        Route::put('owner/{id}', 'Api\PemilikController@edit');
        Route::put('ownerEdtSt/{id}', 'Api\PemilikController@editStatus');

        //Route Untuk History Kepemilikan
        Route::get('historyKepemilikan', 'Api\HistoryKepemilikanController@read');
        Route::put('historyKepemilikan/{id}', 'Api\HistoryKepemilikanController@edit');
        Route::post('historyKepemilikan', 'Api\HistoryKepemilikanController@add');

        //Route Untuk Penyewa
        Route::get('tenant', 'Api\PenyewaController@read');
        Route::get('tenant/{id}', 'Api\PenyewaController@search');
        Route::post('tenant', 'Api\PenyewaController@add');
        Route::put('tenant/{id}', 'Api\PenyewaController@edit');
        Route::put('tenantEdtSt/{id}', 'Api\PenyewaController@editStatus');

        //Route Untuk History Penyewaan
        Route::get('historyPenyewaan', 'Api\HistoryPenyewaanController@read');
        Route::put('historyPenyewaan/{id}', 'Api\HistoryPenyewaanController@edit');
        Route::post('historyPenyewaan', 'Api\HistoryPenyewaanController@add');

        //Route Untuk Billing
        Route::get('billing', 'Api\BillingController@read');
        Route::put('billingSt/{id}', 'Api\BillingController@editStatus');

        //Route Untuk Detail Pembayaran Billing
        Route::get('billingDetail', 'Api\DetailPembayaranBillingController@read');
        Route::post('billingDetailPemilik', 'Api\DetailPembayaranBillingController@addPemilik');
        Route::post('billingDetailPenyewa', 'Api\DetailPembayaranBillingController@addPenyewa');

        //Route Untuk Pendaftaran Penyewa
        Route::get('tenantRegister/{id}', 'Api\DetailPendaftaranPenyewaController@read');
        Route::post('tenantRegister', 'Api\DetailPendaftaranPenyewaController@add');

        //Route Untuk Laporan
        Route::post('laporanPembayaranBulanan', 'Api\LaporanController@laporanPembayaranBulanan');
        Route::post('laporanPendapatanBulanan', 'Api\LaporanController@laporanPendapatanBulanan');


    ////Mobile App
        //Route Untuk Properti
        Route::get('propertyPemilikMobile/{id}', 'Api\PropertiController@readPemilik');
        Route::get('propertyPenyewaMobile/{id}', 'Api\PropertiController@readPenyewa');
        Route::put('propertyMobile/{id}', 'Api\PropertiController@editMobile');

        //Route Untuk Pemilik
        Route::get('ownerMobile/{id}', 'Api\PemilikController@searchMobile');
        Route::put('ownerMobile/{id}', 'Api\PemilikController@editMobile');

        //Route Untuk History Kepemilikan
        Route::get('historyKepemilikanMobile/{id}', 'Api\HistoryKepemilikanController@searchMobile');
        Route::put('historyKepemilikanMobile/{id}', 'Api\HistoryKepemilikanController@editMobile');
        Route::post('historyKepemilikanMobile', 'Api\HistoryKepemilikanController@addMobile');

        //Route Untuk Penyewa
        Route::get('tenantMobile/{id}', 'Api\PenyewaController@searchMobile');
        Route::put('tenantMobile/{id}', 'Api\PenyewaController@editMobile');
        Route::post('tenantMobile', 'Api\PenyewaController@addMobile');

        //Route Untuk History Penyewaan
        Route::get('historyPenyewaanMobile/{id}', 'Api\HistoryPenyewaanController@searchMobile');
        Route::put('historyPenyewaanMobile/{id}', 'Api\HistoryPenyewaanController@editMobile');
        Route::post('historyPenyewaanMobile', 'Api\HistoryPenyewaanController@addMobile');

        //Route Untuk Billing
        Route::get('billingMobile/{id}', 'Api\BillingController@searchMobile');
        Route::put('billingStMobile/{id}', 'Api\BillingController@editStatusMobile');

        //Route Untuk Detail Pembayaran Billing
        Route::get('billingDetailMobile/{id}', 'Api\DetailPembayaranBillingController@readMobile');
        Route::post('billingDetailPemilikMobile', 'Api\DetailPembayaranBillingController@addPemilikMobile');
        Route::post('billingDetailPenyewaMobile', 'Api\DetailPembayaranBillingController@addPenyewaMobile');

        //Route Untuk Pendaftaran Penyewa
        Route::get('tenantRegisterMobile/{id}', 'Api\DetailPendaftaranPenyewaController@readMobile');
        Route::post('tenantRegisterMobile', 'Api\DetailPendaftaranPenyewaController@addMobile');

        //Route Untuk Laporan

});
