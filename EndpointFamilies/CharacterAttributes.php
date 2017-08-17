<?php

require_once('EndpointFamily.php');

/**
 * Handles the group of API endpoints falling under '/characterattributes/...'
 */
class CharacterAttributes extends EndpointFamily
{
    const ENDPOINT_BASE = '/api/characterattributes';
    
    function __construct()
    {
        parent::__construct();
        $this->staticCurlHandle = StaticCurlHandle::getInstance();
    }

    /**
     * Gets all Smash 4 characters, or a single character by ID or name.
     *
     * @param mixed $id ID number of a character, or name.
     * @param bool $details Whether or not to include detailed metadata.
     * @return mixed Response from the API decoded into a PHP array, or false
     *  if ID is provided but not found.
     */
    function baseKnockbacks($id = null)
    {
        if ($id !== null) {
            return $this->request($id);
        }

        return $this->request();
    }

    /**
     * Helper function to generalize requests across all /characters API
     * endpoints.
     *
     * @param mixed $id ID or name of a character
     * @param string $endpoint The api/characters/endpoint to use.
     * @return mixed Response from the API decoded into a PHP array, or false
     *  if ID is provided but not found.
     */
    private function request($id = null)
    {
        $path = Characters::ENDPOINT_BASE;
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
