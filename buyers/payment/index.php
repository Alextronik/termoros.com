<?
define('LEFTBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Оплата");
$APPLICATION->SetPageProperty("title", "Оплата | Международная группа компаний «Терморос»");
$APPLICATION->SetPageProperty("keywords", "оплата");
$APPLICATION->SetTitle("Оплата");
?>
<h2>Способы оплаты</h2>

<h3>Доступные способы оплаты</h3>
<table style="width: 70%;" border="1" cellpadding="10" cellspacing="1">
	<tr>
		<td><b>Наличные</b></td>
		<td>Розничные покупатели, Партнеры</td>
	</tr>
	<tr>
		<td><b>Оплата счета</b></td>
		<td>Розничные покупатели, Партнеры</td>
	</tr>
	<tr>
		<td><b><a href="/buyers/payment_delivery/card.php">Оплата заказа на сайте банковской картой</b></td>
		<td>Розничные покупатели</td>
	</tr>
	<tr>
		<td><b>Терминал для оплаты</b></td>
		<td>Розничные покупатели, Партнеры</td>
	</tr>
</table>

<h2>По вопросам оплаты и доставки обращайтесь к менеджерам «Терморос» по тел.: <br>+7 (499) 500-00-01, +7 (499) 394-33-45, 8 (800) 550 33 45</h2>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>