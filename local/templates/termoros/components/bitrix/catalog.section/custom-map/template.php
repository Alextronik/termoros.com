<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
} ?>
<? 
$showForm = false;
if ($APPLICATION->GetCurDir() == '/contacts/') 
{
	$showForm = true;
}
?>
<?
$map_data['PLACEMARKS'] = array();
if ($arParams['BIGSCALE'] == 'Y')
{
	$map_data['yandex_scale'] = 4;
	foreach ($arResult["ITEMS"] as $cell => $arElement)
	{
		//$arResort[$arElement['IBLOCK_SECTION_ID']][] = $arElement;
		$arResult['SORTSECT'][$arElement['IBLOCK_SECTION_ID']][] = $arElement;
		//p($arElement);
	}
	//p($arResort);
}

//if($_REQUEST['SECTION_ID'] == 28 || !$_REQUEST['SECTION_ID']):
if ($arResult['UF_LONLAT'])
{
	$cords = explode(", ", $arResult['UF_LONLAT']);
	//p($cords);
	$map_data['yandex_lon'] = $cords[0];
	$map_data['yandex_lat'] = $cords[1];
}
else
{
	$map_data['yandex_lon'] = 37.63999999999997;
	$map_data['yandex_lat'] = 55.75999999999371;
}


krsort($arResult["ITEMS"]);

foreach ($arResult["ITEMS"] as $cell => $arElement)
{
	$strtext = "";
	$strtext .= '<p><b>' . $arElement['NAME'] . '</b></p><br/>';

	if ($arElement['PROPERTIES']['METRO']['VALUE'])
	{
		$strtext .= '<p>Метро: ' . $arElement['PROPERTIES']['METRO']['VALUE'] . '</p>';
	}
	if ($arElement['PROPERTIES']['ADDRESS']['VALUE'])
	{
		$strtext .= '<p>Адрес: ' . $arElement['PROPERTIES']['ADDRESS']['VALUE'] . '</p>';
	}
	if ($arElement['PROPERTIES']['PHONE']['VALUE'])
	{
		$strtext .= '<p>Тел: ' . $arElement['PROPERTIES']['PHONE']['VALUE'] . '</p>';
	}
	if ($arElement['PROPERTIES']['WORK_TIME']['VALUE'])
	{
		$strtext .= '<p>График: ' . $arElement['PROPERTIES']['WORK_TIME']['VALUE'] . '</p>';
	}
	if ($arElement['PROPERTIES']['EMAIL']['VALUE'])
	{
		$strtext .= '<p>Е-mail: <a href="mailto:' . $arElement['PROPERTIES']['EMAIL']['VALUE'] . '" class="link">'
			. $arElement['PROPERTIES']['EMAIL']['VALUE'] . '</a></p>';
	}
	if ($arElement['PROPERTIES']['SITE']['VALUE'])
	{
		$strtext .= '<p><noindex><a rel="nofollow" href="http://' . $arElement['PROPERTIES']['SITE']['VALUE']
			. '" target="_blank" class="link">Перейти на сайт</a></noindex></p>';
	}
	if ($arElement['PROPERTIES']['TYPE_OF_PRODUCTS']['VALUE'])
	{
		$strtext .= '<p>Тип продукции: '. implode(', ',$arElement['PROPERTIES']['TYPE_OF_PRODUCTS']['VALUE']) . '</p>';
	}	
/*
	if ($arElement["PREVIEW_PICTURE"])
	{
		$strtext .= '<p><a target="_blank" rel="img_'.$arElement["PREVIEW_PICTURE"]["ID"].'_map" class="fancyPrint" href="'.$arElement["PREVIEW_PICTURE"]["SRC"].'">Схема проезда на общественном транспорте</a></p>';
	}
	
	if ($arElement["DETAIL_PICTURE"])
	{
		$strtext .= '<p><a target="_blank" rel="img_'.$arElement["DETAIL_PICTURE"]["ID"].'_map" class="fancyPrint" href="'.$arElement["DETAIL_PICTURE"]["SRC"].'">Схема проезда на автомобиле</a></p>';
	}
*/
	
	if ($arElement['PROPERTIES']["SCHEME"]["VALUE"])
	{
		foreach($arElement['PROPERTIES']["SCHEME"]["VALUE"] as $k => $v)
		{
			$strtext .= '<p><a target="_blank" href="'.$v.'">'.$arElement['PROPERTIES']["SCHEME"]["DESCRIPTION"][$k].'</a></p>';
		}
	}
	
	
	$coord = explode(',', $arElement['PROPERTIES']['ON_MAP']['VALUE']);
	array_push($map_data['PLACEMARKS'], array(
		'TEXT' => $strtext, 'LON' => $coord[1], 'LAT' => $coord[0], 'id' => $arElement['ID']
	));
}

