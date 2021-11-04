<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

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

CJSCore::Init(array('fx', 'popup', 'window', 'ajax'));


?>
<?if(\Redreams\Partners\partner::isPartner()):?>
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
	<div id="order_form_div" class="order-checkout">
		<div class="basket_page orderpage">
			<div class="container">
				<div class='cart_page orderpage' >

	<?if($_POST["is_ajax_post"] != "Y")
	{
	?><form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
	<?=bitrix_sessid_post()?>
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

		<div class="bx_order_make">


						<?
						if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
						{
							if(!empty($arResult["ERROR"]))
							{
								foreach($arResult["ERROR"] as $v)
									echo ShowError($v);
							}
							elseif(!empty($arResult["OK_MESSAGE"]))
							{
								foreach($arResult["OK_MESSAGE"] as $v)
									echo ShowNote($v);
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

									BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
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
										foreach($arResult["ERROR"] as $v)
											echo ShowError($v);
										?>
										<script type="text/javascript">
											top.BX.scrollToNode(top.BX('ORDER_FORM'));
										</script>
										<?
									}

									//p($_REQUEST);
									?>

				<?/*<p class='cart_summary'>В заказе присутствуют товары в наличии и товары под заказ. Вы можете выбрать для них разные способы оплаты и доставки </p>*/?>

				<a href='' class='del_terms'>Условия доставки</a>
				<div class='clear'></div>

				<div class='order_left'>
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
													<?if(strpos($inx, 'ORDER_PROP_') !== false):?>
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
											include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
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
											<a onclick="setStep(3,true,this)" class="continue_order next_step">продолжить</a>
											<?endif;?>
										<?endif?>
											<div class="clear"></div>

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
											<a href="javascript:void();" onclick="submitForm('Y'); return false;" id="ORDER_CONFIRM_BUTTON" class="fin_btn checkout">Оформить заказ</a>
										</div>
										<? /*  */ ?>
									<?endif?>


					<div class="clear"></div>

			</div>

			<?if(!$_REQUEST['ORDER_ID']):?>
			<div class='cart_right'>

				<div class='btn_wp'>
					<a href="/personal/cart" class="edit_basket" >Редактировать корзину</a>
				</div>
				<?//p($rez["COU"])?>
				<?if($rez["COU"][1]>0){?>
					<?//p($rez["COU"])?>
					<?$ar_delivery_1 = explode(':',$_REQUEST['DELIVERY_ID']);?>
					<?
						//if (doubleval($arResult["DELIVERY_PRICE"]) > 0)
						//{

							?>

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

							<?$deliver_price_1 = $deliver_price_1 ? $deliver_price_1 : $arPrice['VALUE'];
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
									<?=CurrencyFormat($rez["SUM"][1]+$deliver_price_1+$rez["DIS"][1],"RUB")?>
								</td>
							</tr>
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
					<?/*?>
					<div class="section summ">
						<p class="name">Товары, готовые к доставке</p>
						<p class="text">Товаров<span class="val"><?=round($rez["COU"][1])?><span>шт</span></span></p>
						<?if($rez["DIS"][1]>1):?>
						<p class="text">Скидка<span class="val"><?=CurrencyFormat($rez["DIS"][1],"RUB")?><span>руб</span></span></p>
						<?endif?>

							<?if($deliver_price_1):?>
								<p class="text">Доставка<span class="val">
								<?echo (CurrencyFormat($deliver_price_1,'RUB'))?>
								<span>руб</span></span></p>
							<?endif?>
							<?
						//}?>
						<p class="text">Стоимость<span class="val"><?=CurrencyFormat($rez["SUM"][1]+$deliver_price_1,"RUB")?><span>руб</span></span></p>
					</div>
					<?*/?>
				<?}else{$deliver_price_1 = 0;}?>

				<?if($rez["COU"][2]>0){?>

					<?if($rez["COU"][1]==0){
						$ar_delivery_2 = explode(':',$_REQUEST['DELIVERY_ID']);
					}else{
						$ar_delivery_2 = explode(':',$_REQUEST['DELIVERY_ID_2']);
					}?>

					<?if($ar_delivery_2[1]<>""):?>
						<?$arPrice2 = CSaleDeliveryHandler::CalculateFull(
								$ar_delivery_2[0],
								$ar_delivery_2[1],
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
					<?if($rez["COU"][1]==0){
						$deliver_price_2 = $deliver_price_1 ? $deliver_price_1 : $arPrice2['VALUE'];
					}else{
						$deliver_price_2 = $deliver_price_2 ? $deliver_price_2 : $arPrice2['VALUE'];
					}
					?>
					<div class='order_pars'>
						<p class='ttl'>товары под заказ</p>
						<table class='par_table'>
							<tr>
								<td>
									Стоимость заказа
								</td>
								<td class='val'>
									<?=CurrencyFormat($rez["SUM"][2]+$deliver_price_2+$rez["DIS"][2],"RUB")?>
								</td>
							</tr>
							<tr>
								<td>
									Скидка
								</td>
								<td class='val'>
									<?=CurrencyFormat($rez["DIS"][2],"RUB")?>
								</td>
							</tr>
						</table>
					</div>
					<?/*?>
					<div class="section summ">
						<p class="name">Товары под заказ</p>
						<p class="text">Товаров<span class="val"><?=round($rez["COU"][2])?><span>шт</span></span></p>
						<?if($rez["DIS"][2]>1):?>
						<p class="text">Скидка<span class="val"><?=CurrencyFormat($rez["DIS"][2],"RUB")?><span>руб</span></span></p>
						<?endif?>

						<?if($deliver_price_2&&$rez["SUM"][0]):?>
							<p class="text">Доставка<span class="val">
							<?echo (CurrencyFormat($deliver_price_2,'RUB'))?><span>руб</span></span></p>
						<?endif?>

						<p class="text">Стоимость<span class="val"><?=CurrencyFormat($rez["SUM"][2]+$deliver_price_2,"RUB")?><span>руб</span></span></p>
					</div>
					<?*/?>
				<?}?>
				<?/*?>
				<div class='account_block'>
						<p class='ttl'>Ваш бонусный счет</p>
						<p class='price'>121 234<span>руб.</span></p>
						<p class='i'>Вы можете частично или <br/>полностью оплатить свой заказ</p>
						<a href='' class='opener'></a>
						<div class='inp_wp'>
							<input type='text' class='inp_self' value='' >
							<input type='submit' class='btn' value=''>
							<div class='clear'></div>
						</div>
					</div>

					<div class='account_block'>
						<p class='ttl'>Ваш кредитный счет</p>
						<p class='price'>121 234<span>руб.</span></p>
						<p class='i'>Вы можете частично или <br/>полностью оплатить свой заказ</p>
						<a href='' class='opener'></a>
						<div class='inp_wp'>
							<input type='text' class='inp_self' value='' >
							<input type='submit' class='btn' value=''>
							<div class='clear'></div>
						</div>
					</div>
				<?*/?>
					<?if(!\Redreams\Partners\partner::isPartner()):?>
						<div class='account_block promo'>
							<p class='ttl'>Есть промо-код?</p>
							<p class='i'>Введите промо-код <br/>для получения скидки</p>
							<a href='' class='opener'></a>
							<div class='inp_wp'>
								<input type='text' class='inp_self' value='' >
								<input type='submit' class='btn' value=''>
								<div class='clear'></div>
							</div>
						</div>
					<?endif?>

				<div class='cart_summ'>
						<p class='ttl'>Итого</p>
						<table class='par_table'>
							<!--<tr>
								<td>
									Оплата с кредитного счета
								</td>
								<td class='val'>
									1 500 руб.
								</td>
							</tr>
							<tr>
								<td>
									Оплата с бонусного счета
								</td>
								<td class='val'>
									1 234 945 руб.
								</td>
							</tr>-->
							<tr>
								<td>
									<?if(\Redreams\Partners\partner::isPartner()):?>
										Партнерская скидка
									<?else:?>
										Скидка по промо-коду
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
									<p class='price'><?=CurrencyFormat($rez["SUM"][0]-$_SESSION['pay_bonus']+($deliver_price_2+$deliver_price_1),"RUB")?></p>
								</td>
							</tr>
						</table>
					</div>

					<?/*?>
				<div class="section summ fin">
					<p class="name">Итого</p>
					<p class="text">Товаров<span class="val"><?=round($rez["COU"][0])?><span>шт</span></span></p>
					<p class="text">Скидка<span class="val"><?=CurrencyFormat($rez["DIS"][0],"RUB")?><span>руб</span></span></p>
					<?if($rez["SUM"][0]):?>
						<?
						if (($deliver_price_2+$deliver_price_1) > 0)
						{
							$ar_delivery_1 = explode(':',$_REQUEST['DELIVERY_ID']);

							?>
							<p class="text">Доставка<span class="val">
							<?=CurrencyFormat(($deliver_price_2+$deliver_price_1),"RUB")?><span>руб</span></span></p>
							<?
						}
						?>
					<?endif?>
					<?if($_SESSION['pay_bonus']):?>
						<p class="text">Будет оплачено бонусами<span class="val"><?=CurrencyFormat($_SESSION['pay_bonus'],"RUB")?><span>руб</span></span></p>
					<?endif?>
					<p class="text">Стоимость<span class="val"><?=CurrencyFormat($rez["SUM"][0]-$_SESSION['pay_bonus']+($deliver_price_2+$deliver_price_1),"RUB")?><span>руб</span></span></p>
				</div>
					<?*/?>
			</div>
			<?endif?>

		</div>
	<?if($_POST["is_ajax_post"] != "Y")
		{
		?>
		</div>

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
