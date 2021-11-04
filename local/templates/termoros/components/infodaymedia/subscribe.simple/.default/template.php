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
			
			<form name="profile_subscribe" id="profile_subscribe" method="POST" action="">
				<?foreach($arResult["RUBRICS"] as $arRubric):?>
					<tr>
						<td>
						<input style="display: none;" onchange="$('#profile_subscribe').submit()" onclick="$('#profile_subscribe').submit()" value="<?echo $arRubric["ID"]?>"  id="rub_<?echo $arRubric["ID"]?>" name="RUB_ID[]" <?=($arRubric["CHECKED"] ? "checked" : '');?> class="hidden" type="checkbox" />
						<label for="rub_<?echo $arRubric["ID"]?>"><?echo $arRubric["NAME"]?></label>
						</td>
						<td><a><label for="rub_<?echo $arRubric["ID"]?>" class="rsslink profile_rubric"><?=($arRubric["CHECKED"] ? "Отписаться" : 'Подписаться');?></label></a></td>
					</tr>
				<?endforeach?>

				</div>	
				<?echo bitrix_sessid_post();?>
				<input name="FORMAT" value="html" id="FORMAT_html" type="hidden" />
				<input name="Update" value="<?echo GetMessage("CT_BSS_FORM_BUTTON")?>" type="hidden" />
			</form>
	<?endif?>
<?endif?>