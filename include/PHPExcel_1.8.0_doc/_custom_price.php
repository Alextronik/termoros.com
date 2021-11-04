<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';

CModule::IncludeModule('main');
CModule::IncludeModule('iblock');
CModule::IncludeModule('sale');
CModule::IncludeModule('highloadblock');


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
	/*
	die();
	
	$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'].'/include/PHPExcel_1.8.0_doc/price_all_site.xlsx');

	$objPHPExcel->setActiveSheetIndex(0);

	$sheet = $objPHPExcel->getActiveSheet();

	$rowIterator = $sheet->getRowIterator();
	foreach ($rowIterator as $key => $row) {
		$maxRow++;
	}

	for($i=2;$i<=$maxRow;$i++)
	{
		$brand = $sheet->getCellByColumnAndRow(2, $i)->getValue();
		$type = $sheet->getCellByColumnAndRow(3, $i)->getValue();
		
		$brandNames[$brand] = $brand;
		$types[$type] = $type;
	}

	ksort($brandNames);
	ksort($types);
    */
    $vars = array($brandNames, $types);
   
    $obCache->EndDataCache($vars);
}
$brandNames = $vars[0];
$types = $vars[1];
?>
<p><b><sup style="color: red;">*</sup>Для выбора нескольких брендов удерживайте Ctrl</b></p>
<p><b>Процесс создания прайс-листа может занять до 5-и минут. После этого прайс-лист автоматически скачается.</b></p>
<?/*<form method="get"  action="/include/PHPExcel_1.8.0_doc/generate_price.php">*/?>
<form method="get" id="gen_form" action="/buyers/prices/custom/generate.php">
	<input type="hidden" name="custom" value="Y">
	<table  cellpadding="5" >
		<tr>
			<td><b>Бренд</b></td>
			<td><b>Вид продукта</b></td>
			<td><b>Тип продукта</b></td>
		</tr>
		<tr>
			<td>
				<select size="20" multiple="multiple" name="brands[]">
				<? foreach($brandNames as $k => $v) { ?>
					<option value="<?=$k?>"><?=$k?></option>
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
		</tr>
		<tr>
			<td><input id="gen" type="submit" value="Сгенерировать"><span id="timeleft" style="display:none;">Новый запрос будет доступен через 60 секунд</span></td>
			<td></td>
			<td></td>
		</tr>
	</table>
</form>
<script>
	$(document).ready(function() {
		$('#gen').click(function() {
			$(this).hide();
			$('#timeleft').show();
			
			setTimeout(function() {
				$('#gen').show();
				$('#timeleft').hide();
			}, 60000);
			
			//$(this).delay(5000).show();
		});
	});
</script>