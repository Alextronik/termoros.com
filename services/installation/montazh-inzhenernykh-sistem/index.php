<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Монтаж инженерных систем многоэтажных зданий");
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
<li>В группе компаний «Терморос» более 100 квалифицированных монтажников в штате со стажем работы от 8 лет.</li>
<li>С нами вы получаете реализацию всех внутренних инженерных систем «под ключ».</li>
<li>Все строительно-монтажные работы проводятся в строгом соответствии с заранее согласованным графиком.</li>
<li>Использование нами передовых технологий, позволяет вести строительно-монтажные работы круглогодично.</li>
<li>В портфеле Группы компаний «Терморос» более 500 реализованных объектов разной степени сложности. </li>
<li>Снабжение строительства всеми необходимыми материалами.</li>
<li>Мы осуществляем сдачу объекта надзорным органам и эксплуатирующей организации. </li>

</ul>
<h2>Примеры нашей работы</h2>
<div class="news-gallery">
	<div class="news-gallery-row">
		<div class="gallery-img">
			<a class="fancy" href="img/2.jpg" rel="gallery" >
				<img src="img/2-m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/3.jpg" rel="gallery" >
				<img src="img/3-m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/4.jpg" rel="gallery" >
				<img src="img/4-m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/5.jpg" rel="gallery" >
				<img src="img/5-m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/6.jpg" rel="gallery" >
				<img src="img/6-m.jpg" alt="" />
			</a>
		</div>
	</div>
</div>

<div class="news-gallery">
	<div class="news-gallery-row">
		<div class="gallery-img">
			<a class="fancy" href="img/7.jpg" rel="gallery" >
				<img src="img/7-m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/8.jpg" rel="gallery" >
				<img src="img/8-m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/9.jpg" rel="gallery" >
				<img src="img/9-m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/10.jpg" rel="gallery" >
				<img src="img/10-m.jpg" alt="" />
			</a>
		</div>
		<div class="gallery-img">
			<a class="fancy" href="img/11.jpg" rel="gallery" >
				<img src="img/11-m.jpg" alt="" />
			</a>
		</div>
	</div>
</div>
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
		"WEB_FORM_ID" => "20"
	)
);?> <?endif;?>
	
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#select_201').change(function() {
			var val = $(this).find('option:selected').attr('data-value');
			
			var i = 0;
			$('#select_202 option').each(function() {
				$(this).hide();
				if ($(this).attr('data-type') == val) { 
					$(this).show();
					if (!i) $('#select_202').val($(this).val());
					i++;
				}
			});

		});
		
		$('#select_201').val(296).trigger('change');
		
	});
</script>
<style>
	#select_202 {
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