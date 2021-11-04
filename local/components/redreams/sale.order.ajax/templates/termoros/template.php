<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//CJSCore::Init();
$arrValid=array(
	"ORDER_PROP_1",
	"ORDER_PROP_20",
	"ORDER_PROP_21",
	"ORDER_PROP_2",
	"ORDER_PROP_22",
	"ORDER_PROP_4",
	"ORDER_PROP_23",
	"ORDER_PROP_24",
	'ORDER_PROP_5',
	"ORDER_PROP_25",
	"ORDER_PROP_26"
);
$arrValidMail=array("ORDER_PROP_2");
if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
{
	if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
	{
		if(strlen($arResult["REDIRECT_URL"]) > 0)
		{
			$APPLICATION->RestartBuffer();
			?>
			<script type="text/javascript">
				window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
			</script>
			<?
			die();
		}

	}
}

$APPLICATION->SetAdditionalCSS($templateFolder."/style_cart.css");
$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");

CJSCore::Init(array('fx', 'popup', 'window', 'ajax', 'jquery'));

?>
<?if(\Redreams\Partners\partner::isPartner()):?>
	<style>
		.pers_info
		{
			display: none;
		}
	</style>
<?endif?>
<?if(\Redreams\Partners\partner::isOperator()):?>
	<style>
		.pers_info
		{
			display: none;
		}
	</style>
<?endif?>
<?
$rez=array(
	"SUM" => array(0, 0, 0),
	"COU" => array(0, 0, 0),
	"DIS" => array(0, 0, 0)
);

foreach($arResult["GRID"]["ROWS"] as $val)
{
	if(\Redreams\Partners\partner::isPartner())
	{
		$val["data"]['DISCOUNT_PRICE'] = $val["data"]["BASE_PRICE"]-$val["data"]['PRICE'];
	}


	//echo "<pre>";print_r($val);echo "</pre>";
	$rez["COU"][0]+=$val['data']['QUANTITY'];
	$rez["SUM"][0]+=$val['data']['PRICE']*$val['data']['QUANTITY'];
	$rez["DIS"][0]+=$val['data']['QUANTITY']*$val["data"]["DISCOUNT_PRICE"];

	if($val["data"]["PROPERTY_FOR_ORDER_VALUE"]=="Да")
	{
		$rez["COU"][2]+=$val['data']['QUANTITY'];
		$rez["SUM"][2] +=$val['data']['PRICE']*$val['data']['QUANTITY'];
		$rez["DIS"][2]+=$val['data']['QUANTITY']*$val["data"]["DISCOUNT_PRICE"];
	}
	else
	{
		$rez["COU"][1]+=$val['data']['QUANTITY'];
		$rez["SUM"][1] +=$val['data']['PRICE']*$val['data']['QUANTITY'];
		$rez["DIS"][1]+=$val['data']['QUANTITY']*$val["data"]["DISCOUNT_PRICE"];
	}
}

if($rez["COU"][2]&&!$rez["COU"][1])
{
	$skip_step = 2;
}

