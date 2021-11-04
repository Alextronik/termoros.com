<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

	<div class='mainservices_block'>
	<div class='container px-0'>
		<ul class='services_ul'>
			<?foreach($arResult as $arItem):
				if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
					continue;
				?>

				<li>
				<a href='<?=$arItem["LINK"]?>'>
					<div class='s_ico'>
						<img class="lozad" data-src='<?=SITE_TEMPLATE_PATH?><?=$arItem["PARAMS"]["IMG"]?>'  alt=''>
					</div>
					<div class='serv_i'>
						<p class='ttl'><?=$arItem["TEXT"]?></p>
						<p class='txt'><?=$arItem["PARAMS"]["TEXT"]?></p>
						<span href='' class='read_more'>Узнать больше</span>
					</div>
				</a>
				</li>
			<?endforeach?>


		</ul>
		<div class='clear'></div>
	</div>
	</div>



<?endif?>