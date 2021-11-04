<?php
namespace Termoros;

use Bitrix\Main\Loader;

class Main extends \CModule
{
    /**
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    static function getAllProducts()
    {
        return \Bitrix\Iblock\ElementTable::getList(array(
            'select' => array('ID','XML_ID'),
            'filter' => array('IBLOCK_ID' => 4, "ACTIVE"=>"Y")
        ))->fetchAll();
    }

    /**
     * @param $partner_xml_id
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    static function getPriceMatrix($partner_xml_id)
    {
        Loader::includeModule("highloadblock");
        $hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById(4)->fetch();
        $hlentity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);

        $query = new \Bitrix\Main\Entity\Query($hlentity);
        $query->setSelect(['UF_DISCOUNT_VALUE','UF_PRICE_GROUP']);
        $query->setFilter(['UF_PARTNER' => $partner_xml_id]);
        $query->setCacheTtl(86400);
        return $query->exec()->fetchAll();
    }

    /** get props type L
     * @return array
     */
    static function getPropsTypeL()
    {
        $propsValAr = \Bitrix\Iblock\PropertyEnumerationTable::getList(array(
            'cache' => array('ttl' => 86400,'cache_joins' => true)
        ))->fetchAll();
        $propsArray = [];
        foreach ($propsValAr as $k=>$v){
            $propsArray[$v['ID']] = $v;
        }
        return $propsArray;
    }

    static function delInactiveProducts()
    {
        $allProducts = \Bitrix\Iblock\ElementTable::getList(array(
            'select' => array('ID'),
            'filter' => array('IBLOCK_ID' => 4,'ACTIVE' => "N"),
            'limit' => 3000,
            'cache' => array(
                'ttl' => 0,
                'cache_joins' => true
            ),
        ))->fetchAll();
        $el = new \CIBlockElement;
        foreach($allProducts as $k=>$v)
        {
            $el->Delete($v['ID']);
            echo 'el ' . $v['ID'] . 'deleted<br>';
        }
    }

    /** REINDEX FASET
     * @param $iblockId
     * @return int
     */
    static function reindexCatalogFaset($iblockId) {

        $max_execution_time = 20;

        // Пересоздание фасетного индекса
        // Удалим имеющийся индекс
        \Bitrix\Iblock\PropertyIndex\Manager::dropIfExists($iblockId);
        \Bitrix\Iblock\PropertyIndex\Manager::markAsInvalid($iblockId);

        // Создадим новый индекс
        $index = \Bitrix\Iblock\PropertyIndex\Manager::createIndexer($iblockId);
        $index->startIndex();
        $NS = 0;

        do {
            $res = $index->continueIndex($max_execution_time);
            $NS += $res;
        } while($res > 0);

        $index->endIndex();

        // чистим кэши
        \CBitrixComponent::clearComponentCache("bitrix:catalog.smart.filter");
        \CIBlock::clearIblockTagCache($iblockId);

        return $NS;
    }

    // HL USE PROPS
    static function updPropsTable()
    {
        Loader::includeModule("highloadblock");

        $hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById(11)->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData);
        $entity_data_class = $entity->getDataClass();
        $res = $entity_data_class::getList()->fetchAll();
        //var_dump($res);

        $arProps = \Bitrix\Iblock\PropertyTable::getList(array(
            'order' => array('ID' => "asc"),
            'select' => array('CODE','ID','NAME','XML_ID','SMART_FILTER'),
            'filter' => array('IBLOCK_ID' => 4,'ACTIVE' => 'Y'),
            //'cache' => array('ttl' => 86400,'cache_joins' => true)
        ))->fetchAll();

        // add & update
        foreach($arProps as $k=>$v){
            // find existed by ID
            $found_key = array_search($v['ID'], array_column($res, "UF_PROP_ID"));

            if($found_key === false){// add new
                $entity_data_class::add(array(
                    'UF_PROP_ID' => $v['ID'],
                    'UF_PROP_CODE' => $v['CODE'],
                    'UF_NAME' => $v['NAME'],
                    'UF_STATUS'   => '0',
                    'UF_STATUS_DETAIL'   => '0',
                    'UF_GUID'   => $v['XML_ID']
                ));
            }else{
                //var_dump($res[$found_key]['ID'],$v);
                //var_dump($v);
                $entity_data_class::update($res[$found_key]['ID'],array(
                    'UF_PROP_ID' => $v['ID'],
                    'UF_PROP_CODE' => $v['CODE'],
                    'UF_NAME' => $v['NAME'],
                    'UF_GUID'   => $v['XML_ID'],
                ));
            }
        }

        // del
        foreach($res as $k=>$v){
            $found_key = array_search($v['UF_PROP_ID'], array_column($arProps, "ID"));
            if($found_key === false){
                $entity_data_class::delete($v['ID']);
            }
        }
    }

    /**
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    static function getPropsTableHL($code = true)
    {
        $array = [];
        Loader::includeModule("highloadblock");

        $field = ($code == true) ? 'UF_PROP_CODE' : 'UF_PROP_ID';

        $hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById(11)->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData);
        $entity_data_class = $entity->getDataClass();
        $res = $entity_data_class::getList(array(
            'select' => array($field),
            'filter' => array('UF_STATUS_DETAIL'=>'1'),
            'cache' => array('ttl' => 86400)
        ));
        while($el = $res->fetch()){
            $array[] = $el[$field];
        }

        return $array;
    }

}