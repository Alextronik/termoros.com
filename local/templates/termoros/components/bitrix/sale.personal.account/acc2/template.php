<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

	<?		
	foreach($arResult["ACCOUNT_LIST"] as $val)
	{
		
			?>
			<div class="bonus_wp">
				<p class="sum"><?=CurrencyFormat($val["ACCOUNT_LIST"]['CURRENT_BUDGET'],'RUB')?><span>руб</span></p>
				<p class="i">на бонусном счете</p>
			</div>
			<?
		
	}
	?>	


