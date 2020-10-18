<?php

namespace ccmslibcustom\items\IntermediairCheckForm;

use ccmslib\items\Item\Item;
use ccmslib\items\Item\ItemFrontEndView;
use ccmslib\Managers\ItemManager\ItemManager;
use ccmslib\Wrappers\my_smarty;
use ccmslib\Views\MainPaginaView\MainPaginaView;
use Smarty;
//use ccmslib\Managers\DbManager\DatabaseHandler;
use ccmslibcustom\modules\gebruikerHack\gebruikerHack;
use ccmslibcustom\modules\GezinneninArmoedeEmail\GezinneninArmoedeEmail;

class IntermediairCheckFormFrontEndView extends ItemFrontEndView {

    protected $gebruikerHack;

    function __construct(ItemManager $cms) {
//      Initialiseerd de CMS en Smarty
        $this->gebruikerHack = gebruikerHack::getInstance();

        $this->cmsmanager = $cms;
        $this->smarty = new my_smarty();
        $this->smarty = $this->smarty->getSmarty();
        MainPaginaView::enableJquery();
        $this->smarty->template_dir = CCMSCUSTOMLIBPATH . '/items/IntermediairCheckForm/template/';
    }
//  Haalt de gebruiker op met een gegenereerde token die de gebruiker in een mail heeft gekregen,
//  laat de juiste pagina's zien als wel of niet de juiste gebruiker is.
//  Als de gebruiker de form heeft ingevuld word diegene naar een andere pagina geleid.
    function show(IntermediairCheckForm $item, Smarty &$sm = null) {

        if (isset($_GET['token'])) {

            $userid = $this->getUserIdFromToken();
            $this->getIntermediairFromUserId($userid['userid']);
            
        } else {
            $page = $this->smarty->fetch('geenIntermediair.html');
        }        

        if (isset($_POST['keuze'])) {
            $this->sendFormResponse($userid['userid']);
            $page = $this->smarty->fetch('beantwoord.html');
            header("refresh:5;url=/#Home");
        }else{
            $page = $this->smarty->fetch('gegevensCheck.html');
        }
        
        echo $page;
    }
//  Haalt de juiste intermediair op vanuit de database,
//  returned de info van de intermediair.
    private function getIntermediairFromUserId($userid) {

        $userq = 'SELECT * FROM `Intermediair` LEFT JOIN `Useridemail` ON Intermediair.userid = Useridemail.id WHERE Intermediair.userid =' . $userid;
        $user = $this->cmsmanager->customSelectQuery($userq)[0];
        $form = $this->setIntermediairInfo($user);

        return $form;
    }
//  Set alle benodigde info van de intermediair die vanuit de database is gehaald
    private function setIntermediairInfo($db) {
        $form = new IntermediairCheckForm();
        $form->setVoornaam($db['voornaam']);
        $form->setAchternaam($db['achternaam']);
        $form->setNaamOrganisatie($db['naamOrganisatie']);
        $form->setEmail($db['email']);
        $form->setTelNr($db['telNr']);
        $form->setRefCode($db['refCode']);
        $this->smarty->assign("form", $form);
    }
//  Verzend het antwoord wat de gebruiker heeft verzonden, er word gecheckt of de response 0 of 1 is,
//  zoja, update de isActive kolom met de verzonden response
    private function sendFormResponse($userid) {
        $userq = 'SELECT * FROM `Intermediair` LEFT JOIN `Useridemail` ON Intermediair.userid = Useridemail.id WHERE Intermediair.userid =' . $userid;
        $user = $this->cmsmanager->customSelectQuery($userq)[0];
        $this->smarty->assign("userdata", $user);
        
        if($_POST['keuze'] == 0 || $_POST['keuze'] == 1){
            
            $q = "UPDATE `Intermediair` SET isActive =" . $_POST['keuze'] . " WHERE userid = " . $userid;
            $this->cmsmanager->customUpdateQuery($q);
        }else{
           unset($_POST['keuze']); 
        }
        
    }
//  Haalt de huidige intermediair en checkt of het de juiste is met een gegenereerde token,
//  gedaan met sha1 die een token maakt van de email, id en refCode die uit de database worden gehaald
    private function getUserIdFromToken() {

        $token = $_GET['token'];
        $qry = "SELECT * FROM `Intermediair` LEFT JOIN `Useridemail` ON Intermediair.userid = Useridemail.id WHERE Intermediair.userid = " . $_GET['id'];
        $userr = $this->cmsmanager->customSelectQuery($qry)[0];

        if (sha1($userr['email'] . $userr['id'] . $userr['refCode']) === $token) {
            $q = "SELECT userid FROM `Intermediair` WHERE userid =" . $userr['id'];
            $result = $this->cmsmanager->customSelectQuery($q)[0];

            return $result;
        } else {
            echo $this->smarty->fetch('geenIntermediair.html');
            
        }
    }

}
