<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!empty($arResult["ORDER"]))
{
	?>
	
	<div class='orderpage finorder'>
		
		<div class='order_content'>
			
			<p class='sub_t'>Заказ №<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?> от <?=$arResult["ORDER"]["DATE_INSERT"]?> г. успешно оформлен.<br/>
			Информация о статусе исполнения заказа всегда доступна в Личном кабинете</p>
			
			<a href='' class='print'></a>
			<a href='' class='send'></a>
			
			<?
			if (0 && !empty($arResult["PAY_SYSTEM"]))
			{
				?>
				<br /><br />

				<table class="sale_order_full_table">
					<!--<tr>
						<td class="ps_logo">
							<div class="pay_name"><?=GetMessage("SOA_TEMPL_PAY")?></div>
							<?=CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"], 100, 100, "border=0", "", false);?>
							<div class="paysystem_name"><?= $arResult["PAY_SYSTEM"]["NAME"] ?></div><br>
						</td>
					</tr>-->
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
										window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>&PAYMENT_ID=<?=$arResult['ORDER']["PAYMENT_ID"]?>');
									</script>
									<?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&PAYMENT_ID=".$arResult['ORDER']["PAYMENT_ID"]))?>
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
				<br /><br />
				<?
			}
			?>
			
			<a href='<?=$arParams["PATH_TO_PERSONAL"]?>' class='lnk'>Личный кабинет</a>
			<a href='/' class='lnk'>Закрыть</a>
			
			
		</div>
		
	</div>
	<?/*?>
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
	<?*/
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
	<?
}
?>
