<?php
/**
 * Created by PhpStorm.
 * User: bearl
 * Date: 05.07.2016
 * Time: 2:50
 */

namespace Redreams\Partners;


use Bitrix\Main\Loader;

class discounts
{
    private static $_instance = null;
    private $priceMatrixIBlockID = 4;
    private $priceGroupPropCode = 'TSENOVAYA_GRUPPA';
    static $priceGroupPropCodeStatic = "TSENOVAYA_GRUPPA";
    private $discountGroups;
    private $products;
    private $productsToBasketItems;
	private $priceMatrixArray = [];
	
    private function __construct($params)
    {
        $this->params = $params;
        Loader::includeModule('highloadblock');
    }

    protected function __clone() {

    }

    static public function getInstance($params = NULL) {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self($params);
        }
        else
        {
            self::$_instance->setParams($params);
        }

        return self::$_instance;
    }

    function setParams($params)
    {
        $this->params = $params;
    }

    function setProducts($products)
    {
        $this->products = $products;
    }

    public function getBasket()
    {
        
		
		if(!$this->products)
        {
            $result = array();

            \Bitrix\Main\Loader::includeModule('sale');

            $dbBasketItems = \CSaleBasket::GetList(
                array(
                    "PRICE" => "ASC",
                    "ID" => "ASC"
                ),
                array(
                    "FUSER_ID" => \CSaleBasket::GetBasketUserID(),
                    "ORDER_ID" => "NULL",
                    "CAN_BUY" => "Y",
                    "DELAY" => "N"
                ),
                false,
                false,
                array(
                    'PRODUCT_ID',
                    'ID'
                )
            );

            while ($basketItem = $dbBasketItems->Fetch())
            {
                $products[] = $basketItem['PRODUCT_ID'];
                $this->productsToBasketItems[$basketItem['ID']] = $basketItem['PRODUCT_ID'];
            }

            $groups = [];

            if($products)
            {
                $dbItems = \CIBlockElement::GetList(
                    [],['ID' => $products,'IBLOCK_ID' => 4],false,['nTopCount' => count($products)],['IBLOCK_ID','NAME','ID','PROPERTY_'.$this->priceGroupPropCode]
                );

                while($item = $dbItems->GetNext())
                {
                    if($item['PROPERTY_'.$this->priceGroupPropCode."_VALUE"])
                    {
                        $groups[$item['PROPERTY_'.$this->priceGroupPropCode."_VALUE"]][] = $item['ID'];
                    }

                }

                $this->products = $groups;
            }

        }
        else
        {
            $result = $this->products;
        }

        return $result;
    }

    public function processDiscount()
    {
		if(!$this->discountGroups && $this->products)
        {
            $this->discountGroups = $this->getDiscountByPriceGroup();
        }
		
        if($this->discountGroups)
        {
            foreach($this->products as $group => $products)
            {
                foreach($products as $id) {
                    $itemsToDiscounts[$id] = $this->discountGroups[$group];
                }
            }

        }
		
		$NozPrice = 0;
		
        if($itemsToDiscounts[$this->productsToBasketItems[$this->params['ID']]])
        {
            $discount = $itemsToDiscounts[$this->productsToBasketItems[$this->params['ID']]];

            if($discount > 0)
            {
				$oldPrice = $this->params['fields']['PRICE'];
                $discountPrice = round($this->params['fields']['PRICE']*($discount/100),2);
                $price = round($this->params['fields']['PRICE'] - $discountPrice,2);

				global $USER;
				\Bitrix\Main\Loader::includeModule('sale');
				\Bitrix\Main\Loader::includeModule('catalog');
				$dbPrice = \CPrice::GetList(
						array("QUANTITY_FROM" => "ASC", "QUANTITY_TO" => "ASC", "SORT" => "ASC"),
						array("PRODUCT_ID" => $this->params["fields"]["PRODUCT_ID"]),
						false,
						false,
						array("ID", "CATALOG_GROUP_ID", "PRICE", "CURRENCY", "QUANTITY_FROM", "QUANTITY_TO")
					);
				while ($arPrice = $dbPrice->Fetch())
				{
					$arDiscounts = \CCatalogDiscount::GetDiscountByPrice(
							$arPrice["ID"],
							$USER->GetUserGroupArray(),
							"N",
							SITE_ID
						);
					$dPrice = \CCatalogProduct::CountPriceWithDiscount(
							$arPrice["PRICE"],
							$arPrice["CURRENCY"],
							$arDiscounts
						);
					
					
					
					$NozPrice = $dPrice;

					if ($NozPrice > $dPrice || !$NozPrice)
					{
						$NozPrice = $dPrice;
					}
					
					
				}
				
				

				global $USER;
				if ($USER->GetID() == 191111){
					var_dump($NozPrice);
					var_dump($oldPrice);
					var_dump($discountPrice);
					var_dump($price);
				}

				
				
				if ($NozPrice && $NozPrice <= $price && $NozPrice != $this->params['fields']['PRICE'])
				{
					
					$this->params['fields']['PRICE'] = $NozPrice;
                    $this->params['fields']['DISCOUNT_PRICE'] =  $this->params['fields']['BASE_PRICE'] - $NozPrice;
					
                    /*$this->params['fields']['DISCOUNT_VALUE'] =  $discount;*/
					$this->params['fields']['CUSTOM_PRICE'] = "Y";
					$this->params['fields']['OLD_PRiCE'] = $oldPrice;
					
				}
				elseif($this->params['fields']['CUSTOM_PRICE'] != 'Y' && $this->params['fields']['BASE_PRICE'] == $this->params['fields']['PRICE'])
                {
                    $this->params['fields']['PRICE'] = $price;
                    $this->params['fields']['DISCOUNT_PRICE'] = $discountPrice;
                    $this->params['fields']['DISCOUNT_VALUE'] = $discount;
                    $this->params['fields']['CUSTOM_PRICE'] = "Y";
                    $this->params['fields']['OLD_PRiCE'] = $oldPrice;
                }
				
				/*
				if ($NozPrice && $NozPrice != $this->params['fields']['PRICE'])
				{
					$this->params['fields']['DISCOUNT_PRICE'] = $this->params['fields']['BASE_PRICE'] - $NozPrice;
				}
				*/
				
				/*
				if ($NozPrice)
				{
					$this->params['fields']['PRICE'] = $price;
                    $this->params['fields']['DISCOUNT_PRICE'] = $price - $NozPrice;
                    $this->params['fields']['DISCOUNT_VALUE'] =  $discount;
                    $this->params['fields']['CUSTOM_PRICE'] = "N";
                    $this->params['fields']['OLD_PRiCE'] = $oldPrice;
				}
				*/
				
				
            }
        }
		else
		{
			global $USER;
			
			\Bitrix\Main\Loader::includeModule('sale');
			\Bitrix\Main\Loader::includeModule('catalog');
			$dbPrice = \CPrice::GetList(
					array("QUANTITY_FROM" => "ASC", "QUANTITY_TO" => "ASC", "SORT" => "ASC"),
					array("PRODUCT_ID" => $this->params["fields"]["PRODUCT_ID"]),
					false,
					false,
					array("ID", "CATALOG_GROUP_ID", "PRICE", "CURRENCY", "QUANTITY_FROM", "QUANTITY_TO")
				);
			while ($arPrice = $dbPrice->Fetch())
			{
				$arDiscounts = \CCatalogDiscount::GetDiscountByPrice(
						$arPrice["ID"],
						$USER->GetUserGroupArray(),
						"N",
						SITE_ID
					);
				$discountPrice = \CCatalogProduct::CountPriceWithDiscount(
						$arPrice["PRICE"],
						$arPrice["CURRENCY"],
						$arDiscounts
					);
				$arPrice["DISCOUNT_PRICE"] = $discountPrice;

				if ($NozPrice > $discountPrice || !$NozPrice)
				{
					$NozPrice = $discountPrice;
				}
			}

			if ($NozPrice && $NozPrice != $this->params['fields']['PRICE'])
			{
				$this->params['fields']['DISCOUNT_PRICE'] = $this->params['fields']['BASE_PRICE'] - $NozPrice;
			}
			
		}

        return $this->params['fields'];

    }

    public function getDiscountByPriceGroup()
    {
        global $USER;
		
        $priceGroups = $this->products;

        $partner = $this->getPartner();

        if($partner)
        {
            $hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->priceMatrixIBlockID)->fetch();
            $hlentity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);

            $query = new \Bitrix\Main\Entity\Query($hlentity);
            $query->setLimit(count(array_keys($priceGroups)));
            $query->setSelect(['UF_DISCOUNT_VALUE','UF_PRICE_GROUP']);
            $query->setFilter(['UF_PARTNER' => $partner, "UF_PRICE_GROUP" => array_keys($priceGroups)]);

            $result = $query->exec();

            $discounts = [];

            if ($result->getSelectedRowsCount() > 0) {
                while($discount = $result->fetch())
                {
                    $discounts[$discount['UF_PRICE_GROUP']] = $discount['UF_DISCOUNT_VALUE'];
                }
            }

            return $discounts;
        }
    }

    public function getPartner()
    {
        global $USER;
        if($USER->IsAuthorized())
        {
            return \CUser::GetList($by,$order,['ID'=>$USER->GetID()])->GetNext()['XML_ID'];
        }
    }

    /**
     * @param $products array [PROPERTY_PRICE_GROUP => [PRODUCT_ID_1,PRODUCT_ID_2,...],...
     * @return array [UF_PRICE_GROUP => UF_DISCOUNT_VALUE],...
     */

    public static function getDiscountsByProducts($products)
    {
		$discount = \Redreams\Partners\discounts::getInstance([]);
        $discount->setProducts($products);
        return $discount->getDiscountByPriceGroup();
    }

    public static function processPartnerDiscount(&$result)
    {
		if ($result['ITEMS'])
        {
			foreach($result['ITEMS'] as $k => $item)
            {
				
				$result['ITEMS'][$k]["MIN_PRICE"]["FULL_BASE_PRICE"] = $item["MIN_PRICE"]["VALUE"];
			}
		}
		else
		{
			$result["MIN_PRICE"]["FULL_BASE_PRICE"] = $result["MIN_PRICE"]["VALUE"];
		}
		
		
		//var_dump($result);
		if(partner::isPartner()) {
            $products = [];
            $discounts = [];
			
			global $USER;
            
			
			if ($result['ITEMS'])
            {
                foreach($result['ITEMS'] as $k => $item)
                {
					if($item['PROPERTIES'][self::$priceGroupPropCodeStatic]['VALUE'])
                    {
                        $products[$item['PROPERTIES'][self::$priceGroupPropCodeStatic]['VALUE']][] = $item['ID'];
                    }
                }

                $discounts = self::getDiscountsByProducts($products);

				
				
				foreach($result['ITEMS'] as $k => $item)
                {
					$price = ($item['CATALOG_PRICE_2']) ? $item['CATALOG_PRICE_2'] : $item['MIN_PRICE']['VALUE'];
                    //var_dump($price);
					
					$priceGroup =  $item['PROPERTIES'][self::$priceGroupPropCodeStatic]['VALUE'];
                    //var_dump($priceGroup);
                    if($priceGroup)
                    {
                        //var_dump($price);
                        $discountValue = $discounts[$priceGroup];
                        $discountPrice = round($price*($discountValue/100),2);
                        $result['ITEMS'][$k]["MIN_PRICE"]["VALUE"] = round(($price - $discountPrice),2);
                        $result['ITEMS'][$k]["MAX_PRICE"]["VALUE"] = $price;
                    }
                }
                //var_dump($result["MIN_PRICE"]);
            }
            else
            {
                if($result['PROPERTIES'][self::$priceGroupPropCodeStatic]['VALUE'])
                {
                    $products[$result['PROPERTIES'][self::$priceGroupPropCodeStatic]['VALUE']][] = $result['ID'];
                }

                $discounts = self::getDiscountsByProducts($products);

                $price = $result['CATALOG_PRICE_2'];
                //var_dump($price);
                $priceGroup =  $result['PROPERTIES'][self::$priceGroupPropCodeStatic]['VALUE'];
                if($priceGroup)
                {
                    $discountValue = $discounts[$priceGroup];

                    $discountPrice = round($price*($discountValue/100),2);
                    //var_dump($discountPrice);
                    $result["MIN_PRICE"]["VALUE"] = round(($price - $discountPrice),2);
                    $result["MAX_PRICE"]["VALUE"] = $price;
                    //var_dump($result["MIN_PRICE"]["VALUE"]);
                }

            }
        } else {
            if ($result['ITEMS'])
            {
                foreach($result['ITEMS'] as $k => $item)
                {
                    if ($item["MIN_PRICE"]["DISCOUNT_VALUE"])
                    {


                        if ($item["MIN_PRICE"]["VALUE"] > $item["MIN_PRICE"]["DISCOUNT_VALUE"])
                        {
                            $result['ITEMS'][$k]["MAX_PRICE"]["VALUE"] = $item["MIN_PRICE"]["FULL_BASE_PRICE"];
                            $result['ITEMS'][$k]["MIN_PRICE"]["VALUE"] = $item["MIN_PRICE"]["DISCOUNT_VALUE"];
                            $result['ITEMS'][$k]["SALE"] = TRUE;

                        }
                    }
                    //PRICE 3 < PRICE 2
                    if ($item["PRICES"]["СлужебноеДляСайта (розничные цены)"]["VALUE"] > $item["MIN_PRICE"]["VALUE"])
                    {
                        $result['ITEMS'][$k]["MAX_PRICE"]["VALUE"] = $item["PRICES"]["СлужебноеДляСайта (розничные цены)"]["VALUE"];
                    }


                }
            }
            else
            {
                if ($result["MIN_PRICE"]["DISCOUNT_VALUE"])
                {
                    //v($result);
                    //v($result["PRICES"]["СлужебноеДляСайта (розничные цены)"]["VALUE"]);

                    if ($result["MIN_PRICE"]["VALUE"] > $result["MIN_PRICE"]["DISCOUNT_VALUE"])
                    {
                        $result["MAX_PRICE"]["VALUE"] = $result["MIN_PRICE"]["FULL_BASE_PRICE"];
                        $result["MIN_PRICE"]["VALUE"] = $result["MIN_PRICE"]["DISCOUNT_VALUE"];
                        $result["SALE"] = TRUE;
                    }

                    //PRICE 3 < PRICE 2
                    if ($result["PRICES"]["СлужебноеДляСайта (розничные цены)"]["VALUE"] > $result["MIN_PRICE"]["VALUE"])
                    {
                        $result["MAX_PRICE"]["VALUE"] = $result["PRICES"]["СлужебноеДляСайта (розничные цены)"]["VALUE"];
                    }


                }
            }
        }
		

		
    }

    public function import($fileName)
    {
        $import = new import($fileName);
        $agreements = $import->parseNode('Соглашение');

        //p($agreements);
		$hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->priceMatrixIBlockID)->fetch();
		$hlentity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
		$hl_class = $hlentity->getDataClass();
		
		$r = $hl_class::getList(['select'=>['*']]);

		while($res = $r->fetch())
		{
			if (!$this->priceMatrixArray[$res['UF_PRICE_GROUP'].' '.$res['UF_PARTNER']])
				$this->priceMatrixArray[$res['UF_PRICE_GROUP'].' '.$res['UF_PARTNER']] = $res;
			else
			{
				//echo $res['ID'].'<br>';
				$hl_class::delete($res['ID']);
				
			}
		}
		
		/*
		$hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->priceMatrixIBlockID)->fetch();
		if($hldata["TABLE_NAME"] !="")
		{
			\Bitrix\Main\Application::getConnection()->queryExecute('TRUNCATE TABLE ' . $hldata["TABLE_NAME"]);
		}
		*/
		
		
        foreach($agreements as $agreement)
        {
            foreach($agreement->attributes() as $k => $v)
            {
                $resultAgreements[$k] = (string)$v;
            }

			$this->addAgreement($resultAgreements);
			$agrs[$resultAgreements['PriceGroup_id'].' '.$resultAgreements['Client_id']] = 1;
			
        }
		
		foreach($this->priceMatrixArray as $k => $v)
		{
			if ($agrs[$k])
			{
				
			}
			else
			{
				//Удалить лишние
				$hl_class::delete($v['ID']);
				echo 'd';
			}
		}
		
    }

    function addAgreement($resultAgreements)
    {
        $fields = [
            'UF_PARTNER' => $resultAgreements['Client_id'],
            'UF_PRICE_GROUP' => $resultAgreements['PriceGroup_id'],
            'UF_DISCOUNT_VALUE' => $resultAgreements['Discount'],
            'UF_XML_ID' => $resultAgreements['Agreement_id'],
        ];

        

		$hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->priceMatrixIBlockID)->fetch();
		$hlentity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
		$hl_class = $hlentity->getDataClass();
		
		if ($this->priceMatrixArray[$resultAgreements['PriceGroup_id'].' '.$resultAgreements['Client_id']]['ID'])
		{
			if ($this->priceMatrixArray[$resultAgreements['PriceGroup_id'].' '.$resultAgreements['Client_id']]['UF_DISCOUNT_VALUE'] != $resultAgreements['Discount'])
			{
				$result = $hl_class::update($this->priceMatrixArray[$resultAgreements['PriceGroup_id'].' '.$resultAgreements['Client_id']]['ID'],$fields);
				//echo 'r';
			}
		}
		else
		{
			$result = $hl_class::add($fields);
			//echo 'i';
		}
		
        /*if($result = $hl_class::getList([
            'filter'=>['UF_XML_ID'=>$resultAgreements['Agreement_id'],'UF_PRICE_GROUP'=>$resultAgreements['PriceGroup_id']],
            'select'=>['*']])->fetch()
        )
        {
            $result = $hl_class::update($result['ID'],$fields);
        }
        else
        {
        $result = $hl_class::add($fields);
        }
		*/
    }

}