<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тестирование для сотрудников Termoros");
if ($_REQUEST['level'] > 0)
{
	
	require($_SERVER['DOCUMENT_ROOT'].'/termoros_test/cfg'.$_REQUEST['level'].'.php');
}
else
{
	require($_SERVER['DOCUMENT_ROOT'].'/termoros_test/cfg'.$_SESSION['TERMOROS_TEST']['LEVEL'].'.php');
}

date_default_timezone_set('UTC');

function shuffle_assoc(&$array) {
	$keys = array_keys($array);
	shuffle($keys);
	foreach($keys as $key) {
		$new[$key] = $array[$key];
	}
	$array = $new;
	return true;
}
if(!function_exists('mb_ucfirst'))
{
	function mb_ucfirst($str, $encoding='UTF-8')
	{
		$str = mb_ereg_replace('^[\ ]+', '', $str);
		$str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
			   mb_substr($str, 1, mb_strlen($str), $encoding);
		return $str;
	}
}

if ($_GET['id'] && strlen($_GET['id']) == 10)
{
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/termoros_test/test_acc/'.$_GET['id']))
	{
		unlink($_SERVER['DOCUMENT_ROOT'].'/termoros_test/test_acc/'.$_GET['id']);
		$_SESSION['TERMOROS_TEST']["ID"] = $_GET['id'];
	}
}

