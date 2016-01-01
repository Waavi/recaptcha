<?php

namespace Waavi\ReCaptcha\IO;

class Broker
{
    public function __construct($url, $secret, $timeout)
    {
        $this->url     = $url;
        $this->secret  = $secret;
        $this->timeout = $timeout;
    }

    public function getResponse($input)
    {
        $parameters = http_build_query([
            'secret'   => $this->secret,
            'response' => $input,
        ]);
        $url = $this->url . '?' . $parameters;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $json = curl_exec($curl);

        return new Response($json);
    }
}
