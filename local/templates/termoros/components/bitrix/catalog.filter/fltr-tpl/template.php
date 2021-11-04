<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

foreach($_REQUEST as $ind => $val){
	//p($ind);
	//p($val);
	if(is_array($val)){
		foreach($val as $indexval => $idval){
			$checked[$ind.'['.$indexval.']'] = $idval;
		}
	}
}

//p($checked);
?>
<?//p($arResult["ITEMS"]);?>

<div class="left_fltr">
<div class="bx_filter listfilter">
	<p class='ttl'>Параметры подбора</p>
					<?//p($arResult);?>
	<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
			<?foreach($arResult["ITEMS"] as $arItem):
				if(array_key_exists("HIDDEN", $arItem)):
					echo $arItem["INPUT"];
				endif;
			endforeach;?>
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<?//p($arItem);?>
				<?if(!array_key_exists("HIDDEN", $arItem)):?>
					<?if($arItem['TYPE'] == 'INPUT'):?>
					<div class='fltr_section opened active'>
						<a href='' class='section_btn'><?=$arItem["NAME"]?></a>
						<ul class='fltr_list'>
							<li>
								
								<input 									
									id="id_<?=$arItem["INPUT_NAME"]?>" 
									type='input' 
									name="<?=$arItem["INPUT_NAME"]?>" 
									value="<?=$_REQUEST['arrFilter_ff']['NAME']?>" class="inp_self"
								/>
								<input name="set_filter" class="btn" value="Y" type="submit" />
								
							</li>			
						</ul>
					</div>
					<?elseif($arItem['TYPE'] == 'SELECT'):?>
					<?//p($_REQUEST{$arItem["INPUT_NAME"]});?>
					<div class='fltr_section opened active'>
						<a href='' class='section_btn'><?=$arItem["NAME"]?></a>
						<ul class='fltr_list'>
						<?natsort($arItem['LIST']);?>
						<li>
							<label for="id_<?=$arItem["INPUT_NAME"]?>_<?=$key?>" class="bx_filter_param_label" >
							
							<input 
								<?/*if($checked[$arItem["INPUT_NAME"]] == false):?>
								checked
								<?endif;*/?>
								id="id_<?=$arItem["INPUT_NAME"]?>_<?=$key?>" 
								type='radio' 
								onchange="setFilterPage($(this));"
								name="<?=$arItem["INPUT_NAME"]?>" 
								value="" class='customRadio'
							/>
							<span class="bx_filter_param_text" >Всё</span>
							</label>
						</li>
						<?foreach($arItem['LIST'] as $key => $vals):?>
							<?if(!$key) continue;?>
							<li>
								<label for="id_<?=$arItem["INPUT_NAME"]?>_<?=$key?>" class="bx_filter_param_label" >
								
								<input 
									<?if($checked[$arItem["INPUT_NAME"]] == $key):?>
									checked
									<?endif;?>
									id="id_<?=$arItem["INPUT_NAME"]?>_<?=$key?>" 
									type='radio' 
									onchange="setFilterPage($(this));"
									name="<?=$arItem["INPUT_NAME"]?>" 
									value="<?=$key?>" class='customRadio'
								/>
								<span class="bx_filter_param_text" ><?=$vals?></span>
								</label>
							</li>
						<?endforeach;?>				
						</ul>
					</div>
					<?endif?>
				<?endif?>
			<?endforeach;?>
			<input type="submit" name="set_filter" value="<?=GetMessage("IBLOCK_SET_FILTER")?>" /><input type="hidden" name="set_filter" value="Y" />&nbsp;&nbsp;<input type="submit" name="del_filter" value="<?=GetMessage("IBLOCK_DEL_FILTER")?>" />
	</form>
</div>
</div>