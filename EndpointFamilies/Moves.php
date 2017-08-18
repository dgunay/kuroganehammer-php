<?php

require_once('EndpointFamily.php');

/**
 * Handles the group of API endpoints falling under '/Moves/...'
 */
class Moves extends EndpointFamily
{
    const ENDPOINT_BASE = '/api/Moves';
    
    function __construct()
    {
        parent::__construct();
        $this->staticCurlHandle = StaticCurlHandle::getInstance();
    }

    function moves($moveIdOrName = null)
    {
        return $this->request($moveIdOrName);
    }
    
    /**
     * /api/moves/{id}/hitboxes Get the {FrannHammer.Models.Hitbox} data associated with this move.
     */
    function hitboxes($idOrName)
    {
        return $this->request($idOrName, 'hitboxes');
    }

    /**
     * /api/moves/{id}/autocancel Get the {FrannHammer.Models.Autocancel} data associated with this move.
     */
    function autocancel($idOrName)
    {
        return $this->request($idOrName, 'autocancel');
    }

    /**
     * /api/moves/{id}/landinglag Get the {FrannHammer.Models.LandingLag} data associated with this move.
     */
    function landingLag($idOrName)
    {
        return $this->request($idOrName, 'landinglag');
    }

    /**
     * /api/moves/{id}/baseknockbacks Get the {FrannHammer.Models.BaseKnockback} data associated with this move.
     */
    function baseKnockback($idOrName)
    {
        return $this->request($idOrName, 'baseknockbacks');
    }

    /**
     * /api/moves/{id}/setknockbacks Get the {FrannHammer.Models.SetKnockback} data associated with this move.
     */
    function setKnockbacks($idOrName)
    {
        return $this->request($idOrName, 'setknockbacks');
    }

    /**
     * /api/moves/{id}/angles Get the {FrannHammer.Models.Angle} data associated with this move.
     */
    function angles($idOrName)
    {
        return $this->request($idOrName, 'angles');
    }

    /**
     * /api/moves/{id}/firstActionableFrames Get the {FrannHammer.Models.FirstActionableFrame} data associated with this {FrannHammer.Models.Move}.
     */
    function firstActionableFrames($idOrName)
    {
        return $this->request($idOrName, 'firstActionableFrames');
    }

    /**
     * /api/moves/{id}/basedamages Get the {FrannHammer.Models.BaseDamage} data associated with this move.
     */
    function baseDamages($idOrName)
    {
        return $this->request($idOrName, 'basedamages');
    }

    /**
     * /api/moves/{id}/knockbackgrowths Get the {FrannHammer.Models.KnockbackGrowth} data associated with this {FrannHammer.Models.Move}.
     */
    function knockbackGrowths($idOrName)
    {
        return $this->request($idOrName, 'knockbackgrowths');
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
