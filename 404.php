<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");?>

<?/*?>
<div class="col-sm-offset-1 col-sm-4" style="text-align: center;" >
	<div class="bx-404-container">
		<div class="bx-404-block"><img src="<?=SITE_DIR?>images/404.png" alt=""></div>
		<div class="bx-404-text-block">Неправильно набран адрес, <br>или такой страницы на сайте больше не существует.</div>
		<div class="">Вернитесь на <a href="<?=SITE_DIR?>">главную</a> или воспользуйтесь картой сайта.</div>
	</div>
	<div class="map-columns row">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="bx-maps-title">Карта сайта:</div>
		</div>
	</div>
</div>
<?*/?>

<div class='err_page container'>
<div class='err_im'>
	
	<div class='err_inner'>
		<p class='big'>404</p>
		<p class='small'>ошибка</p>
		<p class='txt'>К сожалению, запрашиваемой страницы не существует</p>
	</div>
	
</div>

<!--
<div class='popular_block'>
	<p class='ttl'>Популярные товары</p>
	<div class='cat_list_wp'>
		<div class='cat_list'>
			
			<div class='cat_item'>
				<div class='im_area'>
					<a href='' class='quick_btn'>Быстрый просмотр</a>
					<div class='new_label'></div>
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
					<div class='new_label'></div>
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
					<div class='new_label'></div>
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
					<div class='new_label'></div>
					<img src='img/item1.png'>
				</div>
				<a href='' class='name'>Регулирующий узел для системы напольного отопления</a>
				<p class='brand'>Бренд:<a href=''>FAR</a></p>
				<div class='price_block'>
					<p class='price'>121 234<span>руб.</span></p>
					
					<a href='' class='to_basket'>в корзину</a>
				</div>
			</div>
			
			<div class='clear'></div>
		</div>
	</div>
	
	<a href='' class='show_more'></a>
	
</div>
-->
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>