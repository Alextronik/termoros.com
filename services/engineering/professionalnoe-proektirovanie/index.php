<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Проектирование инженерных систем мнгоэтажных зданий");
?>
<?/*
<div class='is_links'>
	<a href='/engineering_systems/boiler_rooms/'><img src='<?=SITE_TEMPLATE_PATH?>/img/is4.jpg' alt=''></a>
	<a href='/engineering_systems/itp_ctp/'><img src='<?=SITE_TEMPLATE_PATH?>/img/is6.jpg' alt=''></a>
	<a href='/engineering_systems/water_supply/'><img src='<?=SITE_TEMPLATE_PATH?>/img/is1.jpg' alt=''></a>
	<a href='/engineering_systems/water_disposal/'><img src='<?=SITE_TEMPLATE_PATH?>/img/is5.jpg' alt=''></a>
	<a href='/engineering_systems/heat_supply_ventilation/'><img src='<?=SITE_TEMPLATE_PATH?>/img/is7.jpg' alt=''></a>
	<a href='/engineering_systems/cold_supply/'><img src='<?=SITE_TEMPLATE_PATH?>/img/is2.jpg' alt=''></a>
	<div class='clear'></div>
</div>
*/?>
<ul>
<li>Точные расчёты гарантируют работоспособность инженерных систем в заданном режиме, что обеспечивает людям, находящимся в помещении, максимальный комфорт. </li>
<li>Наличие проекта позволяет оптимизировать затраты на оборудование и минимизировать сроки монтажа и пусконаладки, а также четко спланировать очередность этапов работ.</li>
<li>Проект увязывает между собой различные инженерные разделы и обеспечивает их эффективное функционирование как единого целого.</li>
<li>В проекте фиксируются все инженерные системы, места их размещения и технические параметры, что обеспечивает возможность замены оборудования или обновления системы в случае необходимости. Вся информация остается у заказчика в виде исполнительной документации и чертежей.</li>
<li>В случае необходимости мы производим согласование проекта с надзорными органами.</li>
</ul>
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
		"WEB_FORM_ID" => "22"
	)
);?> <?endif;?>
	
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#select_213').change(function() {
			var val = $(this).find('option:selected').attr('data-value');
			
			var i = 0;
			$('#select_214 option').each(function() {
				$(this).hide();
				if ($(this).attr('data-type') == val) { 
					$(this).show();
					if (!i) $('#select_214').val($(this).val());
					i++;
				}
			});

		});
		
		$('#select_201').val(438).trigger('change');
		
	});
</script>
<style>
	#select_214 {
		width: 555px;
	}
	.pop_up .inpt .inp_self {
		padding: 5px 30px;
	}
	.pop_up .inpt {
        margin: 0 0 10px 0;
	}
</style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>