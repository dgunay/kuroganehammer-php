<?php


class Character_Ids
{
    const BAYONETTA         = 1;
    const BOWSER            = 2;
    const BOWSER_JR         = 3;
    const CAPTAIN_FALCON    = 4;
    const CHARIZARD         = 5;
    const CLOUD             = 6;
    const CORRIN            = 7;
    const DARK_PIT          = 8;
    const DIDDY_KONG        = 9;
    const DONKEY_KONG       = 10;
    const DR_MARIO          = 11;
    const DUCK_HUNT         = 12;
    const FALCO             = 13;
    const FOX               = 14;
    const GANONDORF         = 15;
    const GRENINJA          = 16;
    const IKE               = 17;
    const JIGGLYPUFF        = 18;
    const KING_DEDEDE       = 19;
    const KIRBY             = 20;
    const LINK              = 21;
    const LITTLE_MAC        = 22;
    const LUCARIO           = 23;
    const LUCAS             = 24;
    const LUCINA            = 25;
    const LUIGI             = 26;
    const MARIO             = 27;
    const MARTH             = 28;
    const MEGA_MAN          = 29;
    const META_KNIGHT       = 30;
    const MEWTWO            = 31;
    const MII_BRAWLER       = 32;
    const MII_GUNNER        = 33;
    const MII_SWORDFIGHTER  = 34;
    const MR_GAME_WATCH     = 35;
    const NESS              = 36;
    const OLIMAR            = 37;
    const PACMAN            = 38;
    const PALUTENA          = 39;
    const PEACH             = 40;
    const PIKACHU           = 41;
    const PIT               = 42;
    const ROB               = 43;
    const ROBIN             = 44;
    const ROSALINA_LUMA     = 45;
    const ROY               = 46;
    const RYU               = 47;
    const SAMUS             = 48;
    const SHEIK             = 49;
    const SHULK             = 50;
    const SONIC             = 51;
    const TOON_LINK         = 52;
    const VILLAGER          = 53;
    const WARIO             = 54;
    const WII_FIT_TRAINER   = 55;
    const YOSHI             = 56;
    const ZELDA             = 57;
    const ZERO_SUIT_SAMUS   = 58;
}

class KuroganeHammer
{
    private $curl_handle;
    const API_URL_BASE = 'http://api.kuroganehammer.com';

    function __construct()
    {
        $this->curl_handle = $this->initializeCurlResource();
    }

    function __destruct()
    {
        curl_close($this->curl_handle);
    }

    /**
     * Initializes a cURL resource for use making calls to the API.
     *
     * @return resource A cURL resource.
     */
    private function initializeCurlResource()
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_SSL_VERIFYPEER  => true,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_CONNECTTIMEOUT  => 30,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_ENCODING        => "gzip",
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HEADER          => false,
            CURLOPT_NOBODY          => false
        ));

        return $ch;
    }
  
    /**
     * Gets all Smash 4 characters, or a single character by ID or name.
     *
     * @param mixed $id ID number of a character, or name.
     * @param bool $details Whether or not to include detailed metadata.
     * @return mixed Response from the API decoded into a PHP array, or false
     *  if ID is provided but not found.
     */
    function getCharacters($id = null, $details = false)
    {
        if ($id !== null){
            if ($details === true){
                return $this->charactersRequest($id, 'details');
            }

            return $this->charactersRequest($id);
        }

        return $this->charactersRequest();
    }

    function getDetailedMoves($id = null){
        if ($id === null){
            return $this->get('/api/DetailedMoves');
        }
        return $this->charactersRequest($id, 'detailedmoves');
    }

    function getMovements($id = null){
        if ($id === null){
            return $this->get('/api/Movements');
        }
        return $this->charactersRequest($id, 'movements');
    }

    function getMoves($id = null){
        if ($id === null){
            return $this->get('/api/Moves');
        }
        return $this->charactersRequest($id, 'moves');        
    }

    function getThrows($id = null){
        if ($id === null){
            return $this->get('/api/Throws');
        }
        return $this->charactersRequest($id, 'throws');        
    }

    function getCharacterAttributes($id = null){
        if ($id === null){
            return $this->get('/api/CharacterAttributes');
        }
        return $this->charactersRequest($id, 'characterattributes');        
    }

    function getSmashAttributeType($type){
        // TODO: Figure out what the heck this API endpoint does
    }

    function getAngles($id = null){
        if ($id === null){
            return $this->get('/api/Angles');
        }
        return $this->charactersRequest($id, 'angles');        
    }
    
    function getHitboxes($id = null){
        if ($id === null){
            return $this->get('/api/Hitboxes');
        }
        return $this->charactersRequest($id, 'hitboxes');        
    }

    function getKnockbackGrowths($id = null){
        if ($id === null){
            return $this->get('/api/KnockbackGrowths');
        }
        return $this->charactersRequest($id, 'knockbackgrowths');        
    }

    function getBaseDamages($id = null){
        if ($id === null){
            return $this->get('/api/BaseDamages');
        }
        return $this->charactersRequest($id, 'basedamages');        
    }

    /**
     * Helper function to generalize requests across all Characters API 
     * endpoints.
     *
     * @param mixed $id ID or name of a character
     * @param string $endpoint The api/characters/endpoint to use.
     * @return mixed Response from the API decoded into a PHP array, or false
     *  if ID is provided but not found.
     */ 
    private function charactersRequest($id = null, $endpoint = null)
    {
        $path = '/api/characters';
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
    
    /**
     * Function to execute generalized GET requests.
     * 
     * TODO: Should I return false, or throw an exception.
     *
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
        
        try {
            $response = $this->json_decode_with_exception($response);
        } catch (Exception $e) {
            throw $e;
        }

        $http_code = curl_getinfo($this->curl_handle, CURLINFO_HTTP_CODE);
        if ($http_code != 200) {
            $response['httpCode'] = $http_code;
            return $response;
        }


        // false if not found
        if (isset($response['message'])) {
            return false;
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

$kh = new KuroganeHammer();

print_r($kh->getCharacters('morf'));
