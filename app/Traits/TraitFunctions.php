<?php

namespace App\Traits;



use Carbon\Carbon;

trait TraitFunctions{

    public static function intToDate(int $dateInt): ?string
    {
        if (empty($dateInt) || $dateInt <= 0) {
            return null;
        }
        return Carbon::createFromFormat('Ymd', $dateInt)->format('d/m/Y');
    }

    public static function dateToInt(?string $dateStr): ?int
    {
        if (empty($dateStr)) {
            return null;
        }
        $date = Carbon::createFromFormat('d/m/Y', $dateStr);
        if (!$date) {
            return null;
        }
        return (int)$date->format('Ymd');
    }

    public static function json_encode($data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public static function json_decode(string $json, bool $assoc = true)
    {
        return json_decode($json, $assoc);
    }
    

}







?>