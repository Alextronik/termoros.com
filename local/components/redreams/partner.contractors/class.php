<?php
namespace Redreams\Components;

use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

Loader::includeModule('sale');

class Contractor extends \CBitrixComponent
{
    public $userID;
    public $conctractorID;

    public function executeComponent()
    {
        $this->userID = $GLOBALS['USER']->GetID();

        if($this->request->getPost('contractor'))
        {
            $this->setContractor($this->request->getPost('contractor'));
        }

        $this->getCurentProfile();

        $this->getProfiles();
        $this->includeComponentTemplate();
    }
    public function getProfiles()
    {
        if($this->userID)
        {
            $ob = \CSaleOrderUserProps::GetList([],['USER_ID' => $this->userID,'PERSON_TYPE_ID'=>[1,2,3,4]], false, false, array('*', 'XML_ID'));
            while($profile = $ob->GetNext())
            {
                if($profile['ID']==$this->conctractorID)
                {
                    $profile['SELECTED'] = true;
                }

                $result[] = $profile;
            }
        }

        $this->arResult['PROFILES'] = $result;
    }

    public function getCurentProfile()
    {
        $user = \CUser::GetList($by,$order,['ID'=>$this->userID],["SELECT"=>['UF_CONTRACTOR']])->GetNext();
        $this->conctractorID = $user['UF_CONTRACTOR'];
    }

    public function setContractor($id)
    {
        $user = new \CUser();
        $user->Update($this->userID,['UF_CONTRACTOR' => $id]);
    }
}