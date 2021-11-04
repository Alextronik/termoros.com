<?
define('LEFTBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Информация об условиях онлайн оплаты заказов");
$APPLICATION->SetPageProperty("description", "Информация об условиях онлайн оплаты заказов");
$APPLICATION->SetTitle("Онлайн оплата заказов");
?>
<p>Оплата происходит через ПАО СБЕРБАНК с использованием Банковских карт следующих платежных систем:</p>

	<img style="height: 40px; vertical-align: middle;" src="mir.png">
	<img style="height: 40px; vertical-align: middle;" src="visa.png">&nbsp;&nbsp;
	<img style="height: 60px; vertical-align: middle;" src="mastercard.png">
<br><br>
<h3>Какая информация необходима для оплаты банковской картой</h3>
<ul>
<li>номер вашей кредитной карты;</li>
<li>cрок окончания действия вашей кредитной карты, месяц/год;</li>
<li>CVV код для карт Visa / CVC код для Master Card: 3 последние цифры на полосе для подписи на обороте карты.</li>
</ul>

<h3>Описание процесса передачи данных</h3>
<p>Для оплаты (ввода реквизитов Вашей карты) Вы будете перенаправлены на платежный шлюз ПАО СБЕРБАНК. Соединение с платежным шлюзом и передача информации осуществляется в защищенном режиме с использованием протокола шифрования SSL. </p>
<p>В случае если Ваш банк поддерживает технологию безопасного проведения интернет-платежей Verified By Visa или MasterCard SecureCode для проведения платежа также может потребоваться ввод специального пароля.</p>
<p>Настоящий сайт поддерживает 256-битное шифрование. Конфиденциальность сообщаемой персональной информации обеспечивается ПАО СБЕРБАНК. Введенная информация не будет предоставлена третьим лицам за исключением случаев, предусмотренных законодательством РФ. Проведение платежей по банковским картам осуществляется в строгом соответствии с требованиями платежных систем МИР, Visa Int. и MasterCard Europe Sprl.</p>

<h3>Описание процессa оплаты</h3>
<p>Оплата заказов осуществляется после проверки заказа менеджером интернет-магазина. После подтверждения суммы заказа, в личном кабинете рядом с номером этого заказа будет ссылка, которая переведет Вас на страницу авторизационного сервера, где Вам будет предложено ввести реквизиты пластиковой карты, инициировать ее авторизацию. В случае успешной авторизации до зачисления средств статус заказ будет иметь статус “Ожидаем поступления оплаты”. После того, как к нам поступит оплата, статус заказа изменится на "Оплачен". После этого вы сможете получить заказанный товар выбранным способом доставки.</p>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>