<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!function_exists("showFilePropertyField"))
{
	function showFilePropertyField($name, $property_fields, $values, $max_file_size_show=50000)
	{
		$res = "";

		if (!is_array($values) || empty($values))
			$values = array(
				"n0" => 0,
			);

		if ($property_fields["MULTIPLE"] == "N")
		{
			$res = "<label for=\"\"><input type=\"file\" size=\"".$max_file_size_show."\" value=\"".$property_fields["VALUE"]."\" name=\"".$name."[0]\" id=\"".$name."[0]\"></label>";
		}
		else
		{
			$res = '
			<script type="text/javascript">
				function addControl(item)
				{
					var current_name = item.id.split("[")[0],
						current_id = item.id.split("[")[1].replace("[", "").replace("]", ""),
						next_id = parseInt(current_id) + 1;

					var newInput = document.createElement("input");
					newInput.type = "file";
					newInput.name = current_name + "[" + next_id + "]";
					newInput.id = current_name + "[" + next_id + "]";
					newInput.onchange = function() { addControl(this); };

					var br = document.createElement("br");
					var br2 = document.createElement("br");

					BX(item.id).parentNode.appendChild(br);
					BX(item.id).parentNode.appendChild(br2);
					BX(item.id).parentNode.appendChild(newInput);
				}
			</script>
			';

			$res .= "<label for=\"\"><input type=\"file\" size=\"".$max_file_size_show."\" value=\"".$property_fields["VALUE"]."\" name=\"".$name."[0]\" id=\"".$name."[0]\"></label>";
			$res .= "<br/><br/>";
			$res .= "<label for=\"\"><input type=\"file\" size=\"".$max_file_size_show."\" value=\"".$property_fields["VALUE"]."\" name=\"".$name."[1]\" id=\"".$name."[1]\" onChange=\"javascript:addControl(this);\"></label>";
		}

		return $res;
	}
}

