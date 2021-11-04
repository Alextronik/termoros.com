<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Прайс-листы");
//die();
CModule::IncludeModule('main');
CModule::IncludeModule('sale');

$brand = $_GET['brand'];
$res = CUser::GetByID($USER->GetID());
$user = $res->GetNext();
//var_dump($user);

$partnerXmlID = $user['XML_ID'];
$brands = getBrandXmlIdArrayByCode($brand);

$brandXmlID = $brands[0];
$storeID = $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID'];
if (!$storeID) $storeID = 208;


$rsStore = CCatalogStore::GetList(array(), array('ID' => $storeID), false, false, array('ID', 'XML_ID'));
while($arStore = $rsStore->Fetch()){
	$storeXmlID = $arStore["XML_ID"];
}

?>
<? if ($partnerXmlID && $brandXmlID && $storeXmlID) { ?>
	<?$res = file_get_contents('http://termoros.pro/exchange/?RefPartner='.$partnerXmlID.'&RefBrand='.$brandXmlID.'&RefStock='.$storeXmlID.'&RefContr='.md5(substr($partnerXmlID, 1,10).substr($brandXmlID, 1,10).substr($storeXmlID, 1,10)))?>
	<? if ($res == 1) { ?>
	<p>Запрос на формирование прайс-листа отправлен.<br>Сформированный прайс-лист будет отправлен Вам на Email: <b><?=$USER->GetEmail()?></b></p>
	<? } else { ?>
	<p>Возникла ошибка. Обратитесь пожалуйста в поддержку.</p>
	<? } ?>
<? } else { ?>
<p>Возникла ошибка. Обратитесь пожалуйста в поддержку.</p>
<? } ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>