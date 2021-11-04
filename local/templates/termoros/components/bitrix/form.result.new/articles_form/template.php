<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?if(is_ajax()&&$_REQUEST['AJAX_TYPE']=='FEED_BACK'):?>
	<?//ajax_start();?>
<?endif?>

	<a href='' class='popclose'></a>
<div class='pop_inn'>

<?
?>
	<?if ($arResult["isFormNote"] == "Y")
	{?>
		<p class='pop_ttl'><?=$arResult['arForm']['NAME']?></p>
<span class="rules" style="float: left; margin-top: -16px;">
	<?=$arResult['arForm']['DESCRIPTION']?>
</span>
	<?
	}else{
	
	?>
<div class="clear" style="height: 10px;"></div>
<?
unset($arResult["isFormNote"]);

?>
	<p class='pop_ttl'><?=$arResult['arForm']['NAME']?></p>
	<?if ($arResult['FORM_ERRORS'][0]) { ?>
		<p style="color: red;"><?=$arResult['FORM_ERRORS'][0]?></p>
	<? } ?>
	<?=$arResult['FORM_HEADER']?>
	<div class="pop_left">
	<?foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion):?>
			<?//p($arQuestion)?>
				<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='text'||$arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='email'):?>
				
					<?if($arQuestion['CAPTION']=='от'):?>
					<div class='inpt title'>
					<p class='inp_name'>Время для звонка</p>
					</div>
					<?endif;?>
					<div class='inpt <?if($arQuestion['CAPTION']=='до' || $arQuestion['CAPTION']=='от'):?> inline<?endif;?><?if($arQuestion['CAPTION']=='до'):?> right<?endif;?>'>
						<p class='inp_name'><?=$arQuestion['CAPTION']?><?if($arQuestion['REQUIRED']=='Y'):?>*<?endif;?></p>
						<input name="form_<?=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$arQuestion['STRUCTURE'][0]['ID']?>" 
							<?if($arQuestion['REQUIRED']=='Y'&&$arQuestion['CAPTION']=='Телефон'):?>data-phone="1"<?elseif($arQuestion['REQUIRED']=='Y'&&$arQuestion['CAPTION']=='E-mail'):?>data-email="1"<?elseif($arQuestion['REQUIRED']=='Y'):?>data-req="1"<?endif?>
							type="text"
							class="inp_self formfield <?if($arQuestion['CAPTION']=='до' || $arQuestion['CAPTION']=='от'):?> call<?endif;?><?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?> error<?endif?>"
							value="<?if($_REQUEST['form_'.$arQuestion['STRUCTURE'][0]['FIELD_TYPE'].'_'.$arQuestion['STRUCTURE'][0]['ID']]) echo $_REQUEST['form_'.$arQuestion['STRUCTURE'][0]['FIELD_TYPE'].'_'.$arQuestion['STRUCTURE'][0]['ID']];?>"
						/>
						<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
						<span class="errorreport">Не заполнено поле: <?=$arQuestion['CAPTION'];?></span>
						<?endif?>
						<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>

						<?endif?>
					</div>
				<?endif?>
				<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='textarea'):?>
					<div class='inpt'>
						<p class='inp_name'><?=$arQuestion['CAPTION']?><?if($arQuestion['REQUIRED']=='Y'):?>*<?endif;?></p>					
						<textarea name="form_<?=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$arQuestion['STRUCTURE'][0]['ID']?>"  class="inp_self <?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>error<?endif?>"><?if($_REQUEST['form_'.$arQuestion['STRUCTURE'][0]['FIELD_TYPE'].'_'.$arQuestion['STRUCTURE'][0]['ID']]) echo $_REQUEST['form_'.$arQuestion['STRUCTURE'][0]['FIELD_TYPE'].'_'.$arQuestion['STRUCTURE'][0]['ID']];?></textarea>
											
					</div>
				<?endif?>
				<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='radio'):?>				
					<?/*if($arQuestion['CAPTION']=='от'):?><label class="fslab ft"><?=$arQuestion['CAPTION']?></label><?endif*/?>
					
					<?//p($arQuestion['STRUCTURE'][0]['ID']);?>
					<div class="inpt custm" style="width:auto;">
						<p class='inp_name'><?=$arQuestion['CAPTION']?></p>
						<?=str_replace("<br />", "", $arQuestion['HTML_CODE']);?>
						<?//var_dump($arQuestion['HTML_CODE']);?>
					</div>
					
				<?endif?>
				<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='checkbox'):?>				
					<?/*if($arQuestion['CAPTION']=='от'):?><label class="fslab ft"><?=$arQuestion['CAPTION']?></label><?endif*/?>
					
					<?//p($arQuestion['STRUCTURE'][0]['ID']);?>
					<div class="inpt custm" >
						<p class='inp_name'><?=$arQuestion['CAPTION']?></p>
						<?=$arQuestion['HTML_CODE'];?>
					</div>
					
				<?endif?>
				<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='dropdown'):?>
					
					
					<div class="inpt custm">
						<p class='inp_name'><?=$arQuestion['CAPTION']?><?if($arQuestion['REQUIRED']=='Y'):?>*<?endif;?></p>
						<select name="form_<?=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$FIELD_SID?>" id="select_<?=$arQuestion['STRUCTURE'][0]['QUESTION_ID']?>" style="padding: 5px;" class="custom Select">
							<?foreach($arQuestion['STRUCTURE'] as $option):?>
								<option <?=$option["FIELD_PARAM"]?> value="<?=$option['ID']?>"><?=$option['MESSAGE']?></option>
							<?endforeach?>
						</select>
					</div>
					<div style="clear:both;"></div>
				<?endif?>
				
				<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='file'):?>
				<div class='inpt custm'>
					<div class='inpt title'>
						<p class='inp_name'><?=$arQuestion['CAPTION']?></p>
					</div>
					<input type="file" name="form_<?=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$arQuestion['STRUCTURE'][0]['ID']?>">
					
					<?if($arResult['FORM_ERRORS'][$FIELD_SID]):?>
						<span class="errorreport"><?=$arResult['FORM_ERRORS'][$FIELD_SID]?></span>
					<?endif?>
				</div>
				<?endif?>
				
				<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='image'):?>
					<div class='inpt title'>
						<p class='inp_name'><?=$arQuestion['CAPTION']?></p>
					</div>
					<input name="form_<?=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$arQuestion['STRUCTURE'][0]['ID']?>" class="inputfile" size="0" type="file"><span class="bx-input-file-desc"></span>
					<?if(strpos($arResult['FORM_ERRORS'][0],'FILE')!==false):?>
						<span class="errorreport">Выберите файл</span>
					<?endif?>
					<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
					<p style="color:red;">Указание файла обязательно</p>
					<?endif?>
				<?endif?>
				
				<div style="clear:both;"></div>
				<?//p($arQuestion);?>
		<?$k++?>
	<?endforeach?>
		<?// if ($USER->IsAdmin()) { ?>
			<input type="hidden" name="policy_required" value="1">
			<div class="inpt custm ">
				<input class="policy_agree" name="policy_agree"  value="1" checked="checked" type="checkbox"> <a style="color: red;" target="_blank" href="/copy.php"> Согласен на обработку персональных данных</a>
			</div>
		<?// } ?>		
		<input type="submit" class="formsubmit snd pop_btn" name="web_form_submit" value="Отправить"/>
	</div>
	<input type="hidden" name="FORM_NAME" value="CALL_BACK" />
	<input type="hidden" name="AJAX_TYPE" value="FEED_BACK" />
	<input type="hidden" name="js_captcha" value="" />
	<script>
		$('input[name="js_captcha"]').val('yes');
		$('.inpt.custm input').customCheckbox();
		if ($('form[name="SIMPLE_FORM_<?=$arResult['arForm']['ID']?>"]').length)
		{
			$('form[name="SIMPLE_FORM_<?=$arResult['arForm']['ID']?>"]').submit(function() {
				yaCounter26951046.reachGoal('SIMPLE_FORM_<?=$arResult['arForm']['ID']?>');
			});
		}
	</script>

	
	
	<?=$arResult['FORM_FOOTER']?>
<?}?>
	</div>



<?if(is_ajax()&&$_REQUEST['AJAX_TYPE']=='FEED_BACK'):?>
	<?ajax_end()?>
<?endif?>

