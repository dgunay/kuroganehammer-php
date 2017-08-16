<?php

include_once('EndpointFamily.php');

/**
 * Handles the group of API endpoints falling under '/characters/...'
 */
class Characters extends EndpointFamily {
    const ENDPOINT_BASE = '/api/characters';
    
    function __construct(){
        $this->configureCurlHandle();
    }

    /**
     * Implement these endpoints:
     * 
     * Done:
     * characters (base)
     * 
     * TODO:
     * /id
     * /id/details
     * /name/{name}/details
     * /id/detailedmoves
     * /id/name/{name}/detailedmoves
     * /id/movements
     * /name/{name}/movements
     * /id/moves
     * /name/{names}/moves
     * /id/throws
     * /name/name/throws
     * /id/characterattributes
     * /id/smashattributetypes/{smashAttriibuteTypeId}
     * /name/{nname}/characterattributes
     * /name/{name}/smashattributetypes/name/{smashAttriibuteTypeName}
     * /id/angles
     * /name/{name}/angles
     * /id/hitboxes
     * /name/{name}/hitboxes
     * /id/knockbackgrowths
     * /name/{name}/knockbackgrowths
     * /id/basedamages
     * /namenamebasedagames
     */

     function characters($id = null, $details = false){
        if ($id !== null){
            if ($details === true){
                return $this->request($id, 'details');
            }

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