if (!function_exists("PrintPropsForm"))
{
	function PrintPropsForm($arSource = array(), $locationTemplate = ".default",$group_ID)
	{
		$arrValid=array(
			"ORDER_PROP_1",
			"ORDER_PROP_20",
			"ORDER_PROP_21",
			"ORDER_PROP_2",
			"ORDER_PROP_22",
			"ORDER_PROP_4",
			"ORDER_PROP_23",
			"ORDER_PROP_24",
			"ORDER_PROP_5",
			"ORDER_PROP_24",
			"ORDER_PROP_28",
			"ORDER_PROP_29",
			"ORDER_PROP_8",
			"ORDER_PROP_12",
			"ORDER_PROP_13",
		);
		$arrValidMail=array("ORDER_PROP_2", "ORDER_PROP_29", "ORDER_PROP_13");
		if (!empty($arSource))
		{

			//p($arSource);
			?>

					<?
					$sh=0;
			?>
				<div class="inp_side " >
			<?
					foreach ($arSource as $arProperties)
					{
						//p($arProperties['VALUE']);
						if(!in_array($arProperties[PROPS_GROUP_ID],$group_ID))
						{
							continue;
						}
						if($sh==2){/*
							?>
							</div>
							<div class="inp_side right">
						<?*/}

						$class="";

						if($arProperties['CODE'] == 'ADDRESS' && \Redreams\Partners\partner::isPartner())
						{
							global $USER;
							$class="address";
							$ob_adress = new Redreams\Partners\adress();
							$arResult['adresses'] = $ob_adress->getlist(['UF_PARTNER' => $USER->GetID()]);

							if(!$arProperties["VALUE"])
							{
								$arProperties["VALUE"] = $arResult['adresses'][0]['UF_ADRESS'];
							}
						}

						?>
						<div class="inpt"  data-property-id-row="<?=intval(intval($arProperties["ID"]))?>" <?if($arProperties["TYPE"] == "LOCATION"||$arProperties["CODE"] == "CITY"):?>style="display: none;"<?endif;?>  >
						<p class="inp_name"><?=$arProperties["NAME"]?> <?=$arProperties["REQUIED_FORMATED"]=="Y"?"*":""?></p>
						<?
						if ($arProperties["TYPE"] == "CHECKBOX")
						{
							?>
							<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" value="">
							<input data-error_mes="?????? ???????????? ???? ???????????? ?????????????????????? ???????? ??????????????!"  type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" <?=(in_array($arProperties["FIELD_NAME"],$arrValid)||$arProperties["REQUIED_FORMATED"]=="Y")?'data-req="1"':""?> class="customCheckbox"  value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>>
							<label for="<?=$arProperties["FIELD_NAME"]?>">?????? ?????????? 18 ?????? <?=$arProperties["REQUIED_FORMATED"]=="Y"?"*":""?></label>
							<?
						}
						elseif ($arProperties["TYPE"] == "TEXT")
						{
							//var_dump($arProperties["VALUE"]);
							?>
							<input type="text" class="<?=$class?> inp_self <?=$sh>2?"short":""?> <?=$sh==5?"last":""?>" <?=(in_array($arProperties["FIELD_NAME"],$arrValid)||$arProperties["REQUIED_FORMATED"]=="Y")?'data-req="1"':""?> <?=in_array($arProperties["FIELD_NAME"],$arrValidMail)?'data-email="1"':""?> value="<?=$arProperties["VALUE"]=="&lt;?????? ??????????&gt;" ? "" : $arProperties["VALUE"]?>" maxlength="250" size="<?=$arProperties["SIZE1"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" />

							<?
						}	/*placeholder="<?=$arProperties["NAME"]?> <?=$arProperties["REQUIED_FORMATED"]=="Y"?"*":""?>"*/
						elseif ($arProperties["TYPE"] == "SELECT")
						{
							?>

							<select class="customSelect country "  name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
								<?
								foreach($arProperties["VARIANTS"] as $arVariants):
									?>
									<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
									<?
								endforeach;
								?>
							</select>
							<?
						}
						elseif ($arProperties["TYPE"] == "MULTISELECT")
						{
							?>
							<br/>
							<div class="bx_block r1x3 pt8">
								<?=$arProperties["NAME"]?>
								<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
									<span class="bx_sof_req">*</span>
								<?endif;?>
							</div>

							<div class="bx_block r3x1">
								<select multiple name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
									<?
									foreach($arProperties["VARIANTS"] as $arVariants):
									?>
										<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
									<?
									endforeach;
									?>
								</select>

								<?
								if (strlen(trim($arProperties["DESCRIPTION"])) > 0):
								?>
								<div class="bx_description">
									<?=$arProperties["DESCRIPTION"]?>
								</div>
								<?
								endif;
								?>
							</div>
							<div style="clear: both;"></div>
							<?
						}
						elseif ($arProperties["TYPE"] == "TEXTAREA")
						{
							$rows = ($arProperties["SIZE2"] > 10) ? 4 : $arProperties["SIZE2"];
							?>

							<div class="bx_block r3x1">
								<textarea class="<?=$class?> inp_self" rows="<?=$rows?>" cols="<?=$arProperties["SIZE1"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>

								<?
								if (strlen(trim($arProperties["DESCRIPTION"])) > 0):
								?>
								<div class="bx_description">
									<?=$arProperties["DESCRIPTION"]?>
								</div>
								<?
								endif;
								?>
							</div>
							<div style="clear: both;"></div>
							<?
						}
						elseif ($arProperties["TYPE"] == "LOCATION")
						{

							//p($_SESSION['GEOIP']['curr_city_id']);
							?>

							<div class="bx_block r3x1"  >

								<?
								$value = 0;
								if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0)
								{
									foreach ($arProperties["VARIANTS"] as $arVariant)
									{
										if ($arVariant["SELECTED"] == "Y")
										{
											$value = $arVariant["ID"];
											break;
										}
									}
								}

								// here we can get '' or 'popup'
								// map them, if needed
								if(CSaleLocation::isLocationProMigrated())
								{
									$locationTemplateP = $locationTemplate == 'popup' ? 'search' : 'steps';
									$locationTemplateP = $_REQUEST['PERMANENT_MODE_STEPS'] == 1 ? 'steps' : $locationTemplateP; // force to "steps"
								}
								?>

								<?if($locationTemplateP == 'steps'):?>
									<input type="hidden" id="LOCATION_ALT_PROP_DISPLAY_MANUAL[<?=intval($arProperties["ID"])?>]" name="LOCATION_ALT_PROP_DISPLAY_MANUAL[<?=intval($arProperties["ID"])?>]" value="<?=($_REQUEST['LOCATION_ALT_PROP_DISPLAY_MANUAL'][intval($arProperties["ID"])] ? '1' : '0')?>" />
								<?endif?>

								<?CSaleLocation::proxySaleAjaxLocationsComponent(array(
									"AJAX_CALL" => "N",
									"COUNTRY_INPUT_NAME" => "COUNTRY".$group_ID,
									"REGION_INPUT_NAME" => "REGION".$group_ID,
									"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
									"CITY_OUT_LOCATION" => "Y",
									"LOCATION_VALUE" => $_SESSION['GEOIP']['curr_city_id'], //$value ?
									"ORDER_PROPS_ID" => $arProperties["ID"],
									"ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
									"SIZE1" => $arProperties["SIZE1"],
								),
								array(
									"ID" => $_SESSION['GEOIP']['curr_city_id'],//$value,
									"CODE" => "",
									"SHOW_DEFAULT_LOCATIONS" => "Y",

									// function called on each location change caused by user or by program
									// it may be replaced with global component dispatch mechanism coming soon
									"JS_CALLBACK" => "submitFormProxy",

									// function window.BX.locationsDeferred['X'] will be created and lately called on each form re-draw.
									// it may be removed when sale.order.ajax will use real ajax form posting with BX.ProcessHTML() and other stuff instead of just simple iframe transfer
									"JS_CONTROL_DEFERRED_INIT" => intval($arProperties["ID"]),

									// an instance of this control will be placed to window.BX.locationSelectors['X'] and lately will be available from everywhere
									// it may be replaced with global component dispatch mechanism coming soon
									"JS_CONTROL_GLOBAL_ID" => intval($arProperties["ID"]),

									"DISABLE_KEYBOARD_INPUT" => "Y",
									"PRECACHE_LAST_LEVEL" => "Y",
									"PRESELECT_TREE_TRUNK" => "Y",
									"SUPPRESS_ERRORS" => "Y"
								),
								$locationTemplateP,
								true,
								'location-block-wrapper'
								)?>

								<?
								if (strlen(trim($arProperties["DESCRIPTION"])) > 0):
								?>
								<div class="bx_description">
									<?=$arProperties["DESCRIPTION"]?>
								</div>
								<?
								endif;
								?>

							</div>
							<div style="clear: both;"></div>
							<?
						}
						elseif ($arProperties["TYPE"] == "RADIO")
						{
							?>
							<div class="bx_block r1x3 pt8">
								<?=$arProperties["NAME"]?>
								<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
									<span class="bx_sof_req">*</span>
								<?endif;?>
							</div>

							<div class="bx_block r3x1">
								<?
								if (is_array($arProperties["VARIANTS"]))
								{
									foreach($arProperties["VARIANTS"] as $arVariants):
									?>
										<input
											type="radio"
											name="<?=$arProperties["FIELD_NAME"]?>"
											id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"
											value="<?=$arVariants["VALUE"]?>" <?if($arVariants["CHECKED"] == "Y") echo " checked";?> />

										<label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"><?=$arVariants["NAME"]?></label></br>
									<?
									endforeach;
								}
								?>

								<?
								if (strlen(trim($arProperties["DESCRIPTION"])) > 0):
								?>
								<div class="bx_description">
									<?=$arProperties["DESCRIPTION"]?>
								</div>
								<?
								endif;
								?>
							</div>
							<div style="clear: both;"></div>
							<?
						}
						elseif ($arProperties["TYPE"] == "FILE")
						{
							?>
							<br/>
							<div class="bx_block r1x3 pt8">
								<?=$arProperties["NAME"]?>
								<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
									<span class="bx_sof_req">*</span>
								<?endif;?>
							</div>

							<div class="bx_block r3x1">
								<?=showFilePropertyField("ORDER_PROP_".$arProperties["ID"], $arProperties, $arProperties["VALUE"], $arProperties["SIZE1"])?>

								<?
								if (strlen(trim($arProperties["DESCRIPTION"])) > 0):
								?>
								<div class="bx_description">
									<?=$arProperties["DESCRIPTION"]?>
								</div>
								<?
								endif;
								?>
							</div>

							<div style="clear: both;"></div><br/>
							<?
						}
						?>
						</div>

						<?if(CSaleLocation::isLocationProEnabled()):?>

							<?
							$propertyAttributes = array(
								'type' => $arProperties["TYPE"],
								'valueSource' => $arProperties['SOURCE'] == 'DEFAULT' ? 'default' : 'form' // value taken from property DEFAULT_VALUE or it`s a user-typed value?
							);

							if(intval($arProperties['IS_ALTERNATE_LOCATION_FOR']))
								$propertyAttributes['isAltLocationFor'] = intval($arProperties['IS_ALTERNATE_LOCATION_FOR']);

							if(intval($arProperties['CAN_HAVE_ALTERNATE_LOCATION']))
								$propertyAttributes['altLocationPropId'] = intval($arProperties['CAN_HAVE_ALTERNATE_LOCATION']);

							if($arProperties['IS_ZIP'] == 'Y')
								$propertyAttributes['isZip'] = true;
							?>

							<script>

								<?// add property info to have client-side control on it?>
								(window.top.BX || BX).saleOrderAjax.addPropertyDesc(<?=CUtil::PhpToJSObject(array(
									'id' => intval($arProperties["ID"]),
									'attributes' => $propertyAttributes
								))?>);

							</script>
						<?endif?>
						<?
						$sh++;

			}
			?>
			</div>
			<div class="clear"></div>
			<?
		}
	}
}
?>