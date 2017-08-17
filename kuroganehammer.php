<?php

foreach (glob("EndpointFamilies/*.php") as $filename){
    require_once($filename);
}

/**
 * The KuroganeHammer class.
 * 
 * TODO: Rewrite documentation for all endpoints.
 */
class KuroganeHammer
{
    /**
     * Characters class, containing functions to get /Characters endpoints
     *
     * @var object Characters
     */
    public $characters;

    function __construct()
    {
        $this->characters = new Characters();
    }

    function __destruct()
    {

    }

    function getDetailedMoves($id = null){
        if ($id === null){
            return $this->get('/api/DetailedMoves');
        }
        return $this->charactersRequest($id, 'detailedmoves');
    }

    
    
    function getThrows($id = null){
        if ($id === null){
            return $this->get('/api/Throws');
        }
        return $this->charactersRequest($id, 'throws');        
    }
    
    function getCharacterAttributes($id = null){
        $path = '/api/CharacterAttributes';
        if ($id !== null){
            if (is_numeric($id)){
                $path .= '/' . $id;
            }
            else {
                $path .= '/name/' . $id;
            }
        }
        return $this->get($path);
    }
    
    function getCharacterAttributeTypes($id = null){
        $path = '/api/characterattributetypes';
        if ($id !== null){
            $path .= '/' . $id;
        }
        return $this->get($path);
    }
    
    function getFirstActionableFrames($id = null){
        $path = '/api/FirstActionableFrames';
        if ($id !== null){
            $path .= '/' . $id;
        }
        return $this->get($path);
    }
    
    function getHitboxes($id = null){
        $path = '/api/Hitboxes';
        if ($id !== null){
            $path .= '/' . $id;
        }
        return $this->get($path);
    }
    
    function getKnockbackGrowths($id = null){
        $path = '/api/KnockbackGrowths';
        if ($id !== null){
            $path .= '/' . $id;
        }
        return $this->get($path);    
    }
    
    function getMovements($id = null){
        $path = '/api/movements';
        if ($id !== null){
            if (is_numeric($id)){
                $path .= '/' . $id;
            }
            else {
                $path .= '/name/' . $id;
            }
        }
        return $this->get($path);
    }
    
    function getMoves($id = null){
        if ($id === null){
            return $this->get('/api/moves');
        }
        return $this->movesRequest($id);        
    }

    private function movesRequest($id = null, $endpoint = null){
        $path = '/api/moves';
        if ($id !== null) {
            if (!is_numeric($id)) {
                $path .= '/name';
            }
            
            $path .= '/' . $id;
        }
        
        if ($endpoint !== null) {
            $path .= '/'.$endpoint;
        }
        
        return $this->get($path);
    }

    function getSmashAttributeType($type){
        // TODO: Figure out what the heck this API endpoint does
    }
    
    function getAngles($id = null){
        $path = '/api/Angles';
        if ($id !== null){
            $path .= '/'.$id;
        }
        return $this->get($path);        
    }
    
    function getNotations($id = null){
        if ($id === null){
            return $this->get('/api/notations');
        }
        return $this->charactersRequest($id, 'notations');        
    }
    
    
    
    
    function getBaseKnockbacks($id = null){
        $path = '/api/BaseKnockbacks';
        if ($id !== null){
            $path .= '/' . $id;
        }
        return $this->get($path);        
    }
    
    function getBaseDamages($id = null){
        $path = '/api/BaseDamages';
        if ($id !== null){
            $path .= '/' . $id;
        }
        return $this->get($path);
    }
    
    
    
    /**
     * Function to execute generalized GET requests.
     * @param string $path API path in form '/api/endpoint'.
     * @throws Exception if failed to decode JSON.
     * @return array The API's response decoded as a PHP array, whether the
     *  resource is found or not (an error message and HTTP code are returned in
     *  an array if not.)
     */
    private function get($path)
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
     * Queries the API at an endpoint explicitly defined by the function arg.
     *
     * @param string $path The API path.
     * @return void
     */
    function customGet($path){
        return $this->get($path);
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

$kh = new KuroganeHammer();

print_r($kh->characters->angles());
