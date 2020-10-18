<?php

namespace ccmslibcustom\items\IntermediairCheckForm;

use ccmslib\items\Item\Item;

class IntermediairCheckForm extends Item {
    /*
     * constructor voor myItem
     *
     * @param item $item
     * @param String $titel
     * @param String $template
     */

    function __construct() {
        parent::__construct();
        $this->setUitklappen(0);
    }
    
    private $userId;
    private $naamOrganisatie;
    private $voornaam;
    private $achternaam;
    private $email;
    private $telNr;
    private $refCode;
    private $isActive;
    
    
    function getUserId () {
        return $this->userId;
    }
    
    function setUserId ($userId) {
        $this->userId = $userId;
    }
    
    function getNaamOrganisatie () {
        return $this->naamOrganisatie;
    }
    
    function setNaamOrganisatie ($naamOrganisatie) {
        $this->naamOrganisatie = $naamOrganisatie;
    }
    
    function getVoornaam () {
        return $this->voornaam;
    }
    
    function setVoornaam ($voornaam) {
        $this->voornaam = $voornaam;
    }
    
    function getAchternaam () {
        return $this->achternaam;
    }
    
    function setAchternaam ($achternaam) {
        $this->achternaam = $achternaam;
    }
    
    function getEmail () {
        return $this->email;
    }
    
    function setEmail ($email) {
        $this->email = $email;
    }
    
    function getTelNr () {
        return $this->telNr;
    }
    
    function setTelNr ($telNr) {
        $this->telNr = $telNr;
    }
    
    function getRefCode () {
        return $this->refCode;
    }
    
    function setRefCode ($refCode) {
        $this->refCode = $refCode;
    }
    
    function getActive () {
        return $this->isActive;
    }
    
    function setActive ($isActive) {
        $this->isActive = $isActive;
    }
           
    
}