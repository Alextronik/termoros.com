<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
		<link type="text/css" href="jquery-ui-1.8.21.custom.css" rel="stylesheet" />
		<script src="jquery-1.7.2.min.js" type="text/javascript"></script>
		<script src="jquery-ui-1.8.21.custom.min.js" type="text/javascript"></script>
		<script src="form2js.js" type="text/javascript"></script>
		<script src="json2.js" type="text/javascript"></script>
		<style type="text/css">
			.ui-autocomplete-loading {
				background: #FFF right center no-repeat;
			}
			#city {
				width: 25em;
			}
			#log {
				height: 200px;
				width: 600px;
				overflow: auto;
			}
		</style>
		<script type="text/javascript">
			/**
			 * автокомплит
			 * подтягиваем список городов ajax`ом, данные jsonp в зависмости от введённых символов
			 */
			$(function() {
				$("#city").autocomplete({
					source : function(request, response) {
						$.ajax({
							url : "https://api.cdek.ru/city/getListByTerm/jsonp.php?callback=?",
							dataType : "jsonp",
							data : {
								q : function() {
									return $("#city").val()
								},
								name_startsWith : function() {
									return $("#city").val()
								}
							},
							success : function(data) {
								response($.map(data.geonames, function(item) {
									return {
										label : item.name,
										value : item.name,
										id : item.id
									}
								}));
							}
						});
					},
					minLength : 1,
					select : function(event, ui) {
						//console.log("Yep!");
						$('#receiverCityId').val(ui.item.id);
					}
				});

				/**
				 * ajax-запрос на сервер для получения информации по доставке
				 */
				$('#cdek').submit(function() {

					var formData = form2js('cdek', '.', true, function(node) {
						if(node.id && node.id.match(/callbackTest/)) {
							return {
								name : node.id,
								value : node.innerHTML
							};
						}
					});
					var formDataJson = JSON.stringify(formData);
					// console.log(JSON.stringify(formData));
					document.getElementById('testArea').innerHTML = 'Отправляемые данные: <br />' + JSON.stringify(formData, null, '\t');

					$.ajax({
						url : 'https://api.cdek.ru/calculator/calculate_price_by_jsonp.php',
						jsonp : 'callback',
						data : {
							"json" : formDataJson
						},
						type : 'GET',
						dataType : "jsonp",
						success : function(data) {
						    console.log(data);
						    if(data.hasOwnProperty("result")) {
								document.getElementById('resArea').innerHTML = 'Цена доставки: ' + data.result.price + '<br />Срок доставки: ' + data.result.deliveryPeriodMin + ' - ' + data.result.deliveryPeriodMax + 'дн. ' + '<br />Планируемая дата доставки: c ' + data.result.deliveryDateMin + ' по ' + data.result.deliveryDateMax + '<br />id тарифа, по которому произведён расчёт: ' + data.result.tariffId + '<br />';
								if(data.result.hasOwnProperty("cashOnDelivery")) {
								    document.getElementById('resArea').innerHTML = document.getElementById('resArea').innerHTML + 'Ограничение оплаты наличными, от (руб): ' + data.result.cashOnDelivery;
								}
							} else {
								for(var key in data["error"]) {
									// console.log(key);
									// console.log(data["error"][key]);
									document.getElementById('resArea').innerHTML = document.getElementById('resArea').innerHTML+'Код ошибки: ' + data["error"][key].code + '<br />Текст ошибки: ' + data["error"][key].text + '<br /><br />';
								}
							}
						}
					});
					return false;
				});
			});

		</script>
	
		<h3>Расчёт стоимости доставки СДЭК</h3>
		Город-отправитель: Москва<br />
		<label for="city">Город-получатель: </label>
		<div class="ui-widget" style="display: inline-block;">
			<input id="city" />
			<br />
		</div>
		<form action="" id="cdek" method="GET" />
        <!-- Версия API -->
		<input name="version" value="1.0" hidden />
        <!-- Планируемая дата доставки (ГГГГ-ММ-ДД) -->
		<input name="dateExecute" value="<?=date("Y-m-d");?>" hidden />
		
        <!-- Для получения логина/пароля (в т.ч. тестового) обратитесь к разработчикам СДЭК -->
        <!-- 	<input name="authLogin" value="authLoginString" hidden />  -->
        <!-- 	<input name="secure" value="secureString" hidden /> -->
		
        <!-- Город-отправитель, Новосибирск -->		
		<input name="senderCityId" value="44" hidden />
        <!-- Город-получатель -->
		<input name="receiverCityId" id="receiverCityId" value="" hidden />
        
		<!-- <input name="tariffId" value="137" hidden /> --> <!-- id тарифа, Посылка склад-дверь 137, требутеся авторизация, параметры authLogin и secure -->
		<!-- <input name="tariffId" value="11" hidden /> --> <!-- id тарифа, Экспресс-лайт склад-дверь 11, не требует авторизации -->		
		<input name="tariffId" value="11" hidden />

	<!-- Используется для задания списка тарифов с приоритетами, подробнее см. документацию. -->
	<!-- <input name="tariffList[0].priority" value="1" hidden /> -->
	<!-- <input name="tariffList[0].id" value="137" hidden /> -->
	<!-- <input name="tariffList[1].priority" value="2" hidden /> -->
	<!-- <input name="tariffList[1].id" value="136" hidden /> -->

        <!-- режим доставки, склад-дверь -->
        <!-- <input name="modeId" value="3" hidden /> -->
        <!-- Вес места, кг.  -->
		<input name="goods[0].weight" value="0.3" hidden />
        <!-- Длина места, см. -->
		<input name="goods[0].length" value="10" hidden />
        <!-- Ширина места, см. -->
		<input name="goods[0].width" value="10" hidden />
        <!-- Высота места, см. -->
		<input name="goods[0].height" value="10" hidden />
		
        <?/*
		<!-- Вес места, кг.-->
		<input name="goods[1].weight" value="0.1" hidden />
        <!-- объём места, длина*ширина*высота, метры кубические -->
		<input name="goods[1].volume" value="0.001" hidden />
		*/?>
		<input type="submit" value="Посчитать">
		</form>
		<pre>
			<code id="testArea">
			</code>
		</pre>
		<code id="resArea">
		</code>
