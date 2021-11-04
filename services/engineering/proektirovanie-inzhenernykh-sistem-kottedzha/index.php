<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Проектирование инженерных систем коттеджа");
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
<li>При монтаже без проекта или по схеме, нарисованной монтажником, велика вероятность, что система не только не сможет обеспечить вам необходимый уровень комфорта, но и элементарную работоспособность оборудования. Кроме того, ошибки проектирования и монтажа могут привести к выходу дорогостоящего оборудования из строя, при этом возможен отказ производителя от гарантии.</li>
<li>Разработка проекта с применением энергосберегающих технологий позволяет уменьшить расход топлива на 45%.</li>
<li>На основании проектной документации разрабатывается смета с фиксированной стоимостью строительно-монтажных работ и оборудования.</li>
<li>При проектировании учитываются пожелания всех представителей заказчика, что позволяет избежать затруднений и многочисленных переделок при монтаже. </li>
</ul>
<br>
<h2>Примеры нашей работы</h2>
<div class="news-gallery">
	<div class="news-gallery-row">
		<div class="gallery-img">
			<a class="fancy" href="img/1.jpg" rel="gallery" >
				<img src="img/1m.jpg" alt="" />
			</a>
		</div>
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
	</div>
</div>

<div class="news-gallery">
	<div class="news-gallery-row">
		<div class="gallery-img">
			<a class="fancy" href="img/6.jpg" rel="gallery" >
				<img src="img/6m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/7.jpg" rel="gallery" >
				<img src="img/7m.jpg" alt="" />
			</a>
		</div>
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
<br><br>
<div class="servpage">
	<div style="float:left;">
		<a href="/services/stages/" class="serv_btn">Этапы работ с новыми клиентами</a>
	</div>
</div>
<div style="clear:both;"></div>
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
		"WEB_FORM_ID" => "23"
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