if ($_SESSION['TERMOROS_TEST']["ID"])
{
	if ($_REQUEST['F'] && $_REQUEST['I'] && $_REQUEST['O'])
	{
		$_SESSION['TERMOROS_TEST']['F'] = mb_ucfirst($_REQUEST['F']);
		$_SESSION['TERMOROS_TEST']['I'] = mb_ucfirst($_REQUEST['I']);
		$_SESSION['TERMOROS_TEST']['O'] = mb_ucfirst($_REQUEST['O']);
		$_SESSION['TERMOROS_TEST']['LEVEL'] = $_REQUEST['level'];
		if (!$_SESSION['TERMOROS_TEST']['C_DATE']) $_SESSION['TERMOROS_TEST']['C_DATE'] = time();
		$_SESSION['TERMOROS_TEST']['RAND'] = $_REQUEST['RAND'];
		
		if ($_REQUEST['RAND'])
		{
			shuffle_assoc($testCfg);
		}
		
		$_SESSION['TERMOROS_TEST']['RESULTS'] = $testCfg;
		$_SESSION['TERMOROS_TEST']['CURSOR'] = 1;
		$_SESSION['TERMOROS_TEST']['ANSWERS'] = 0;
	}

	$testInTime = $_SESSION['TERMOROS_TEST']['C_DATE'] + 7200 > time();

	if ($_REQUEST['qnumber'] && $testInTime)
	{
		if ($_SESSION['TERMOROS_TEST']['RESULTS'][$_REQUEST['qnumber']]) 
		{
			
			if (($_REQUEST['next'] == 'Далее' || $_REQUEST['next'] == 'Завершить тестирование' || $_REQUEST['back'] == 'Назад') && $_REQUEST['q_'.$_REQUEST['qnumber']])
			{
				if (!$_SESSION['TERMOROS_TEST']['RESULTS'][$_REQUEST['qnumber']]["ANSWER"]) $_SESSION['TERMOROS_TEST']['ANSWERS']++;
				
				$_SESSION['TERMOROS_TEST']['RESULTS'][$_REQUEST['qnumber']]["ANSWER"] = $_REQUEST['q_'.$_REQUEST['qnumber']];
			}
			
			
			if ($_REQUEST['next'] == 'Далее' || $_REQUEST['next'] == 'Завершить тестирование')
			{
				$_SESSION['TERMOROS_TEST']['CURSOR']++;
			}
			elseif ($_REQUEST['back'] == 'Назад' && $_SESSION['TERMOROS_TEST']['CURSOR'] > 1)
			{
				$_SESSION['TERMOROS_TEST']['CURSOR']--;
			}
			
			//if ($_SESSION['TERMOROS_TEST']['CURSOR'] > count($_SESSION['TERMOROS_TEST']['RESULTS'])) $_SESSION['TERMOROS_TEST']['CURSOR'] = 1;
		}
	}

	?>
	<? if (!$_SESSION['TERMOROS_TEST']['RESULTS']) { ?>

	<form id="termoros-testing-form-intro" method="POST">
	<table>
		<tr>
			<td><b>Фамилия</b> (на русском):</td>
			<td><input id="input-F" onchange="if(!/^[А-Я][а-я]*$/gui.test(this.value) && this.value != '') {alert('Принимаются только русские символы без пробелов и других знаков'); this.value='';}"
				 type="text" name="F"></td>
		</tr>
		<tr>
			<td><b>Имя</b> (на русском):</b></td>
			<td><input id="input-I" onchange="if(!/^[А-Я][а-я]*$/gui.test(this.value) && this.value != '') {alert('Принимаются только русские символы без пробелов и других знаков'); this.value='';}" type="text" name="I"></td>
		</tr>
		<tr>
			<td><b>Отчество</b> (на русском):</td>
			<td><input id="input-O" onchange="if(!/^[А-Я][а-я]*$/gui.test(this.value) && this.value != '') {alert('Принимаются только русские символы без пробелов и других знаков'); this.value='';}" type="text" name="O"></td>
		</tr>
		<tr>
			<td><b>Уровень теста</b>:</td>
			<td>
				<select name="level">
					<option value="0">Новый сотрудник</option>
					<option value="1">Менеджер (У1)</option>
					<option value="2">Менеджер (У2)</option>
					<option value="3">Менеджер (У3)</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><b>Вопросы в случайном порядке (+5% к результатам теста):</b></td>
			<td><input type="checkbox" value="1" name="RAND"></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Начать тестирование"></td>
		</tr>
	</table>
	</form>
	<? } elseif ($testInTime) { ?>
		<?
		foreach($_SESSION['TERMOROS_TEST']['RESULTS'] as $k => $q)
		{
			$l++;
			if ($l == $_SESSION['TERMOROS_TEST']['CURSOR'])
			{
				$showQ = $q;
				$qNumber = $k;
				break;
			}
		}
		$nextButton = 'Далее';
		if (!$_SESSION['TERMOROS_TEST']['RESULTS'][$l+1]) $nextButton = 'Завершить тестирование';
		
		if ($showQ)
		{
			$q = $showQ;
			

			$img1 = '';
			$img2 = '';
			$img3 = '';
			$img4 = '';
			if ($q["Q_IMG"]) $qImg = '<img class="test-img" src="/termoros_test/common/'.$q["Q_IMG"].'">';
			if ($q["IMG1"]) $img1 = '<img class="test-img" src="/termoros_test/common/'.$q["IMG1"].'">';
			if ($q["IMG2"]) $img2 = '<img class="test-img" src="/termoros_test/common/'.$q["IMG2"].'">';
			if ($q["IMG3"]) $img3 = '<img class="test-img" src="/termoros_test/common/'.$q["IMG3"].'">';
			if ($q["IMG4"]) $img4 = '<img class="test-img" src="/termoros_test/common/'.$q["IMG4"].'">';

			if ($showQ["ANSWER"] == 1) $a1Active = 'checked="checked"';
			if ($showQ["ANSWER"] == 2) $a2Active = 'checked="checked"';
			if ($showQ["ANSWER"] == 3) $a3Active = 'checked="checked"';
			if ($showQ["ANSWER"] == 4) $a4Active = 'checked="checked"';
			
			$cTime = $_SESSION['TERMOROS_TEST']['C_DATE'];
			$eTime = time();
			$diffTime = $eTime - $cTime;
			$testTime = date("H:i:s", $diffTime);
			
			
			
			//$completeTest = false;
			//if ($_SESSION['TERMOROS_TEST']['CURSOR'] == count($_SESSION['TERMOROS_TEST']['RESULTS'])) $completeTest = true;
			
			echo '<ul>
				<li>Общее количество вопросов: '.count($_SESSION['TERMOROS_TEST']['RESULTS']).'</li>
				<li>Количество ответов: '.$_SESSION['TERMOROS_TEST']['ANSWERS'].'</li>
				<li>Осталось дать ответов: '.(count($_SESSION['TERMOROS_TEST']['RESULTS'])-$_SESSION['TERMOROS_TEST']['ANSWERS']).'</li>
				<li>Ограничение времени: 02:00:00</li>
				<li>Затраченное время: <span id="testTime">'.$testTime.'</span></li>
			</ul>';
			echo '<div class="question-block-'.$qNumber.'" >';
			echo '<h3>Вопрос №'.$_SESSION['TERMOROS_TEST']['CURSOR'].'. '.$q['Q'].'</h3>';
			if ($qImg) echo $qImg.'<br>';
			echo '<hr>';
			echo '<form class="question-form" id="form-'.$qNumber.'" action="" method="post">';
			echo '<input type="hidden" name="qnumber" value="'.$qNumber.'">';
			echo '<ol class="test-ol">';
			echo '<li><input '.$a1Active.' type="radio" id="q_'.$qNumber.'_1" name="q_'.$qNumber.'" value="1"><label for="q_'.$qNumber.'_1">'.$q['A1'].'<br>'.$img1.'</label></li>';
			echo '<li><input '.$a2Active.' type="radio" id="q_'.$qNumber.'_2" name="q_'.$qNumber.'" value="2"><label for="q_'.$qNumber.'_2">'.$q['A2'].'<br>'.$img2.'</label></li>';
			echo '<li><input '.$a3Active.' type="radio" id="q_'.$qNumber.'_3" name="q_'.$qNumber.'" value="3"><label for="q_'.$qNumber.'_3">'.$q['A3'].'<br>'.$img3.'</label></li>';
			echo '<li><input '.$a4Active.' type="radio" id="q_'.$qNumber.'_4" name="q_'.$qNumber.'" value="4"><label for="q_'.$qNumber.'_4">'.$q['A4'].'<br>'.$img4.'</label></li>';
			echo '</ol>';
			echo '<input type="submit" style="margin: 10px;" name="back" value="Назад">';
			echo '<input type="submit" style="margin: 10px;" name="next" value="'.$nextButton.'">';
			echo '</form>';
			echo '</div>';

			//$hidden = 'question-hidden';

			?>
			<script>
				$('#termoros-testing-form-intro').submit(function() {
					var error = "";
					if (!$('#input-F').val()) error += 'Не введена фамилия'+"\n";
					if (!$('#input-F').val()) error += 'Не введено имя'+"\n";
					if (!$('#input-F').val()) error += 'Не введено отчество'+"\n";
					
					if (error) 
					{
						alert(error);
						return false;
					}
					
				});
				
				if ($('#testTime').length > 0)
				{
					var x = setInterval(function() {
						
						var d = new Date();
						var curTimeArr = $('#testTime').html().split(":");
						d.setHours(curTimeArr[0]);
						d.setMinutes(curTimeArr[1]);
						d.setSeconds(parseInt(curTimeArr[2])+1);
						$('#testTime').html(d.toTimeString().substring(0, 8));
						
					}, 1000);
					
				}
				
				
			</script>
			<style>
				.test-img {
					margin: 5px 0 5px 20px;
					border: 1px solid black;
				}
				.test-ol {
					font-size: 16px;
					font-weight: bold;
				}
				.question-hidden {
					display:none;
				}
			</style>
		<? } ?>
		
		
	<? } ?>
	<? if ($_SESSION['TERMOROS_TEST']['RESULTS'] && (!$showQ || !$testInTime)) { ?>
		<?
		
		?>
		
		<?
		//Завершение теста
		$trueAnswers = 0;
		$falseAnswers = 0;
		$log = '';
		foreach($_SESSION['TERMOROS_TEST']['RESULTS'] as $qNumber => $q)
		{
			$log .= 'Вопрос №'.$qNumber."\n\r";
			$log .= $q['Q']."\n\r";
			
			
			
			/*
			Вопрос №1
			К какому регулирующему коллектору FAR, при помощи концовок FAR, можно напрямую присоединить металлопластиковые трубы диаметром 20-26 мм?
			Ответ: артикул: FK 3827 (Да 54:29)
			*/
			
			if ($q["ANSWER"] == $q["T"]) 
			{
				$trueAnswers++;
				$log .= "Ответ: ".$q["A".$q["ANSWER"]]." (Да) \n\r";
				
			}
			else 
			{
				$falseAnswers++;
				$log .= "Ответ: ".$q["A".$q["ANSWER"]]." (Нет) \n\r";
			}
			
			$log .= "\n\r";
			
			
			$answers++;
		}
		$percent = $trueAnswers/$answers * 100;
		if ($_SESSION['TERMOROS_TEST']['RAND']) $percent += 5;
		if ($percent > 100) $percent = 100;
		if ($percent < 65) $complete = false;
		else $complete = true;
		
		$cTime = $_SESSION['TERMOROS_TEST']['C_DATE'];
		
		if ($testInTime) 
		{
			$eTime = time();
			$diffTime = $eTime - $cTime;
			$testTime = date("H:i:s", $diffTime);
		}
		else $testTime = '02:00:00';
		
		$lvl = $_SESSION['TERMOROS_TEST']['LEVEL']?$_SESSION['TERMOROS_TEST']['LEVEL']:"0";
		$rnd = ($_SESSION['TERMOROS_TEST']['RAND'])?'Да':'Нет';
		
		$log = "Результат теста
Фамилия: ".$_SESSION['TERMOROS_TEST']['F']."
Имя: ".$_SESSION['TERMOROS_TEST']['I']."
Отчество: ".$_SESSION['TERMOROS_TEST']['O']."
Уровень: ".$lvl."
Случайный порядок вопросов: ".$rnd."
Затраченное время: ".$testTime."
Количество вопросов: ".$answers."
Количество верных ответов: ".$trueAnswers."
Количество неверных ответов: ".$falseAnswers."
Процент верных ответов: ".round($percent, 0)."%
\n\r\n\r
".$log;
		$fileName = date("Y-m-d H:i").' '.$_SESSION['TERMOROS_TEST']['F'].' '.$_SESSION['TERMOROS_TEST']['I'].'.txt';
		
		$fp = fopen($_SERVER['DOCUMENT_ROOT'].'/termoros_test/log/'.$fileName, 'w+');
		fwrite($fp, $log);
		fclose($fp);
		
		$files = array();
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/termoros_test/log/'.$fileName))
		{
			$files[] = $_SERVER['DOCUMENT_ROOT'].'/termoros_test/log/'.$fileName;
		}
		
		if ($_SESSION['TERMOROS_TEST']['LEVEL'] == 0) $levelText = 'Новый сотрудник';
		elseif ($_SESSION['TERMOROS_TEST']['LEVEL'] == 1) $levelText = 'Менеджер (У1)';
		elseif ($_SESSION['TERMOROS_TEST']['LEVEL'] == 2) $levelText = 'Менеджер (У1)';
		elseif ($_SESSION['TERMOROS_TEST']['LEVEL'] == 3) $levelText = 'Менеджер (У1)';
		
		?>
		<h3>Результат теста</h3>
		<p><b>Фамилия:</b> <?=$_SESSION['TERMOROS_TEST']['F']?></p>
		<p><b>Имя:</b> <?=$_SESSION['TERMOROS_TEST']['I']?></p>
		<p><b>Отчество:</b> <?=$_SESSION['TERMOROS_TEST']['O']?></p>
		<p><b>Уровень:</b> <?=$levelText?></p>
		<p><b>Случайный порядок вопросов:</b> <?=($_SESSION['TERMOROS_TEST']['RAND'])?'Да':'Нет'?></p>
		<p><b>Затраченное время:</b> <?=$testTime?></p>
		<p><b>Количество вопросов:</b> <?=$answers?></p>
		<p><b>Количество верных ответов:</b> <?=$trueAnswers?></p>
		<p><b>Количество неверных ответов:</b> <?=$falseAnswers?></p>
		<p><b>Процент верных ответов:</b> <?=round($percent, 0)?>%</p>
		<br><br>
		<? if ($complete) { ?><img src="common/App/Печать 1.gif"><? } else { ?><img src="common/App/Печать 2.gif"><? } ?>
		<?
		if ($complete) $testResult = 'Тест пройден';
		else $testResult = 'Тест не пройден';
		if ($_SESSION['TERMOROS_TEST']['RAND']) 
		{
			$random = 'Да';
			$excelBonus = 0.05;
		}
		else 
		{
			$random = 'Нет';
			$excelBonus = 0;
		}
		
		?>
		
		<?//<p><b>Случайный порядок вопросов:</b> '.($_SESSION['TERMOROS_TEST']['RAND'])?'Да':'Нет'.'</p>
		$level = $_SESSION['TERMOROS_TEST']['LEVEL']?$_SESSION['TERMOROS_TEST']['LEVEL']:"0";
		
		$fields = array(
			"SUBJ" => 'Результат прохождения теста Termoros сотрудником: '.$_SESSION['TERMOROS_TEST']['F'].' '.$_SESSION['TERMOROS_TEST']['I'].' '.$_SESSION['TERMOROS_TEST']['O'],
			"TEXT" => '<h3>Результат теста - '.$testResult.'</h3>
		<p><b>Фамилия:</b> '.$_SESSION['TERMOROS_TEST']['F'].'</p>
		<p><b>Имя:</b> '.$_SESSION['TERMOROS_TEST']['I'].'</p>
		<p><b>Отчество:</b> '.$_SESSION['TERMOROS_TEST']['O'].'</p>
		<p><b>Уровень:</b> '.$levelText.'</p>
		<p><b>Случайный порядок вопросов:</b> '.$random.'</p>
		<p><b>Затраченное время:</b> '.$testTime.'</p>
		<p><b>Количество вопросов:</b> '.$answers.'</p>
		<p><b>Количество верных ответов:</b> '.$trueAnswers.'</p>
		<p><b>Количество неверных ответов:</b> '.$falseAnswers.'</p>
		<p><b>Процент верных ответов:</b> '.round($percent, 0).'%</p>'
		);
		CEvent::Send("ZZ_TERMOROS_TEST", "s1", $fields, "N", "", $files);
		?>
		<?
		$getStr = urlencode('?FIO='.$_SESSION['TERMOROS_TEST']['F'].' '.$_SESSION['TERMOROS_TEST']['I'].''.$_SESSION['TERMOROS_TEST']['O'].'&time='.$testTime.'&all='.$answers.'&true='.$trueAnswers.'&false='.$falseAnswers.'&bonus='.$excelBonus.'&percents='.round($percent/100, 2).'&need=0.65&result='.$testResult.'&level='.$level);
		
		
		file_get_contents('http://www.termoros.com/include/PHPExcel_1.8.0_doc/save_test_results.php'.$getStr);
		
		unset($_SESSION['TERMOROS_TEST']);
		?>
	<? } ?>
<? } else { ?>
	<p>Тест можно пройти только получив уникальную ссылку.</p>
<? } ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>