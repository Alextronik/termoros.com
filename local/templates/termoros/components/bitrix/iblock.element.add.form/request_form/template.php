<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<?
//echo "<pre>Template arParams: "; print_r($arParams); echo "</pre>";
//echo "<pre>Template arResult: "; print_r($arResult); echo "</pre>";
//exit();
?>
<br />
<br />
<a href="" class="green_color" id="send_request">Отправить заявку</a>
<br />
<br />
<div id="request_form">
	<form action="<?=POST_FORM_ACTION_URI?>#request_form" method="post" id="anketa_frm" enctype="multipart/form-data">
		<?=bitrix_sessid_post()?>
		<input type="hidden" name="PROPERTY[646][0]" value="<?=$arParams["ELEMENT"]["ID"]?>">
		<input type="hidden" name="PROPERTY[645][0]" value="<?=$arParams["ELEMENT"]["NAME"]?>">
		<div class="anketa">
			<?if (count($arResult["ERRORS"])):?>
				<div class="aform-block main">
					<div class="hr_mid"></div>
					<?=ShowError(implode("<br />", $arResult["ERRORS"]))?>
				</div>
				<script>
					jQuery(document).ready(function(){
						jQuery('#request_form').slideToggle();
					});
				</script>
			<?endif?>
			<?if (strlen($arResult["MESSAGE"]) > 0):?>
				<div class="aform-block main">
					<div class="hr_mid"></div>
					<?=ShowNote($arResult["MESSAGE"])?>
				</div>
				<script>
					jQuery(document).ready(function(){
						jQuery('#request_form').slideToggle();
					});
				</script>
			<?endif?>
			<?if (strlen($arResult["MESSAGE"]) == 0) { ?>
			<div class="aform-block main">
				<div class="hr_mid"></div>
				<div class="ajustblock row">
					<div class="fieldname"><sup class="red">*</sup>Название организации:</div>
					<div><input type="text" value="<?=$arResult["ELEMENT"]["NAME"]?>" name="PROPERTY[NAME][0]"></div>
				</div>
				
				<div class="ajustblock row">
					<div class="fieldname"><sup class="red">*</sup>ИНН:</div>
					<div><input type="text" value="<?=$arResult["ELEMENT_PROPERTIES"]["639"][0]["VALUE"]?>" name="PROPERTY[639][0]"></div>
				</div>
				
				<div class="ajustblock row">
					<div class="fieldname"><sup class="red">*</sup>Юридический адрес:</div>
					<div><input type="text" value="<?=$arResult["ELEMENT_PROPERTIES"]["640"][0]["VALUE"]?>" name="PROPERTY[640][0]"></div>
				</div>
				
				<div class="ajustblock row">
					<div class="fieldname"><sup class="red">*</sup>Email:</div>
					<div><input type="text" value="<?=$arResult["ELEMENT_PROPERTIES"]["643"][0]["VALUE"]?>" name="PROPERTY[643][0]"></div>
				</div>
				
				<div class="ajustblock row">
					<div class="fieldname"><sup class="red">*</sup>Телефон:</div>
					<div><input class="phone-number" value="<?=$arResult["ELEMENT_PROPERTIES"]["642"][0]["VALUE"]?>" type="text" name="PROPERTY[642][0]"></div>
				</div>
				
				<div class="hr_mid"></div>
				
				<h3><sup class="red">*</sup>Краткая характеристика компании:</h3>
				<div class="aform-block">
					<textarea name="PROPERTY[641][0]"><?=$arResult["ELEMENT_PROPERTIES"]["641"][0]["VALUE"]?></textarea>
				</div>
				
				<div class="hr_mid"></div>
				<br><br>
				<div class="green_color">Форматы загружаемых документов: doc, docx, pdf, rtf, xls, txt</div>
				<br>
				<input type="hidden" value="" name="PROPERTY[644][0]">
				<div class="green_color">Прикрепить заполненное конкурсное предложение</div>
				<div class="row">
					<input type="file" name="PROPERTY_FILE_644_0" data-message="Прикрепить заполненное конкурсное предложение">
				</div>
				<br>
				<input type="hidden" value="" name="PROPERTY[644][1]">
				<div class="green_color">Прикрепить документ, подтверждающий квалификацию участника</div>
				<div class="row">
					<input type="file" name="PROPERTY_FILE_644_1" data-message="Прикрепить документ, подтверждающий квалификацию участника">
				</div>
				<br>
				<div class="ajustblock row">
					<a id="add_more_doc" class="green_color" href="#">Еще документ</a>
				</div>
				
				<div class="acenter">
					<input type="submit" name="iblock_submit" class="animate_all green_color" value="Отправить заявку">
				</div>
			</div>
			<? } ?>
		</div>
	</form>
</div>