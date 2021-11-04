<?
define('NOMENU', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Прайс-листы – Скачать прайсы на инженерное оборудование │ Группа компаний Терморос");
$APPLICATION->SetPageProperty("description", "Прайс-листы на инженерное оборудование можно скачать в формате PDF на сайте Терморос. Актуальные цены. Фильтр по производителям и виду продукции.");
$APPLICATION->SetTitle("Прайс-листы");
?>
<p>Перечень прайс-листов</p>
<?
$res = CIblockElement::GetList(
	array("PROPERTY_PRODUCTER" => "ASC", "NAME" => "ASC"),
	array("IBLOCK_ID" => 15, "ACTIVE" => "Y"),
	false,
	false,
	array('*', 'PROPERTY_ZIP', 'PROPERTY_FILE_PATH_ZIP', 'PROPERTY_PRODUCTER')
);
while($ar = $res->GetNext())
{
	$priceLists[$ar["PROPERTY_PRODUCTER_VALUE"]][] = $ar;
}
?>
<table>
	<tr>
		<td><b>Бренд</b></td>
		<td><b>Прайс-лист</b></td>
	</tr>
	<? foreach($priceLists as $brand => $arr) { ?>
		<? foreach($arr as $k => $el) { ?>
			<?
			if ($el["PROPERTY_ZIP_VALUE"])
			{
				$filePath = CFile::GetPath($el["PROPERTY_ZIP_VALUE"]);
			}
			elseif ($el["PROPERTY_FILE_PATH_ZIP_VALUE"])
			{
				$filePath = '/upload/pricelists/'.$el['PROPERTY_FILE_PATH_ZIP_VALUE'];
			}
			
			
			?>
			<tr>
				<td><?=$brand?></td>
				<td><a target="_blank" href="<?=$filePath?>"><?=$el["NAME"]?></a></td>
			</tr>
		<? } ?>
	<? } ?>
</table>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>