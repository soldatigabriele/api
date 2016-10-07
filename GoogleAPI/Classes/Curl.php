<?php


namespace connect;


class Curl
{
    public $_results;

    public function __construct($url)
    {
        $channel = curl_init();
        curl_setopt($channel, CURLOPT_URL, $url);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
        $json = curl_exec($channel);
        $this->_results = json_decode($json,true);
    }

    public function returnResults(){
        return $this->_results;
    }


}

