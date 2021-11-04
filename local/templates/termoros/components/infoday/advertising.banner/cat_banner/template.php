<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//p($arResult);
?>
<a href='' class='cat_link'>
	<? $file = CFile::ResizeImageGet($arResult["BANNERS"][0]['IMAGE_ID'], array('width'=>320, 'height'=>385), BX_RESIZE_IMAGE_EXACT, true);?>
	<img src="<?=$file['src']?>">
</a>
