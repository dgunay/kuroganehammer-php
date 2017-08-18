<?php

require_once('EndpointFamily.php');

/**
 * Handles the group of API endpoints falling under
 *  '/FirstActionableFrames/...'
 */
class Hitboxes extends EndpointFamily
{
    const ENDPOINT_BASE = '/api/Hitboxes';
    
    function __construct()
    {
        parent::__construct();
        $this->staticCurlHandle = StaticCurlHandle::getInstance();
    }

    /**
     * Getter function
     *
     * @param mixed $id ID number of a character, or name.
     * @return mixed Response from the API decoded into a PHP array, or false
     *  if ID is provided but not found.
     */
    function hitboxes($id = null)
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
     * @param mixed $id ID
     * @param string $endpoint The api/characters/endpoint to use.
     * @return mixed Response from the API decoded into a PHP array, or false
     *  if ID is provided but not found.
     */
    private function request($id = null)
    {
        $path = self::ENDPOINT_BASE;
        if ($id !== null) {
            if (!is_numeric($id)) {
                throw new RuntimeException('ID must be numeric.');
            }
            
            $path .= '/' . $id;
        }
        
        return $this->get($path);
    }
}
