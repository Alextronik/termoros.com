<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Типовые расчеты отопительных систем в коттеджах");
?>
<div style="width: 880px;">
<h2>Выберите дом</h2>
	<div style="width:200px; float: left; margin: 10px; cursor: pointer; margin-left:0; text-align: center;">
		
		<a class="fancy" rel="house" onclick="$('#radio1').trigger('click');" href="img/1-max.jpg">
			<img src="img/1-min.jpg" />
		</a>
		<label for="radio1" style="cursor: pointer;">
		<p style="font-size:18px; text-align:center;"><input class="defaultRadio" id="radio1" type="radio" name="houseArea" value="100" /> <b>100м<sup style="font-size: 12px; vertical-align: super;">2</sup></b></p>
		</label>
	</div>

	<div style="width:200px;  float: left; margin: 10px; cursor: pointer;">
		<a class="fancy" rel="house" onclick="$('#radio2').trigger('click');" href="img/2-max.jpg">
			<img src="img/2-min.jpg" />
		</a>
		<label for="radio2" style="cursor: pointer;">
		<p style="font-size:18px; text-align:center;"><input class="defaultRadio" id="radio2" type="radio" name="houseArea" value="200" /> <b>200м<sup style="font-size: 12px; vertical-align: super;">2</sup></b></p>
		</label>
	</div>

	<div style="width:200px;  float: left; margin: 10px; cursor: pointer;">
		<a class="fancy" rel="house" onclick="$('#radio3').trigger('click');" href="img/3-max.jpg">
			<img src="img/3-min.jpg" />
		</a>
		<label for="radio3" style="cursor: pointer;">
		<p style="font-size:18px; text-align:center;"><input class="defaultRadio" id="radio3" type="radio" name="houseArea" value="300" /> <b>300м<sup style="font-size: 12px; vertical-align: super;">2</sup></b></p>
		</label>
	</div>

	<div style="width:200px;  float: left; margin: 10px; cursor: pointer;">
		<a class="fancy" rel="house" onclick="$('#radio4').trigger('click');" href="img/4-max.jpg">
			<img src="img/4-min.jpg" />
		</a>
		<label for="radio4" style="cursor: pointer;">
		<p style="font-size:18px; text-align:center;"><input class="defaultRadio" id="radio4" type="radio" name="houseArea" value="400" /> <b>400м<sup style="font-size: 12px; vertical-align: super;">2</sup></b></p>
		</label>
	</div>
</div>
<div class="clear"></div>

<div class="servpage" style="display:none; width: 880px; text-align: center;">

	<div style="width:50%;float:left;">
		<a href="#" id="eco" class="serv_btn">Эконом</a>
	</div>
	<div style="width:50%;float:left;">	
		<a href="#" id="comf" class="serv_btn">Комфорт</a>
	</div>
</div>
<div style="clear:both;"></div>

