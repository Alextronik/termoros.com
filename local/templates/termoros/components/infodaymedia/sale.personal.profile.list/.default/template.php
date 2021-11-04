<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$isPartner = \Redreams\Partners\partner::isPartner()?>
 <div class="tab-pane <?if($isPartner):?>partner_page<?endif?>" id="my_adress">
	<?if(strlen($arResult["ERROR_MESSAGE"])>0)
		ShowError($arResult["ERROR_MESSAGE"]);?>
	<?if(strlen($arResult["NAV_STRING"]) > 0):?>

	<div class="sorting">
		<div class="pager">
			<?=$arResult["NAV_STRING"]?>
		</div>
	</div>

	<?endif?>


	<div class='prof_list <?if($isPartner):?>right_sidebar<?endif?>'>

			<?//p($arResult["PROFILES"])?>
			<?foreach($arResult["PROFILES"] as $val):?>
				<?
				$arUserProfileExt = \CSaleOrderUserProps::GetByID($val["ID"]);
				
				?>
				<? if ($arUserProfileExt["XML_ID"] && strtotime($arUserProfileExt["DATE_UPDATE"]) > (time() - 60*60*24*5)) { ?>
					<?
					//if($_REQUEST['user_type'] == 5 && $val['PERSON_TYPE_ID']!= 5) continue;
					//if(($_REQUEST['user_type'] == 4 || !$_REQUEST['user_type'])&& $val['PERSON_TYPE_ID']!= 4) continue;

					$APPLICATION->IncludeComponent(
						"infodaymedia:sale.personal.profile.detail",
						"",
						array(
							"PATH_TO_LIST" => $arResult["PATH_TO_LIST"],
							"PATH_TO_DETAIL" => $arResult["PATH_TO_DETAIL"],
							"SET_TITLE" =>$arParams["SET_TITLE"],
							"USE_AJAX_LOCATIONS" => $arParams['USE_AJAX_LOCATIONS'],
							"ID" => $val["ID"],
						),
						false
					);
					?>
				<? } ?>
			<?endforeach;?>
			<?if(!$isPartner):?>
			<a href='' class='add_prof new_profile save' onclick="$(this).next().show();$(this).hide(); return false;" >добавить профиль</a>
			<span class="add_profs">
				<a href='?add=1' class='add_prof new_profile save' >частное лицо</a>
				<a href='?add=3' class='add_prof new_profile save' >индивид. предприниматель</a>
				<a href='?add=2' class='add_prof new_profile save' >юридическое лицо</a>
			</span>
			<?endif?>

		</div>
	 <? include($_SERVER['DOCUMENT_ROOT'] . "/include/partner_right.php") ?>
	<div class="clear"></div>
	<?if(strlen($arResult["NAV_STRING"]) > 0):?>
		<div class="sorting">
			<div class="pager">
				<?=$arResult["NAV_STRING"]?>
			</div>
		</div>
	<?endif?>

</div>