<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($arParams["SHOW_CHAIN"] != "N" && !empty($arResult["TAGS_CHAIN"])):
?>
<noindex>
	<div class="search-tags-chain" <?=$arParams["WIDTH"]?>><?
		foreach ($arResult["TAGS_CHAIN"] as $tags):
			?><a href="<?=$tags["TAG_PATH"]?>" rel="nofollow"><?=$tags["TAG_NAME"]?></a> <?
			?>[<a href="<?=$tags["TAG_WITHOUT"]?>" class="search-tags-link" rel="nofollow">x</a>]  <?
		endforeach;?>
	</div>
</noindex>
<?
endif;

$tag = urldecode($_REQUEST["tags"]);

if(is_array($arResult["SEARCH"]) && !empty($arResult["SEARCH"])):?>
<noindex>
	<div class="search-tags-cloud" style="width: 100%;">
		<?
		$count=count($arResult["SEARCH"]);
		$i=0;
		foreach ($arResult["SEARCH"] as $key => $res)
		{
			if($i<($count/2))
				{
					$arResult["SEARCHTAB"][0][]=$arResult["SEARCH"][$key];
					$i++;
				}
			else
				$arResult["SEARCHTAB"][1][]=$arResult["SEARCH"][$key];
		}  ?>
	    <div class="contain-cloud">
			<?foreach ($arResult["SEARCHTAB"][0] as $key => $res)
			{
				{
					?>
			        <a class="tags-art-a" href="<?=$res["URL"]?>" style="font-size: <?=$res["FONT_SIZE"]?>px;" rel="nofollow"><span class="tags-art"><?=$res["NAME"]?> (<?=$res["CNT"]?>)</span></a>
			        <?
				}	
			}
			 foreach ($arResult["SEARCHTAB"][1] as $key => $res)
			{
				{
			        ?>
			        <a href="<?=$res["URL"]?>" style="font-size: <?=$res["FONT_SIZE"]?>px; color: #<?=$res["COLOR"]?>;" rel="nofollow"><span class="tags-art"><?=$res["NAME"]?> (<?=$res["CNT"]?>)</span></a>
			        <?
				}	
			}
			;?>
	    </div>
	  	</div>
	<div style="clear: both; width: 100%; height: 1px;"></div>  
</noindex>
<?
endif;
?>
