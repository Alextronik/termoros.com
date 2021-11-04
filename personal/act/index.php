<?
define('LEFTBAR3', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Запросить акт сверки");
?>
<?
\Bitrix\Main\Loader::includeModule('redreams.partners');
?>
<?if(\Redreams\Partners\partner::isPartner()) { ?>

<? if ($_GET['success']) { ?>
	<p>Запрос на акт сверки успешно отправлен. Акт сверки будет выслан вам на электронную почту.</p>
	<p><a href="/personal/act/">Запросить еще один акт сверки</a></p>
<? } else { ?>
	<form action="http://termoros.pro/exchange/" method="POST" name="form">
	<input type="hidden" name="act" value="1">
	<table>
		<tr>
			<td>Выберите контрагента:</td>
			<td>
	<?php
	$APPLICATION->IncludeComponent('redreams:partner.contractors','act');
	?>
	</td>
	</tr>
	<tr>
	<td>Выберите период:</td>
	<td>
	<?
	$curDate = date("d.m.Y");
	$lastMonthDate = date("d.m.Y", time()-60*60*24*30);
	?>
	<?$APPLICATION->IncludeComponent("bitrix:main.calendar","",Array(
		 "SHOW_INPUT" => "Y",
		 "FORM_NAME" => "form",
		 "INPUT_NAME" => "DateBegin",
		 "INPUT_NAME_FINISH" => "DateEnd",
		 "INPUT_VALUE" => $lastMonthDate,
		 "INPUT_VALUE_FINISH" => $curDate, 
		 "SHOW_TIME" => "N",
		 "HIDE_TIMEBAR" => "Y"
		)
	);?>
	</td>
	</tr>
	<tr><td colspan="2" style="color: #969696;"><sup style="color: red;">*</sup>Акт сверки можно запросить только для организации "Торговый Дом"</td></tr>
	<tr><td colspan="2"><input type="submit" style="
	display: inline-block;
    vertical-align: top;
    padding: 9px 15px 5px;
    border-radius: 3px;
    background: #749a4a;
    font-size: 14px;
    line-height: 16px;
    color: #ffffff;
    text-transform: uppercase;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    border: 0;
    min-width: 55px;
	" name="submit" value="Отправить запрос"></td></tr>
	</table>
	</form>
<? } ?>
<? } ?>

<style>
	#DateBegin, #DateEnd {
		padding: 5px;		
	}
</style>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>