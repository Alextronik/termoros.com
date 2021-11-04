<?php
/**
 * Created by Notepad++.
 * User: LizoCom
 * Date: 17.10.2017
 * Time: 13:20
 */

namespace Redreams\Partners;


use Bitrix\Main\Loader;

class price
{
    function __construct()
    {
		\CModule::IncludeModule('iblock');
		\CModule::IncludeModule('catalog');
		\CModule::IncludeModule('sale');
        ini_set('memory_limit', '1024M');
    }

    function import($fileName)
    {
		$import = new import($fileName);
        $pricesXML = [];
        $elements = [];

		$prices = $import->parseNode('A');
		foreach($prices as $price)
		{
			$resultPrices = array();
			foreach ($price->attributes() as $k => $v) {
                $resultPrices[$k] = (string)$v;
            }
			$pricesXML[$resultPrices["Id"]] = $resultPrices;
		}

		$res = \CIBlockElement::GetList(
			Array(),
			Array("IBLOCK_ID" => 4, "ACTIVE" => "Y"),
			false,
			false,
			Array("ID", "IBLOCK_ID", "XML_ID", "PROPERTY_TSENOVAYA_GRUPPA", "NAME")
		);
		while($el = $res->fetch())
		{
			$elements[$el["ID"]] = $el; 
			//$elementsXML[$el["XML_ID"]] = $el;
		}
        unset($prices);
        unset($resultPrices);
		unset($res);
        //var_dump(current($pricesXML));
		//var_dump(current($elements));

        if ($pricesXML && $elements)
        {
            foreach ($elements as $k=>$v){
                // default price
                $price_def = \Bitrix\Catalog\Model\Price::getList(["filter" => ["PRODUCT_ID" => $k,"CATALOG_GROUP_ID" => 2]]);
                if ($pricesXML[$v["XML_ID"]]["P"])
                {
                    $arFieldsDef = Array(
                        "CATALOG_GROUP_ID" => 2,
                        "PRODUCT_ID" => $v["ID"],
                        "PRICE" => $pricesXML[$v["XML_ID"]]["P"],
                        "CURRENCY" => "RUB"
                    );

                    if ($arPrice = $price_def->fetch()) {
                        if($pricesXML[$v["XML_ID"]]["P"] != $arPrice['PRICE']) {
                            $resultDef = \Bitrix\Catalog\Model\Price::update($arPrice['ID'], $arFieldsDef);
                                if ($resultDef->isSuccess()) {
                                    //echo "Обновили цену DEF у товара у элемента каталога " . $k . " Цена " . $pricesXML[$v["XML_ID"]]["P"] . PHP_EOL;
                                } else {
                                    echo "Ошибка обновления цены DEF у товара у элемента каталога " . $k . "-" . $arPrice['ID'] . " Ошибка " . $resultDef->getErrorMessages()[0] . PHP_EOL;
                                }
                            }
                        }else{
                            $resultDef = \Bitrix\Catalog\Model\Price::add($arFieldsDef);
                            if ($resultDef->isSuccess()) {
                                //echo "Добавили цену DEF у товара у элемента каталога " . $k . " Цена " . $pricesXML[$v["XML_ID"]]["P"] . PHP_EOL;
                            } else {
                                echo "Ошибка добавления цены DEF у товара у элемента каталога " . $k . "-" . $arPrice['ID'] . " Ошибка " . $resultDef->getErrorMessages()[0] . PHP_EOL;
                            }
                    }
                }

                // price group
                if ($pricesXML[$v["XML_ID"]]["PG"] && $pricesXML[$v["XML_ID"]]["PG"] != $v["PROPERTY_TSENOVAYA_GRUPPA_VALUE"])
                {
                    \CIBlockElement::SetPropertyValueCode($k, "TSENOVAYA_GRUPPA", $pricesXML[$v["XML_ID"]]["PG"]);
                }

                // rrc price
                $price_rrc = \Bitrix\Catalog\Model\Price::getList(["filter" => ["PRODUCT_ID" => $k,"CATALOG_GROUP_ID" => 3]]);
                if ($pricesXML[$v["XML_ID"]]["R"])
                {
                    $arFieldsRRC = Array(
                        "CATALOG_GROUP_ID" => 3,
                        "PRODUCT_ID" => $v["ID"],
                        "PRICE" => $pricesXML[$v["XML_ID"]]["R"],
                        "CURRENCY" => "RUB"
                    );

                    if ($arPrice = $price_rrc->fetch()) {
                        if($pricesXML[$v["XML_ID"]]["R"] != $arPrice['PRICE']) {
                            $resultRRC = \Bitrix\Catalog\Model\Price::update($arPrice['ID'], $arFieldsRRC);
                            if ($resultRRC->isSuccess()) {
                                //echo "Обновили цену RRC у товара у элемента каталога " . $k . " Цена " . $pricesXML[$v["XML_ID"]]["R"] . PHP_EOL;
                            } else {
                                echo "Ошибка обновления цены RRC у товара у элемента каталога " . $k . "-" . $arPrice['ID'] . " Ошибка " . $resultRRC->getErrorMessages()[0] . PHP_EOL;
                            }
                        }
                    }else{
                        $resultRRC = \Bitrix\Catalog\Model\Price::add($arFieldsRRC);
                        if ($resultRRC->isSuccess()) {
                            //echo "Добавили цену RRC у товара у элемента каталога " . $k . " Цена " . $pricesXML[$v["XML_ID"]]["P"] . PHP_EOL;
                        } else {
                            echo "Ошибка добавления цены RRC у товара у элемента каталога " . $k . "-" . $arPrice['ID'] . " Ошибка " . $resultRRC->getErrorMessages()[0] . PHP_EOL;
                        }
                    }
                }
            }
            /*
            // set default price & prop "PROPERTY_TSENOVAYA_GRUPPA"
            $price_def = \Bitrix\Catalog\PriceTable::getList([
                "select" => ["*"],
                "filter" => [
                    "CATALOG_GROUP_ID" => 2
                ]
            ]);
            while($ar = $price_def->Fetch())
            {
                if ($elements[$ar["PRODUCT_ID"]]["XML_ID"])
                {
                    if ($pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["P"] && $pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["P"] != $ar["PRICE"])
                    {
                        $arFields = Array(
                            "CATALOG_GROUP_ID" => 2,
                            "PRODUCT_ID" => $ar["PRODUCT_ID"],
                            "PRICE" => $pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["P"],
                            "CURRENCY" => "RUB"
                        );

                        \Bitrix\Catalog\Model\Price::update($ar["ID"], $arFields);

                    }
                }

                if ($pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["PG"] && $pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["PG"] != $elements[$ar["PRODUCT_ID"]]["PROPERTY_TSENOVAYA_GRUPPA_VALUE"])
                {
                    \CIBlockElement::SetPropertyValueCode($ar["PRODUCT_ID"], "TSENOVAYA_GRUPPA", $pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["PG"]);
                }
            }




            // set RRC price
            $price_rrc = \Bitrix\Catalog\PriceTable::getList([
                "select" => ["*"],
                "filter" => [
                    "CATALOG_GROUP_ID" => 3
                ]
            ]);
            //var_dump($price_rrc);
            while($ar = $price_rrc->Fetch())
            {
                //var_dump($ar["PRODUCT_ID"]);
                if ($elements[$ar["PRODUCT_ID"]]["XML_ID"])
                {
                    //if($pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["Id"] == "d49cedb5-afca-11ea-a2be-0cc47a1d85d9") {
                        //var_dump($pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["Id"]);
                    //}
                    //var_dump($ar["PRODUCT_ID"]);
                    if ($pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["R"])
                    {
                        //var_dump($ar);
                        $arFields = Array(
                            "CATALOG_GROUP_ID" => 3,
                            "PRODUCT_ID" => $ar["PRODUCT_ID"],
                            "PRICE" => $pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["R"],
                            "CURRENCY" => "RUB"
                        );

                        $result =  \Bitrix\Catalog\Model\Price::update($ar["ID"], $arFields);
                        if ($result->isSuccess())
                        {
                            //echo "Обновили цену у товара у элемента каталога " . $ar["PRODUCT_ID"] . " Цена " . $price . PHP_EOL;
                        }
                        else {
                            //echo "Ошибка обновления цены у товара у элемента каталога " . $ar["PRODUCT_ID"] . " Ошибка " . $result->getErrorMessages() . PHP_EOL;
                        }
                    }
                }
            }
            */
        }


/*
		if ($pricesXML)
		{
			$r = \CPrice::GetList(
			array(),
			array(
					"CATALOG_GROUP_ID" => 3
				)
			);
			while($ar = $r->Fetch())
			{
				$pricesGroup3[$ar["PRODUCT_ID"]] = $ar;
				if ($elements[$ar["PRODUCT_ID"]]["XML_ID"])
				{
					if ($pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["R"] && $pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["R"] != $ar["PRICE"] && $pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["R"] != $pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["P"])
					{
						
						$arFields = Array(
							"PRICE" => $pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["R"],
						);
						
						//var_dump($arFields);
						\CPrice::Update($ar["ID"], $arFields);
						
						//die();
					}
					elseif ($pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["R"] && $pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["R"] == $pricesXML[$elements[$ar["PRODUCT_ID"]]["XML_ID"]]["P"])
					{
						\CPrice::Delete($ar["ID"]);
						//die();
					}
					else
					{
						//var_dump($ar);
						//die();
					}
				}
			}
			
			foreach($pricesXML as $xmlID => $priceArr)
			{
				if ($priceArr["R"] && $priceArr["P"] != $priceArr["R"] && !$pricesGroup3[$elementsXML[$priceArr["Id"]]["ID"]])
				{
					//var_dump($priceArr["Id"]);					
					//var_dump($elementsXML[$priceArr["Id"]]["NAME"]);					
					
					$arFields = Array(
						"PRICE" => $priceArr["R"],
						"PRODUCT_ID" => $elementsXML[$priceArr["Id"]]["ID"],
						"CATALOG_GROUP_ID" => 3,
						"CURRENCY" => 'RUB',
					);
					
					//var_dump('ADD');
					
					//if ($arFields["PRODUCT_ID"] == '64188')
					//{
						//var_dump($arFields);
					
						\CPrice::Add($arFields);
					
						//die();
					//}
					
				}
			}
		}
*/
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