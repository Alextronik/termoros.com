<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?
if (!empty($arResult['ITEMS']))
{?>
	<div class='cat_list'>
	<?foreach($arResult['ITEMS'] as $arItem){
		p($arItem)?>
	

			<div class='cat_item'>
				<div class='im_area'>
					<a href='' class='quick_btn'>Быстрый просмотр</a>
					<div class="new_label"></div>
					<img src='img/item1.png'>
				</div>
				<a href='' class='name'>Регулирующий узел для системы напольного отопления</a>
				<p class='brand'>Бренд:<a href=''>FAR</a></p>
				<div class='price_block'>
					<p class='price'>121 234<span>руб.</span></p>

					<a href='' class='to_basket'>в корзину</a>
				</div>
			</div>

			<div class='cat_item'>
				<div class='im_area'>
					<a href='' class='quick_btn'>Быстрый просмотр</a>
					<div class="sale_label"></div>
					<img src='img/item1.png'>
				</div>
				<a href='' class='name'>Регулирующий узел для системы напольного отопления</a>
				<p class='brand'>Бренд:<a href=''>FAR</a></p>
				<div class='price_block'>
					<p class='oldprice'>521 234</p>
					<p class='price'>121 234<span>руб.</span></p>

					<a href='' class='to_basket'>в корзину</a>
				</div>
			</div>

			<div class='cat_item'>
				<div class='im_area'>
					<a href='' class='quick_btn'>Быстрый просмотр</a>
					<div class="hit_label"></div>
					<img src='img/item1.png'>
				</div>
				<a href='' class='name'>Регулирующий узел для системы напольного отопления</a>
				<p class='brand'>Бренд:<a href=''>FAR</a></p>
				<div class='price_block'>
					<p class='oldprice'>521 234</p>
					<p class='price'>121 234<span>руб.</span></p>

					<a href='' class='to_basket'>в корзину</a>
				</div>
			</div>


			<div class='clear'></div>

	<?}?>
	</div>

<?
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}
}