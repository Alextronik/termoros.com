<form method="POST" action="">
	<h1>Генерация сертификатов Termoros</h1>
	<table>
		<tr>
			<td>
			<input type="radio" checked="checked" name="SEND" value="1" /> Сгенерировать сертификаты<br>
			<input type="radio" name="SEND" value="2" /> Отправлять письма
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<input type="radio" name="img_name" <?if (!$_REQUEST['img_name'] || $_REQUEST['img_name'] == 'termoros.png') { ?>checked="checked"<? } ?> value="termoros.png" />Бланк Терморос<br>
				<input type="radio" name="img_name" <?if ($_REQUEST['img_name'] == 'gekon.png') { ?>checked="checked"<? } ?> value="gekon.png" />Бланк Gekon<br>
				<input type="radio" name="img_name" <?if ($_REQUEST['img_name'] == 'uponor.png') { ?>checked="checked"<? } ?> value="uponor.png" />Бланк Termoros + Uponor<br>
				<input type="radio" name="img_name" <?if ($_REQUEST['img_name'] == 'baxi.png') { ?>checked="checked"<? } ?> value="baxi.png" />Бланк BAXI<br>
				<input type="radio" name="img_name" <?if ($_REQUEST['img_name'] == 'termostyle.png') { ?>checked="checked"<? } ?> value="termostyle.png" />Бланк ТермоСтайл<br>
				<input type="radio" name="img_name" <?if ($_REQUEST['img_name'] == 'lambo1.png') { ?>checked="checked"<? } ?> value="lambo1.png" />Бланк Lamborghini Матвеев<br>
				<input type="radio" name="img_name" <?if ($_REQUEST['img_name'] == 'lambo2.png') { ?>checked="checked"<? } ?> value="lambo2.png" />Бланк Lamborghini Никитин<br>
				<input type="radio" name="img_name" <?if ($_REQUEST['img_name'] == 'far.png') { ?>checked="checked"<? } ?> value="far.png" />Бланк FAR<br>
			</td>
		</tr>
		<tr>
			<td>ФИО</td>
			<td>Email</td>
		</tr>
		<tr>
			<td><textarea rows="20" cols="40" name="fio"><?=$_REQUEST['fio']?></textarea></td>
			<td><textarea rows="20" cols="40" name="email"><?=$_REQUEST['email']?></textarea></td>
		</tr>
		<tr>
			<td>Перед темой</td>
			<td><input type="text" name="before_theme" value="<?=($_REQUEST['before_theme'])?$_REQUEST['before_theme']:"ПРОШЁЛ ОБУЧЕНИЕ НА СЕМИНАРЕ"?>"></td>
		</tr>
		<tr>
			<td>Тема события</td>
			<td><textarea rows="5" cols="70" name="theme"><?=($_REQUEST['theme'])?$_REQUEST['theme']:'«Алюминиевые и биметаллические радиаторы Atlant»'?></textarea></td>
		</tr>
		<tr>
			<td>Город, дата</td>
			<td><input type="text" name="city_date" value="<?=($_REQUEST['city_date'])?$_REQUEST['city_date']:"Москва, ".date('d.m.Y')?>"></td>
		</tr>
		<tr>
			<td>Тема письма: </td>
			<td><input type="text" name="SUBJ" value="<?=($_REQUEST['SUBJ'])?$_REQUEST['SUBJ']:'Вебинар «Алюминиевые и биметаллические радиаторы Atlant», 5 октября 2017 г.'?>"></td>
		</tr>
		<tr>
			<td>Текст письма: </td>
			<td><textarea rows="8" cols="30" name="TEXT"><?=($_REQUEST['TEXT'])?$_REQUEST['TEXT']:'Уважаемый участник вебинара!<br><br>Благодарим Вас за участие в нашем вебинаре, который состоялся 5 октября 2017 года по теме: «Алюминиевые и биметаллические радиаторы Atlant».<br><br>В прикрепленном файле Вы найдете Ваш сертификат.<br><br>Ждем Вас снова!'?></textarea></td>
		</tr>
		<tr>
			<td><input type="submit"></td>
		</tr>
	</table>
