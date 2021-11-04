<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props_format.php");
?>
<div class="section">




	<?
	$bHideProps = true;

	if (is_array($arResult["ORDER_PROP"]["USER_PROFILES"]) && !empty($arResult["ORDER_PROP"]["USER_PROFILES"])):
		if ($arParams["ALLOW_NEW_PROFILE"] == "Y" ):
		?>
			<?/*if($_REQUEST['STEP']==''||$_REQUEST['STEP']==1):?>
			<div class="bx_block r1x3">
				<?=GetMessage("SOA_TEMPL_PROP_CHOOSE")?>
			</div>

			<div class="bx_block r3x1 order_details_wp ">
				<select  class="customSelect country" name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
					<option value="0"><?=GetMessage("SOA_TEMPL_PROP_NEW_PROFILE")?></option>
					<?
					foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
					{
						?>
						<option value="<?= $arUserProfiles["ID"] ?>"<?if ($arUserProfiles["CHECKED"]=="Y") echo " selected";?>><?=$arUserProfiles["NAME"]?></option>
						<?
					}
					?>
				</select>
				<div style="clear: both;"></div>
			</div>
			<?endif*/?>
		<?
		else:
		?>
			<div class="bx_block r1x3">
				<?=GetMessage("SOA_TEMPL_EXISTING_PROFILE")?>
			</div>
			<div class="bx_block r3x1">
					<?
					if (count($arResult["ORDER_PROP"]["USER_PROFILES"]) == 1)
					{
						foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
						{
							echo "<strong>".$arUserProfiles["NAME"]."</strong>";
							?>
							<input type="hidden" name="PROFILE_ID" id="ID_PROFILE_ID" value="<?=$arUserProfiles["ID"]?>" />
							<?
						}
					}
					else
					{
						?>
						<select name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
							<?
							foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
							{
								?>
								<option value="<?= $arUserProfiles["ID"] ?>"<?if ($arUserProfiles["CHECKED"]=="Y") echo " selected";?>><?=$arUserProfiles["NAME"]?></option>
								<?
							}
							?>
						</select>
						<?
					}
					?>
				<div style="clear: both;"></div>
			</div>
		<?
		endif;
	else:
		$bHideProps = false;
	endif;
	?>
</div>

<br/>
<div class="bx_section">

<?//echo"<pre>";print_r($arResult["ORDER_PROP"]);echo"</pre>";?>

	<div <?if($_REQUEST["DELIVERY_ID"]==2){?>style="display: none;"<?}?> class="<?=$_REQUEST['STEP']!=1&&$_REQUEST['STEP'] ? "order_details_wp":"pers_info"?>">
			<?/*?>
			<p class="name">Данные для доставки</p>
			<p class="n_i">Сначала введите адрес, а после выберите способ доставки</p>
			<p class="sub_t">Адрес доставки</p>
			<?*/?>
		<?/*if($arResult['ADR']){?>
			<input type="hidden" value="<?=$_REQUEST['ADR']?>" class="adr_hidden" name="ADR">
			<select class='customSelect adr_select' name="ATR">
				<?
				foreach($arResult['ADR'] as $key => $val):
				?>
				<option <?if($_REQUEST['ADR']==$val['ID']||(!$_REQUEST['ADR']&&!$arResult['ADR'][$key+1])):?>selected<?endif?> value="<?=$val['ID']?>" data-id="<?=$val['ID']?>"><?=$val["NAME"]?></option>
				<?endforeach;?>

			</select>
		<?}*/?>


		<div class="clear"></div>
	</div>

		<div id="sale_order_props">
			<?
			PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"],array("2"));
			PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"],array("2"));
			?>
			<?=PrintPropsForm($arResult["ORDER_PROP"]["RELATED"], $arParams["TEMPLATE_LOCATION"],array("2"))?>
		</div>

	<div class="clear"></div>
</div>

<script type="text/javascript">
	function fGetBuyerProps(el)
	{
		var show = '<?=GetMessageJS('SOA_TEMPL_BUYER_SHOW')?>';
		var hide = '<?=GetMessageJS('SOA_TEMPL_BUYER_HIDE')?>';
		var status = BX('sale_order_props').style.display;
		var startVal = 0;
		var startHeight = 0;
		var endVal = 0;
		var endHeight = 0;
		var pFormCont = BX('sale_order_props');
		pFormCont.style.display = "block";
		pFormCont.style.overflow = "hidden";
		pFormCont.style.height = 0;
		var display = "";

		if (status == 'none')
		{
			el.text = '<?=GetMessageJS('SOA_TEMPL_BUYER_HIDE');?>';

			startVal = 0;
			startHeight = 0;
			endVal = 100;
			endHeight = pFormCont.scrollHeight;
			display = 'block';
			BX('showProps').value = "Y";
			el.innerHTML = hide;
		}
		else
		{
			el.text = '<?=GetMessageJS('SOA_TEMPL_BUYER_SHOW');?>';

			startVal = 100;
			startHeight = pFormCont.scrollHeight;
			endVal = 0;
			endHeight = 0;
			display = 'none';
			BX('showProps').value = "N";
			pFormCont.style.height = startHeight+'px';
			el.innerHTML = show;
		}

		(new BX.easing({
			duration : 700,
			start : { opacity : startVal, height : startHeight},
			finish : { opacity: endVal, height : endHeight},
			transition : BX.easing.makeEaseOut(BX.easing.transitions.quart),
			step : function(state){
				pFormCont.style.height = state.height + "px";
				pFormCont.style.opacity = state.opacity / 100;
			},
			complete : function(){
					BX('sale_order_props').style.display = display;
					BX('sale_order_props').style.height = '';

					pFormCont.style.overflow = "visible";
			}
		})).animate();
	}
</script>


