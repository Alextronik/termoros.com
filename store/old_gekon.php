<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CModule::IncludeModule('iblock');
$res = CIBlockElement::GetList(
 Array(),
 Array("IBLOCK_ID"=>4, 'ACTIVE'=>"Y", 'PROPERTY_CML2_ARTICLE'=>"GETL0.%"),
 false,
 false,
 Array("ID", "NAME", "PROPERTY_CML2_ARTICLE", "IBLOCK_SECTION_ID", "SECTION_ID", "PROPERTY_TEPLOOTDACHA_VT", "DETAIL_PAGE_URL")
);
while($el = $res->GetNext())
{
	$article = $el["PROPERTY_CML2_ARTICLE_VALUE"];
	$height = (int)substr($article, 6, 3);
	$length = (int)substr($article, 9, 3);
	$width = (int)substr($article, 12, 2);
	$grid = substr($article, 15, 3);
		
	$elements[$height][$length][$width] = $el;
	$elements[$el["IBLOCK_SECTION_ID"]][] = $el;
}

$lengthArr = array(90,100,110,130,150,170,190,210,230,250,270,290,310,350,390,430,450,490);
$heightWidthArr = array(8 => array(18,23,30,38), 11 => array(18,23,30,38), 14 => array(23,30,38), 19 => array(23,30,38));

?>
<h1>Конвекторы Gekon</h1>
<h2>Код заказа</h2>
<table>
	<tr>
		<td>Прибор<sup style="color: red; font-weight:bold;">*</sup></td>
		<td>Высота</td>
		<td>Длина</td>
		<td>Глубина</td>
		<td>Решетка</td>
	</tr>
	<tr>
		<td>GETL0.</td>
		<td>008</td>
		<td>120</td>
		<td>23</td>
		<td>/RNA</td>
	</tr>
</table>
<br>
<p>
	<sup style="color: red; position: relative; left: -5px;font-weight:bold;">*</sup>GETL - Gekon Eco (естественная конвекция)<br>
	<sup style="color: white; position: relative; left: -10px;">&nbsp;&nbsp;</sup>GDTL - Gekon Vent (принудительная конвекция)
</p>
<?
$koefEco = 1;
$koefVent = 1;
$t1 = 95;
$t2 = 85;
$t3 = 20;
?>
<?
$t1 = ((int)$_GET['t1'])?(int)$_GET['t1']:95;
$t2 = ((int)$_GET['t2'])?(int)$_GET['t2']:85;
$t3 = ((int)$_GET['t3'])?(int)$_GET['t3']:20;

if ($t1 < 35 || $t1 > 105) $t1 = 95;
if ($t2 < 35 || $t2 > 105) $t1 = 85;
if ($t2 > $t1) $t2 = $t1;
if ($t3 < 15 || $t3 > 25) $t1 = 20;

$tKnown = 70;
$tNew = ($t1+$t2)/2 - $t3;

$nEco = 1.4;
$nVent = 1;

$koefEco = pow($tNew/$tKnown, $nEco);
$koefVent = pow($tNew/$tKnown, $nVent);
?>
<h3>Изменить температурный режим</h3>
<form>
<table>
	<tr>
		<td>Температура входа</td>
		<td>
<select name="t1" class="t_select" id="T1">
	<?for($i=105;$i>=35;$i--) { ?>
		<?
		$checked='';
		if ($i==$t1) $checked = 'selected="selected"';
		?>
		<option <?=$checked?> value="<?=$i?>"><?=$i?></option>
	<? } ?>
</select>
</td>
</tr>
<tr>
		<td>Температура выхода</td>
		<td>
<select name="t2" class="t_select" id="T1">
	<?for($i=105;$i>=35;$i--) { ?>
		<?
		$checked='';
		if ($i==$t2) $checked = 'selected="selected"';
		?>
		<option <?=$checked?> value="<?=$i?>"><?=$i?></option>
	<? } ?>
</select>
</td>
</tr>
<tr>
		<td>Температура помещения</td>
		<td>
<select name="t3" class="t_select" id="T1">
	<?for($i=25;$i>=15;$i--) { ?>
		<?
		$checked='';
		if ($i==$t3) $checked = 'selected="selected"';
		?>
		<option <?=$checked?> value="<?=$i?>"><?=$i?></option>
	<? } ?>
</select>
</td>
</tr>
<tr>
<td colspan="2"><b><span style="font-size:10px;">Δ</span>T = <?=$tNew?>°C</b></td>
</tr>
<tr>
<td colspan="2"><input style="display: inline-block;
    vertical-align: top;
    padding: 9px 15px 9px;
    border-radius: 3px;
    background: #749a4a;
    font-size: 14px;
    line-height: 16px;
    color: #ffffff;
    text-transform: uppercase;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    border: 0;
    min-width: 55px;" type="submit" value="Рассчитать"></td>
