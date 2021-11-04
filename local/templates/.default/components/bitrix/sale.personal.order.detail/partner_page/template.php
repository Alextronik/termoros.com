<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p class='ttl'>Мои заказы <span>(<?=$arResult['CNT']?>)</span></p>
<p>Заказ №<?=$arResult['ID']?> от <?=$arResult["DATE_INSERT_FORMATED"]?></p>
<p>Статус: <?=$arResult["STATUS"]["NAME"]?></p>
<?$addr = array_search(['CODE','ADDRESS'],$arResult["ORDER_PROPS"]);?>
<?
$addr = array_filter($arResult["ORDER_PROPS"], function($innerArray) use ($needle) {
return ($innerArray['CODE'] == 'ADDRESS'); //Поиск по первому значению
});
?>
<p><?=array_pop($addr)['VALUE']?></p>
<a href='order/' class='green_lnk'>Все заказы</a>


