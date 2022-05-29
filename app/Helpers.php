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
        return Carbon::now()->format('F');
    }

    public static function getTahun()
    {
        return Carbon::now()->format('Y');
    }

    public static function getDate()
    {
        return Carbon::now()->format('d F Y');
    }

    public static function getTime()
    {
        return Carbon::now()->format('H').':'.Carbon::now()->format('i').':'.Carbon::now()->format('s');
    }
}