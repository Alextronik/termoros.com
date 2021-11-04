<?php
/**
 * Created by Notepad++.
 * User: LizoCom
 * Date: 17.10.2017
 * Time: 13:20
 */

namespace Redreams\Partners;


use Bitrix\Main\Loader;

class store
{
    function __construct()
    {
		\CModule::IncludeModule('iblock');
		\CModule::IncludeModule('catalog');
		\CModule::IncludeModule('sale');

    }

    function import($fileName)
    {
		$import = new import($fileName);
		
		$res = \CIBlockElement::GetList(
			Array(),
			Array("IBLOCK_ID" => 4, "ACTIVE" => "Y"),
			false,
			false,
			Array("ID", "IBLOCK_ID", "XML_ID", "ID", "NAME")
		);
		while($el = $res->GetNext())
		{
			$elements[$el["ID"]] = $el; 
			$elementsXML[$el["XML_ID"]] = $el;
		}
		
		
		
		
		$stores = $import->parseNode('A');
		foreach($stores as $store)
		{
			foreach ($store->attributes() as $k => $v) {
                $resultStore[$k] = (string)$v;
            }
			$storesXML[$resultStore["Id"]][$resultStore["Ids"]] = $resultStore["C"];
			
		}
		
		unset($stores);
		unset($resultStores);
		
		$rStore = \CCatalogStore::GetList(
		 array(),
		 array(),
		 false,
		 false,
		 array('*')
		);
		while($s = $rStore->GetNext())
		{
			$storesIdtoXML[$s["ID"]] = $s["XML_ID"];
			$storesXMLtoID[$s["XML_ID"]] = $s["ID"];
		}
		
		
		$rsStore = \CCatalogStoreProduct::GetList(
			array(),
			array(), 
			false,
			false,
			array("ID", "STORE_ID", "XML_ID", "PRODUCT_ID", "AMOUNT")
		);
		$q = 0;
		
		while($s = $rsStore->GetNext())
		{
			if ($storesXML[$elements[$s["PRODUCT_ID"]]["XML_ID"]][$storesIdtoXML[$s["STORE_ID"]]])
			{
				//Update Остатка
				if ($storesXML[$elements[$s["PRODUCT_ID"]]["XML_ID"]][$storesIdtoXML[$s["STORE_ID"]]] != $s["AMOUNT"])
				{
					//var_dump($s["PRODUCT_ID"].' - '.$elements[$s["PRODUCT_ID"]]["XML_ID"].' REST1: '.$storesXML[$elements[$s["PRODUCT_ID"]]["XML_ID"]][$storesIdtoXML[$s["STORE_ID"]]].' ||| REST2: '.$s["AMOUNT"]);
					$arFields = Array(
						"PRODUCT_ID" => $s["PRODUCT_ID"],
						"STORE_ID" => $s["STORE_ID"],
						"AMOUNT" => $storesXML[$elements[$s["PRODUCT_ID"]]["XML_ID"]][$storesIdtoXML[$s["STORE_ID"]]],
					);
					$ID = \CCatalogStoreProduct::Update($s["ID"], $arFields);
				}
				unset($storesXML[$elements[$s["PRODUCT_ID"]]["XML_ID"]][$storesIdtoXML[$s["STORE_ID"]]]);
			}
			elseif ($s["AMOUNT"])
			{
				if ($elements[$s["PRODUCT_ID"]])
				{
					//Обнуляем остаток
					$arFields = Array(
						"PRODUCT_ID" => $s["PRODUCT_ID"],
						"STORE_ID" => $s["STORE_ID"],
						"AMOUNT" => 0,
					);
					$ID = \CCatalogStoreProduct::Update($s["ID"], $arFields);
				}
			}
			
			/*
			if ($storesXML[$elements[$s["PRODUCT_ID"]]["XML_ID"]] && $storesXML[$elements[$s["PRODUCT_ID"]]["XML_ID"]][$storesIdtoXML[$s["STORE_ID"]]])
			{
				var_dump($s);
				var_dump($storesXML[$elementsXML[$s["PRODUCT_ID"]]][$storesIdtoXML[$s["STORE_ID"]]]);
				die();
			}
			*/
			
		}
		
		foreach($storesXML as $k => $v)
		{
			if ($k && $v)
			{
				foreach($v as $storeXML => $quantity)
				{
					$arFields = Array(
						"PRODUCT_ID" => $elementsXML[$k]["ID"],
						"STORE_ID" => $storesXMLtoID[$storeXML],
						"AMOUNT" => $quantity,
					);
					
					$ID = \CCatalogStoreProduct::Add($arFields);
				}
			}
		}
		
		
		
    }

    function add($params)
    {
		
    }
	
	function update($id, $params)
    {
		
    }
	

    function delete($id)
    {
        
    }
	
	function getlist($params)
    {
		
    }
	
}