ksort($arResult["ITEMS"]);
$curCityId = $arParams['SECTS']['CURRENTCITY_ID'];
unset($arParams['SECTS']['CURRENTCITY_ID']);

if ($arParams['BIGSCALE'] != 'Y')
{
	ksort($arParams['SECTS']);
}
//p($arParams['SECTS']['CURRENTCITY_ID']);
//if($USER->isAdmin()){
//krsort($map_data['PLACEMARKS']);
//}
//v($map_data);

$isServiceCentersMode = isset($arParams['SERVICE_CENTERS_MODE']) && $arParams['SERVICE_CENTERS_MODE'];
?>
<div class='shops_wp'>

	<div class='shop_left col-12 col-md-3'>
		<? /*?>
	<p class='loc'>г. <?=$_SESSION['GEOIP']['curr_city_name']?></p>
	<a href='' class='change_loc' onclick="$('.location_lnk').click(); return false;" >изменить</a>
	<?*/ ?>

		<form method="get" id="a_filter">
			<? if ($arParams['SECTS']): ?>
				<select class='customSelect mtr sort_sel' name="city"
						action="<?= $APPLICATION->GetCurPageParam("", array("")); ?>">
					<option value="">Выберите город</option>
					<? foreach ($arParams['SECTS'] as $name => $id): ?>
						<option value="<?= $id; ?>" <? if ($_REQUEST['city'] == $id
						|| (!$arParams['BIGSCALE'] && !$_REQUEST['city']
							&& $curCityId == $id)): ?>selected="selected"<? endif; ?> ><?= $name; ?></option>
					<? endforeach; ?>
				</select>
			<? endif; ?>

			<?/* if ($arResult['METRO'] && $arResult['METRO'][0]): ?>
				
				<select class='customSelect mtr sort_sel' name="metro"
						action="<?= $APPLICATION->GetCurPageParam("", array("")); ?>">
					<option value="">Выберите метро</option>
					<? foreach ($arResult['METRO'] as $names): ?>
						<option value="<?= $names; ?>" <? if ($_REQUEST['metro']
						== $names): ?>selected="selected"<? endif; ?> ><?= $names; ?></option>
					<? endforeach; ?>
				</select>
			<? endif; */?>

			<? if ($isServiceCentersMode && $arResult['TYPE_OF_PRODUCTS']): ?>
				<div class="sc_top">
					<div class="sc_top_head">Выберите тип продукции</div>
					<div class="sc_top_list">
						<?foreach ($arResult['TYPE_OF_PRODUCTS'] as $i => $typeOfProduct):?>
							<input type="checkbox" class="customCheckbox" name="type_of_products[]"
							   value="<?=$typeOfProduct?>" id="type_of_products_<?=$i?>"
								<?if (in_array($typeOfProduct, $_REQUEST['type_of_products'])):?>checked="checked"<?endif;?>>
							<label for="type_of_products_<?=$i?>"><?=$typeOfProduct?></label><br/>
						<?endforeach;?>
					</div>
				</div>
			<?endif;?>
			<? if ($showForm) { ?>
				<div style="margin-bottom: 40px;">
					<a href="#" style="display: inline-block;
						vertical-align: top;
						padding: 9px 15px 5px;
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
						min-width: 231px;" 
			onclick="$('.global_overflow').show();
			var cur_sc = $(window).scrollTop() + 100;
			$('.callback.pop_up').css({'position':'absolute', 'top':cur_sc});
			$('.callback.pop_up').show();
			return false;">Задать вопрос</a>
				</div>
			<? } ?>
		</form>

		<? if ($arParams['BIGSCALE'] == 'Y' && !$_REQUEST['city']): ?>
			<ul class='shop_list'>
				<? foreach ($arResult['SORTSECT'] as $id => $sectarray): ?>
					<? $markind += count($sectarray); ?>
				<? endforeach; ?>
				<? $markind--; ?>
				<?/* foreach ($arResult['SORTSECT'] as $id => $sectarray): ?>
					<? $sectname = array_search($id, $arParams['SECTS']); */?>
					<? foreach ($arParams['SECTS'] as $sectname => $id): ?>
					<? $sectarray = $arResult['SORTSECT'][$id]?>
					<li>
						<p class="ttl"><?= $sectname; ?></p>
					</li>
					<? foreach ($sectarray as $cell => $arElement): ?>
						<li>
							<a href='' class='name'
							   onclick='window["obPlacemark<?= $markind;//$cell;  ?>"].balloon.open(); window.GLOBAL_arMapObjects["map<?= $arResult['ITEMS']['0']['IBLOCK_SECTION_ID'] ?>"].setZoom(13).panTo([<?= $arElement['PROPERTIES']['ON_MAP']['VALUE'] ?>], {flying: true, duration: 500}); return false;'><?= $arElement['NAME']; ?></a>

							<p class='metro'><?= $arElement['PROPERTIES']['METRO']['VALUE'] ?></p>
							<? if ($isServiceCentersMode): ?>
								<?foreach ($arElement['PROPERTIES']['TYPE_OF_PRODUCTS']['VALUE'] as $topValue):?>
									<p class="txt"><?=$topValue?></p>
								<?endforeach;?>
							<? endif; ?>
							<p class='txt'><?= $arElement['PROPERTIES']['ADDRESS']['VALUE'] ?></p>
							<p class='txt'><?= $arElement['PROPERTIES']['PHONE']['VALUE'] ?></p>
							<p class='txt'><?= $arElement['PROPERTIES']['WORK_TIME']['VALUE'] ?></p>
							<? if ($arElement['PROPERTIES']['EMAIL']['VALUE']): ?><a
								href='mailto:<?= $arElement['PROPERTIES']['EMAIL']['VALUE'] ?>' target="_blank"
								class='link'><?= $arElement['PROPERTIES']['EMAIL']['VALUE'] ?></a><? endif; ?>
							<noindex><a rel="nofollow" href='http://<?= $arElement['PROPERTIES']['SITE']['VALUE'] ?>' target="_blank"
							   class='link'><?= $arElement['PROPERTIES']['SITE']['VALUE'] ?></a></noindex>
						</li>
						<? $markind--; ?>
					<? endforeach; ?>
				<? endforeach; ?>
			</ul>
		<? else: ?>
			<ul class='shop_list'>
				<? $markind = count($arResult["ITEMS"]) - 1; ?>
				<? foreach ($arResult["ITEMS"] as $cell => $arElement): ?>
					<li>
						<div itemscope itemtype="http://schema.org/Organization">
						<a href='' class='name'
						   onclick='window["obPlacemark<?= $markind;//$cell;  ?>"].balloon.open(); window.GLOBAL_arMapObjects["map<?= $arElement['IBLOCK_SECTION_ID'] ?>"].setZoom(13).panTo([<?= $arElement['PROPERTIES']['ON_MAP']['VALUE'] ?>], {flying: true, duration: 500}); return false;'><span itemprop="name"><?= $arElement['NAME']; ?></span></a>
						<p class='metro'><?= $arElement['PROPERTIES']['METRO']['VALUE'] ?></p>
						<? if ($isServiceCentersMode): ?>
							<?foreach ($arElement['PROPERTIES']['TYPE_OF_PRODUCTS']['VALUE'] as $topValue):?>
								<p class="txt"><?=$topValue?></p>
							<?endforeach;?>
						<? endif; ?>
						<p class='txt'><div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><span itemprop="streetAddress"><?= $arElement['PROPERTIES']['ADDRESS']['VALUE'] ?></span></div></p>
						<p class='txt'><span itemprop="telephone"><?= $arElement['PROPERTIES']['PHONE']['VALUE'] ?></span></p>
						<p class='txt'><?= $arElement['PROPERTIES']['WORK_TIME']['VALUE'] ?></p>
						<? if ($arElement['PROPERTIES']['EMAIL']['VALUE']): ?><a
							href='mailto:<?= $arElement['PROPERTIES']['EMAIL']['VALUE'] ?>' target="_blank"
							class='link'><span itemprop="email"><?= $arElement['PROPERTIES']['EMAIL']['VALUE'] ?></span></a>
						<? endif; ?>
						<?if ($arElement['PROPERTIES']['SITE']['VALUE']) { ?><noindex><a rel="nofollow" href='http://<?= $arElement['PROPERTIES']['SITE']['VALUE'] ?>' target="_blank"
						class='link'>Перейти на сайт</a></noindex><? } ?>
						<?
						if ($arElement['PROPERTIES']["SCHEME"]["VALUE"])
						{
							foreach($arElement['PROPERTIES']["SCHEME"]["VALUE"] as $k => $v)
							{
								echo '<a target="_blank" href="'.$v.'">'.$arElement['PROPERTIES']["SCHEME"]["DESCRIPTION"][$k].'</a><br>';
							}
						}
						?>
						<?
						$coord = explode(',', $arElement['PROPERTIES']['ON_MAP']['VALUE']);
						?>
						<p class='txt' style="margin-top:5px;"><b>GPS координаты:</b> <?=round($coord[0], 6)?>, <?=round($coord[1], 6)?></p>
						</div>
					</li>
					<? $markind--; ?>
				<? endforeach; ?>
			</ul>
		<? endif; ?>

	</div>
	<script>
		$(document).ready(function () {
			console.log(window.GLOBAL_arMapObjects);
		});
	</script>
	
	
	<div class='map_area col-12 col-md-9'>
		<? $APPLICATION->IncludeComponent("bitrix:map.yandex.view", "ymaps", Array(
			"INIT_MAP_TYPE" => "MAP", "MAP_DATA" => serialize($map_data), "MAP_WIDTH" => "930", "MAP_HEIGHT" => "675",
			"CONTROLS" => array("ZOOM", "TYPECONTROL", "SCALELINE"),
			"OPTIONS" => array("ENABLE_SCROLL_ZOOM", "ENABLE_DBLCLICK_ZOOM", "ENABLE_DRAGGING"),
			"MAP_ID" => "map" . $arResult['ITEMS']['0']['IBLOCK_SECTION_ID']
		), false); ?>
	</div>

	
	
	<div class='clear'></div>
	<? if ($arParams['SECTS'] && !$arParams['BIGSCALE']): ?>
		<? $arRows = array_chunk($arParams['SECTS'], 13); ?>
		<div class="citys_list">
			<? foreach ($arRows as $row): ?>
				<div class="city_col">
					<? foreach ($row as $keys => $vls): ?>
						<? $nm = array_search($vls, $arParams['SECTS']); ?>

						<a href='?city=<?= $vls; ?>' class='name'><?= $nm ?></a>
						<? $k++; ?>
					<? endforeach ?>
				</div>
			<? endforeach ?>
			
		</div>
	<? endif; ?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancyPrint').fancybox({
		  'beforeShow': function(){
			var win=null;
			var content = $('.fancybox-inner');
			$('.fancybox-outer').prepend('<a href="#" title="Печать" id="fancy_print" style=" background: url(/local/templates/termoros/img/print.png) no-repeat center; width: 26px; height: 22px; position: absolute; top: -30px; right: 35px;"></a>');
			var imgSrc = $('.fancybox-outer').find('img').attr('src');
			var imgSrcArr = imgSrc.split('/');
			var imgName = imgSrcArr[imgSrcArr.length-1];
			$('.fancybox-outer').prepend('<a href="'+imgSrc+'" download="'+imgName+'" title="Сохранить"  style=" background: url(/img/save.png) no-repeat; width: 25px; height: 25px; position: absolute; top: -32px; right: 70px;"></a>');
			
			$('#fancy_print').bind("click", function(){
			  win = window.open("width=200,height=200");
			  self.focus();
			  win.document.open();
			  win.document.write('<'+'html'+'><'+'head'+'><'+'style'+'>');
			  win.document.write('body, td { font-family: Verdana; font-size: 10pt;}');
			  win.document.write('<'+'/'+'style'+'><'+'/'+'head'+'><'+'body'+'>');
			  win.document.write(content.html());
			  win.document.write('<'+'/'+'body'+'><'+'/'+'html'+'>');
			  win.document.close();
			  win.print();
			  win.close();
			});
		  }
		 });		
	});
</script>