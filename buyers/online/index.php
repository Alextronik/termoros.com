<?
define('LEFTBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Онлайн оплата заказа");
$APPLICATION->SetPageProperty("title", "Онлайн оплата заказа | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("keywords", "онлайн оплата заказа");
$APPLICATION->SetTitle("Онлайн оплата заказа");

if ($_POST['order_date'])
{
	$postDate = date('Y-m-d', strtotime($_POST['order_date']));
	//$_POST['order_date'] = date(''strtotime($_POST['order_date']));
}
?>
<?
function get1COrder($order1CId, $date, $orderSumm){
	
	//Proxy request
	$result = file_get_contents("http://termoros.pro/exchange/order.php?Number=".$order1CId."&Sum=".$orderSumm."&Date=".$date);
	//http://www.termoros.pro/exchange/order.php?Number=66615&Sum=18205.68&Date=2019-09-30
	//echo "http://termoros.pro/exchange/order.php?Number=".$order1CId."&Sum=".$orderSumm."&Date=".$date;
	
	if (!$result) return false;
	if ($result == 'ERROR') return false;
	
	$xml = simplexml_load_string($result);
	
	$ID1C = (string)$xml->{Документ}->{Номер1С};
	$PRICE = (string)$xml->{Документ}->{Сумма};
	$DATE = (string)$xml->{Документ}->{Дата};
	$DATE_1C = (string)$xml->{Документ}->{Дата1С};
	$VERSION_1C = (string)$xml->{Документ}->{НомерВерсии};

	if (!$ID1C) return false;
	
	if ($DATE_1C)
	{
		$date1CUnix = strtotime($DATE_1C);
		
		if ($date1CUnix < time() - 60*60*24*3)
		{
			return false;
		}
		
	}
	else
	{
		return false;
	}
	
	
	
	
	
	if ($ID1C)
	{
		$changeID1C = false;
		
		
		CModule::IncludeModule('main');
		CModule::IncludeModule('sale');
		CModule::IncludeModule('catalog');
		
		$arFilter = array('ID_1C' => $ID1C);
		$db_sales = CSaleOrder::GetList(array("ID" => "DESC"), $arFilter, false, false, array('*'));
		$order = $db_sales->GetNext();
		
		if ($order)
		{
			
			$orderYear = date("Y", strtotime($order['DATE_UPDATE']));
			$orderDate = strtotime($order['DATE_UPDATE']);
			
			if ($orderYear == date("Y"))
			{
				//Заказ от текущего года, нужно обновлять
				//echo 'Заказ от текущего года, нужно обновлять';
				
			}
			else
			{
				//'Меняем ID_1C для корректного импорта нового заказа';

				$arUpdateOrderFields = array(
					"ID_1C" => $order["ID_1C"].'_'.date("Y", $orderDate),
				);
			
				CSaleOrder::Update($order["ID"], $arUpdateOrderFields);
				
				
				
			}
		}
		else
		{
			//Импортируем новый заказ
			
			
		}
				
		
		
		//v($ID1C);
		$site_url = 'https://www.termoros.com/bitrix/admin/1c_c_exchange.php?type=sale&mode=checkauth'; //URL стартовой страницы админки Битрикса
		$post_var = 'AUTH_FORM=Y&TYPE=AUTH&USER_LOGIN=import&USER_PASSWORD=i123mport&Login=&USER_REMEMBER=Y'; //эти данные собираются путём парсинга формы авторизации, для простоты поместил их в одну переменную

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/upload/1c_exchange_cookie/cookie.txt'); //куда сохранять cookie
		curl_setopt($ch, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'].'/upload/1c_exchange_cookie/cookie.txt'); //откуда берем cookie
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   // возвращаем веб-страницу 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // следуем за редиректами
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($ch, CURLOPT_HEADER, false); //не выводим заголовки
		curl_setopt($ch, CURLOPT_URL, $site_url); //URL сайта на Битриксе
		curl_setopt($ch, CURLOPT_POST, true); //используем POST-запрос
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_var); //строка с POST-переменными (значения присвоены выше)
		
		$text = curl_exec($ch); 
		curl_close($ch);
		//v($text);
		//die();
		$sessID1 = substr(trim($text), -32);
		$sessID2 = substr(trim($text), 18, 32);
		if ($sessID1)
		{
			//CModule::IncludeModule('main');
			//v(COption::SetOptionString("catalog", "DEFAULT_SKIP_SOURCE_CHECK", "Y")); 
			//v(COption::SetOptionString("sale", "secure_1c_exchange", "N"));
			
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, 'https://www.termoros.com/bitrix/admin/1c_c_exchange.php?type=sale&mode=init&sessid='.$sessID1.'&version=2.09');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'].'/upload/1c_exchange_cookie/cookie.txt'); //откуда берем cookie
			$text2 = curl_exec($ch);
			/*
			v($text2);
			v(curl_error($ch));
			*/
			curl_close($ch);
			
			file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/1c_c_exchange/'.$ID1C.'.xml', $result);
			
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, 'https://www.termoros.com/bitrix/admin/1c_c_exchange.php?type=sale&mode=import&sessid='.$sessID1.'&filename='.$ID1C.'.xml');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'].'/upload/1c_exchange_cookie/cookie.txt'); //откуда берем cookie
			$text4 = curl_exec($ch);
			/*
			v(iconv('windows-1251', 'utf-8', $text4));
			v($text4);
			v(curl_error($ch));
			*/
			curl_close($ch);
			
			
			@unlink($_SERVER['DOCUMENT_ROOT'].'/upload/1c_c_exchange/'.$ID1C.'.xml');
			
			
			/*
			$PRICE = (string)$xml->{Документ}->{Сумма};
			$DATE = (string)$xml->{Документ}->{Дата};
			$VERSION_1C = (string)$xml->{Документ}->{НомерВерсии};
			*/
			$arFilter = array('ID_1C' => $ID1C);
			$db_sales = CSaleOrder::GetList(array("ID" => "DESC"), $arFilter, false, false, array('*'));
			$order = $db_sales->GetNext();
			
			
		}
		
		
		@unlink($_SERVER['DOCUMENT_ROOT'].'/upload/1c_exchange_cookie/cookie.txt');
		
		
		return $order;
		
	}
}
$hideForm = false;
if ($_POST['order_id'] && $postDate && (int)($_POST['order_id']) > 0 && strtotime($postDate) > time() - 60*60*24*3 && (int)($_POST['order_summ']) > 0)
{
	$order_summ = str_replace(",",".",$_POST['order_summ']);
	$order_summ = preg_replace('/[^0-9.]/', '', $order_summ);
	$order = get1COrder($_POST['order_id'], $postDate, $order_summ);
	
	if ($order)
	{
		
		$lastPayment = false;
		
		$orderNew = \Bitrix\Sale\Order::load($order['ID']);
		$arPaymentsCollection = $orderNew->loadPaymentCollection();
		
		foreach ($arPaymentsCollection as $payment)
		{
			if (!$payment->isPaid())
			{
				$lastPayment = $payment->getId();
			}
		}
		if ($lastPayment && $order['ID'])
		{
			//change order pay method
			if ($order["ID_1C"] && substr($order["ID_1C"], 0, 2) == 'ГВ')
			{
				$arUpdateOrderFields = array(
					"PAY_SYSTEM_ID" => 15,
				);
			}

			if ($order["ID_1C"] && substr($order["ID_1C"], 0, 2) == 'ТД')
			{
				$arUpdateOrderFields = array(
					"PAY_SYSTEM_ID" => 14,
				);
			}
			CSaleOrder::Update($order["ID"], $arUpdateOrderFields);
			
			$link = "/personal/order/payment/?ORDER_ID=".$order['ID']."&PAYMENT_ID=".$lastPayment;
			global $USER;
			$USER->Authorize($order['USER_ID']);

			echo '<p>Заказ найден и идентифицирован</p>';
			echo '<input type="checkbox" name="agree" value="Y"><a href="/public_offer.php">Вы соглашаетесь с публичной офертой</a><br>';
			echo '<p><a href="'.$link.'" class="pay_button">Оплатить</a></p>';
			
			//header("Location: ".$link);
			//die();
			
			
			$hideForm = true;
			
		}
		else
		{
			$err[] = 'Заказ не найден или не доступен к онлайн оплате';
		}
	}
	else
	{
		$err[] = 'Заказ не найден или не доступен к онлайн оплате';
	}

	//Process Order
	//Check 1C Order
	
	/*
	$arFilter = Array(
	   "ID_1C" => $_POST['order_id'],
	   "PERSON_TYPE_ID" => array(1,3),
	);

	$db_sales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
	$ar_sales = $db_sales->Fetch();
	*/
	
	//Ищем заказ в 1С и создаем его копию в нашей базе
	
}

