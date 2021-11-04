<?php
namespace Redreams\Components;

use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

Loader::includeModule('sale');
Loader::includeModule('redreams.partners');

class Addr extends \CBitrixComponent
{
    public $userID;
    public $conctractorID;

    public function executeComponent()
    {
        $this->userID = $GLOBALS['USER']->GetID();


        $this->getAddr();

        $this->includeComponentTemplate();
    }

    public function getAddr()
    {
        if(!$this->userID) return;
        
        $ob_adress = new \Redreams\Partners\adress();
        $result = $ob_adress->getlist(['UF_PARTNER' => $this->userID]);
        $this->arResult = $result;
    }
}