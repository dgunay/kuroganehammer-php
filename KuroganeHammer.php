<?php

foreach (glob("EndpointFamilies/*.php") as $filename) {
    require_once($filename);
}

/**
 * The KuroganeHammer class. Allows access to the entire KuroganeHammer API
 * via its properties
 *
 * @example $kh->characters('Marth'); // Get simple data about Marth.
 * @example $kh->characters('Marth', true); // Get detailed data about Marth.
 *
 * TODO: Rewrite documentation for all endpoints.
 * TODO: Add BadMethodCallExceptions for endpts requiring id/name.
 * TODO: Refactor endpoint functions that can take id, name, or null.
 * TODO: Look into generalizing/refactoring URL parameter adding functions
 * TODO: Add a CacheAllEndpoints function to download contents of the
 *      database.
 * TODO: Refactor call flow to be $kh->service() for basic getAll calls, or
 *      $kh->service()->subService() for specific endpoints
 */
class KuroganeHammer
{
    
    /**
     * Angles class, containing functions for each /angles endpoint
     *
     * @var Angles
     */
    public $angles;
    
    /**
     * BaseDamages class, containing functions for each /baseDamages endpoint
     *
     * @var BaseDamages
     */
    public $baseDamages;
    
    /**
     * BaseKnockbacks class, containing functions for each /baseKnockbacks
     * endpoint
     *
     * @var BaseKnockbacks
     */
    public $baseKnockbacks;
    
    /**
     * CharacterAttributes class, containing functions for each
     * /characterAttributes endpoint
     *
     * @var CharacterAttributes
     */
    public $characterAttributes;
    
    /**
     * CharacterAttributeTypes class, containing functions for each
     * /characterAttributeTypes endpoint
     *
     * @var CharacterAttributeTypes
     */
    public $characterAttributeTypes;
    
    /**
     * Characters class, containing functions to get /Characters endpoints
     *
     * @var object Characters
     */
    public $characters;
    
    /**
     * FirstActionableFrames class, containing functions for each
     * /firstActionableFrames endpoint
     *
     * @var FirstActionableFrames
     */
    public $firstActionableFrames;
    
    /**
     * Hitboxes class, containing functions for each /hitboxes endpoint
     *
     * @var Hitboxes
     */
    public $hitboxes;
    
    /**
     * KnockbackGrowths class, containing functions for each /knockbackGrowths
     * endpoint
     *
     * @var KnockbackGrowths
     */
    public $knockbackGrowths;
    
    /**
     * Movements class, containing functions for each /movements endpoint
     *
     * @var Movements
     */
    public $movements;
    
    /**
     * Moves class, containing functions for each /moves endpoint
     *
     * @var Moves
     */
    public $moves;

    /**
     * Notations class, containing functions for each /notations endpoint
     *
     * @var Notations
     */
    public $notations;

    /**
     * SetKnockbacks class, containing functions for each /setKnockbacks
     * endpoint
     *
     * @var SetKnockbacks
     */
    public $setKnockbacks;

    /**
     * SmashAttributeTypes class, containing functions for each
     * /smashAttributeTypes endpoint
     *
     * @var SmashAttributeTypes
     */
    public $smashAttributeTypes;

    /**
     * Throws class, containing functions for each /throws endpoint
     *
     * @var Throws
     */
    public $throws;

    /**
     * ThrowTypes class, containing functions for each /throwTypes endpoint
     *
     * @var ThrowTypes
     */
    public $throwTypes;
    

    function __construct()
    {
        $this->characters = new Characters();
        $this->angles = new Angles();
        $this->baseDamages = new BaseDamages();
        $this->baseKnockbacks = new BaseKnockbacks();
        $this->characterAttributes = new CharacterAttributes();
        $this->characterAttributeTypes = new CharacterAttributeTypes();
        $this->firstActionableFrames = new FirstActionableFrames();
        $this->hitboxes = new Hitboxes();
        $this->knockbackGrowths = new KnockbackGrowths();
        $this->movements = new Movements();
        $this->moves = new Moves();
    }

    function __destruct()
    {
        // Doesn't need to handle anything in the destructor (yet)
    }
}

$kh = new KuroganeHammer();

print_r($kh->baseDamages->baseDamages());
