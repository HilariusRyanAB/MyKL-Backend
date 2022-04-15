<?php

namespace App\Helpers;
use Carbon\Carbon;

class Helper
{
    public static function changeToCurrency($money)
    {
        $hasil_rupiah = "Rp " . number_format($money, 2, ',' , '.');
	    return $hasil_rupiah;
    }

    public static function getBulan()
    {
        return Carbon::now()->translatedFormat('F');
    }

    public static function getTahun()
    {
        return Carbon::now()->translatedFormat('Y');
    }

    public static function getDate()
    {
        return Carbon::now()->translatedFormat('d F Y');
    }

    public static function getTime()
    {
        return Carbon::now()->translatedFormat('H').':'.Carbon::now()->translatedFormat('i').':'.Carbon::now()->translatedFormat('s');
    }
}