<?php

namespace Redreams\Supply;

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Highloadblock as HL;
use Bitrix\Main\Type\DateTime;


Loc::loadMessages(__FILE__);

class SupplyInfo
{
     static $HlBlockId = "6";


    public static function GetSupply($ElementId, $StoreId)
    {
        \Bitrix\Main\Loader::includeModule('iblock');
        \Bitrix\Main\Loader::includeModule('catalog');
        \Bitrix\Main\Loader::includeModule("highloadblock");

        $hlblock = HL\HighloadBlockTable::getById(self::$HlBlockId)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $dbSupplys = $entity_data_class::getList(
            [
                "filter" => ["UF_ELEMENT_ID"=>$ElementId,"UF_STORE_ID"=>$StoreId,">UF_DATE"=>new DateTime()],
                "order" => ["UF_DATE"=>"ASC"],
                "limit" => 2
            ]
        );
        while ($arSupplys = $dbSupplys -> fetch())
        {
           $arRez[] = $arSupplys;
        }
        
        return $arRez;

    }
}