if(!$rez["COU"][2]&&$rez["COU"][1])
{
	$skip_step = 3;
}
?>
<? if(!\Redreams\Partners\partner::isPartner() && !$_GET['ORDER_ID']) { ?>
        <div class="col-12">
            <a href="/images/retail_instruction/1.png" rel="order" class="how_to_order fancy">Как оформить заказ</a>
            <a href="/images/retail_instruction/2.png" rel="order" style="display:none;" class="fancy"></a>
        </div>

<? } else { ?>
	<?/*<p id="partner_error_sale_order_ajax" style="display:none; color: red;">Если у вас возникла эта ошибка, сообщите пожалуйста наименование</p>*/?>
<? } ?>
	<div id="order_form_div" class="order-checkout col-12 mt-4">
		<div class="basket_page orderpage">
			<div class="containe">
				<div class='cart_page orderpage' >

	<?if($_POST["is_ajax_post"] != "Y")
	{
	?><form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
	<?=bitrix_sessid_post()?>
		<? if ($_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]["ID"]) { ?>
			<input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]["ID"]?>">
		<? } else { ?>
			<input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="208">
		<? } ?>
	<div id="order_form_content">
	<?
	}
	else
	{
		$APPLICATION->RestartBuffer();
	}
	?>




					<NOSCRIPT>
						<div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
					</NOSCRIPT>

					<?
					if (!function_exists("getColumnName"))
					{
						function getColumnName($arHeader)
						{
							return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
						}
					}

					if (!function_exists("cmpBySort"))
					{
						function cmpBySort($array1, $array2)
						{
							if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
								return -1;

							if ($array1["SORT"] > $array2["SORT"])
								return 1;

							if ($array1["SORT"] < $array2["SORT"])
								return -1;

							if ($array1["SORT"] == $array2["SORT"])
								return 0;
						}
					}
					?>

		<div class="bx_order_make row">





						<?
						
						if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
						{
							if(!empty($arResult["ERROR"]))
							{
								echo '<b style="color:red;">';
								foreach($arResult["ERROR"] as $v)
								{
									echo ShowError($v);
								}
								echo '</b>';
							}
							elseif(!empty($arResult["OK_MESSAGE"]))
							{
								echo '<b style="color:red;">';
								foreach($arResult["OK_MESSAGE"] as $v)
								{
									echo ShowNote($v);
								}
								echo '</b>';
							}

							include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
						}
						else
						{
							if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
							{
								if(strlen($arResult["REDIRECT_URL"]) == 0)
								{
									include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
								}
							}
							else
							{

								?>
								<script type="text/javascript">

									<?if(CSaleLocation::isLocationProEnabled()):?>

									<?
                                    // spike: for children of cities we place this prompt
                                    $city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
                                    ?>

									top.BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
										'source' => $this->__component->getPath().'/get.php',
										'cityTypeId' => intval($city['ID']),
										'messages' => array(
											'otherLocation' => '--- '.GetMessage('SOA_OTHER_LOCATION'),
											'moreInfoLocation' => '--- '.GetMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
											'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.GetMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.GetMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
												'#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
												'#ANCHOR_END#' => '</a>'
											)).'</div>'
										)
									))?>);

									<?endif?>

									var BXFormPosting = false;
									function submitForm(val)
									{
										if (BXFormPosting === true)
											return true;

										if (!BX('policy_agree').checked && val == 'Y')
										{
											alert('Для завершения оформления заказа необходимо согласие на обработку персональных данных');
											return true;
										}
										
										BXFormPosting = true;
										if(val != 'Y')
											BX('confirmorder').value = 'N';

										var orderForm = BX('ORDER_FORM');
										
										
										
										BX.showWait();

										<?if(CSaleLocation::isLocationProEnabled()):?>
										BX.saleOrderAjax.cleanUp();
										<?endif?>

										
										
										BX.ajax.submit(orderForm, ajaxResult);

										
										
										return true;
									}

									function ajaxResult(res)
									{

										var orderForm = BX('ORDER_FORM');
										try
										{
											// if json came, it obviously a successfull order submit

											var json = JSON.parse(res);
											BX.closeWait();
											//console.log(json.error);
											if (json.error)
											{
												BXFormPosting = false;
												return;
											}
											else if (json.redirect)
											{
												window.top.location.href = json.redirect;
											}
										}
										catch (e)
										{
											// json parse failed, so it is a simple chunk of html

											BXFormPosting = false;
											BX('order_form_content').innerHTML = res;

											<?if(CSaleLocation::isLocationProEnabled()):?>
											
											BX.saleOrderAjax.initDeferredControl();
											<?endif?>
										}

										BX.closeWait();
										BX.onCustomEvent(orderForm, 'onAjaxSuccess');
										customInput();
										
									}

									function SetContact(profileId)
									{
										BX("profile_change").value = "Y";
										submitForm();
									}

									function SetAdress(ob,nosubmit)
									{
										$('.address.inp_self').val($(ob).val());
										if(!nosubmit)
										submitForm();
									}
									
									function SetAdressOperator(ob,nosubmit)
									{
										$('#ORDER_PROP_19').val($(ob).val());
										BX('ORDER_PROP_19').value = $(ob).val();
										if(!nosubmit) submitForm();
									}

								</script>
									<?
									if($_REQUEST['PERMANENT_MODE_STEPS'] == 1)
									{
										?>
										<input type="hidden" name="PERMANENT_MODE_STEPS" value="1" />
										<?
									}

									if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
									{
										echo '<br><br><b style="color:red;">';
										foreach($arResult["ERROR"] as $v)
											echo $v.'<br>';
										echo '</b>';
										?>
										
										<script type="text/javascript">
											top.BX.scrollToNode(top.BX('ORDER_FORM'));
										</script>
										<?
									}

									//p($_REQUEST);
									?>

				
									
				<?/*<p class='cart_summary'>В заказе присутствуют товары в наличии и товары под заказ. Вы можете выбрать для них разные способы оплаты и доставки </p>*/?>

				<!--a href='' class='del_terms pops text-right'>Условия доставки</a-->
				<div style="display: none;" class="cart-delivery-text pop_up pops-text" >
				<a href="" class="popclose"></a>
				<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => "/include/deliverys.php"), false);?>
				</div>
				<div class='clear'></div>

				<div class='order_left col-12 col-md-9'>
				<a name="order_form"></a>


									<div class="order_page page_1 finished">
										<div class='order_block_wp <?if($_REQUEST['STEP']>1){?>finished<?}?> <?if($_REQUEST['STEP']==1||$_REQUEST['STEP']==""){?>opened<?}?>'>
										<a href='' class='ob_opener'>Данные для оформления заказа</a>

										<?if($_REQUEST['STEP']>1){?>
										<div class='ob_summary'>
											<div class='obs_inn'>
												<?$cntr=1;?>
												<?foreach($_REQUEST as $inx => $value):?>
													<?if($cntr>9) continue;?>
													<?if(strpos($inx, 'ORDER_PROP_') !== false && $inx != 'ORDER_PROP_6'):?>
													<p><?=$value;?></p>
													<?endif;?>
													<?$cntr++;?>
												<?endforeach;?>
											</div>
											<a href='' class='edit_step' onclick="setStep(1); return false;" ></a>
										</div>
										<?//p($_REQUEST);?>
										<?}?>

										<div class='ob_inner'>
											<?
											if($_REQUEST['STEP']!=1&&$_REQUEST['STEP']!="")
											{/*
											?><div style="display: none;">

											<?
											*/}
											
											if(\Redreams\Partners\partner::isOperator())
											{
												include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type_operator.php");
											}
											else
											{	
												include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
											}	
											
											include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props3.php");
											if($_REQUEST['STEP']!=1&&$_REQUEST['STEP']!="")
											{/*
											?></div>

											<?
											*/}
									?>	</div>


										</div>
									  </div>
									<?//p($arResult);?>
									<?
									if($rez["COU"][1]>0||($rez["COU"][1]==0&&$rez["COU"][2]>0)){?>

									<div class="order_page page_2">

										<div class='order_block_wp  <?if($_REQUEST['STEP']>2){?>finished<?}?>  <?if($_REQUEST['STEP']==2){?>opened<?}?>'>
										<a href='' class='ob_opener'>Товары</a>

										<?if($_REQUEST['STEP']>2){?>
										<div class='ob_summary'>
											<div class='obs_inn'>
												<?if($_REQUEST['PAY_SYSTEM_ID']):?>
												<p><?=$arResult['PAY_SYSTEM'][$_REQUEST['DELIVERY_ID']]['NAME'];?></p>
												<?endif;?>
												<?if($_REQUEST['DELIVERY_ID']):?>
												<p><?=$arResult['DELIVERY'][$_REQUEST['DELIVERY_ID']]['NAME'];?></p>
												<?endif;?>
												<?/*foreach($_REQUEST as $inx => $value):?>
													<?if(strpos($inx, 'ORDER_PROP_') !== false):?>
													<p><?=$value;?></p>
													<?endif;?>
												<?endforeach;*/?>
											</div>
											<a href='' class='edit_step' onclick="setStep(2); return false;" ></a>
										</div>
										<?//p($_REQUEST);?>
										<?}?>

										<div class='ob_inner'>
										<?

										include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");
										$flag3=true;?>

										<?
										//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");
										?>

										<?/*if(!$rez["SUM"][0]):?>
											<div style="display: none;">
										<?endif*/?>
										<?
										include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
										/*if ($arParams["DELIVERY_TO_PAYSYSTEM"] == "p2d")
                                        {
                                            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
                                            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
                                        }
                                        */
										//else
										//{
										//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");

										//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");
										include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
										?>
                                        <?if($arResult['ZERO_QUANT']){?>
                                            <small class="red">"Обратите внимание, что выбранного товара временно нет в наличии. Срок поставки может быть увеличен.</small><br>
                                            <small></small><a href="/personal/cart/">редактировать корзину</a></small><br><br>
                                        <?}?>
										<?/*if(!$rez["SUM"][0]):?>
											</div>
											<div class="bx_section order_details_wp">
											<a onclick="setStep(1,false)" class="continue_order back">назад</a>
											<div class="clear"></div>
											</div>
										<?endif*/?>

										<?if($_REQUEST['STEP'] == 2):?>
											<?/*if($rez["COU"][1]>0||($rez["COU"][1]==0&&$rez["COU"][2]>0))
											{?>
											<a onclick="setStep(2,true,this)" class="continue_order next_step">продолжить</a>
											<?}else{?>
											<a onclick="setStep(3,true,this)" class="continue_order next_step">продолжить</a>

											<?}*/?>
											<?if($rez["COU"][2]>0):?>
											<a onclick="yaCounter26951046.reachGoal('next_korzina'); ga('send', 'pageview','/virtual/next_korzina'); setStep(3,true,this); return true;" class="continue_order next_step">продолжить</a>
											<?endif;?>
										<?endif?>
											<div class="clear"></div>
											<div>
											
											<p>Дополнительная информация по заказу (недостающие позиции, комментарии и т.д.):</p>
											<textarea name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION" style="width:80%;min-height:60px"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea>
											<br>
											
											
											<p><a target="_blank" href="/buyers/payment_delivery/">Условия доставки и оплаты</a></p>
											
											<? //CDEK ?>
											<? if (!$arResult["DELIVERY_PRICE"]) { ?>
											<p><br>«Окончательный состав и стоимость заказа, сроки поставки будут отражаться в отправляемом в ответ на заявку счете. Предложение не является офертой. Цены на сайте и в розничной сети могут отличаться. Информация на сайте о товаре носит рекламный характер и расценивается как приглашение делать оферты на основании п. 1 ст. 437 Гражданского кодекса РФ.»<br>&nbsp;</p>
											<? } ?>
											
											<span class="policy_agree checkboxArea"></span>
											<input class="policy_agree" id="policy_agree" name="policy_agree" value="1" checked="checked" type="checkbox"> 
											<a style="color: red;" target="_blank" href="/copy.php">Согласен с условиями обработки персональных данных</a>
											
											
											</div>
										</div>


										</div>
										
									</div>

										<? // tovari nalichie
									}

									if($rez["COU"][2]>0)
									{
										?>
										<div class="order_page page_3" >

										<div class='order_block_wp <?if($_REQUEST['STEP']==3){?>opened<?}?>'>
											<a href='' class='ob_opener'>Товары под заказ</a>

											<div class='ob_inner'>
										<?

										include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");
										//$flag3=true;
										//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props2.php");
										?>

										<?
										include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery2.php");
										/*if ($arParams["DELIVERY_TO_PAYSYSTEM"] == "p2d")
                                        {
                                            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
                                            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
                                        }
                                        */
										//else
										//{

										include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");
										include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem2.php");
										//}
										?>
												<?if($_REQUEST['STEP'] == 3):?>
													<?/*if($rez["COU"][1]>0||($rez["COU"][1]==0&&$rez["COU"][2]>0))
													{?>
													<a onclick="setStep(2,true,this)" class="continue_order next_step">продолжить</a>
													<?}else{?>
													<a onclick="setStep(3,true,this)" class="continue_order next_step">продолжить</a>
													<a onclick="setStep(4,true,this)" class="continue_order next_step">продолжить</a>
													<?}*/?>

												<?endif?>

													<div class="clear"></div>

												</div>

											</div>
										</div>
										<?
									}

									if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
										echo $arResult["PREPAY_ADIT_FIELDS"];
									?>
									<?if(($_REQUEST['STEP']==2&&$rez["COU"][2]==0)||($_REQUEST['STEP']==3&&$rez["COU"][2]>0)||($_REQUEST['STEP']==2&&$rez["COU"][2]>0&&$rez["COU"][1]==0)):?>
										<div class="clear"></div>
										<div class="finorder_block">
											<?/*<a href="javascript:void();" onclick="yaCounter26951046.reachGoal('final_korzina'); ga('send', 'pageview','/virtual/final_korzina'); submitForm('Y'); return false;" id="ORDER_CONFIRM_BUTTON" class="fin_btn checkout">Оформить заказ</a>*/?>
											<a href="" onclick="submitForm('Y'); return false;" id="ORDER_CONFIRM_BUTTON" class="fin_btn checkout">Оформить заказ</a>
										</div>
										<? /*  */ ?>
									<?endif?>

						
					<div class="clear"></div>
				
			</div>

			<?if(!$_REQUEST['ORDER_ID']):?>
			<div class='cart_right col-12 col-md-3'>

				<div class='btn_wp'>
					<a href="/personal/cart/" class="edit_basket" >Редактировать корзину</a>
				</div>
				
				<?if($rez["COU"][1] > 0){?>
					<?$ar_delivery_1 = explode(':',$_REQUEST['DELIVERY_ID']);?>
						<?if($ar_delivery_1[1]<>""):?>
							<?$arPrice = CSaleDeliveryHandler::CalculateFull(
									$ar_delivery_1[0],
									$ar_delivery_1[1],
									array(
										"PRICE" => $arResult["ORDER_PRICE"],
										"WEIGHT" => $arResult["ORDER_WEIGHT"],
										"LOCATION_TO" => $arResult["USER_VALS"]["DELIVERY_LOCATION"],
										"LOCATION_ZIP" => $arResult["USER_VALS"]["DELIVERY_LOCATION_ZIP"],
										"LOCATION_FROM" => COption::GetOptionString('sale', 'location'),
										"ITEMS" => $arResult["BASKET_ITEMS"]
									),
									"RUB"
								);
							?>
						<?endif?>
						<?if($arResult["DELIVERY_PRICE"] && $arDelivery["PRICE"]):?><?$deliver_price_1 = $arResult["DELIVERY_PRICE"]?><?endif;?>
						<?//$deliver_price_1 = $deliver_price_1 ? $deliver_price_1 : $arPrice['VALUE'];
					?>
					<?if(!$rez["SUM"][0]):?>
						<?$deliver_price_2 = 0;$deliver_price_1 = 0;?>
					<?endif?>

					<div class='order_pars'>
						<p class='ttl'>товары в наличии</p>
						<table class='par_table'>
							<tr>
								<td>
									Стоимость заказа
								</td>
								<td class='val'>
									<?=CurrencyFormat($rez["SUM"][1]+$rez["DIS"][1],"RUB")?>
								</td>
							</tr>
							<? if ($deliver_price_1) { ?>
							<tr>
								<td>
									Стоимость доставки
								</td>
								<td class='val'>
									<?=CurrencyFormat($deliver_price_1,"RUB")?>
								</td>
							</tr>
							<? } ?>
							<tr>
								<td>
									Скидка
								</td>
								<td class='val'>
									<?=CurrencyFormat($rez["DIS"][1],"RUB")?>
								</td>
							</tr>
						</table>
					</div>
				<? } else {
					$deliver_price_1 = 0;
				} ?>

				<div class='cart_summ'>
					<p class='ttl'>Итого</p>
					<table class='par_table'>
						<tr>
							<td>
								<?if(\Redreams\Partners\partner::isPartner()):?>
									Партнерская скидка
								<?else:?>
									Скидка
								<?endif?>
							</td>
							<td class='val'>
								<?=CurrencyFormat($rez["DIS"][0],"RUB")?>
							</td>
						</tr>
						<tr class='fin'>
							<td>
								Стоимость с НДС
							</td>
							<td class='val'>
								<p class='price'><?=CurrencyFormat($rez["SUM"][0]-$_SESSION['pay_bonus']+($deliver_price_1),"RUB")?></p>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<?endif?>
			
		</div>
		
		<?
		foreach($arResult["ORDER_PROP"]["USER_PROPS_Y"] as $prop)
		{
			if ($prop['CODE'] == 'LOCATION')
			{
				if (is_array($prop["VARIANTS"]) && count($prop["VARIANTS"]) > 0)
				{
					foreach ($prop["VARIANTS"] as $arVariant)
					{
						if ($arVariant["SELECTED"] == "Y")
						{
							
							$value = $arVariant["ID"];
							$orderCity = sqlSdekCity::getByBId($arVariant["ID"]);
							
							//var_dump($orderCity["SDEK_ID"]);
							if ($orderCity && $orderCity["SDEK_ID"])
							{
								echo '<input type="hidden" name="ORDER_PROP_57" value="'.$orderCity["SDEK_ID"].'">';
							}
							break;
						}
					}
				}
			}
		}
		//
		//var_dump($orderCity);
		?>
		
		
	<?if($_POST["is_ajax_post"] != "Y")
		{
		?>
		</div>

	<input type="hidden" name="ORDER_PROP_54" value="">
	<input type="hidden" name="ORDER_PROP_55" value="">
	<input type="hidden" name="ORDER_PROP_56" value="">
	
	<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
	<input type="hidden" name="STEP" id="STEP" value="1">

	<input type="hidden" name="profile_change" id="profile_change" value="N">
	<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
	<input type="hidden" name="json" value="Y">

	</form>
	
	<?
	if($arParams["DELIVERY_NO_AJAX"] == "N")
	{
	?>
	<div style="display:none;"><?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?></div>
	<?
	}
	}
	else
	{
	?>
	<script type="text/javascript">
		top.BX('confirmorder').value = 'Y';
		top.BX('profile_change').value = 'N';
	</script>
	<?
	die();
	}
	?>

	<?


	} // else confirm
	?>



				<div class="clear"></div>
				<? // вынужденный костыль
				if($arResult["USER_VALS"]["CONFIRM_ORDER"])
							{?>
							</div>
							<?}?>

				</div>

			</div>

		</div>

	</div>
	<?



	}
	?>
<?if(CSaleLocation::isLocationProEnabled()):?>

	<div style="display: none">
		<?// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.location.selector.steps",
			"", //russeds
			array(
			),
			false
		);?>
		<?$APPLICATION->IncludeComponent("bitrix:sale.location.selector.search", "", Array(

		),
			false
		);?>
	</div>

<?endif?>

