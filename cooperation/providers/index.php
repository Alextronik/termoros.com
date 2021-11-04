<?
define('LEFTBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Поставщики компании «Терморос». Предлагаем купить промышленное и бытовое котельное оборудование, системы отопления, водоснабжения и др. Осуществляем проектирование, монтаж и обслуживание инженерных систем. Гарантия качества, сертификаты и лицензии на проведение работ, оптимальные цены. Доставка по Москве и в регионы России.");
$APPLICATION->SetPageProperty("title", "Поставщики | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("keywords", "поставщики инженерное оборудование системы купить цена продажа интернет магазин");
$APPLICATION->SetTitle("Поставщики");
?><p>
	 В ассортименте международной Группы компаний «Терморос» более 50 брендов современного и высокотехнологичного инженерного оборудования российского, европейского и азиатского производства.
</p>
<p>
 <a href="/brands/">Бренды «Терморос»</a>
</p>
<p>
	 Наши партнеры – ведущие производители промышленного и бытового котельного оборудования, систем отопления, водоснабжения, водоподготовки и другой продукции для комплектации инженерных систем.
</p>
<p>
 <a href="/catalog/">Каталог продукции «Терморос»</a>
</p>
<p>
	 Продукция, предлагаемая «Терморос», соответствует самым высоким российским и международным стандартам качества и обладает <a target="_blank" href="/technical_support/tech_documentation/">всеми необходимыми сертификатами</a> для ее реализации.
</p>
<p>
	 Уверенность в надежности нашей продукции основана на том, что мы проводим полный комплекс работ с нашим оборудованием: от испытаний в лаборатории «Терморос» до применения в собственной инжиниринговой деятельности.
</p>
<p>
	 Оборудование получило многочисленные премии за дизайн, экологичность и энергоэффективность.
</p>

<div class="news-gallery">
	<div class="news-gallery-row">
		<div class="gallery-img">
			<a class="fancy" href="/cooperation/providers/eco1-min.jpg" rel="gallery" >
				<img src="/cooperation/providers/eco1_m-min.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="/cooperation/providers/eco2-min.jpg" rel="gallery" >
				<img src="/cooperation/providers/eco2_m-min.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="/cooperation/providers/eco3-min.jpg" rel="gallery" >
				<img src="/cooperation/providers/eco3_m-min.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="/cooperation/providers/eco4-min.jpg" rel="gallery" >
				<img src="/cooperation/providers/eco4_m-min.jpg" alt="" />
			</a>
		</div>
	</div>
</div>

<p>
	 По вопросам сотрудничества обращайтесь по электронной почте: <a href="mailto:supply@termoros.com">supply@termoros.com</a>&nbsp;или заполните форму обратной связи.
</p>
<div class="anketa pop_up">
	 <?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?> <?else:?> <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"simple_form",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "simple_form",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
		"WEB_FORM_ID" => "9"
	)
);?> <?endif;?>
	<div style="height: 50px;" class="clear">
	</div>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>