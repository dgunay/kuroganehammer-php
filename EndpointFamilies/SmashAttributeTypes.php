<?php

require_once('EndpointFamily.php');

/**
 * Handles the group of API endpoints falling under
 *  '/SmashAttributeTypes/...'
 */
class SmashAttributeTypes extends EndpointFamily
{
    const ENDPOINT_BASE = '/api/SmashAttributeTypess';
    
    function __construct()
    {
        parent::__construct();
        $this->staticCurlHandle = StaticCurlHandle::getInstance();
    }

    function SmashAttributeTypes($idOrName = null)
    {
        return $this->request($idOrName);
    }

    function characterAttributes($idOrName)
    {
        return $this->request($idOrName, 'characterattributes');
    }

    private function request($id = null, $endpoint = null)
    {
        $path = self::ENDPOINT_BASE;
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
}
