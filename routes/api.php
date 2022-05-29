<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 'Api\AuthController@login');

Route::get('sendNotif', 'Api\UserController@sendNotif');

Route::get('previewReport', 'Api\LaporanController@previewReport');

Route::group(['middleware' => 'auth:api'], function()
{
    ////Mobile App
        //Route Untuk User
        Route::get('userMobile/{id}', 'Api\UserController@searchMobile');
        Route::put('userMobile/{id}', 'Api\UserController@editMobile');
        Route::post('setToken', 'Api\AuthController@getToken');

        //Route Untuk Properti
        Route::get('propertyPemilikMobile/{id}', 'Api\PropertiController@readPemilik');
        Route::get('propertyPenyewaMobile/{id}', 'Api\PropertiController@readPenyewa');
        Route::get('propertySearchMobile/{id}', 'Api\PropertiController@searchMobile');

        //Route Untuk Billing
        Route::get('billingPemilikMobile/{id}', 'Api\BillingController@readPemilik');
        Route::get('billingPenyewaMobile/{id}', 'Api\BillingController@readPenyewa');
        Route::get('billingMobile/{id}', 'Api\BillingController@searchMobile');

        //Route Untuk Detail Pembayaran Billing
        Route::post('billingDetailMobile', 'Api\DetailPembayaranBillingController@addMobile');
        Route::get('billingDetailMobile/{id}', 'Api\DetailPembayaranBillingController@readMobile');
        Route::get('searchBillingDetailMobile/{id}', 'Api\DetailPembayaranBillingController@searchMobile');

        //Route Untuk Entry Token
        Route::get('entryToken/{id}', 'Api\EntryTokenController@search');
        Route::post('entryToken', 'Api\EntryTokenController@add');

        //Route Untuk Complaint
        Route::get('allComplaint/{id}', 'Api\ComplaintController@read');
        Route::get('complaint/{id}', 'Api\ComplaintController@search');
        Route::post('complaint', 'Api\ComplaintController@add');
        Route::put('complaint/{id}', 'Api\ComplaintController@edit');
        Route::put('complaintDelete/{id}', 'Api\ComplaintController@delete');
        
        //Route Untuk Laporan
        Route::post('paymentReport', 'Api\LaporanController@laporanPembayaranTahunan');
        Route::post('printPaymentReport', 'Api\LaporanController@cetakLaporanPembayaranTahunan');
});
