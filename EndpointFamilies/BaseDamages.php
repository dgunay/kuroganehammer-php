<?php

require_once('EndpointFamily.php');

/**
 * Handles the group of API endpoints falling under '/BaseDamages/...'
 */
class BaseDamages extends EndpointFamily
{
    const ENDPOINT_BASE = '/api/BaseDamages';
    
    function __construct()
    {
        parent::__construct();
        $this->staticCurlHandle = StaticCurlHandle::getInstance();
    }

    /**
     * Gets all base damages, or a move's base damage by ID.
     *
     * Can return a certain set of fields exclusively.
     *
     * @param string $id base damage ID.
     * @param array $fields Fields to return
     * @return mixed
     */
    function baseDamages($id = null, array $fields = array())
    {
        return $this->request($id, $fields);
    }

    /**
     * Helper function to generalize requests across all /basedamages API
     * endpoints.
     * 
     * Returns a specific set of fields if requested.
     *
     * @param mixed $id ID or name of a character
     * @param string $endpoint The api/characters/endpoint to use.
     * @param array $fields Array of field names to request from the API. Gets
     *  all if empty. Field names that do not exist in the API return nothing.
     * @return mixed Response from the API decoded into a PHP array, or false
     *  if ID is provided but not found.
     */
    private function request($id = null, array $fields = array())
    {
        $path = self::ENDPOINT_BASE;
        if ($id !== null) {
            if (!is_numeric($id)) {
                throw new RuntimeException('ID must be numeric.');
            }
            
            $path .= '/' . $id;
        }
        
        if (count($fields) > 0) { // add requested fields
            $url_params = '?fields=';
            for ($i = 0; $i < count($fields); $i++) {
                $url_params .= $fields[$i];
                if ($i < count($fields) - 1) {
                    $url_params .= ',';
                }
            }
            $path .= $url_params;
        }
        
        return $this->get($path);
    }
}
