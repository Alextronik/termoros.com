<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?
		if (($_REQUEST['action'] == "ADD2PRED")&& IntVal($_REQUEST['ID'])>0)
		{
		
			
			if ($_REQUEST['param'] == "DEL2PRED")
			{	
				global $USER;
				CModule::IncludeModule("sale");
				
				$dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC", "ID" => "ASC"), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "SUBSCRIBE" => "Y",), false, false, array("ID", "PRODUCT_ID", "QUANTITY") );
				while ($arItems = $dbBasketItems->Fetch())
					$arBasketItems[$arItems['PRODUCT_ID']] = $arItems['ID'];
				
				CSaleBasket::Delete($arBasketItems[$_REQUEST['ID']]);
				
				//removeFromPred($_REQUEST['ID']);
				//echo count(getPred());
				//unset($_SESSION['NOTIFY_PRODUCT'][$USER->GetID()][$_REQUEST['ID']]);
			}
			elseif (IntVal($_REQUEST['ID'])>0)
			{
				if(count(getPred()) < 99){
					add2Pred($_REQUEST['ID']);
				}
			}
	
		}
		else
		{
		
			if (($_REQUEST['action'] == "ADD2FAV")&& IntVal($_REQUEST['ID'])>0)
			{		
				if(count(getFav()) < 99){
					add2fav($_REQUEST['ID']);
				}
			}
			elseif ($_REQUEST['action'] == "GETCNT")
			{	
				echo count(getFav());
			}
			elseif ($_REQUEST['action'] == "DEL2FAV")
			{	
				removeFromFav($_REQUEST['ID']);
				echo count(getFav());
			}	
			elseif ($_REQUEST['action'] == "GETCOMPARE")
			{	
				echo count($_SESSION['CATALOG_COMPARE_LIST'][4]['ITEMS']);
			}	
		
		}
?>