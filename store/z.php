<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Инструкция по оплате");
die();
?>
<span id="i"></span>
<script>
navigator.geolocation.getCurrentPosition(
    function(position) {
	    $('#i').html(position.coords.latitude + ", " + position.coords.longitude);
		//alert('Последний раз вас засекали здесь: ' + position.coords.latitude + ", " + position.coords.longitude);
		
	}
);
</script>
<?

die();
$APPLICATION->IncludeComponent("bitrix:map.yandex.view", "ymaps", Array(
	"INIT_MAP_TYPE" => "MAP", "MAP_DATA" => serialize($map_data), "MAP_WIDTH" => "930", "MAP_HEIGHT" => "675",
	"CONTROLS" => array("ZOOM", "TYPECONTROL", "SCALELINE"),
	"OPTIONS" => array("ENABLE_SCROLL_ZOOM", "ENABLE_DBLCLICK_ZOOM", "ENABLE_DRAGGING"),
	"MAP_ID" => "map" . $arResult['ITEMS']['0']['IBLOCK_SECTION_ID']
), false); 
?>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=AJomi10BAAAAjAmiVgIAzvZnYtl2m1QfLHdXdOBvuMr_DWYAAAAAAAAAAAD7hIf2DKQls-tUdBqo4vrefs555A==" type="text/javascript"></script>


<a href="#" id="getGeo">Получить geo</a>
<span id="resGeo"></span>
<script>
	
	ymaps.ready(init);

	function init() {
		var geolocation = ymaps.geolocation,
			myMap = new ymaps.Map('map', {
				center: [55, 34],
				zoom: 10
			}, {
				searchControlProvider: 'yandex#search'
			});

		// Сравним положение, вычисленное по ip пользователя и
		// положение, вычисленное средствами браузера.
		geolocation.get({
			provider: 'yandex',
			mapStateAutoApply: true
		}).then(function (result) {
			// Красным цветом пометим положение, вычисленное через ip.
			result.geoObjects.options.set('preset', 'islands#redCircleIcon');
			result.geoObjects.get(0).properties.set({
				balloonContentBody: 'Мое местоположение'
			});
			myMap.geoObjects.add(result.geoObjects);
		});

		geolocation.get({
			provider: 'browser',
			mapStateAutoApply: true
		}).then(function (result) {
			// Синим цветом пометим положение, полученное через браузер.
			// Если браузер не поддерживает эту функциональность, метка не будет добавлена на карту.
			result.geoObjects.options.set('preset', 'islands#blueCircleIcon');
			myMap.geoObjects.add(result.geoObjects);
		});
	}
</script> 

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
/*
$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/store/noz.csv", "r");
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        $lineArr = explode(";", $buffer);
		foreach($lineArr as $k => $v)
		{
			$lineArr[$k] = rtrim(ltrim(trim($v),'"'), '"');
			$lineArr[$k] = str_replace('"', '', $lineArr[$k]);
		}
		
		$res = CIBlockElement::GetList(
		 Array(),
		 Array("IBLOCK_ID"=>4, "PROPERTY_CML2_ARTICLE" => $lineArr[0]),
		 false,
		 false,
		 Array("ID", "IBLOCK_ID", "DETAIL_PICTURE")
		);
		$ar = $res->GetNext();
		$detailPicture = '';
		if ($ar["DETAIL_PICTURE"])
			$ar["DETAIL_PICTURE_SRC"] = CFile::GetPath($ar["DETAIL_PICTURE"]);
		
		
		if ($ar["DETAIL_PICTURE_SRC"])
		{
			echo 'https://www.termoros.com'.$ar["DETAIL_PICTURE_SRC"].'<br/>';
		}
		else echo '<br>';
		
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
*/

?>
