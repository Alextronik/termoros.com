<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<?
$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/store/part1.csv", "r");
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        $lineArr = explode(";", $buffer);
		foreach($lineArr as $k => $v)
		{
			$lineArr[$k] = rtrim(ltrim(trim($v),'"'), '"');
			$lineArr[$k] = str_replace('"', '', $lineArr[$k]);
			$lineArr[$k] = str_replace("\\", ' корп. ', $lineArr[$k]);
		}
		
		if ($lineArr[1])
		{
			$services[] = $lineArr;
		}
		//echo $buffer;
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

?>
<script src="https://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript">
    ymaps.ready(init);

	function init() {
		var myMap = new ymaps.Map('map', {
			center: [55.753994, 37.622093],
			zoom: 9
		});
		
		<?
		foreach($services as $service)
		{
			
			$location = $service[10].' '.$service[5];
			//$location = str_replace('"', '', $location);
			//$location = str_replace("\\", ' корп. ', $location);
			?>
			
			// Поиск координат центра Нижнего Новгорода.
			ymaps.geocode("<?=$location?>", {
				results: 1
			}).then(function (res) {
				// Выбираем первый результат геокодирования.
				var firstGeoObject = res.geoObjects.get(0),
					// Координаты геообъекта.
					coords = firstGeoObject.geometry.getCoordinates();
					$('#coords table').append("<tr><td><?=implode("</td><td>", $service)?></td><td><?=$location?></td><td>"+coords[0]+"</td><td>"+coords[1]+"</td></tr>");
			},
			function (err) {
				$('#coords table').append("<tr><td><?=implode("</td><td>", $service)?></td><td><?=$location?></td><td></td><td></td></tr>");
			}
			);
			<?
		
		}
		?>
	}
</script>
<style type="text/css">
	html, body, #map {
		width: 100%;
		height: 100%;
		margin: 0;
		padding: 0;
	}
</style>
<div id="map"></div>
<div id="coords">
	<table>
	</table>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>