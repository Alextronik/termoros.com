<?
die();
$resStr = '';
if (!empty($_POST))
{
	$FIO = $_POST['FIO']?$_POST['FIO']:'';
	$CLIENT = $_POST['CLIENT']?$_POST['CLIENT']:'';
	$COMPANY_NAME = $_POST['COMPANY_NAME']?$_POST['COMPANY_NAME']:'';
	$CITY = $_POST['CITY']?$_POST['CITY']:'';
	$CUSTOMER_NAME = $_POST['CUSTOMER_NAME']?$_POST['CUSTOMER_NAME']:'';
	$CUSTOMER_POSITION = $_POST['CUSTOMER_POSITION']?$_POST['CUSTOMER_POSITION']:'';
	$CUSTOMER_SITE = $_POST['CUSTOMER_SITE']?$_POST['CUSTOMER_SITE']:'';
	$CUSTOMER_OFFICE_PHONE = $_POST['CUSTOMER_OFFICE_PHONE']?$_POST['CUSTOMER_OFFICE_PHONE']:'';
	$CUSTOMER_EMAIL = $_POST['CUSTOMER_EMAIL']?$_POST['CUSTOMER_EMAIL']:'';
	$AGREE = $_POST['AGREE']?'Да':'';
	
	$TYPE1 = $_POST['TYPE1']?$_POST['TYPE1']:'';
	$TYPE2 = $_POST['TYPE2']?$_POST['TYPE2']:'';
	$TYPE3 = $_POST['TYPE3']?$_POST['TYPE3']:'';
	$TYPE4 = $_POST['TYPE4']?$_POST['TYPE4']:'';
	$TYPE5 = $_POST['TYPE5']?$_POST['TYPE5']:'';
	$TYPE6 = $_POST['TYPE6']?$_POST['TYPE6']:'';
	
	$TYPE_OTHER = $_POST['TYPE_OTHER']?$_POST['TYPE_OTHER']:'';
	
	$FORM1 = $_POST['FORM1']?$_POST['FORM1']:'';
	$FORM2 = $_POST['FORM2']?$_POST['FORM2']:'';
	$FORM3 = $_POST['FORM3']?$_POST['FORM3']:'';
	$FORM4 = $_POST['FORM4']?$_POST['FORM4']:'';
	$FORM5 = $_POST['FORM5']?$_POST['FORM5']:'';
	
	$FORM_OTHER = $_POST['FORM_OTHER']?$_POST['FORM_OTHER']:'';
	
	$VID1 = $_POST['VID1']?$_POST['VID1']:'';
	$VID2 = $_POST['VID2']?$_POST['VID2']:'';
	$VID3 = $_POST['VID3']?$_POST['VID3']:'';
	$VID4 = $_POST['VID4']?$_POST['VID4']:'';
	$VID5 = $_POST['VID5']?$_POST['VID5']:'';
	
	$VID_OTHER = $_POST['VID_OTHER']?$_POST['VID_OTHER']:'';
	
	$COMMENT = $_POST['COMMENT']?$_POST['COMMENT']:'';
	$PRIORITY = $_POST['PRIORITY']?$_POST['PRIORITY']:'';
	
	if ($_FILES)
	{
		if ($_FILES['FILE']["tmp_name"])
		{
			$IMG_FILE = date("Y-m-d_H-i-s")."_".$_FILES['FILE']["name"];
			move_uploaded_file($_FILES['FILE']["tmp_name"], $_SERVER['DOCUMENT_ROOT'].'/aqua/img/'.$IMG_FILE);
			
		}
	}
	
	$resStr = $FIO.'~'.$CLIENT.'~'.$COMPANY_NAME.'~'.$CITY.'~'.$CUSTOMER_NAME.'~'.$CUSTOMER_POSITION.'~'.$CUSTOMER_SITE.'~'.$CUSTOMER_OFFICE_PHONE.'~'.$CUSTOMER_EMAIL.'~'.$AGREE.'~'.$TYPE1.'~'.$TYPE2.'~'.$TYPE3.'~'.$TYPE4.'~'.$TYPE5.'~'.$TYPE6.'~'.$TYPE_OTHER.'~'.$FORM1.'~'.$FORM2.'~'.$FORM3.'~'.$FORM4.'~'.$FORM5.'~'.$FORM_OTHER.'~'.$VID1.'~'.$VID2.'~'.$VID3.'~'.$VID4.'~'.$VID5.'~'.$VID_OTHER.'~'.$COMMENT.'~'.$IMG_FILE.'~'.$PRIORITY;
	
	if ($resStr)
	{
		$fh = fopen('result.csv', 'a+');
		fwrite($fh, $resStr."\n");
	}
}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Анкета AquaTerm</title>
		
		<!-- Bootstrap core CSS -->
		<link href="/aqua/css/bootstrap.min.css" rel="stylesheet">
		<script src="/aqua/js/jquery.js"></script>
		<script src="/aqua/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
		  <? if (!empty($_POST)) { ?>
		  <div style="max-width: 600px;" class="alert alert-success alert-dismissable">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  <strong>Анкета сохранена!</strong>
			</div>
		  <? } ?>
		  <form enctype="multipart/form-data" action="" method="POST" class="form-signin">
			<table style="width: 100%; max-width: 600px; margin-top: 10px;">
				<tr>
					<td style="text-align: left; margin: 10px 0 10px 0;"  colspan="2">
						<?/*<div style="display: inline-block; width: 50px; height: 50px; border: 1px black dashed; margin: 5px;"></div>*/?>
						<img src="logo.png" width="240" style="margin-right: 20px; margin-botton: 10px;">
						<div style="display: inline-block; vertical-align: top; font-size: 24px; font-weight: bold; height: 50px; padding-top: 12px;">[АНКЕТА АКВАТЕРМ - 2018]<div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row-block"><b><sup style="color: red;">*</sup>ФИО менеджера «Терморос»: </b></div>
					</td>
					<td>
						<div class="row-block"><input name="FIO" class="form-control" type="text" required="true" placeholder="ФИО менеджера «Терморос»" value="<?=$_POST['FIO']?>"></div>
					</td>
				</tr>
				<tr>
					<td>
					<input type="hidden" name="CLIENT" value="">
					<div class="row-block"><label for="NEW_CLIENT"><input id="NEW_CLIENT" name="CLIENT" value="Новый" type="radio"> <b style="margin-left: 5px;">Новый Клиент</b></label></div>
					</td>
					<td>
					<div class="row-block">
					<label for="OLD_CLIENT"><input id="OLD_CLIENT" name="CLIENT" value="Существующий" type="radio"> <b style="margin-left: 5px;">Существующий Клиент</b></label></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row-block"><b>Название компании: </b></div>
					</td>
					<td>
						<div class="row-block"><input name="COMPANY_NAME" class="form-control" type="text" value=""></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row-block"><b><sup style="color: red;">*</sup>Город (федер. округ): </b></div>
					</td>
					<td>
						<div class="row-block"><input required="true" name="CITY" class="form-control" type="text" placeholder="Москва, ЦФО" value=""></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row-block"><b><sup style="color: red;">*</sup>ФИО: </b></div>
					</td>
					<td>
						<div class="row-block"><input required="true" name="CUSTOMER_NAME" class="form-control" type="text" placeholder="Иванов Иван Иванович" value=""></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row-block"><b><sup style="color: red;">*</sup>Должность: </b></div>
					</td>
					<td>
						<div class="row-block"><input required="true" name="CUSTOMER_POSITION" class="form-control" type="text" placeholder="Генеральный директор" value=""></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row-block"><b>Сайт компании: </b></div>
					</td>
					<td>
						<div class="row-block"><input name="CUSTOMER_SITE" class="form-control" type="text" placeholder="termoros.com" value=""></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row-block"><b><sup style="color: red;">*</sup>Рабочий телефон: </b></div>
					</td>
					<td>
						<div class="row-block"><input required="true" name="CUSTOMER_OFFICE_PHONE" class="form-control" type="text" placeholder="+7 900 123 45 67" value=""></div>
					</td>
				</tr>
				<?/*
				<tr>
					<td>
						<div class="row-block"><b>Рабочий телефон (моб.): </b></div>
					</td>
					<td>
						<div class="row-block"><input name="CUSTOMER_MOBILE_PHONE" class="form-control" type="text" placeholder="+7 900 123 45 67" value=""></div>
					</td>
				</tr>
				*/?>
				<tr>
					<td>
						<div class="row-block"><b><sup style="color: red;">*</sup>Email: </b></div>
					</td>
					<td>
						<div class="row-block"><input required="true" name="CUSTOMER_EMAIL" class="form-control" type="text" placeholder="info@termoros.com"  value=""></div>
					</td>
				</tr>
				<tr>
					<td colspan="2"><label for="AGREE"><input type="hidden" name="AGREE" value=""><input id="AGREE" name="AGREE" value="1" type="checkbox"><b style="margin-left: 5px; ">Согласие получать информацию о продукции компании «Терморос» по электронной почте и смс</b></div></label></td>
				</tr>
			</table>
			<table style="width: 100%; max-width: 600px;">
				<tr>
					<td colspan="2">
						<input type="hidden" name="TYPE[]" value="">
						<div class="row-block"><b>Укажите вид деятельности Вашей компании </b></div>
						<label for="TYPE_1"><input type="checkbox" id="TYPE_1" name="TYPE1" value="Оптовая торговля инженерным оборудованием"> Оптовая торговля инженерным оборудованием</label><br>
						<label for="TYPE_2"><input type="checkbox" id="TYPE_2" name="TYPE2" value="Строительно-монтажная организация"> Строительно-монтажная организация</label><br>
						<label for="TYPE_3"><input type="checkbox" id="TYPE_3" name="TYPE3" value="Розничная торговля"> Розничная торговля</label><br>
						<label for="TYPE_4"><input type="checkbox" id="TYPE_4" name="TYPE4" value="Розничная торговля через сети DIY"> Розничная торговля через сети DIY</label><br>
						<label for="TYPE_5"><input type="checkbox" id="TYPE_5" name="TYPE5" value="Дизайн интерьеров"> Дизайн интерьеров</label><br>
						<label for="TYPE_6"><input type="checkbox" id="TYPE_6" name="TYPE6" value="Проектирование и архитектура"> Проектирование и архитектура</label><br>
						<input type="text" class="form-control" name="TYPE_OTHER" value="" placeholder="Другое">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="FORM[]" value="">
						<div class="row-block"><b>Какие формы сотрудничества Вас интересуют? </b></div>
						<label for="FORM_1"><input type="checkbox" id="FORM_1" name="FORM1" value="Закупка оборудования для установки"> Закупка оборудования для установки</label><br>
						<label for="FORM_2"><input type="checkbox" id="FORM_2" name="FORM2" value="Закупка оборудования для последующей продажи"> Закупка оборудования для последующей продажи</label><br>
						<label for="FORM_3"><input type="checkbox" id="FORM_3" name="FORM3" value="Услуги по проектированию и монтажу оборудования"> Услуги по проектированию и монтажу оборудования</label><br>
						<label for="FORM_4"><input type="checkbox" id="FORM_4" name="FORM4" value="Включение оборудования «Терморос» в проекты"> Включение оборудования «Терморос» в проекты</label><br>
						<label for="FORM_5"><input type="checkbox" id="FORM_5" name="FORM5" value="Сервисное обслуживание"> Сервисное обслуживание</label><br>
						<input type="text" class="form-control" name="FORM_OTHER" value="" placeholder="Другое">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="VID[]" value="">
						<div class="row-block"><b>Какие виды оборудования Вас интересуют? </b></div>
						<label for="VID_1"><input type="checkbox" id="VID_1" name="VID1" value="Приборы отопления"> Приборы отопления</label><br>
						<label for="VID_2"><input type="checkbox" id="VID_2" name="VID2" value="Арматура и трубопроводы"> Арматура и трубопроводы</label><br>
						<label for="VID_3"><input type="checkbox" id="VID_3" name="VID3" value="Котельное оборудование"> Котельное оборудование</label><br>
						<label for="VID_4"><input type="checkbox" id="VID_4" name="VID4" value="Насосное оборудование"> Насосное оборудование</label><br>
						<label for="VID_5"><input type="checkbox" id="VID_5" name="VID5" value="Теплообменное оборудование"> Теплообменное оборудование</label><br>
						<input type="text" class="form-control" name="VID_OTHER" value="" placeholder="Другое">
						
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="row-block"><b>Приоритет: </b></div>
						<select name="PRIORITY">
							<option value="Высокий">Высокий</option>
							<option selected="selected" value="Средний">Средний</option>
							<option value="Низкий">Низкий</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="row-block"><b>Загрузить визитку: </b></div>
						<input type="file" class="form-control" name="FILE" value="Визитка">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="COMMENT" value="">
						<div class="row-block"><b>Комментарий: </b></div>
						<textarea class="form-control" name="COMMENT"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2"><button style="margin: 10px 0 10px 0;" class="btn btn-lg btn-primary btn-block" type="submit">Сохранить анкету</button></td>
				</tr>
			</table>
			<?/*
			<label for="inputEmail" class="">Email address</label>
			<input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
			<div class="checkbox">
			  <label>
				<input type="checkbox" value="remember-me"> Remember me
			  </label>
			</div>
			*/?>
		  </form>
		</div>
		<style>
			.img_holder {
				width: 200px;
				height: 100px;
			}
			.row-block {
				margin: 5px;
			}
		</style>
		
	</body>
</html>