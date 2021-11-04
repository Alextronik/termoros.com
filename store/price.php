<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
die();
$res = CIBlockElement::GetList(
 Array(),
 Array("IBLOCK_ID"=>4, 'ACTIVE'=>"Y", 'PROPERTY_BREND'=>"524dfe7d-ce74-11e5-80d6-0cc47a1d8513"),
 false,
 false,
 Array("ID", "NAME", "CML2_ARTICLE", "IBLOCK_SECTION_ID", "SECTION_ID")
);
while($el = $res->GetNext())
{
	$elements[$el["IBLOCK_SECTION_ID"]][] = $el;
}


$res = CIBlockSection::GetTreeList(
 Array("IBLOCK_ID"=>4, 'ACTIVE'=>"Y", 'PROPERTY'=>Array('BREND'=>"524dfe7d-ce74-11e5-80d6-0cc47a1d8513")),
 Array("ID", "NAME", "DEPTH_LEVEL")
);

while($ob = $res->GetNext())
{
	//echo str_repeat("-", $ob['DEPTH_LEVEL']).$ob['NAME'].'<br>';
	$groups[] = $ob;
	
	//if ($elements[$ob["ID"]]) echo count($elements[$ob["ID"]]);
}

foreach($groups as $k => $group)
{
	if ($groups[$k+1] && $groups[$k+1]['DEPTH_LEVEL'] > $groups[$k]['DEPTH_LEVEL']) $groups[$k]['IS_PARENT'] = TRUE;
	
	/*echo str_repeat("-", $group['DEPTH_LEVEL']).'<b>'.$group['NAME'].'</b><br>';
	if ($elements[$group["ID"]])
	{
		foreach($elements[$group["ID"]] as $el)
		{
			echo '<input type="radio" value="'.$el["ID"].'">'.$el["NAME"].'<br>';
		}
		
	}
	*/
}
$arResult = $groups;

$previousLevel = 0;
foreach($arResult as $k => $arItem){
	
	if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) {
		echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
	}

	if ($arItem["IS_PARENT"]) { ?>
		<li><a href="<?=$arItem["LINK"]?>" class="parent<?if ($arItem["SELECTED"]):?> item-selected<?endif?>"><?=$arItem["NAME"]?></a>
				<ul>
	<?	} else {
		?>
		<? if ($elements[$arItem['ID']]) { ?>
		<li><a href="<?=$arItem["LINK"]?>" <?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><?=$arItem["NAME"]?></a>
			<ul>
			<? foreach($elements[$arItem['ID']] as $el) { ?>
				<li><input type="checkbox" name="EL_ID" value="<?=$el["ID"]?>"><?=$el["NAME"]?></li>
			<? } ?>
			</ul>
		</li>
		<? } ?>
		<?
	}

	$previousLevel = $arItem["DEPTH_LEVEL"];

}

if ($previousLevel > 1){
	echo str_repeat("</ul></li>", ($previousLevel-1) );
}
?>
<style>
	li {
		margin: 5px !important;
		padding: 0px !important;
		
	}
	ul {
		margin: 0 !important;
		padding: 0;
		
	}
	input 
	{
		-webkit-appearance: checkbox !important;
		vertical-align: bottom;
	}
</style>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>