<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); $this->setFrameMode(true);
$summ = 0;
$quan = 0;

//['SUBSCRIBE']
//var_dump($arResult);
foreach($arResult['ITEMS'] as $vals){
	if($vals['DELAY'] == 'Y') continue;
	if($vals['CAN_BUY'] == 'N') continue;
	
	$summ += $vals['PRICE']*$vals['QUANTITY'];
	$quan += $vals['QUANTITY'];
}
?>
<a onclick="yaCounter26951046.reachGoal('pereiti_korzina'); ga('send', 'pageview','/virtual/pereiti_korzina'); return true;" href='/personal/cart' class='basket_wp <?if(!$quan):?>noitems<?endif;?>'>
	<span class='name'>Корзина</span>
	<span class='sum' style="text-align: left;"><?if($quan):?><?=$quan;?> шт. | <?else:?>нет товаров<?endif;?><?if($summ):?><?=CurrencyFormat($summ,'RUB')?><?else:?><?endif;?></span>
</a>
<div id="small_cart">
    <?if($arResult["READY"]=="Y"){

    }?>

</div>

