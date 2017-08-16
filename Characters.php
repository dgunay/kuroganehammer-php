<?php

require_once('EndpointFamily.php');

/**
 * Handles the group of API endpoints falling under '/characters/...'
 */
class Characters extends EndpointFamily
{
    const ENDPOINT_BASE = '/api/characters';
    
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
    function characters($id = null, $details = false)
    {
        if ($id !== null) {
            if ($details === true) {
                return $this->request($id, 'details');
            }

            return $this->request($id);
        }

        return $this->request();
    }

    function detailedMoves($nameOrId)
    {
        return $this->request($nameOrId, 'detailedmoves');
    }
    
    function movements($nameOrId)
    {
        return $this->request($nameOrId, 'movements');
    }
    
    function moves($nameOrId)
    {
        return $this->request($nameOrId, 'moves');
    }
    
    function throws($nameOrId)
    {
        return $this->request($nameOrId, 'throws');
    }
    
    function characterAttributes($nameOrId)
    {
        return $this->request($nameOrId, 'throws');
    }
    
    function smashAttributeTypes($nameOrId, $smashAttributeTypeIdOrName)
    {   
        // TODO: figure this function out
        throw new Exception('smashAttributeTypes() is not yet implemented.');
        // char/id/smashattrtypes/smashattrid
        // or
        // char/name/{name}/shasmattrtypes/name/smashattrtypename
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
    
    function angles($nameOrId)
    {
        return $this->request($nameOrId, 'angles');
    }
    
    function hitboxes($nameOrId)
    {
        return $this->request($nameOrId, 'hitboxes');
    }
    
    function knockbackGrowths($nameOrId)
    {
        return $this->request($nameOrId, 'knockbackgrowths');
    }
    
    function baseDamages($nameOrId)
    {
        return $this->request($nameOrId, 'basedamages');
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
    private function request($id = null, $endpoint = null)
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
