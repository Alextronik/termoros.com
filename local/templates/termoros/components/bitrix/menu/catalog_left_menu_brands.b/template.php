<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

?>

<?if($arResult['BRANDS']):?>
<div class='left_menu'>
	<?foreach($arResult['BRANDS'] as $item){?>
		<?//p($item);?>
		<a href='<?=$item["LINK"] ?>?arrFilter[PROPERTY_BREND]=<?=$arResult['BRAND_XMLID']?>'
		   class='ttl<?=$item["SELECTED"] == 'Y' ? " active" : "" ?>'><?= $item["TEXT"] ?>
		</a>
	<?}?>
</div>
<?endif;?>

