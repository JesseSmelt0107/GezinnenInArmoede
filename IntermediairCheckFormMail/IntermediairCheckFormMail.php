<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ccmslibcustom\modules\IntermediairCheckFormMail;

use ccmslibcustom\modules\GezinneninArmoedeEmail\GezinneninArmoedeEmail;
use ccmslib\Managers\ItemManager\ItemManager;

use ccmslib\Wrappers\my_smarty;


class IntermediairCheckFormMail {
    
        private $smarty;

//initialiseerd Smarty en CMS
function __construct(ItemManager $cms) {
    
        $this->cmsmanager = $cms;
        $this->smarty = new my_smarty();
        $this->smarty = $this->smarty->getSmarty();
        MainPaginaView::enableJquery();
        $this->smarty->template_dir = CCMSCUSTOMLIBPATH . '/modules/IntermediairCheckFormMail/template/';
    }
    
    //Selecteerd alles in intermediair en verstuurd vervolgends een email naar die intermediair

    public function runCron(){
//        $q = 'SELECT * FROM `Intermediair`';
        $q = 'SELECT * FROM `Intermediair` WHERE userid = 11529';
        $res = $this->cmsmanager->customSelectQuery($q)[0];
        $this->generateEmail($res);
        
//        if(count($res) > 0){
//            foreach($res as $intermediair){
//                $this->generateEmail($intermediair);
//            }
//        }
    }
    
    //Set alle nodige info voor de email die naar de intermediair gestuurd word.
    private function generateEmail($intermediair) {
        $this->smarty->assign('user', $intermediair);
        $q = 'SELECT * FROM `Useridemail` WHERE id = ' . $intermediair['userid'];
        $data = $this->cmsmanager->customSelectQuery($q)[0];
        $token = $this->generateToken($data['email'], $user['userid'], $user['refCode']);
        $this->smarty->assign('token', $token);
        $email = new GezinneninArmoedeEmail();
        $email->addReceiver('smelt@cardsolutions.nl');
//    //$email->addReceiver($data['email']);
        $email->setSubject('Activiteit 2020');
        $email->setHtmlBody($this->smarty->fetch("intermediairFormEmail.html"));
        $email->setSender("info@gezinneninarmoede.nl");
        $email->send();
    }
    
    //Token word gegenereerd met id, email en refCode, de token word vervolgends gereturned
    private function generateToken($email, $id, $refCode) {
        $token = sha1($email . $id . $refCode);
        return $token;
    }
    
    
}