</form>
<?php
$blankName = $_REQUEST['img_name'];
if ($_REQUEST['fio'] && $_REQUEST['email'])
{
	$fioArrRaw = explode(PHP_EOL, $_REQUEST['fio']);
	$emailArrRaw = explode(PHP_EOL, $_REQUEST['email']);

	foreach($fioArrRaw as $k => $v)
	{
		if (trim($v)) $fioArr[] = trim($v);
	}
	foreach($emailArrRaw as $k => $v)
	{
		if (trim($v)) $emailArr[] = trim($v);
	}
	if (count($fioArr) != count($emailArr))
	{
		echo '<h2>Количество фамилий не совпадает с количеством введенных email-ов, заполните еще раз</h2>';
		die();
	}
	if (!$_REQUEST['img_name'])
	{
		echo '<h2>Выберите сертификат</h2>';
		die();
	}
}
if (count($fioArr) && $_REQUEST['img_name']) {
    	
	foreach($fioArr as $k => $fio)
	{
		if ($_REQUEST['SEND'] == 1)
		{
			if ($blankName == 'termoros.png')
			{
				$im = imagecreatefrompng($blankName);
				$black = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$beforeThemeColor = imagecolorallocate($im, 0x3d, 0x41, 0x75);

				$font_file = './MyriadProRegular.ttf';
				$font_file_bold = './MyriadProBold.ttf';
				$date = $_REQUEST['city_date'];
				$theme = $_REQUEST['theme'];
				$beforeTheme = $_REQUEST['before_theme'];
				
				$sizeText = 150;
				$sizeDate = 50;
				$sizeTheme = 50;
				$sizeBeforeTheme = 50;

				$bbox = imagettfbbox($sizeText, 0, $font_file, $fio);

				$cX = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$cY = (imagesy($im) / 2) - (($bbox[3] - $bbox[1]) / 2);
				$centerX = 230;
				$centerY = 1650;

				$centerX2 = 230;
				$centerY2 = 3270;
				
				$centerX3 = 230;
				$centerY3 = 2048;
				
				$centerX4 = 230;
				$centerY4 = 1898;
				
				imagefttext($im, $sizeText, 0, $centerX, $centerY, $black, $font_file, $fio);
				imagefttext($im, $sizeDate, 0, $centerX2, $centerY2, $black, $font_file, $date);
				imagefttext($im, $sizeTheme, 0, $centerX3, $centerY3, $black, $font_file, $theme);
				imagefttext($im, $sizeBeforeTheme, 0, $centerX4, $centerY4, $beforeThemeColor, $font_file_bold, $beforeTheme);
				
				imagepng($im, $_SERVER['DOCUMENT_ROOT'].'/certificate/termoros/cert/'.$fio.'.png', 7);
				imagedestroy($im);
			}
			elseif ($blankName == 'gekon.png')
			{
				$im = imagecreatefrompng($blankName);
				$fioColor = imagecolorallocate($im, 0xc9, 0x53, 0x62);
				$beforeThemeColor = imagecolorallocate($im, 0x20, 0x16, 0x00);
				$themeColor = imagecolorallocate($im, 0x20, 0x16, 0x00);
				$cityColor = imagecolorallocate($im, 0x20, 0x16, 0x00);

				$fioFont = './GOTHICB.TTF';
				$beforeThemeFont = './GOTHIC.TTF';
				$themeFont = './GOTHICB.TTF';
				$cityFont = './GOTHIC.TTF';
				
				$date = $_REQUEST['city_date'];
				$theme = $_REQUEST['theme'];
				
				$beforeTheme = $_REQUEST['before_theme'];
				
				$fioSize = 81;
				$beforeThemeSize = 41;
				$themeSize = 41;
				$dateSize = 41;

				$bbox = imagettfbbox($fioSize, 0, $fioFont, $fio);
				$cX = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				//$cY = (imagesy($im) / 2) - (($bbox[3] - $bbox[1]) / 2);
				$centerY = 2113;
				
				$bbox = imagettfbbox($beforeThemeSize, 0, $beforeThemeFont, $beforeTheme);
				$cX2 = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY2 = 2261;
				
				$bbox = imagettfbbox($themeSize, 0, $themeFont, $theme);
				$cX3 = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY3 = 2519;
				
				$bbox = imagettfbbox($dateSize, 0, $cityFont, $date);
				$cX4 = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY4 = 3325;
				
				imagefttext($im, $fioSize, 0, $cX, $centerY, $fioColor, $fioFont, $fio);
				imagefttext($im, $beforeThemeSize, 0, $cX2, $centerY2, $beforeThemeColor, $beforeThemeFont, $beforeTheme);
				imagefttext($im, $themeSize, 0, $cX3, $centerY3, $themeColor, $themeFont, $theme);
				imagefttext($im, $dateSize, 0, $cX4, $centerY4, $cityColor, $cityFont, $date);
				
				imagepng($im, $_SERVER['DOCUMENT_ROOT'].'/certificate/termoros/cert/'.$fio.'.png', 7);
				imagedestroy($im);
				
			}
			elseif ($blankName == 'uponor.png')
			{
				$im = imagecreatefrompng($blankName);
				$fioColor = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$beforeThemeColor = imagecolorallocate($im, 0x3d, 0x41, 0x75);
				$themeColor = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$cityColor = imagecolorallocate($im, 0x00, 0x00, 0x00);

				$fioFont = './MyriadProRegular.ttf';
				$beforeThemeFont = './MyriadProBold.ttf';
				$themeFont = './MyriadProRegular.ttf';
				$cityFont = './MyriadProRegular.ttf';
				
				$date = $_REQUEST['city_date'];
				$theme = $_REQUEST['theme'];
				
				$beforeTheme = $_REQUEST['before_theme'];
				
				$fioSize = 150;
				$beforeThemeSize = 52;
				$themeSize = 60;
				$dateSize = 60;

				$bbox = imagettfbbox($fioSize, 0, $fioFont, $fio);
				$cX = 1131;
				$centerY = 1371;
				
				$bbox = imagettfbbox($beforeThemeSize, 0, $beforeThemeFont, $beforeTheme);
				$cX2 = 1131;
				$centerY2 = 1600;
				
				$bbox = imagettfbbox($themeSize, 0, $themeFont, $theme);
				$cX3 = 1131;
				$centerY3 = 1800;
				
				$bbox = imagettfbbox($dateSize, 0, $cityFont, $date);
				$cX4 = 1131;
				$centerY4 = 2250;
				
				imagefttext($im, $fioSize, 0, $cX, $centerY, $fioColor, $fioFont, $fio);
				imagefttext($im, $beforeThemeSize, 0, $cX2, $centerY2, $beforeThemeColor, $beforeThemeFont, $beforeTheme);
				imagefttext($im, $themeSize, 0, $cX3, $centerY3, $themeColor, $themeFont, $theme);
				imagefttext($im, $dateSize, 0, $cX4, $centerY4, $cityColor, $cityFont, $date);
				
				imagepng($im, $_SERVER['DOCUMENT_ROOT'].'/certificate/termoros/cert/'.$fio.'.png', 7);
				imagedestroy($im);
				
			}
			elseif ($blankName == 'baxi.png')
			{
				
				$im = imagecreatefrompng($blankName);
				$fioColor = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$beforeThemeColor = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$themeColor = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$cityColor = imagecolorallocate($im, 0x00, 0x00, 0x00);

				$fioFont = './MyriadProBold.ttf';
				$beforeThemeFont = './MyriadProBold.ttf';
				$themeFont = './MyriadProRegular.ttf';
				$cityFont = './MyriadProBold.ttf';
				
				$date = $_REQUEST['city_date'];
				$theme = $_REQUEST['theme'];
				
				$beforeTheme = $_REQUEST['before_theme'];
				
				$fioSize = 37;
				$beforeThemeSize = 20;
				$themeSize = 20;
				$dateSize = 20;

				$bbox = imagettfbbox($fioSize, 0, $fioFont, $fio);
				$cX = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY = 626;
				
				/*
				$bbox = imagettfbbox($beforeThemeSize, 0, $beforeThemeFont, $beforeTheme);
				$cX2 = 1131;
				$centerY2 = 1600;
				*/
				
				$bbox = imagettfbbox($themeSize, 0, $themeFont, $theme);
				$cX3 = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY3 = 715;
				
				$bbox = imagettfbbox($dateSize, 0, $cityFont, $date);
				$cX4 = 655;
				$centerY4 = 1262;
				
				imagefttext($im, $fioSize, 0, $cX, $centerY, $fioColor, $fioFont, $fio);
				//imagefttext($im, $beforeThemeSize, 0, $cX2, $centerY2, $beforeThemeColor, $beforeThemeFont, $beforeTheme);
				imagefttext($im, $themeSize, 0, $cX3, $centerY3, $themeColor, $themeFont, $theme);
				imagefttext($im, $dateSize, 0, $cX4, $centerY4, $cityColor, $cityFont, $date);
				
				imagepng($im, $_SERVER['DOCUMENT_ROOT'].'/certificate/termoros/cert/'.$fio.'.png', 7);
				imagedestroy($im);
				
				
			}
			elseif ($blankName == 'termostyle.png')
			{
				
				$im = imagecreatefrompng($blankName);
				$fioColor = imagecolorallocate($im, 0xd2, 0x4a, 0x43);
				$beforeThemeColor = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$themeColor = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$cityColor = imagecolorallocate($im, 0xff, 0xff, 0xff);

				$fioFont = './MyriadProBold.ttf';
				$beforeThemeFont = './MyriadProBold.ttf';
				$themeFont = './MyriadProRegular.ttf';
				$cityFont = './MyriadProRegular.ttf';
				
				$date = $_REQUEST['city_date'];
				$theme = $_REQUEST['theme'];
				
				$beforeTheme = $_REQUEST['before_theme'];
				
				$fioSize = 66;
				$beforeThemeSize = 35;
				$themeSize = 37;
				$dateSize = 36;

				$bbox = imagettfbbox($fioSize, 0, $fioFont, $fio);
				$cX = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY = 1406;
				
				$bbox = imagettfbbox($beforeThemeSize, 0, $beforeThemeFont, $beforeTheme);
				$cX2 = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY2 = 1544;
				
				$bbox = imagettfbbox($themeSize, 0, $themeFont, $theme);
				$cX3 = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY3 = 1646;
				
				$bbox = imagettfbbox($dateSize, 0, $cityFont, $date);
				$cX4 = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY4 = 2248;
				
				imagefttext($im, $fioSize, 0, $cX, $centerY, $fioColor, $fioFont, $fio);
				imagefttext($im, $beforeThemeSize, 0, $cX2, $centerY2, $beforeThemeColor, $beforeThemeFont, $beforeTheme);
				imagefttext($im, $themeSize, 0, $cX3, $centerY3, $themeColor, $themeFont, $theme);
				imagefttext($im, $dateSize, 0, $cX4, $centerY4, $cityColor, $cityFont, $date);
				
				imagepng($im, $_SERVER['DOCUMENT_ROOT'].'/certificate/termoros/cert/'.$fio.'.png', 7);
				imagedestroy($im);
				
				
			}
			elseif ($blankName == 'lambo1.png' || $blankName == 'lambo2.png')
			{
				$im = imagecreatefrompng($blankName);
				$fioColor = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$beforeThemeColor = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$themeColor = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$cityColor = imagecolorallocate($im, 0x00, 0x00, 0x00);

				$fioFont = './MyriadProRegular.ttf';
				$beforeThemeFont = './MyriadProRegular.ttf';
				$themeFont = './MyriadProRegular.ttf';
				$cityFont = './MyriadProRegular.ttf';
				
				$date = $_REQUEST['city_date'];
				$theme = $_REQUEST['theme'];
				
				$beforeTheme = $_REQUEST['before_theme'];
				
				$fioSize = 60;
				$beforeThemeSize = 60;
				$themeSize = 1;
				$dateSize = 50;

				$bbox = imagettfbbox($fioSize, 0, $fioFont, $fio);
				$cX = 488;
				$centerY = 761;
				
				$bbox = imagettfbbox($beforeThemeSize, 0, $beforeThemeFont, $beforeTheme);
				$cX2 = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY2 = 1150;
				
				/*
				$bbox = imagettfbbox($themeSize, 0, $themeFont, $theme);
				$cX3 = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY3 = 1646;
				*/
				
				$bbox = imagettfbbox($dateSize, 0, $cityFont, $date);
				$cX4 = 156;
				$centerY4 = 1941;
				
				imagefttext($im, $fioSize, 0, $cX, $centerY, $fioColor, $fioFont, $fio);
				imagefttext($im, $beforeThemeSize, 0, $cX2, $centerY2, $beforeThemeColor, $beforeThemeFont, $beforeTheme);
				//imagefttext($im, $themeSize, 0, $cX3, $centerY3, $themeColor, $themeFont, $theme);
				imagefttext($im, $dateSize, 0, $cX4, $centerY4, $cityColor, $cityFont, $date);
				
				imagepng($im, $_SERVER['DOCUMENT_ROOT'].'/certificate/termoros/cert/'.$fio.'.png', 7);
				imagedestroy($im);
			}
			elseif ($blankName == 'far.png')
			{
				$im = imagecreatefrompng($blankName);
				$fioColor = imagecolorallocate($im, 0x00, 0x91, 0x36);
				$beforeThemeColor = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$themeColor = imagecolorallocate($im, 0x00, 0x00, 0x00);
				$cityColor = imagecolorallocate($im, 0x5A, 0x5A, 0x5A);

				$fioFont = './MyriadProBold.ttf';
				$beforeThemeFont = './MyriadProRegular.ttf';
				$themeFont = './MyriadProRegular.ttf';
				$cityFont = './MyriadProRegular.ttf';
				
				$date = $_REQUEST['city_date'];
				$theme = $_REQUEST['theme'];
				
				$beforeTheme = $_REQUEST['before_theme'];
				
				$fioSize = 80;
				$beforeThemeSize = 60;
				$themeSize = 1;
				$dateSize = 50;

				$bbox = imagettfbbox($fioSize, 0, $fioFont, $fio);
				$cX = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY = 1020;
				/*
				$bbox = imagettfbbox($beforeThemeSize, 0, $beforeThemeFont, $beforeTheme);
				$cX2 = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY2 = 1150;
				*/
				/*
				$bbox = imagettfbbox($themeSize, 0, $themeFont, $theme);
				$cX3 = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY3 = 1646;
				*/
				
				$bbox = imagettfbbox($dateSize, 0, $cityFont, $date);
				$cX4 = (imagesx($im) / 2) - (($bbox[2] - $bbox[0]) / 2);
				$centerY4 = 1945;
				
				imagefttext($im, $fioSize, 0, $cX, $centerY, $fioColor, $fioFont, $fio);
				//imagefttext($im, $beforeThemeSize, 0, $cX2, $centerY2, $beforeThemeColor, $beforeThemeFont, $beforeTheme);
				//imagefttext($im, $themeSize, 0, $cX3, $centerY3, $themeColor, $themeFont, $theme);
				imagefttext($im, $dateSize, 0, $cX4, $centerY4, $cityColor, $cityFont, $date);
				
				imagepng($im, $_SERVER['DOCUMENT_ROOT'].'/certificate/termoros/cert/'.$fio.'.png', 7);
				imagedestroy($im);
			}
		}
		if ($_REQUEST['SEND'] == 1) { 
		?>
		<a target="_blank" href="/certificate/termoros/cert/<?=$fio?>.png"><img src="/certificate/termoros/cert/<?=$fio?>.png?hash=<?=time()?>" width="300"></a>
		<?
		if ($k % 5 == 4) echo '<br>';
		}
		
		if ($_REQUEST['SEND'] == 2)
		{
			require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
			 
			$email = $emailArr[$k];
			
			$cert = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/certificate/termoros/cert/'.$fio.'.png');
			$certs = array();
			$certs[] = CFile::SaveFile($cert, "cert");
			
			CModule::IncludeModule('main');
			$arr = array(
				"EMAIL" => $email,
				"SUBJ" => $_REQUEST['SUBJ'],
				"TEXT" => $_REQUEST['TEXT']
			);

			if (CEvent::Send("ZZ_CERTIFICATE", "s1", $arr, "N", "", $certs))
			{
				echo 'Отправлено: '.$email.'<br>';
			}
			else
			{
				echo 'НЕ Отправлено: '.$email.'<br>';
			}
			
		}
		
	}
}
?>
