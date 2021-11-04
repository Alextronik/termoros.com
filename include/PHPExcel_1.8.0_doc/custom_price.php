<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
//require_once $_SERVER['DOCUMENT_ROOT'] . '/include/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';

CModule::IncludeModule('main');
CModule::IncludeModule('iblock');
CModule::IncludeModule('sale');
CModule::IncludeModule('highloadblock');

global $USER;

\Bitrix\Main\Loader::includeModule('redreams.partners');

$isPartner = \Redreams\Partners\partner::isPartner();

if ($isPartner)
{
	$partnerRes = CUser::GetByID($USER->GetID());
	$partner = $partnerRes->GetNext();
}
elseif ($_GET['u']) 
{
	
	$xmlID = $_GET['u'];
	if ($xmlID) 
	{	
		
		$partnerID = \Redreams\Partners\partner::getByXMLID($xmlID);
		if ($partnerID)
		{
			$partnerRes = CUser::GetByID($partnerID);
			$partner = $partnerRes->GetNext();
			$isPartner = true;
		}
		elseif (strlen($xmlID) == 36)
		{
			$uError = TRUE;
			
		}
		
	}
}

$obCache = new CPHPCache();
if($obCache->InitCache(3600, "create_price_vars"))
{
   $vars = $obCache->GetVars();// Извлечение переменных из кэша
}
elseif( $obCache->StartDataCache()  )// Если кэш невалиден
{
    $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/1c-services/pricelists/pricelist_all.xml');
	

	foreach($xml->Dat as $o)
	{
		foreach($o->Attributes() as $k => $v)
		{
			$v = trim($v);
			if ($k == "A") $brandNames[$v] = $v;
			if ($k == "E") $types[$v] = $v;
		}
		
	}
	
	ksort($brandNames);
	ksort($types);
	
    $vars = array($brandNames, $types);
   
    $obCache->EndDataCache($vars);
}
$brandNames = $vars[0];
$selectedBrands = array();
if ($_GET['brands']) $selectedBrands = $_GET['brands'];

$types = $vars[1];
if (0 && !$_GET['n'])
{
	$partner = false;
	$isPartner = false;
}
?>
<? if ($uError) { ?>
<p style="color: red;"><b>Данный партнер не найден на сайте. Для генерации персонализированного прайс-листа необходимо сначала выгрузить этого партнера на сайт.</b></p>

<? } ?>

<p><b><sup style="color: red;">*</sup>Для выбора нескольких брендов удерживайте Ctrl</b></p>
<p><b>Процесс создания прайс-листа может занять до 5-и минут. После этого прайс-лист автоматически скачается.</b></p>
<form method="get" id="gen_form" action="/buyers/prices/custom/generate.php">
	<input type="hidden" name="custom" value="Y">
	<?if ($partner) { ?> <input type="hidden" name="partner" value="<?=$partner["XML_ID"]?>"><? } ?>
	<table  cellpadding="5" >
		<tr>
			<td><b>Бренд</b></td>
			<td><b>Вид продукта</b></td>
			<td><b>Тип продукта</b></td>
			<?if ($_SESSION['STORES'] && $isPartner) { ?><td><b>Склад</b></td><? } ?>
		</tr>
		<tr>
			<td>
				<select size="20" multiple="multiple" name="brands[]">
				<? foreach($brandNames as $k => $v) { ?>
					<? $s = '';?>
					<? if (in_array($v, $selectedBrands)) { $s = 'selected="selected"';} ?>
					<option <?=$s?> value="<?=$k?>"><?=$k?></option>
				<? } ?>
				</select>
			</td>
			<td>
				<select size="20" multiple="multiple" name="types[]">
				<? foreach($types as $k => $v) { ?>
					<option value="<?=$k?>"><?=$k?></option>
				<? } ?>
				</select>
			</td>
			<td style="vertical-align: top;">
				<select size="3" multiple="multiple" name="stores[]">
					<option value="Склад.">Складская</option>
					<option value="Заказ.">Заказная</option>
					<option value="Не за.">Распродажа</option>
				</select>
			</td>
			<?if ($_SESSION['STORES'] && $isPartner) { ?>
			<td style="vertical-align: top;">
				<select size="10" name="sklad">
					<?$q=0;?>
					<? foreach($_SESSION['STORES'] as $cname => $carr) { ?>
						<? if (!$carr['SKIP']) { ?>
							<option <?if ($_SESSION['GEOIP']['curr_city_name'] == $cname || $q==0) { ?>selected="selected"<? } ?> value="<?=$carr['ID'];?>"><?=$cname;?></option>
						<? } ?>
						<?$q++?>
					<? } ?>
				</select>
			</td>
			<? } ?>
		</tr>
		<tr>
			<td><input id="gen" type="submit" value="Сгенерировать"></td>
			<td></td>
			<td></td>
		</tr>
	</table>
</form>
<div id="timeleft" style="margin-top: 10px; display:none; color: red;"><img width="24" style="margin-top: 5px;" src="/buyers/prices/generate.gif?123"><b><span  style="vertical-align: middle;
    margin-bottom: 15px;
    display: inline-block;
    margin-left: 7px;">Дождитесь загрузки прайс-листа. Новый запрос будет доступен через 120 секунд.</span></b></div>
<script>
	$(document).ready(function() {
		$('#gen').click(function() {
			$(this).hide();
			$('#timeleft').show();
			
			setTimeout(function() {
				$('#gen').show();
				$('#timeleft').hide();
			}, 120000);
			
			//$(this).delay(5000).show();
		});
	});
</script>