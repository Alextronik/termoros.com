<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Фото менеджеров.");
die();
\Bitrix\Main\Loader::includeModule('redreams.partners');
$man = new \Redreams\Partners\manager();

$managers = $man->getlist(array(">UF_PHOTO" => "0"));
foreach($managers as $m)
{
	$imgFile = CFile::ResizeImageGet($m['UF_PHOTO'], array('width'=>120, 'height'=>120), BX_RESIZE_IMAGE_EXACT, true);
	?>
	<p><?=$m["UF_FIO"]?><br>
	<img src="<?=$imgFile['src']?>"><br>
	</p>
	<?
}
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>