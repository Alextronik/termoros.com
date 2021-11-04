<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Монтаж инженерных систем коттеджа");
?>
<?/*
<div class='is_links'>
	<a href='#'><img src='<?=SITE_TEMPLATE_PATH?>/img/is4.jpg' alt=''></a>
	<a href='#'><img src='<?=SITE_TEMPLATE_PATH?>/img/is1.jpg' alt=''></a>
	<a href='#'><img src='<?=SITE_TEMPLATE_PATH?>/img/is5.jpg' alt=''></a>
	<a href='#'><img src='<?=SITE_TEMPLATE_PATH?>/img/is7.jpg' alt=''></a>
	<a href='#'><img src='<?=SITE_TEMPLATE_PATH?>/img/is2.jpg' alt=''></a>
	<div class='clear'></div>
</div>
*/?>
<ul>
<li>Ставим реальные сроки, основываясь на знании технологических процессов и накопленном опыте, полученном более чем за 20 лет работы.</li>
<li>В работе используем только сертифицированное оборудование ведущих европейских производителей.</li>
<li>Предоставляем комплексную гарантию от 24 мес. При возникновении проблем в эксплуатации решаем их своими силами.</li>
<li>Являемся производителями и официальными поставщиками котельного, отопительного и сантехнического оборудования на территории РФ. Это позволяет значительно уменьшить срок поставки оборудования на объект и предоставить дополнительную скидку для заказчика.</li>
</ul>
<h2>Примеры нашей работы</h2>
<div class="news-gallery">
	<div class="news-gallery-row">
		<?/*
		<div class="gallery-img">
			<a class="fancy" href="img/2.jpg" rel="gallery" >
				<img src="img/2m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/3.jpg" rel="gallery" >
				<img src="img/3m.jpg" alt="" />
			</a>
		</div>
		*/?>
		<div class="gallery-img">
			<a class="fancy" href="img/1.jpg" rel="gallery" >
				<img src="img/1m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/4.jpg" rel="gallery" >
				<img src="img/4m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/5.jpg" rel="gallery" >
				<img src="img/5m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/7.jpg" rel="gallery" >
				<img src="img/7m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/6.jpg" rel="gallery" >
				<img src="img/6m.jpg" alt="" />
			</a>
		</div>
		
	</div>
</div>

<div class="news-gallery">
	<div class="news-gallery-row">
		<div class="gallery-img">
			<a class="fancy" href="img/8.jpg" rel="gallery" >
				<img src="img/8m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/9.jpg" rel="gallery" >
				<img src="img/9m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/10.jpg" rel="gallery" >
				<img src="img/10m.jpg" alt="" />
			</a>
		</div>
	</div>
</div>
<?/*
<br><br>
<div class="servpage">
	<div style="float:left;">
		<a href="/services/stages/" class="serv_btn">Этапы работ с новыми клиентами</a>
	</div>
</div>
<div style="clear:both;"></div>
*/?>
<br><br>
<div class="anketa pop_up" style="margin:0;">
	 <?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?> <?else:?> <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"inzhiniring_form",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "inzhiniring_form",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
		"WEB_FORM_ID" => "21"
	)
);?><?endif;?>
	
</div>
<style>
	.pop_up .inpt .inp_self {
		padding: 5px 30px;
	}
	.pop_up .inpt {
        margin: 0 0 10px 0;
	}
</style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>