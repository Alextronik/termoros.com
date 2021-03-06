<?
define('LEFTBAR3', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персональный раздел");
?>
<?
\Bitrix\Main\Loader::includeModule('redreams.partners');
?>
<?if(\Redreams\Partners\partner::isPartner()):?>
	<?include 'partners.php'?>
<?else:?>
<div class="bx_page">
	<p>В личном кабинете Вы можете проверить текущее состояние корзины, ход выполнения Ваших заказов, просмотреть или изменить личную информацию, а также подписаться на новости и другие информационные рассылки. </p>
	<div>
		<h2>Личная информация</h2>
		<a href="profile/">Изменить регистрационные данные</a>
	</div>
	<div>
		<h2>Заказы</h2>
		<a href="order/">Ознакомиться с состоянием заказов</a><br/>
		<a href="cart/">Посмотреть содержимое корзины</a><br/>
		<a href="order/">Посмотреть историю заказов</a><br/>
	</div>
</div>
<?endif?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
