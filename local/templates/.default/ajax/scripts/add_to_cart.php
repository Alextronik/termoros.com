<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?
global $USER;
if (CModule::IncludeModule("catalog") && CModule::IncludeModule("iblock"))
{

	if($_REQUEST['ATR'])
	{
		$elem = CIBlockElement::GetList(array(),array("PROPERTY_CML2_ARTICLE"=>trim($_REQUEST['ATR'])),false,false,array("ID"))->Fetch();
		if($elem["ID"])
		{
			$_REQUEST['id'] = $elem["ID"];
			$noCatRef = "Y";
		}
		else
		{
			$mess = "Артикул не найден";
		}
	}
	elseif (key_exists('ATR', $_REQUEST))
	{
		$mess = "Артикул не найден";
	}

    if (($_REQUEST['action'] == "ADD2BASKET") && IntVal($_REQUEST['id'])>0)
    {
		
		$res = CIBlockElement::GetByID($_REQUEST['id']);
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
			$ar_brnd['LINK'] = $brnd['UF_LINK'];
			
			//p($brnd);
		}

		if(!$_REQUEST['quantity']){
			$_REQUEST['quantity'] = 1;
		}
		
		/*
		if($ID && \Redreams\Partners\partner::isPartner()) 
		{
			
			$price_res = CPrice::GetList(
				array(),
				array(
						"PRODUCT_ID" => $_REQUEST['id'],
						"CATALOG_GROUP_ID" => 2
				)
			);
			$price = $price_res->Fetch();
			
			$ID = Add2Basket($price["ID"], $_REQUEST['quantity'],
			array(),
			array(
				array("NAME" => "Артикул", "CODE" => "CML2_ARTICLE", "VALUE" => $ar_art['VALUE']),

			)
			);
			
			$skip = true;
				
			
		}
		*/
		
		
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
			
			$ID = Add2Basket($price["ID"], $_REQUEST['quantity'],
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
			
			$ID = Add2BasketByProductID($_REQUEST['id'], $_REQUEST['quantity'],
					array(),
					array(
						array("NAME" => "Артикул", "CODE" => "CML2_ARTICLE", "VALUE" => $ar_art['VALUE']),

					)
			);
			
		}
		
        if ($ID) {
			/*
			if($ID && \Redreams\Partners\partner::isPartner()) 
			{
				$price_res = CPrice::GetList(
					array(),
					array(
							"PRODUCT_ID" => $_REQUEST['id'],
							"CATALOG_GROUP_ID" => 2
					)
				);
				$price = $price_res->Fetch();
				
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
					$arItem['PRICE'] = $price['PRICE'];
					$arItem['PRODUCT_PRICE_ID'] = $price['ID'];
					
					//\CSaleBasket::Update($ID,$arItem);
				}
				
				
			}
			*/
			
			//if(\Bitrix\Main\Loader::includeModule('redreams.partners') && \Redreams\Partners\partner::isPartner())
			if(\Bitrix\Main\Loader::includeModule('redreams.partners'))
			{
				$rsBaskets = CSaleBasket::GetList(
					array("ID" => "ASC"),
					array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL",'ID'=>$ID),
					//array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "PRODUCT_ID" => $_REQUEST['id']),
					false,
					false,
					array()
				);
				
				
				if($arItem = $rsBaskets->GetNext()) {
					//echo $arItem["PRICE"];
					//echo $arItem["CUSTOM_PRICE"];
					foreach(GetModuleEvents("sale", "OnBeforeBasketUpdateAfterCheck", true) as $arEvent)
					{
						//var_dump($arEvent);
						if (ExecuteModuleEventEx($arEvent, array($ID, &$arItem))===false)
						{
							
						}
					}
					
					$oldPrice = $arItem['BASE_PRICE'];

					\CSaleBasket::Update($ID,$arItem);
				}
			}

		}
		//$ex = $APPLICATION->GetException();
		//var_dump($ex);
		if($ID)
		{
			
			$price = 0;
			$allprice = 0;
			$quant = 0;

			$rsBaskets = CSaleBasket::GetList(
				array("ID" => "ASC"),
				array("LID" => SITE_ID, "ORDER_ID" => "NULL",'ID'=>$ID),
				//array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "PRODUCT_ID" => $_REQUEST['id']),
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
				if($arItem['PRODUCT_ID'] == $_REQUEST['id']) $price = $arItem['PRICE'];

				if($arItem['PRODUCT_ID'] == $_REQUEST['id']) $quant += $arItem['QUANTITY'];

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

			?>
				<a href='' class='popclose' ></a>
				<div class='pop_inn'>
					<img src='<?=$foto["src"]?>' class='add_im' />

					<a href='<?=$arFields['DETAIL_PAGE_URL'];?>' class='name'><?=TruncateText($arFields['NAME'], 34);?></a>
					<?if($ar_art['VALUE']):?>
					<p class='add_i'>Артикул:<span><?=$ar_art['VALUE']?><span></p>
					<?endif;?>
					<?if($ar_art['VALUE']):?>
					<p class='add_i'>Бренд:<a href='/brands/<?=$ar_brnd['LINK']?>/'><?=$ar_brnd['VALUE']?></a></p>
					<?endif;?>
					
					<?if($oldPrice && $oldPrice>$price):?>
						<p class="partner_price">Розничная цена: <span><?=CurrencyFormat($oldPrice,'RUB')?></span></p>
					<?endif?>

					<div class='price_wp'>
						<p class='price'><?=round($price,2)?><span>руб.</span></p>
						<p class='col'><?=$quant?> <?=$edizm ? $edizm : "шт."?></p>
						<!--<p class='fullprice'><?=round($allprice,2)?><span>руб.</span></p>-->
					</div>

					<p class='txt'></p>
					<a href='/personal/cart/' onclick="yaCounter26951046.reachGoal('pereiti_korzina'); ga('send', 'pageview','/virtual/pereiti_korzina'); return true;" class='to_basket'>перейти В корзину</a>
					<?if($noCatRef != "Y")
					{
						?><a href='' class='back_shop'>Продолжить покупки</a><?
					}
					?>


				</div>
			<?
		}
		else
		{
			$mess = 'Товар не удалось добавить корзину. Нет цены';
		}
    }
	echo '<p style="padding: 0 10px;">' . $mess . '</p>';
}
if ($_REQUEST['tocart'] == 'Y')
{
	//header('Location: /personal/cart/');
}
?>