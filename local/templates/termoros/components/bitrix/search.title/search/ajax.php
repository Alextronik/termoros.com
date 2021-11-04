<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!empty($arResult["CATEGORIES"])):?>
	<table class="title-search-result">
			<tr>
				<td class="title-search-separator">&nbsp;</td>
			</tr>
		<?//p($arResult["CATEGORIES"]);?>
		<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>

			<?if($i == 0):?>
			<tr>
				<td class="title-search-item title"><span class="ttl"><?echo $arCategory["TITLE"]?></span></td>
			</tr>
			<?else:?>
			<tr>
				<td class="title-search-item title"><span class="ttl"><?echo $arCategory["TITLE"]?></span></td>
			</tr>
			<?endif?>
			
			<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
			
			<tr>
				<?if($category_id === "all"):?>
					<td class="title-search-all"><a class="search-link-all" href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a></td>
				<?elseif(isset($arItem["ICON"])):?>
					<td class="title-search-item"><a class="search-link-item" href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a></td>
				<?else:?>
					<td class="title-search-more"><a class="search-link-more" href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a></td>
				<?endif;?>
			</tr>
			<?endforeach;?>
		<?endforeach;?>
	</table><div class="title-search-fader"></div>
<?endif;
?>