</table>

</form>
<h2>Конвекторы Gekon Eco</h2>
<table style="width:1354px;" class="gekon_table">
	<tr>
		<td style="width:25px;" rowspan="2"><b>Глубина, [H], см</b></td>
		<td style="width:25px;" rowspan="2"><b>Ширина, [B], см</b></td>
		<td style="width:60px;" rowspan="2"><b>Температурный режим, Вт</b></td>
		<td colspan="18"><b>Длина, [L], см</b></td>
	</tr>
	<tr>
		<?foreach($lengthArr as $l) { ?>
			<td><?=$l?></td>
		<? } ?>
	</tr>
	<? foreach($heightWidthArr as $hk => $h) { ?>
		<? foreach($heightWidthArr[$hk] as $k => $w) { ?>
		<tr>
			<? if ($k==0) { ?>
			<td rowspan="<?=count($h)?>"><?=$hk?></td>
			<? } ?>
			<td><?=$w?></td>
			<td nowrap><?=$t1?>/<?=$t2?>/<?=$t3?> (<span style="font-size:10px;">Δ</span>T=<?=$tNew?>)</td>
			<?foreach($lengthArr as $l) { ?>
				<td><a target="_blank" title="<?=$elements[$hk][$l][$w]["PROPERTY_CML2_ARTICLE_VALUE"]?>" href="<?=$elements[$hk][$l][$w]["DETAIL_PAGE_URL"]?>"><?=round($elements[$hk][$l][$w]["PROPERTY_TEPLOOTDACHA_VT_VALUE"]*$koefEco)?></a></td>
			<? } ?>
		</tr>
		<? } ?>
	<? } ?>
	
	
</table>
<?
$elements = array();
$res = CIBlockElement::GetList(
 Array(),
 Array("IBLOCK_ID"=>4, 'ACTIVE'=>"Y", 'PROPERTY_CML2_ARTICLE'=>"GDTL0.%"),
 false,
 false,
 Array("ID", "NAME", "PROPERTY_CML2_ARTICLE", "IBLOCK_SECTION_ID", "SECTION_ID", "PROPERTY_TEPLOOTDACHA_VT", "DETAIL_PAGE_URL")
);
while($el = $res->GetNext())
{
	$article = $el["PROPERTY_CML2_ARTICLE_VALUE"];
	$height = (int)substr($article, 6, 3);
	$length = (int)substr($article, 9, 3);
	$width = (int)substr($article, 12, 2);
	$grid = substr($article, 15, 3);
		
	$elements[$height][$length][$width] = $el;
	$elements[$el["IBLOCK_SECTION_ID"]][] = $el;
}

$lengthArr = array(90,100,110,130,150,170,190,210,230,250,270,290,310,350,390,430,450,490);
$heightWidthArr = array(8 => array(23,30,38), 14 => array(23,30,38));
?>
<h2>Конвекторы Gekon Vent</h2>
<table class="gekon_table">
	<tr>
		<td style="width:25px;" rowspan="2"><b>Глубина, [H], см</b></td>
		<td style="width:25px;" rowspan="2"><b>Ширина, [B], см</b></td>
		<td style="width:60px;" rowspan="2"><b>Температурный режим, Вт</b></td>
		<td colspan="18"><b>Длина, [L], см</b></td>
	</tr>
	<tr>
		<?foreach($lengthArr as $l) { ?>
			<td><?=$l?></td>
		<? } ?>
	</tr>
	<? foreach($heightWidthArr as $hk => $h) { ?>
		<? foreach($heightWidthArr[$hk] as $k => $w) { ?>
		<tr>
			<? if ($k==0) { ?>
			<td rowspan="<?=count($h)?>"><?=$hk?></td>
			<? } ?>
			<td><?=$w?></td>
			<td nowrap><?=$t1?>/<?=$t2?>/<?=$t3?>  (<span style="font-size:10px;">Δ</span>T=<?=$tNew?>)</td>
			<?foreach($lengthArr as $l) { ?>
				<td><a target="_blank" title="<?=$elements[$hk][$l][$w]["PROPERTY_CML2_ARTICLE_VALUE"]?>" href="<?=$elements[$hk][$l][$w]["DETAIL_PAGE_URL"]?>"><?=round($elements[$hk][$l][$w]["PROPERTY_TEPLOOTDACHA_VT_VALUE"]*$koefVent)?></a></td>
			<? } ?>
		</tr>
		<? } ?>
	<? } ?>
	
	
</table>
<style>
	table.gekon_table tr td {
		text-align: center;
		border: 1px solid #d7d9d8;
		#border-bottom: 1px solid #656565;
		line-height: 16px;
		padding: 5px 13px;
	}
	table tr td a {
		font-weight: bold;
	}
</style>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>