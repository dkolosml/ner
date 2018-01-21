<?php

namespace App\Http\Controllers;

use App\Code;
use App\Date;
use App\Rate;
use /** @noinspection PhpUndefinedClassInspection */
    Illuminate\Support\Facades\DB;

class NbuRates
{
    public static $url = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';

    public static function getCodes()
    {
        /** @noinspection PhpUndefinedClassInspection */
        $codes = DB::table('codes')
                   ->select(['r030', 'txt', 'cc'])
                   ->orderBy('cc', 'asc')
                   ->get()
                   ->jsonSerialize();

        return $codes;
    }

    public static function getRates($date = null, $code = null, $rCode = null)
    {
        if ( ! $date) {
            $date = date('Y-m-d');
        }

        $ymd_arr  = explode('-', $date);
        $nbu_date = $ymd_arr[2] . '.' . $ymd_arr[1] . '.' . $ymd_arr[0];

        $is_db_date = (bool) Date::select()->where('date', $date)->first();

        $get_rate_after_api = false;
        $source             = 'api';
        $rates              = [];

        if ( ! $is_db_date) {
            $source = 'api';
            $rates  = self::nbuGetRates($date);
            if ($code) {
                $get_rate_after_api = true;
            }
        }

        if ($is_db_date || $get_rate_after_api) {
            $source = $get_rate_after_api ? 'api' : 'db';

            if ($code) {

                /** @noinspection PhpUndefinedClassInspection */
                $rates = DB::table('rates')
                           ->join('codes', 'rates.r030', '=', 'codes.r030')
                           ->select(['rates.cc', 'rates.r030', 'txt', 'rate', 'exchangedate'])
                           ->where('exchangedate', $date)
                           ->where('rates.cc', $code)
                           ->get();
            } else {

                /** @noinspection PhpUndefinedClassInspection */
                $rates = DB::table('rates')
                           ->join('codes', 'rates.r030', '=', 'codes.r030')
                           ->select(['rates.cc', 'rates.r030', 'txt', 'rate', 'exchangedate'])
                           ->where('exchangedate', $date)
                           ->orderBy('cc', 'desc')
                           ->get();
            }

        }

        $data           = [];
        $data['date']   = $nbu_date;
        $data['code']   = $code;
        $data['rCode']  = $rCode;
        $data['source'] = $source;
        $data['rates']  = $rates;

        return $data;
    }

    public static function nbuGetRates($date)
    {
        $ask_date = str_replace('-', '', $date);

        $db_date = new Date();
        $db_date->fill(['date' => $date]);
        $db_date->save();

        $url = self::$url . '&date=' . $ask_date;

        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $url);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        $json_rates = curl_exec($connection);
        curl_close($connection);

        $rates = json_decode($json_rates);

        $codes     = Code::select()->get();
        $codes_arr = [];
        foreach ($codes as $code) {
            $codes_arr[$code->r030] = [
                'txt' => $code->txt,
                'cc'  => $code->cc,
            ];
        }

        foreach ($rates as $rate) {
            if ( ! isset($codes_arr[$rate->r030])) {
                $db_code = new Code();
                $db_code->fill(['r030' => $rate->r030]);
                $db_code->fill(['txt' => $rate->txt]);
                $db_code->fill(['cc' => $rate->cc]);
                $db_code->save();
            }
            $db_rate = new Rate();
            $db_rate->fill(['cc' => $rate->cc]);
            $db_rate->fill(['r030' => $rate->r030]);
            $db_rate->fill(['rate' => $rate->rate]);
            $db_rate->fill(['exchangedate' => $date]);
            $db_rate->save();
        }

        usort($rates, 'self::cmpCc');

        return $rates;
    }

    public static function cmpCc($a, $b)
    {
        if ($a->cc == $b->cc) {
            return 0;
        }

        return ($a->cc < $b->cc) ? 1 : - 1;
    }

}
