<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class='section bonus'>					
	<p class='ttl'>Ваш бонусный счет</p>
	<?		
	foreach($arResult["ACCOUNT_LIST"] as $val)
	{
		
			?>
			<p class='price'><?=CurrencyFormat(round($val["ACCOUNT_LIST"]['CURRENT_BUDGET']),'RUB')?></p>
			<?
		
	}
	?>	
	<?if(CurrencyFormat($val["ACCOUNT_LIST"]['CURRENT_BUDGET'],'RUB')):?>
	<p class='i'>Вы можете частично или полностью оплатить свой заказ с бонусного счета</p>
	<div class='inp_wp'>
		<input type='text' class='inp_self' value='' placeholder='<?=$_SESSION['pay_bonus']>0?"Изменить сумму":"Введите сумму"?>'>
		<input type='submit' class='btn ' value=''>
		<div class='clear'></div>
	</div>
	<?if($_SESSION['pay_bonus']>0){?>
		<p class='name'><br><?=CurrencyFormat(round($_SESSION['pay_bonus']),'RUB')?> <span>руб</span> будет оплачено бонусами</p>
	<?}?>
	<?endif?>
</div>