<div style="width: 880px;">
	<div class="house_compred_descr" id="radio1-eco" style="display:none;">
		<h2>Одноэтажный дом из пеноблоков, отапливаемая площадь 104 м² (Эконом)</h2>
		<p><b>План помещения:</b></p>
		<a  class="fancy" rel="scheme-1" href="img/1-plan.gif">
			<img style="margin:5px; border: 1px solid black;" src="img/1-plan-min.gif"/>
		</a>
		<a class="fancy" rel="scheme-1" href="img/scheme-1.jpg">
			<img style="margin:5px; border: 1px solid black;" src="img/scheme-1-min.jpg"/>
		</a>
		<br>
		<br>
		<p><b>Комплекс систем:</b></p>
		<p>Водоснабжение (ХВС, ГВС), отопление (радиаторы)</p>
		
		<h3>Использовано следующее основное оборудование:</h3>
		<p><b>В системе водоснабжения:</b></p>
		<ul>
			<li>Металлопластиковые трубы APE</li>
			<li>Пресс-фитинги APE</li>
			<li>Запорно-регулирующая арматура FAR и FIV</li>
		</ul>
		<p><b>В системе отопления:</b></p>
		<ul>
			<li>Настенный двухконтурный газовый котел LAMBORGHINI TAURA D с битермическим теплообменником,
		коаксиальным дымоходом и встроенной погодозависимой автоматикой.</li>
			<li>Алюминиевые радиаторы GEKON</li>
			<li>Запорно-регулирующая арматура FAR и FIV</li>
			<li>Металлопластиковые трубы APE</li>
				<li>Пресс-фитинги APE</li>
				<li>Запорно-регулирующая арматура FAR и FIV</li>
		</ul>
		
		<table style="" border="1" cellspacing="0" cellpadding="0">
			<tr style="background: #3e457c;">
				<th colspan="4" style="text-align:center; font-size:18px; color: white; line-height: 30px;">Оборудование</th>
			</tr>
			<tr>
				<td colspan="3">Котельная</td>
				<td style="text-align: right;">63 777,90</td>
			</tr>
			<tr>
				<td colspan="3">Отопление (радиаторы, комплектующие, разводка)</td>
				<td style="text-align: right;">115 563,78</td>
			</tr>
			<tr>
				<td colspan="3">ХВС, ГВС (разводка)</td>
				<td style="text-align: right;">19 066,61</td>
			</tr>
			<tr>
				<td colspan="3"><span style="color:red;">***</span>Дополнительноеоб-ние (герметик, провода, крепеж, утеплитель для труб...)</td>
				<td style="text-align: right;">7 000,00</td>
			</tr>
			<tr>
				<td colspan="3"><b>Общая сумма за оборудование</b></td>
				<td style="color: red;text-align: right;">205 408,29</td>
			</tr>

			<tr style="background: #3e457c;">
				<th colspan="4" style="text-align:center; font-size:18px; color: white; line-height: 30px;">Монтаж</th>
			</tr>
			<tr>
				<td colspan="3">Предварительный выезд на объект Заказчика</td>
				<td style="text-align: right;">5 000,00</td>
			</tr>
			<tr>
				<td colspan="3">Котельная</td>
				<td style="text-align: right;">18 000,00</td>
			</tr>
			<tr>
				<td colspan="3">Отопление (радиаторы, комплектующие, разводка)</td>
				<td style="text-align: right;">66 160,00</td>
			</tr>
			<tr>
				<td colspan="3">ХВС, ГВС (разводка)</td>
				<td style="text-align: right;">23 080,00</td>
			</tr>
			<tr>
				<td colspan="3"><b>Общая сумма за монтаж</b></td>
				<td style="color: red;text-align: right;">112 240,00</td>
			</tr>

			<tr style="background: #3e457c;">
				<th colspan="4" style="text-align:center; font-size:18px; color: white; line-height: 30px;">Пусконаладочные работы</th>
			</tr>
			<tr>
				<td colspan="3">Транспортные расходы при выезде на объект Заказчика</td>
				<td style="text-align: right;">3 000,00</td>
			</tr>
			<tr>
				<td>Пуско-наладочные работы по системе отопления, за м2</td>
				<td>104</td>
				<td style="width: 10%;">40</td>
				<td style="text-align: right;">4 160,00</td>
			</tr>
			<tr>
				<td>Проведение пусконаладочных работ настенных моделей газового котла с атмосферной горелкой (с
базовой комплектацией)</td>
				<td>1</td>
				<td style="nowrap;">6 750,00</td>
				<td style="text-align: right;">6 750,00</td>
			</tr>
			<tr>
				<td  colspan="3"><b>Общая сумма за пусконаладочные работы</b></td>
				<td style="color: red;text-align: right;">10 910,00</td>
			</tr>

			<tr style="background: #3e457c;">
				<th colspan="4" style="text-align:center; font-size:18px; color: white; line-height: 30px;">Годовое сервисное обслуживание</th>
			</tr>
			
			<tr>
				<td>Годовое сервисное (техническое) обслуживание настенных моделей котла с атмосферной горелкой</td>
				<td>1</td>
				<td>15 300,00</td>
				<td style="text-align: right;">15 300,00</td>
			</tr>
			<tr>
				<td colspan="3"><b>Годовое сервисное обслуживание</b></td>
				<td style="color: red;text-align: right;">15 300,00</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2"><b>Итого</b></td>
				<td style="text-align: right;"><b>343 858,29</b></td>
			</td>
		</table>
	</div>
	<div class="house_compred_descr" id="radio1-comf" style="display:none;">
		<h2>Одноэтажный дом из пеноблоков, отапливаемая площадь 104 м² (Комфорт)</h2>
		<p><b>План помещения:</b></p>
		<a class="fancy" href="img/1-plan.gif">
			<img src="img/1-plan-min.gif"/>
		</a>

		<br>
		<br>
		<p><b>Комплекс систем:</b></p>
		<p>Водоснабжение (ХВС, ГВС), отопление (радиаторы), теплые полы в режиме "дополнение" (в санузлах и на кухне)</p>
		
		<h3>Использовано следующее основное оборудование:</h3>
		<p><b>В системе водоснабжения:</b></p>
		<ul>
			<li>Металлопластиковые трубы APE</li>
			<li>Пресс-фитинги APE</li>
			<li>Запорно-регулирующая арматура FAR и FIV</li>
			<li>Коллекторные коробки GROTA</li>
		</ul>
		<p><b>В системе отопления:</b></p>
		<ul>
			<li>Настенный двухконтурный газовый котел BAXI NUVOLA 3 COMFORT с коаксиальным дымоходом, со встроенным 60-ти литровым бойлером и встроенной погодозависимой автоматикой.</li>
			<li>Алюминиевые радиаторы ATLANT</li>
			<li>Запорно-регулирующая арматура FAR и FIV</li>
			<li>Металлопластиковые трубы APE</li>
			<li>Пресс-фитинги APE</li>
			<li>Запорно-регулирующая арматура FAR и FIV</li>
			<li>Коллекторные коробки GROTA</li>
		</ul>
		
		<table style="" border="1" cellspacing="0" cellpadding="0">
			<tr style="background: #3e457c;">
				<th colspan="4" style="text-align:center; font-size:18px; color: white; line-height: 30px;">Оборудование</th>
			</tr>
			<tr>
				<td colspan="3">Котельная</td>
				<td style="text-align: right;">63 777,90</td>
			</tr>
			<tr>
				<td colspan="3">Отопление (радиаторы, комплектующие, разводка)</td>
				<td style="text-align: right;">115 563,78</td>
			</tr>
			<tr>
				<td colspan="3">ХВС, ГВС (разводка)</td>
				<td style="text-align: right;">19 066,61</td>
			</tr>
			<tr>
				<td colspan="3"><span style="color:red;">***</span>Дополнительноеоб-ние (герметик, провода, крепеж, утеплитель для труб...)</td>
				<td style="text-align: right;">7 000,00</td>
			</tr>
			<tr>
				<td colspan="3"><b>Общая сумма за оборудование</b></td>
				<td style="color: red;text-align: right;">205 408,29</td>
			</tr>

			<tr style="background: #3e457c;">
				<th colspan="4" style="text-align:center; font-size:18px; color: white; line-height: 30px;">Монтаж</th>
			</tr>
			<tr>
				<td colspan="3">Предварительный выезд на объект Заказчика</td>
				<td style="text-align: right;">5 000,00</td>
			</tr>
			<tr>
				<td colspan="3">Котельная</td>
				<td style="text-align: right;">18 000,00</td>
			</tr>
			<tr>
				<td colspan="3">Отопление (радиаторы, комплектующие, разводка)</td>
				<td style="text-align: right;">66 160,00</td>
			</tr>
			<tr>
				<td colspan="3">ХВС, ГВС (разводка)</td>
				<td style="text-align: right;">23 080,00</td>
			</tr>
			<tr>
				<td colspan="3"><b>Общая сумма за монтаж</b></td>
				<td style="color: red;text-align: right;">112 240,00</td>
			</tr>

			<tr style="background: #3e457c;">
				<th colspan="4" style="text-align:center; font-size:18px; color: white; line-height: 30px;">Пусконаладочные работы</th>
			</tr>
			<tr>
				<td colspan="3">Транспортные расходы при выезде на объект Заказчика</td>
				<td style="text-align: right;">3 000,00</td>
			</tr>
			<tr>
				<td>Пуско-наладочные работы по системе отопления, за м2</td>
				<td>104</td>
				<td style="width: 10%;">40</td>
				<td style="text-align: right;">4 160,00</td>
			</tr>
			<tr>
				<td>Проведение пусконаладочных работ настенных моделей газового котла с атмосферной горелкой (с
базовой комплектацией)</td>
				<td>1</td>
				<td style="nowrap;">6 750,00</td>
				<td style="text-align: right;">6 750,00</td>
			</tr>
			<tr>
				<td  colspan="3"><b>Общая сумма за пусконаладочные работы</b></td>
				<td style="color: red;text-align: right;">10 910,00</td>
			</tr>

			<tr style="background: #3e457c;">
				<th colspan="4" style="text-align:center; font-size:18px; color: white; line-height: 30px;">Годовое сервисное обслуживание</th>
			</tr>
			
			<tr>
				<td>Годовое сервисное (техническое) обслуживание настенных моделей котла с атмосферной горелкой</td>
				<td>1</td>
				<td>15 300,00</td>
				<td style="text-align: right;">15 300,00</td>
			</tr>
			<tr>
				<td colspan="3"><b>Годовое сервисное обслуживание</b></td>
				<td style="color: red;text-align: right;">15 300,00</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2"><b>Итого</b></td>
				<td style="text-align: right;"><b>343 858,29</b></td>
			</td>
		</table>
	</div>
</div>
<script>
	var kp;
	$('.defaultRadio').change(function() {
		kp = $(this).attr('id');
		console.log(kp);
		$('.servpage').fadeIn();

	});
	
	$('#eco').click(function() {
		$('.house_compred_descr').hide();
		$('#'+kp+'-eco').slideDown('slow');
		return false;
	});
	
	$('#comf').click(function() {
		$('.house_compred_descr').hide();
		$('#'+kp+'-comf').slideDown('slow');
		return false;
	});
	
</script>
<style>
	.fancy {
		cursor: zoom-in; 
		cursor: -moz-zoom-in; 
		cursor: -webkit-zoom-in;
	}
</style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>