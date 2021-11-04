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
	
	<?if ($arResult['FORM_ERRORS'][0]) { ?>
		<p style="color: red;"><?=$arResult['FORM_ERRORS'][0]?></p>
	<? } ?>
	<?=$arResult['FORM_HEADER']?>
	<div class="pop_left">
	<?foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion):?>
			<?//p($arQuestion)?>
			<?if($arResult['arForm']['ID'] == 5):?>
				<?/*if($k==10):?></div><div class='pop_right'><?endif*/?>
			<?else:?>
				<?if($k==1&&$arResult['arForm']['ID'] == 4):?></div><div class='pop_right'><?elseif($k==4):?></div><div class='pop_right'><?endif?>
			<?endif?>
			
			
				<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='text'||$arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='email'):?>
				
					<?if($arQuestion['CAPTION']=='от'):?>
					<div class='inpt title'>
					<p class='inp_name'>Время для звонка</p>
					</div>
					<?endif;?>
					<div class='inpt <?if($arQuestion['CAPTION']=='до' || $arQuestion['CAPTION']=='от'):?> inline<?endif;?><?if($arQuestion['CAPTION']=='до'):?> right<?endif;?> line_<?=$arQuestion['STRUCTURE'][0]['ID']?> input-line'>
						<p class='inp_name'><?=$arQuestion['CAPTION']?><?if($arQuestion['REQUIRED']=='Y'):?>*<?endif;?></p>
						<input name="form_<?=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$arQuestion['STRUCTURE'][0]['ID']?>" 
							<?if($arQuestion['REQUIRED']=='Y'&&$arQuestion['CAPTION']=='Телефон'):?>data-phone="1"<?elseif($arQuestion['REQUIRED']=='Y'&&$arQuestion['CAPTION']=='E-mail'):?>data-email="1"<?elseif($arQuestion['REQUIRED']=='Y'):?>data-req="1"<?endif?>
							type="text"
							class="inp_self formfield <?if($arQuestion['CAPTION']=='до' || $arQuestion['CAPTION']=='от'):?> call<?endif;?><?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?> error<?endif?>"
							value="<?if($_REQUEST['form_'.$arQuestion['STRUCTURE'][0]['FIELD_TYPE'].'_'.$arQuestion['STRUCTURE'][0]['ID']]) echo $_REQUEST['form_'.$arQuestion['STRUCTURE'][0]['FIELD_TYPE'].'_'.$arQuestion['STRUCTURE'][0]['ID']];?><?if($arQuestion['STRUCTURE'][0]['ID'] == 36):?><?=$_REQUEST['vac']?><?endif;?>"
						/>
						<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
						<span class="errorreport">Не заполнено поле: <?=$arQuestion['CAPTION'];?></span>
						<?endif?>
						<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>

						<?endif?>
					</div>
				<?endif?>
				<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='textarea'):?>
					<div class="clear"></div>
					<div class='inpt line_<?=$arQuestion['STRUCTURE'][0]['ID']?> textarea-line'>
						<p class='inp_name'><?=$arQuestion['CAPTION']?><?if($arQuestion['REQUIRED']=='Y'):?>*<?endif;?></p>					
						<textarea name="form_<?=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$arQuestion['STRUCTURE'][0]['ID']?>"  class="inp_self <?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>error<?endif?>"><?if($_REQUEST['form_'.$arQuestion['STRUCTURE'][0]['FIELD_TYPE'].'_'.$arQuestion['STRUCTURE'][0]['ID']]) echo $_REQUEST['form_'.$arQuestion['STRUCTURE'][0]['FIELD_TYPE'].'_'.$arQuestion['STRUCTURE'][0]['ID']];?></textarea>
											
					</div>
				<?endif?>
				<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='radio'):?>				
					<?/*if($arQuestion['CAPTION']=='от'):?><label class="fslab ft"><?=$arQuestion['CAPTION']?></label><?endif*/?>
					
					<?//p($arQuestion['STRUCTURE'][0]['ID']);?>
					<div class="inpt custm" >
						<p class='inp_name'><?=$arQuestion['CAPTION']?></p>
						<?=$arQuestion['HTML_CODE'];?>
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
					<div class="selectarea">
					<?if($arQuestion['CAPTION']=='от'):?><label class="fslab ft"><?=$arQuestion['CAPTION']?></label><?endif?>
					<select class="customSelect">
						<?foreach($arQuestion['STRUCTURE'] as $option):?>
							<option value="<?=$option['ID']?>"><?=$option['MESSAGE']?></option>
						<?endforeach?>
					</select>
					</div>
				<?endif?>
				
				<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE']=='file'):?>
				<?//p($arQuestion['STRUCTURE'][0])?>					
				<div class='insert_area f_area file_wp'>
					<input type="hidden" name="form_<?=$arQuestion['STRUCTURE'][0]['FIELD_TYPE']?>_<?=$arQuestion['STRUCTURE'][0]['ID']?>">
					 <input style="display: none;" class="file_form" onchange="SendFile(this);" type="file" name="upload_file" />
					<a onclick="$(this).parent().find('.file_form').click(); $(this).parents('form').attr('id','test_form');" class='file_but insert_file'>Прикрепить фаил *</a>
					<p class='file_name' id="files"> 
						<?if($_SESSION['uploaded_file']):?>
							<span><?=$_SESSION['uploaded_file_name']?></span><a onclick='DeleteFile()' class='del'></a>
						<?endif?>
					</p>
					<p class='sub'>Допустимые форматы файла: .pdf, .doc . <br/>
				Размер загружаемого файла не должен превышать 5мб</p>
					<?/*if(strpos($arResult['FORM_ERRORS'][0],'FILE')!==false):?>
						<span class="errorreport">Приложите резюме</span>
					<?endif*/?>
				</div>
				<?endif?>
				
				<?//p($arQuestion);?>
		<?$k++?>
	<?endforeach?>
		<?// if ($USER->IsAdmin()) { ?>
			<input type="hidden" name="policy_required" value="1">
			<div class="inpt custm ">
				<input class="policy_agree" name="policy_agree"  value="1" checked="checked" type="checkbox"> <a style="color: red; margin-left: 20px;" target="_blank" href="/copy.php"> Согласен на обработку персональных данных</a>
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
	</script>

	<?=$arResult['FORM_FOOTER']?>
<?}?>
	</div>



<?if(is_ajax()&&$_REQUEST['AJAX_TYPE']=='FEED_BACK'):?>
	<?ajax_end()?>
<?endif?>

