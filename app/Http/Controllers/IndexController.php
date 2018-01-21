<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        $codes = NbuRates::getCodes();

        return view('home')->with([
            'today' => date('Y-m-d', time() + 7200),
            'codes' => $codes,
        ]);
    }

    public function getRates()
    {
        $date  = isset($_GET['date']) ? $_GET['date'] : null;
        $code  = isset($_GET['code']) ? $_GET['code'] : null;
        $rCode = isset($_GET['r']) ? $_GET['r'] : null;

        $data = NbuRates::getRates($date, $code, $rCode);

//        $rates = json_encode($rates, JSON_PRETTY_PRINT + );
        $json_data = json_encode($data, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);

        header("Content-type: application/json");
        echo $json_data;

        exit();
    }

}
