<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Запрос прайс-листа");
//die();
CModule::IncludeModule('main');
CModule::IncludeModule('sale');
CModule::IncludeModule('iblock');

$res = CIBlockElement::GetList(
 Array("NAME"=>"ASC"),
 Array("IBLOCK_ID" => 17, "ACTIVE" => "Y"),
 false,
 false,
 Array('*')
);
while($ar = $res->GetNext())
{
	$brands[] = $ar;
}

$res = CCatalogStore::GetList(
 array("ID" => "ASC"),
 array("ACTIVE" => "Y"),
 false,
 false,
 array('*')
);
while($ar = $res->GetNext())
{
	//$ar["TITLE"] = 
	
	$stores[] = $ar;
}
//var_dump($stores);

$storeID = $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID'];
if (!$storeID) $storeID = 208;

?>
<table>
<tr>
<td><h3>Выбрерите необходимые бренды</h3></td>
<td><h3>Выбрерите необходимые склады</h3></td>
</tr>
<tr>
<td>
<div class="price-list-overflow">
<ul class="price-list_ul">
	<?foreach($brands as $v) { ?>
		<li><label for="<?=$v["CODE"]?>"><input value="<?=$v["NAME"]?>" id="<?=$v["CODE"]?>" type="checkbox" value="<?=$v["CODE"]?>" ><span><?=$v["NAME"]?></span></label></li>
	<? } ?>
</ul>
</div>
</td>
<td>
	<div class="price-list-overflow">
	<ul class="price-list_ul">
		<?foreach($stores as $v) { ?>
			<li><label for="<?=$v["CODE"]?>"><input value="<?=$v["TITLE"]?>" id="<?=$v["CODE"]?>" type="checkbox" value="<?=$v["TITLE"]?>" ><span><?=$v["TITLE"]?></span></label></li>
		<? } ?>
	</ul>
	</div>
</td>
</tr>
</table>
<br><br>
<a href="#" class="price-list_btn">Запросить прайс-лист</a>

	
<style>
	.inner_contentblock .price-list-overflow {
		height: 250px;
		width: 250px;
		overflow-y: scroll;
		font-size: 15px;
	}
	
	.inner_contentblock  .price-list_ul li {
		list-style: none;
		margin: 1px;
	}
	
	.inner_contentblock  .price-list_ul span {
		line-height: 20px; 
		top: -2px; 
		position: relative;
	}
	
	.price-list_btn {
		display: block;
		width: 175px;
		padding: 10px 0;
		border-radius: 3px;
		text-align: center;
		font-size: 14px;
		line-height: 16px;
		color: #ffffff;
		text-decoration: none;
		text-transform: uppercase;
		font-weight: 600;
		cursor: pointer;
		background: #b54526;
		margin: 0 0 10px 0;		
	}
	
</style>
<script>
	$('.price-list_btn').click(function() {
		$('.price-list_ul li').each(function() {
			console.log($(this).find('input').eq(0).attr('checked'));
		});
	});
</script>
<?
/*
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
*/?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>