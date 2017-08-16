<?php

/**
 * Singleton class to share a cURL resource without needing to initialize and
 * configure a cURL handle for each child class of EndpointFamily.
 */
class StaticCurlHandle{
    private static $instance = null; // holds the instance of our handle
    private $curl_handle; // the actual handle

    private function __construct()
    {
        $this->curl_handle = curl_init();
        curl_setopt_array($this->curl_handle, array(
            CURLOPT_SSL_VERIFYPEER  => true,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_CONNECTTIMEOUT  => 30,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_ENCODING        => "gzip",
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HEADER          => false,
            CURLOPT_NOBODY          => false,
            CURLOPT_HTTPHEADER      => array(
                'Accept: application/json,'
            ),
        ));
    }

    protected function __clone()
    {  
        // no cloning allowed
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new StaticCurlHandle();
        }
        return self::$instance;
    }

    public function getHandle(){
        return $this->curl_handle;
    }
}