if ($_POST['order_id'] && (int)($_POST['order_id']) < 1)
{
	$err[] = 'Неверное значение номера счета';
}
if ($postDate && strtotime($postDate) < time() - 60*60*24*3)
{
	$err[] = 'Неверная дата';
}
if ($_POST['order_summ'] && (int)($_POST['order_summ']) < 1)
{
	$err[] = 'Неверная сумма заказа';
}
if ($_POST && (!$_POST['order_id'] || !$postDate || !$_POST['order_summ']))
{
	$err[] = 'Заполните пожалуйста все поля';
}
?>
<?
if ($err)
{
	foreach($err as $er)
	{
		echo '<p style="color: red;">'.$er.'</p>';
	}
}
?>
<? if (!$hideForm) { ?>
<p><b>Для онлайн оплаты заказа вам необходимо ввести номер, дату и сумму, указанную в счете</b></p>
<form method="post">
	<table>
		<tr>
			<td>Номер счета:</td>
			<td><input name="order_id" type="text" value="<?=$_POST['order_id']?>" placeholder="123456"></td>
		</tr>
		<tr>
			<td>Дата:</td>
			<td><?
			//$curDate = date("Y-m-d");
			$curDate = date("d.m.Y");
			
			
			?>
			<?$APPLICATION->IncludeComponent("bitrix:main.calendar","",Array(
				 "SHOW_INPUT" => "Y",
				 "FORM_NAME" => "form",
				 "INPUT_NAME" => "order_date",
				 "INPUT_VALUE" => $_POST['order_date']?$_POST['order_date']:$curDate,
				 "SHOW_TIME" => "N",
				 "HIDE_TIMEBAR" => "Y"
				)
			);?>
			</td>
		</tr>
		<tr>
			<td>Сумма заказа полностью:</td>
			<td><input name="order_summ" type="text" value="<?=$_POST['order_summ']?>" placeholder="123456.78"></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" onclick="$(this).hide();$('#online_loading').show();" value="Отправить"><span style="display:none;" id="online_loading">Пожалуйста подождите, идет загрузка</span></td>
		</tr>
	</table>
</form>
<? } ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>