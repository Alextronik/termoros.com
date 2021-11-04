<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$isPartner = \Redreams\Partners\partner::isPartner()?>
<?
$arResult['ORDER']['DATE_INSERT']=FormatDate(array(
	"" => 'j F Y',                    // выведет "9 июля 2012", если год прошел
), MakeTimeStamp($arResult['ORDER']['DATE_INSERT']), time()
);
//p($arResult);
if (!empty($arResult["ORDER"]))
{
	if ($arResult['ORDER_ID'])
	{
		$arOrder = CSaleOrder::GetByID($arResult['ORDER_ID']);
		$delivery = $arOrder['DELIVERY_ID'];
	}
	
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
			<?
			
			if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0 && ($arResult["PAY_SYSTEM"]["ID"] == 15 || $arOrder["PAY_SYSTEM_ID"] == 15) && ($arResult["DELIVERY_ID"] == 44 || $arResult["DELIVERY_ID"] == 43 || $delivery == 'sdek:pickup' || $delivery == 'sdek:courier')) { 
			?>
				<br>
				<p><b>Для отправки заказа необходимо завершить оплату:</b></p>
				<p>
				
				<input class="policy_agree" onclick="if (BX('policy_agree').checked) $('#payButton').show(); if (!BX('policy_agree').checked) $('#payButton').hide();" id="policy_agree" name="policy_agree" value="1" checked="checked" type="checkbox">
				<a style="color: red;" target="_blank" href="/public_offer.php">«Я прочитал Публичную оферту и согласен с её условиями»</a>
				<b>
				</b>
				
				</p>
				
			<?
			} 
			if ($arResult["DELIVERY_ID"] == 44 || $arResult["DELIVERY_ID"] == 43 || $delivery == 'sdek:pickup' || $delivery == 'sdek:courier') 
			{ 
			
			}
			else
			{
			?>
				<br>
				<p><b>Заказы обрабатываются в рабочее время</b></p>
				<p>Подтверждение отправлено на E-mail. Следите за статусом исполнения заказа в Личном кабинете.</p>
				<p>Менеджер свяжется с Вами в ближайшее время для уточнения деталей заказа. Если у Вас возникли вопросы, свяжитесь с нами по телефону +7 (499) 500 00 01</p>
				<? if (!$isPartner) { ?>
					<br>
					<p><b>В соответствии с п. 4 ст. 26.1. Закона РФ от 07.02.1992 № 2300-1 "О защите прав потребителей" потребитель вправе отказаться от товара в любое время до его передачи, а после передачи товара - в течение семи дней. Возврат товара надлежащего качества возможен в случае, если сохранены его товарный вид, потребительские свойства, а также документ, подтверждающий факт и условия покупки указанного товара.</b></p>
				<? } ?>
				<br>
				<p>«Окончательный состав и стоимость заказа, сроки поставки будут отражаться в отправляемом в ответ на заявку счете. Предложение не является офертой. Цены на сайте и в розничной сети могут отличаться. Информация на сайте о товаре носит рекламный характер и расценивается как приглашение делать оферты на основании п. 1 ст. 437 Гражданского кодекса РФ.»</p>
			<? } ?>
			<?
			if ($isPartner) { 
				$voted = FALSE;
				$FORM_ID = 42;
				$timestamp1 = date('d.m.Y', time()-60*60*24*30);
				$arF = array(
					"USER_ID"              => $USER->GetID(),         // пользователь-автор
					"USER_ID_EXACT_MATCH"  => "Y",               // точное совпадение
					"TIMESTAMP_1"          => $timestamp1,
				);
				
				$rsRes = CFormResult::GetList(
					$FORM_ID, 
					($by="s_timestamp"), 
					($order="desc"), 
					$arF,
					$is_filtered,
					"N", 
					1);
				
				while ($arR = $rsRes->Fetch())
				{
					if ($arR["ID"]) $voted = TRUE;
				}
				
				?>
				<? if (!$voted) { ?>
				</form>
				<div class="anketa pop_up order_survey" style="margin:0;">
					 <?if($_REQUEST['web_form_submit']&&!$_REQUEST['js_captcha']):?> <?else:?> <?$APPLICATION->IncludeComponent(
					"bitrix:form.result.new",
					"simple_form",
					Array(
						"CACHE_TIME" => "3600",
						"CACHE_TYPE" => "N",
						"CHAIN_ITEM_LINK" => "",
						"CHAIN_ITEM_TEXT" => "",
						"COMPONENT_TEMPLATE" => "simple_form",
						"EDIT_URL" => "result_edit.php",
						"IGNORE_CUSTOM_TEMPLATE" => "N",
						"LIST_URL" => "",
						"SEF_MODE" => "N",
						"SUCCESS_URL" => "",
						"USE_EXTENDED_ERRORS" => "Y",
						"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
						"WEB_FORM_ID" => "42"
					)
				);?> <?endif;?>
				</div>
				<div class="clear"></div>
				<form>
				<? } else { ?>
					<? if ($_REQUEST['RESULT_ID']) { ?>
					<h3>Спасибо за ваше мнение!</h3>
					<? } ?>
				<? } ?>
			<? } ?>
			
			<style>
				.order_survey {
					padding-top: 20px !important;
				}
				
				.pop_up .pop_inn {
					margin: 0;
				}
				.pop_up.order_survey .pop_inn .pop_left {
					width: 400px;
					float: left;
				}
				.pop_up.order_survey .pop_inn .pop_ttl {
					margin-bottom: 10px !important;
				}
				.pop_up.order_survey .pop_inn .inpt	{
					margin-bottom: 0px;
				}
				.pop_up.order_survey .pop_inn .pop_btn	{
					margin: 10px 0 20px 0;
				}
			</style>
            <?php
                $user_type_ar = [0=> "Партнер",1 =>"Физическое лицо",2=>"Юридическое лицо",3=>"Индивидуальный предприниматель"];
                $user_type = "";
                if ($isPartner){
                    $user_type = $user_type_ar[0];
                }else{
                    $user_type = $user_type_ar[(int)$arResult['ORDER']['PERSON_TYPE_ID']];
                }
            ?>
			<script>
                window.onload = function() {
                    let goalParams = {user_type:"<?=$user_type?>"}
                    yaCounter26951046.reachGoal('final_korzina',goalParams);
                    ga('send', 'pageview', {eventCategory:'/virtual/final_korzina','dimension1': '<?=$user_type?>'});
                    roistat.event.send('user_type', goalParams)
                }
			</script>
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
		<?
		if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0 && $arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y" && $arResult["PAY_SYSTEM"]["ID"] == 15 && ($arResult["DELIVERY_ID"] == 44 || $arResult["DELIVERY_ID"] == 43 || $delivery == 'sdek:pickup' || $delivery == 'sdek:courier')) { 
		?>
			<p><a id="payButton" style="background: #db7653;" href='<?=$arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>' class='to_lk'>Оплатить</a></p><br>
		<?
		}
		?>
		<?
		
		if ($arResult["DELIVERY_ID"] == 44 || $arResult["DELIVERY_ID"] == 43 || $delivery == 'sdek:pickup' || $delivery == 'sdek:courier')
		{
			?>
			
			<p>Подтверждение заказа отправлено на e-mail, указанный в заказе. После передачи заказа в службу доставки Вам придёт электронное письмо с номером отправления, которое вы можете использовать для отслеживания посылки на сайте <a href="http://www.cdek.ru" target="_blank">www.cdek.ru</a>.</p>
			<p>Если у Вас возникли вопросы, свяжитесь с нами по телефону +7 (499) 500 00 01</p>
			<p>Оплаченные заказы отправляются покупателям на следующий рабочий день.</p>
			<p>Пожалуйста, ознакомьтесь с <a target="_blank" href="/buyers/payment_delivery/#CDEK">Условиями доставки СДЭК</a></p>
			<?
		}
		else 
		{
		?>
			<a href='/personal/order/detail/<?=$arResult['ORDER_ID']?>/' class='to_lk'>В личный кабинет</a>
			<a href='/' class='to_main'>на главную страницу</a>
		<? } ?>
		<div class="pay-block">
		<?
		if (0 && strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
		{
			?>
			
					<?
					if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
					{
						/*
						?>
						<script language="JavaScript">
							window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
						</script>
						<?*/?>
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
