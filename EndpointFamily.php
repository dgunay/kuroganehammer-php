<?php

/**
 * Abstract superclass to represent collections of endpoints nested underneat
 * a parent endpoint (such as '/moves/...' or 'characters...')
 */
abstract class EndpointFamily {
    const API_URL_BASE = 'http://api.kuroganehammer.com';
    protected $curl_handle; 

    function __construct(){
        $this->configureCurlHandle();
    }

    // TODO: make the curl handle statically shared (Singleton pattern)
    protected function configureCurlHandle(){
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

    /**
     * Function to execute generalized GET requests.
     * 
     * @param string $path API path in form '/api/endpoint'.
     * @throws Exception if failed to decode JSON.
     * @return array The API's response decoded as a PHP array, whether the
     *  resource is found or not (an error message and HTTP code are returned in
     *  an array if not.)
     */
    protected function get($path)
    {
        $url = self::API_URL_BASE . $path;

        curl_setopt($this->curl_handle, CURLOPT_URL, $url);
        $response = curl_exec($this->curl_handle);
        $http_code = curl_getinfo($this->curl_handle, CURLINFO_HTTP_CODE);
        
        // 404 errors do not return JSON, so we handle them first
        if ($http_code == 404){
            return array(
                'message'   => 'File or directory not found.',
                'httpCode'  => 404,
            );
        }

        try {
            $response = $this->json_decode_with_exception($response);
        } catch(Exception $e) {
            throw $e;
        }

        if ($http_code != 200) {
            $response['httpCode'] = $http_code;
            return $response;
        }

        return $response;
    }

    /**
     * Calls json_decode() with assoc = true, but throws an exception if it
     * doesn't work.
     *
     * @param string $json_str
     * @throws Exception if failure to decode.
     * @return array Results decoded into a PHP array.
     */
    private function json_decode_with_exception($json_str)
    {
        $result = json_decode($json_str, true);

        if (json_last_error() != 0) {
            throw new RuntimeException('Failed to decode JSON.');
        }

        return $result;
    }
}