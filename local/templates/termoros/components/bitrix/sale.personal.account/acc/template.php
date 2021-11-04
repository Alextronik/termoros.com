<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class='section bonus'>					
	<p class='name'>На Вашем бонусном счете</p>
	<?		
	foreach($arResult["ACCOUNT_LIST"] as $val)
	{
		
			?>
			<p class='val'><?=CurrencyFormat(round($val["ACCOUNT_LIST"]['CURRENT_BUDGET']),'RUB')?><span>руб</span></p>
			<?
		
	}
	?>	
	<?if(CurrencyFormat($val["ACCOUNT_LIST"]['CURRENT_BUDGET'],'RUB')):?>
	<p class='inp_name'>Вы можете частично или полностью оплатить заказ</p>
	<div class='inp_wp'>
		<input type='text' class='inp_self' value='' placeholder='<?=$_SESSION['pay_bonus']>0?"Изменить сумму":"Введите сумму"?>'>
		<input type='submit' class='inp_btn' value=''>
	</div>
		<?if($_SESSION['pay_bonus']>0){?>
			<p class='name'><br><?=CurrencyFormat(round($_SESSION['pay_bonus']),'RUB')?> <span>руб</span> будет оплачено бонусами</p>
		<?}?>
	<?endif?>
</div>
