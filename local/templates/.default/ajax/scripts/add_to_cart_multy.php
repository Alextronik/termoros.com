<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?
//p($_REQUEST);
if (CModule::IncludeModule("catalog") && CModule::IncludeModule("iblock"))
{
    if(is_array($_REQUEST["ID"]))
	{
        \Bitrix\Main\Diag\Debug::writeToFile($_REQUEST);
	    foreach ($_REQUEST["ID"] as $num => $ID)
		{
			if (IntVal($ID)>0)
			{
                \Bitrix\Main\Diag\Debug::writeToFile(3);
			    $_REQUEST["id"] = $ID;
				$res = CIBlockElement::GetByID($ID);
				if($obRes = $res->GetNextElement())
				{
					$arFields = $obRes->GetFields();
					$ar_art = $obRes->GetProperty("CML2_ARTICLE");
					$ar_brnd = $obRes->GetProperty("BREND");
					$ar_order = $obRes->GetProperty("FOR_ORDER");
					//p($ar_brnd);

					CModule::IncludeModule('highloadblock');
					$hldata = Bitrix\Highloadblock\HighloadBlockTable::getById(3)->fetch();
					$hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
					$Query = new Bitrix\Main\Entity\Query($hlentity);

					//Зададим параметры запроса, любой параметр можно опустить
					$Query->setSelect(array('*'));
					$Query->setFilter(array('UF_XML_ID'=> array($ar_brnd['VALUE'])));
					$Query->setOrder(array('UF_NAME' => 'ASC'));

					//Выполним запрос
					$result = $Query->exec();

					//Получаем результат по привычной схеме
					$result = new CDBResult($result);
					$arLang = array();
					while ($row = $result->Fetch()){
						//p($row);
						$brnd = $row;
					}
					//p($rbrend);
					$ar_brnd['VALUE'] = $brnd['UF_NAME'];
					//p($brnd);
				}

				if(!$_REQUEST['quantity'][$num]){
					$_REQUEST['quantity'][$num] = 1;
				}

				global $USER;
						
				$price_res = CPrice::GetList(
					array(),
					array(
						"PRODUCT_ID" => $_REQUEST['id'],
						"CATALOG_GROUP_ID" => 3
					)
				);
				$price3 = $price_res->Fetch();
				
				
				if($price3["ID"] && $price3["PRICE"] > 0 && \Redreams\Partners\partner::isPartner())
				{
					
					$price_res = CPrice::GetList(
						array(),
						array(
							"PRODUCT_ID" => $_REQUEST['id'],
							"CATALOG_GROUP_ID" => 2
						)
					);
					$price = $price_res->Fetch();
					
					$ID = Add2Basket($price["ID"], $_REQUEST['quantity'][$num],
						array("CUSTOM_PRICE" => "N", "BASE_PRICE" => $price["PRICE"], "PRICE" => $price["PRICE"], "PRODUCT_PRICE_ID" => $price["ID"]),
						array(
							array("NAME" => "Артикул", "CODE" => "CML2_ARTICLE", "VALUE" => $ar_art['VALUE']),

						)
					);
					
					$rsBaskets = CSaleBasket::GetList(
						array("ID" => "ASC"),
						array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL",'ID'=>$ID),
						//array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "PRODUCT_ID" => $_REQUEST['id']),
						false,
						false,
						array()
					);
						
					if($arItem = $rsBaskets->GetNext())
					{
						/*
						echo '<div style="display:none;">';
						var_dump($arItem);
						echo '</div>';
						*/
						$arItem["PRICE"] = $price["PRICE"];
						$arItem["BASE_PRICE"] = $price["PRICE"];
						$arItem["PRODUCT_PRICE_ID"] = $price["ID"];
						$arItem["PRICE_TYPE_ID"] = 2;
						$arItem["CUSTOM_PRICE"] = "N";
						
						\CSaleBasket::Update($ID, $arItem);
						/*
						$rsBaskets = CSaleBasket::GetList(
							array("ID" => "ASC"),
							array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL",'ID'=>$ID),
							//array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "PRODUCT_ID" => $_REQUEST['id']),
							false,
							false,
							array()
						);
						$arItem = $rsBaskets->GetNext();
						echo '<div style="display:none;">';
						var_dump($arItem);
						echo '</div>';
						*/
						
					}
					
					
					//echo $ID;
					
				}
				else
				{
					
					$ID = Add2BasketByProductID($_REQUEST['id'], $_REQUEST['quantity'][$num],
							array(),
							array(
								array("NAME" => "Артикул", "CODE" => "CML2_ARTICLE", "VALUE" => $ar_art['VALUE']),

							)
					);
					
				}

				if($ID) {

					if(\Bitrix\Main\Loader::includeModule('redreams.partners') && \Redreams\Partners\partner::isPartner())
					{

						$rsBaskets = CSaleBasket::GetList(
							array("ID" => "ASC"),
							array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL",'ID'=>$ID),
							//array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "PRODUCT_ID" => $ID),
							false,
							false,
							array()
						);
						if($arItem = $rsBaskets->GetNext()) {
							//p($arItem);
							foreach(GetModuleEvents("sale", "OnBeforeBasketUpdateAfterCheck", true) as $arEvent)
								if (ExecuteModuleEventEx($arEvent, array($ID, &$arItem))===false)
								{

								}

							$oldPrice = $arItem['BASE_PRICE'];

							\CSaleBasket::Update($ID,$arItem);
						}
					}

				}

				if($ID)
				{
					$price = 0;
					$allprice = 0;
					$quant = 0;

					$rsBaskets = CSaleBasket::GetList(
						array("ID" => "ASC"),
						array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL",'ID'=>$ID),
						//array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "PRODUCT_ID" => $ID),
						false,
						false,
						array(
							"ID", "NAME", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY",
							"PRICE", "WEIGHT", "DETAIL_PAGE_URL", "NOTES", "CURRENCY", "VAT_RATE", "CATALOG_XML_ID",
							"PRODUCT_XML_ID", "SUBSCRIBE", "DISCOUNT_PRICE", "PRODUCT_PROVIDER_CLASS", "TYPE", "SET_PARENT_ID"
						)
					);
					while($arItem = $rsBaskets->GetNext()){
						//p($arItem);
						if($arItem['PRODUCT_ID'] == $ID) $price = $arItem['PRICE'];

						if($arItem['PRODUCT_ID'] == $ID) $quant += $arItem['QUANTITY'];

						$allprice += $arItem['PRICE']*$arItem['QUANTITY'];
					}

					if($arFields["DETAIL_PICTURE"]!=""){
						$foto=CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array('width'=>260, 'height'=>260), BX_RESIZE_IMAGE_PROPORTIONAL , true);
					}elseif($arFields["PREVIEW_PICTURE"]!=""){
						$foto=CFile::ResizeImageGet($arFields["DETAIL_PICTURE"], array('width'=>260, 'height'=>260), BX_RESIZE_IMAGE_PROPORTIONAL , true);
					}

					if(!$foto['src']){
						$foto['src']=SITE_TEMPLATE_PATH."/img/no-foto-small.jpg";
					}

					$measures = array(
						1 => "м",
						2 => "л.",
						3 => "г",
						4 => "кг",
						5 => "шт",
					);

					$arcat = CCatalogProduct::GetByID($arFields['ID']);
					//p($arcat['MEASURE']);
					$edizm = $measures[$arcat['MEASURE']];
					//echo 'Товар добавлен в корзину, перейти к <a class="green" href="/personal/cart/">оформлению</a>';
				}
				else
				{
					$mess = 'Товар не удалось добавить корзину. Нет цены';
				}
			}
		}
	}
	
}
?>