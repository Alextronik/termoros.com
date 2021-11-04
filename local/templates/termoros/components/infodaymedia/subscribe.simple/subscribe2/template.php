<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?//p($arResult)?>


<?if(!$USER->GetEmail()):?>
	<p class="errortext">Чтобы подписаться на рассылку - заполните поле Email!</p>
<?else:?>

	<?if($arResult["MESSAGE"]):?>
		<p class="notetext"><?//echo $arResult["MESSAGE"]?></p>
	<?endif?>

	<?if(count($arResult["ERRORS"]) > 0):?>

		<?foreach($arResult["ERRORS"] as $strError):?>
			<p class="errortext"><?echo $strError?></p>
		<?endforeach?>

	<?elseif(count($arResult["RUBRICS"]) <= 0):?>

		<p class="errortext"><?echo GetMessage("CT_BSS_NO_RUBRICS_FOUND")?></p>

	<?else:?>
			<?//p($_GET)?>
			<form name="profile_subscribe" id="profile_subscribe" method="POST" action="/bitrix/templates/ampir/ajax/subscribe2.php">
				<div class="accountrss">
				<h3 class="sftitle">Моя рассылка</h3>
	<div class="fieldset" style="width: auto">
			<div class="flabwrap">
				<label class="fslab ">Email</label>
									<span class="required">*</span>
							</div>
				<input type="text" class="formfield" onfocus="if (this.value=='E-mail') this.value='';" onblur="if (this.value=='') this.value='E-mail';" name="EMAIL" maxlength="25" value="<?=$arResult["SUBSCRIPTION"]["EMAIL"]!="" ? $arResult["SUBSCRIPTION"]["EMAIL"] : $arResult["REQUEST"]["EMAIL"];?>"/>			
										
						
		</div>			

				<?foreach($arResult["RUBRICS"] as $arRubric):?>
					<div class="rssitem"> 
						<input value="<?echo $arRubric["ID"]?>"  id="rub_<?echo $arRubric["ID"]?>" name="RUB_ID[]" <?=($arRubric["CHECKED"] ? "checked" : '');?> class="customCheckbox" type="checkbox" />
						<label for="rub_<?echo $arRubric["ID"]?>"><?echo $arRubric["NAME"]?></label>
						<label for="rub_<?echo $arRubric["ID"]?>" class="rsslink profile_rubric"><?=($arRubric["CHECKED"] ? "Отписаться" : 'Подписаться');?></label>
					</div>				
				<?endforeach?>

				</div>	
				<?echo bitrix_sessid_post();?>
				<input name="FORMAT" value="html" id="FORMAT_html" type="hidden" />
				<input name="Update" value="<?echo GetMessage("CT_BSS_FORM_BUTTON")?>" type="hidden" />
			</form>
	<?endif?>
<?endif?>