<?
define('LEFTBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Сотрудничество с монтажными компаниями. Предлагаем купить промышленное и бытовое котельное оборудование, системы отопления, водоснабжения и др. Осуществляем проектирование, монтаж и обслуживание инженерных систем. Гарантия качества, сертификаты и лицензии на проведение работ, оптимальные цены. Доставка по Москве и в регионы России.");
$APPLICATION->SetPageProperty("title", "Монтажные компании | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("keywords", "монтажные компании инженерное оборудование системы купить цена продажа интернет магазин");
$APPLICATION->SetTitle("Монтажные компании");
?><p>
	 Группа компаний «Терморос» успешно сотрудничает с частными монтажниками и крупными монтажными организациями, предлагая выгодные условия совместной работы: от профессиональных консультаций и подбора инженерной продукции до запуска в эксплуатацию инженерных систем и последующего их обслуживания.
</p>
<h3>Продукция </h3>
<p>
	 В ассортиментном портфеле «Терморос» <a href="/brands/">более 50 брендов</a>&nbsp;отечественной, европейской и азиатской продукции: лидирующие на рынке Danfoss, Purmo, Rifar, Grundfos, Baxi, Reflex, FAR, Jaga и собственная продукция Группы компаний «Терморос» – Gekon, Euros, Germanium, Atlant.
</p>
<h3>Услуги </h3>
<p>
</p>
<ol class="custom_ol">
	<li><span class="num">1</span>Наличие оборудования на <a href="/contacts/">складских комплексах компании</a> в 9 городах России: Москве, Санкт-Петербурге, Казани, Краснодаре, Уфе, Новосибирске, Екатеринбурге, Ростове-на-Дону и Пятигорске;</li>
	<li><span class="num">2</span>Выгодные условия и индивидуальные скидки;</li>
	<li><span class="num">3</span><a href="/technical_support/tech_documentation/">Сопровождение продаж</a> всей необходимой документацией, технической, рекламно-маркетинговой, информационной продукцией и полиграфией, а также помощь в оборудовании мест продаж;</li>
	<li><span class="num">4</span>Доставка по Москве, Московской области и до терминалов многих транспортных компаний для отгрузки в регионы;</li>
	<li><span class="num">5</span><a href="/technical_support/training/">Регулярное бесплатное обучение</a> навыкам продаж и техническим особенностям оборудования в нашем учебном центре или на территории партнера с участием специалистов компании «Терморос» и представителей поставщиков;</li>
</ol>
<p>
 <b>По вопросам сотрудничества</b> обращайтесь к Руководителю проекта Ромаченко Ирине, тел.: (499) 500 00 01 (доб.1147), <a href="mailto:irina@termoros.com">irina@termoros.com</a>
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
		"WEB_FORM_ID" => "13"
	)
);?> <?endif;?>
	<div style="height: 50px;" class="clear">
	</div>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>