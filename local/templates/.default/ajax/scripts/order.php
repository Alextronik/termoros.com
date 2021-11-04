<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?
global $USER;
CModule::IncludeModule("sale");
if (CModule::IncludeModule("catalog"))
{
	
	$orders = getDelayOrders();	
	if(!is_array($orders)){
		$orders = array();
	}	
	
	//$norder = time();
	
	//p($orders);
    if ($_REQUEST['action'] == "ADD2ORDER")
    {
		$price = 0;
		$allprice = 0;
		$quant = 0;
		
		$rsBaskets = CSaleBasket::GetList(
			array("ID" => "ASC"),
			array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"),
			false,
			false,
			array(
				"ID", "NAME", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY",
				"PRICE", "WEIGHT", "DETAIL_PAGE_URL", "NOTES", "CURRENCY", "VAT_RATE", "CATALOG_XML_ID",
				"PRODUCT_XML_ID", "SUBSCRIBE", "DISCOUNT_PRICE", "PRODUCT_PROVIDER_CLASS", "TYPE", "SET_PARENT_ID"
			)
		);
		while($arItem = $rsBaskets->GetNext()){
			//if($arItem['PRODUCT_ID'] == $_REQUEST['id']) $price = $arItem['PRICE'];
			if($arItem['CAN_BUY'] == 'Y'){
				$arNewOrder['ITEMS'][$arItem['PRODUCT_ID']] = $arItem['QUANTITY'];
			
			$allprice += $arItem['PRICE']*$arItem['QUANTITY'];
			}
		}
		$arNewOrder['PRICE'] = $allprice;
		$arNewOrder['DATE'] = date('d.m.Y');
		
		//p($arNewOrder);
		
			$user = new CUser;			
			$orders[] = $arNewOrder;
			
			$fields = Array( 
				"UF_ORDS" =>serialize($orders), 
			); 
			
			p($orders);
			//p(serialize($orders));
			if(!$_REQUEST['test'])
			{
				$user->Update($USER->GetID(), $fields);		
			}
    }
}
?>