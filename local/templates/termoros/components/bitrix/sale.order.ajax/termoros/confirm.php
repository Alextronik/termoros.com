<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arResult['ORDER']['DATE_INSERT']=FormatDate(array(
	"" => 'j F Y',                    // выведет "9 июля 2012", если год прошел
), MakeTimeStamp($arResult['ORDER']['DATE_INSERT']), time()
);
//p($arResult);
if (!empty($arResult["ORDER"]))
{
	if(empty($arResult['DELIVERY'])) {
		if (!$arResult['DELIVERY_ID'] > 0) {
			$deliv = "Отправления 1 класса";
		}
	}else{
		$deliv = $arResult['DELIVERY']["NAME"];
	}
	?>
	<div class='finblock'>
	
		<div class='txt'>
			<p><b>Заказ №<?=$arResult['ORDER_ID']?> от  <?=$arResult['ORDER']['DATE_INSERT']?></b> успешно оформлен.</p>
			<p>Подтверждение отправлено на E-mail. Следите за статусом исполнения заказа в Личном кабинете.</p>
			<p>Менеджер свяжется с Вами в ближайшее время для уточнения деталей заказа. Если у Вас возникли вопросы, свяжитесь с нами по телефону +7 (495) 785 55 00</p>
		</div>
		
		<!--<div class='inpt'>
			<input type='checkbox' class='customCheckbox'>
			<label>Информировать меня по SMS</label>
			
			<div class='inp_wp'>
				<input type='text' class='inp_self' value='' placeholder='Укажите мобильный телефон '>
				<input type='submit' class='btn' value=''>
				<div class='clear'></div>
			</div>
			<div class='clear'></div>
			
		</div>-->
		
		<a href='/personal/order/detail/<?=$arResult['ORDER_ID']?>/' class='to_lk'>В личный кабинет</a>
		<a href='/' class='to_main'>на главную страницу</a>
	
		<div class="pay-block">
		<?
		if (0 && strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
		{
			?>
			<tr>
				<td>
					<?
					if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
					{
						?>
						<script language="JavaScript">
							window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
						</script>
						<?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))))?>
						<?
						if (CSalePdf::isPdfAvailable() && CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE']))
						{
							?><br />
							<?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
							<?
						}
					}
					else
					{
						if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
						{
							try
							{
								include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
							}
							catch(\Bitrix\Main\SystemException $e)
							{
								if($e->getCode() == CSalePaySystemAction::GET_PARAM_VALUE)
									$message = GetMessage("SOA_TEMPL_ORDER_PS_ERROR");
								else
									$message = $e->getMessage();

								echo '<span style="color:red;">'.$message.'</span>';
							}
						}
					}
					?>
				</td>
			</tr>
			<?
		}
		?>
		</div>
	
	</div>
	
	<?/*?>
	<div class="finorder_info">
		<p class="name">Заказ №<?=$arResult['ORDER_ID']?> от <?=$arResult['ORDER']['DATE_INSERT']?> успешно оформлен</p>
		<p class="txt">Тип заказа: Товары, готовые к доставке</p>
		<p class="txt">Стоимость заказа: <?=round($arResult['ORDER']['PRICE'])?> РУБ</p>
		<p class="txt">Способ доставки: <?=$deliv?></p>
		<p class="txt">Способ оплаты: <?=$arResult['PAY_SYSTEM']['NAME']?></p>

		<p class="txt_b">Подтверждение отправлено на указанный E-mail. Следить за статусом исполнения заказа Вы можете в Личном кабинете.</p>

		<a href="/personal/order/detail/<?=$arResult['ORDER_ID']?>/" class="lnk">Личный кабинет</a>
		<a target="_blank" href="/personal/order/detail/<?=$arResult['ORDER_ID']?>/?print=y" class="lnk">Печать</a>
	</div>
	<?*/?>
	<?
	/*if(!empty($arResult["ORDER2"])){
		if(empty($arResult['ORDER2']['DELIVERY'])) {
			if (!$arResult['ORDER2']['DELIVERY_ID'] > 0) {
				$deliv = "Отправления 1 класса";
			}
		}else{
			$deliv = $arResult['ORDER2']['DELIVERY']["NAME"];
		}

		?>
		<div class="finorder_info">
		<p class="name">Заказ №<?=$arResult['ORDER2']['ID']?> от <?=$arResult['ORDER']['DATE_INSERT']?> успешно оформлен</p>
		<p class="txt">Тип заказа: Товары под заказ</p>
		<p class="txt">Стоимость заказа: <?=round($arResult['ORDER2']['PRICE'])?> РУБ</p>
		<p class="txt">Способ доставки: <?=$deliv?></p>
		<p class="txt">Способ оплаты: <?=$arResult['ORDER2']['PAY_SYSTEM']['NAME']?></p>

		<p class="txt_b">Подтверждение отправлено на указанный E-mail. Следить за статусом исполнения заказа Вы можете в Личном кабинете.</p>

		<a href="/personal/order/detail/<?=$arResult['ORDER_ID2']?>/" class="lnk">Личный кабинет</a>
		<a target="_blank" href="/personal/order/detail/<?=$arResult['ORDER_ID2']?>/?print=y" class="lnk">Печать</a>
	</div>
	<?
	}*/
	/*
	<b><?=GetMessage("SOA_TEMPL_ORDER_COMPLETE")?></b><br /><br />
	<table class="sale_order_full_table">
		<tr>
			<td>
				<?= GetMessage("SOA_TEMPL_ORDER_SUC", Array("#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"], "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]))?>
				<br /><br />
				<?= GetMessage("SOA_TEMPL_ORDER_SUC1", Array("#LINK#" => $arParams["PATH_TO_PERSONAL"])) ?>
			</td>
		</tr>
	</table>
	<?
	if (!empty($arResult["PAY_SYSTEM"]))
	{
		?>
		<br /><br />

		<table class="sale_order_full_table">
			<tr>
				<td class="ps_logo">
					<div class="pay_name"><?=GetMessage("SOA_TEMPL_PAY")?></div>
					<?=CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"], 100, 100, "border=0", "", false);?>
					<div class="paysystem_name"><?= $arResult["PAY_SYSTEM"]["NAME"] ?></div><br>
				</td>
			</tr>
			<?
			if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
			{
				?>
				<tr>
					<td>
						<?
						if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
						{
							?>
							<script language="JavaScript">
								window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
							</script>
							<?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))))?>
							<?
							if (CSalePdf::isPdfAvailable() && CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE']))
							{
								?><br />
								<?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
								<?
							}
						}
						else
						{
							if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
							{
								try
								{
									include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
								}
								catch(\Bitrix\Main\SystemException $e)
								{
									if($e->getCode() == CSalePaySystemAction::GET_PARAM_VALUE)
										$message = GetMessage("SOA_TEMPL_ORDER_PS_ERROR");
									else
										$message = $e->getMessage();

									echo '<span style="color:red;">'.$message.'</span>';
								}
							}
						}
						?>
					</td>
				</tr>
				<?
			}
			?>
		</table>
		<?
	}
}
else
{
	?>
	<b><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></b><br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>
	<?*/
}
?>
