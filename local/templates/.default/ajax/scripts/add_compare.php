<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?
if (CModule::IncludeModule("catalog")&&CModule::IncludeModule("iblock"))
{
    if ($_REQUEST['action'] == "COMPARE")
    {
		$_REQUEST["id"] = $_REQUEST["ID"];
		$arParams["NAME"] = "CATALOG_COMPARE_LIST";
		
		$res = CIBlockElement::GetByID($_REQUEST["id"]);
		$arRes = $res->GetNext();
		
		$arParams["IBLOCK_ID"] = $arRes['IBLOCK_ID'];
		
		
		
		if(
			intval($_REQUEST["id"]) > 0
			&& !array_key_exists($_REQUEST["id"], $_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"])
		)
		{
		
			//if(count($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"])>9)		{
			//	echo 'Добавить к сравнению возможно не более 10 товаров.;0';		
			//}
			//else
			//{			
				//if(count($_SESSION['COMPARE_ELEMENTS'])>2)
				//{
				//		$id_shift = array_shift($_SESSION['COMPARE_ELEMENTS']);					
				//		unset($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$id_shift]);
				//}
				
				$arOffers = CIBlockPriceTools::GetOffersIBlock($arParams["IBLOCK_ID"]);
				$OFFERS_IBLOCK_ID = $arOffers? $arOffers["OFFERS_IBLOCK_ID"]: 0;

				//SELECT
				$arSelect = array(
					"ID",
					"IBLOCK_ID",
					"IBLOCK_SECTION_ID",
					"NAME",
					"DETAIL_PAGE_URL",
				);
				//WHERE
				$arFilter = array(
					"ID" => intval($_REQUEST["id"]),
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"IBLOCK_LID" => SITE_ID,
					"IBLOCK_ACTIVE" => "Y",
					"ACTIVE_DATE" => "Y",
					"ACTIVE" => "Y",
					"CHECK_PERMISSIONS" => "Y",
					"MIN_PERMISSION" => "R"
				);
				if($OFFERS_IBLOCK_ID > 0)
					$arFilter["IBLOCK_ID"] = array($arParams["IBLOCK_ID"], $OFFERS_IBLOCK_ID);
				else
					$arFilter["IBLOCK_ID"] = $arParams["IBLOCK_ID"];

				$rsElement = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
				$rsElement->SetUrlTemplates($arParams["DETAIL_URL"]);
				$arElement = $rsElement->GetNext();

				$arMaster = false;
				if($arElement && $arElement["IBLOCK_ID"] == $OFFERS_IBLOCK_ID)
				{
					$rsMasterProperty = CIBlockElement::GetProperty($arElement["IBLOCK_ID"], $arElement["ID"], array(), array("ID" => $arOffers["OFFERS_PROPERTY_ID"], "EMPTY" => "N"));
					if($arMasterProperty = $rsMasterProperty->Fetch())
					{
						$rsMaster = CIBlockElement::GetList(
							array()
							,array(
								"ID" => $arMasterProperty["VALUE"],
								"IBLOCK_ID" => $arMasterProperty["LINK_IBLOCK_ID"],
								"ACTIVE" => "Y",
							)
						,false, false, $arSelect);
						$rsMaster->SetUrlTemplates($arParams["DETAIL_URL"]);
						$arMaster = $rsMaster->GetNext();
					}
				}

				if($arMaster)
				{
					$arMaster["NAME"] = $arElement["NAME"];
					$arMaster["DELETE_URL"] = htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=DELETE_FROM_COMPARE_RESULT&id=".$arMaster["ID"], array("action", "id")));
					$_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$_REQUEST["id"]] = $arMaster;
				}
				elseif($arElement)
				{
					$arElement["DELETE_URL"] = htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=DELETE_FROM_COMPARE_RESULT&id=".$arElement["ID"], array("action", "id")));
					$_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$_REQUEST["id"]] = $arElement;
				}
				//unset($_SESSION['COMPARE_ELEMENTS']);
				//$_SESSION['COMPARE_ELEMENTS'][]=$_REQUEST["id"];
				
				echo 'Товар добавлен к сравнению, перейти к <a class="green" href="/compare/">сравнению</a>;1;'.count($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"]);		
			//}
		}	
		elseif($_REQUEST['nodelete'] != 'yes')
		{
			unset($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$_REQUEST["id"]]);
			///foreach($_SESSION['COMPARE_ELEMENTS'] as $k => $v)
			//{
			//	unset($_SESSION['COMPARE_ELEMENTS'][$k]);
			//}			
			echo 'Товар удален из сравнения.;0;'.count($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"]);		
		}

    }
}

//p($_POST);
p($_SESSION);
?>