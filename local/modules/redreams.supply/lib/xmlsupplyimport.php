<?php

namespace Redreams\Supply;

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Highloadblock as HL;


Loc::loadMessages(__FILE__);

class XmlSupplyImport
{
    var $XmlFile = "/1c-services/rests/rests.xml";
    var $HlBlockId = "6";
    var $HlBlockInfo;
    var $IdlockId = "";
    var $XML;
    var $DOM;
    var $ElementMap = [];
    var $StoreMap = [];
    var $arElements = [];

    public static function LoadDate($filePath)
    {
        \Bitrix\Main\Loader::includeModule('iblock');
        \Bitrix\Main\Loader::includeModule('catalog');
        \Bitrix\Main\Loader::includeModule("highloadblock");

        $ob = new XmlSupplyImport;

        if($filePath)
        {
            $ob->XmlFile = $filePath;
        }

        $ob->XMLconnect();
        $ob->XMLread();
        $ob->DecodStore();
        $ob->DecodItem();
        $ob->ClearHL();
        $ob->HLwrite();
    }
    
    private function XMLconnect()
    {
        $this->XML = new \XMLReader;
        $this->XML -> open($_SERVER["DOCUMENT_ROOT"] . $this->XmlFile);
        $this->DOM = new \DOMDocument;
    }
    private function XMLread()
    {
        while ($this->XML -> read() && $this->XML->name != "ПлановоеПоступление");


        while ($this->XML -> name == "ПлановоеПоступление")
        {
            $elem = simplexml_import_dom($this->DOM -> importNode($this->XML->expand(), true));

            $arElement = array(
                "ID" => (string)$elem->Номенклатура->Ид,
                "STORE" => (string)$elem->Склад->Ид,
                "DATE" => (string)$elem->attributes()->ПлановаяДата,
                "QUANTITY" => (string)$elem->Заказано
            );
            if(!in_array($arElement["ID"],$this->ElementMap))
            {
                $this->ElementMap[] = $arElement["ID"];
            }
            if(!in_array($arElement["STORE"],$this->StoreMap))
            {
                $this->StoreMap[] = $arElement["STORE"];
            }
            $this->arElements[] = $arElement;

            $this->XML-> next('ПлановоеПоступление');
        }
    }
    private function DecodStore(){
        $dbStore = \Bitrix\Catalog\StoreTable::getList(
            [
                "filter" => ["XML_ID"=>$this->StoreMap],
                "select" => ["ID","ADDRESS","XML_ID"]
            ]
        );

        while ($arStore = $dbStore->fetch())
        {
            $arStores[$arStore["XML_ID"]] = $arStore["ID"];
        }
        $this->StoreMap = $arStores;
    }
    private function DecodItem(){
        $dbElements = \Bitrix\Iblock\ElementTable::getList(
            [
                "filter" => ["XML_ID"=>$this->ElementMap],
                "select" => ["ID","XML_ID"]
            ]
        );
        while ($arElement = $dbElements->fetch())
        {
            $arElements[$arElement["XML_ID"]] = $arElement["ID"];
        }
        $this->ElementMap = $arElements;
    }
    private function ClearHL()
    {
        $hlblock = HL\HighloadBlockTable::getById($this->HlBlockId)->fetch();
        if($hlblock["TABLE_NAME"] !="")
        {
            \Bitrix\Main\Application::getConnection()->queryExecute('TRUNCATE TABLE ' . $hlblock["TABLE_NAME"]);
            $this->HlBlockInfo = $hlblock;
        }

    }
    private function HLwrite(){
        if(is_array($this->HlBlockInfo))
        {
            $entity = HL\HighloadBlockTable::compileEntity($this->HlBlockInfo);
            $entity_data_class = $entity->getDataClass();
            foreach ($this->arElements as $arElement)
            {
                if($this->ElementMap[$arElement["ID"]] && $this->StoreMap[$arElement["STORE"]])
                {
                    $arField = array(
                        "UF_ELEMENT_ID" => $this->ElementMap[$arElement["ID"]], "UF_DATE" => $arElement["DATE"],
                        "UF_STORE_ID" => $this->StoreMap[$arElement["STORE"]], "UF_QUANTITY" => $arElement["QUANTITY"],
                    );
                    $entity_data_class::add($arField);
                }
            }
        }
    }
}
