<?php

namespace Pupuga\Libs\Curl;

class Curl
{
    public static function connect($url, $requestType, $key, $data = array(), $decode = true)
    {
        $connect = curl_init();
        $requestType = strtoupper($requestType);
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode( 'user:'. $key )
        );
        if($requestType == 'GET') {
            $url .= '?' . http_build_query($data);
        }
        $data = json_encode($data);
        curl_setopt($connect, CURLOPT_URL, $url );
        curl_setopt($connect, CURLOPT_CUSTOMREQUEST, $requestType);
        curl_setopt($connect, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($connect, CURLOPT_POSTFIELDS, $data );
        curl_setopt($connect, CURLOPT_TIMEOUT, 10);
        curl_setopt($connect, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($connect);

        if ($decode) {
            $result = json_decode($result);
        }

        return $result;
    }

    public static function get($url, $key, $data = array())
    {
        return self::connect($url, 'get', $key, $data);
    }

    public static function post($url, $key, $data = array())
    {
        return self::connect($url, 'post', $key, $data);
    }

    public static function delete($url, $key)
    {
        return  self::connect($url, 'delete', $key);
    }

}