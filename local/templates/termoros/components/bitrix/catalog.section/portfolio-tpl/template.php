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


?>
<?if($arParams['MAIN']!='Y'):?>
<div class="portfolio_page" >	
	
	<?if($arResult['PAGE_ELEMENT']):?>
	<?
	$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues(14,$arResult['PAGE_ELEMENT']['ID']); 
	$IPROPERTY = $ipropValues->getValues();
	?>
	
	<?$APPLICATION->AddChainItem($arResult['PAGE_ELEMENT']['NAME']);?>
	<?
	$APPLICATION->SetPageProperty("description", $IPROPERTY["ELEMENT_META_DESCRIPTION"]);
	$APPLICATION->SetPageProperty("title", $IPROPERTY["ELEMENT_META_TITLE"]);
	$APPLICATION->SetPageProperty("keywords", $IPROPERTY["ELEMENT_META_KEYWORDS"]);
	$APPLICATION->SetTitle($IPROPERTY["ELEMENT_PAGE_TITLE"]);
	?>
	
	
	<?//p($arResult['PAGE_ELEMENT'])?>
	<div class='port_mainblock'>
		<ul class='slider_block'>
			
		<?if($arResult['PAGE_ELEMENT']['PROPERTIES']['MORE_PICTURE']['VALUE']) { ?>
			<?foreach($arResult['PAGE_ELEMENT']['PROPERTIES']['MORE_PICTURE']['VALUE'] as $imgz):?>
			<?
			/*if($arResult['PAGE_ELEMENT']['DETAIL_PICTURE'])
				$imgid = resize($arResult['PAGE_ELEMENT']['DETAIL_PICTURE'], 960, 365, 2);
			elseif($arResult['PAGE_ELEMENT']['PREVIEW_PICTURE'])
				$imgid = resize($arResult['PAGE_ELEMENT']['PREVIEW_PICTURE'], 960, 365, 2);
			else*/
			if($imgz)
				$imgid = resize($imgz, 960, 365, 2);
			else
				$imgid = '';	
			?>		
			
			<li><img src='<?=$imgid;?>' class='p_im' alt="gallery" /></li>
			<?endforeach;?>
		<? } else { ?>
			<li><img src='<?=resize($arResult['PAGE_ELEMENT']["PREVIEW_PICTURE"], 960, 365, 2);?>' class='p_im' alt="gallery" /></li>
		<? }?>
		</ul>
		<?if(count($arResult['PAGE_ELEMENT']['PROPERTIES']['MORE_PICTURE']['VALUE']) > 1):?>
			<a href='' class='ms_prev'></a>
			<a href='' class='ms_next'></a>
			<?endif;?>
		<div class='pm_inner'>
			<?/*<p class='ttl'><?=$arResult['PAGE_ELEMENT']['NAME']?></p>*/?>
			<p class='sub'><?=$arResult['PAGE_ELEMENT']['PREVIEW_TEXT']?></p>
			<p class='txt'><?=$arResult['PAGE_ELEMENT']['DETAIL_TEXT']?></p>
		</div>
	</div>	
	<?endif;?>

	<div class='sorting_block'>
		
		
		<form method="get" style="" action="<?//=$APPLICATION->GetCurPageParam("",array());?>" >
			<input type="hidden" name="view" value="<?=$_REQUEST['view']?>">
		<p class='shown'>Тип объекта</p>
			<select class='customSelect proj_sel sort_sel' name="sect" >
				<?if(!$_REQUEST['sect']):?>
				<option value="0" selected="selected" >Выберите тип</option>
				<?endif;?>
				<option value="344" <?=$_REQUEST['sect']=="344"?"selected='selected'":""?> >Коттеджные жилищные объекты</option>
				<option value="345" <?=$_REQUEST['sect']=="345"?"selected='selected'":""?> >Многоквартирные жилищные объекты</option>
				<option value="346" <?=$_REQUEST['sect']=="346"?"selected='selected'":""?> >Объекты промышленного назначения</option>
				<option value="347" <?=$_REQUEST['sect']=="347"?"selected='selected'":""?> >Объекты промышленной водоподготовки</option>
				<option value="348" <?=$_REQUEST['sect']=="348"?"selected='selected'":""?> >Объекты с применением «зеленых технологий» на основе ВИЭ</option>
				<option value="349" <?=$_REQUEST['sect']=="349"?"selected='selected'":""?> >Социально и жилищно-коммунальная сфера</option>
			</select>
		
		<?
		$db_enum_list = CIBlockProperty::GetPropertyEnum(712, Array("SORT" => "ASC", "VALUE" => "ASC"), Array("IBLOCK_ID"=>14));
		while($arCity = $db_enum_list->GetNext())
		{
			if ($arCity["VALUE"])
			{
				$arCities[] = $arCity;
			}
		}
		?>
		<br><br>
		<p class='shown'>Город</p>
			<select class='customSelect proj_sel sort_sel' name="city" >
			<?if(!$_REQUEST['city']):?>
			<option value="0" selected="selected" >Все</option>
			<?endif;?>
			<? foreach($arCities as $city) { ?>
				<option value="<?=$city["ID"]?>" <?=$_REQUEST['city']==$city["ID"]?"selected='selected'":""?> ><?=$city["VALUE"]?></option>
			<? } ?>
			</select>
		</form>
		
		<div class='sorting_view' style="position: absolute; top: 0; right: 0;">
			<form method="get">
				<input type="hidden" name="city" value="<?=$_REQUEST['city']?>">
				<input type="hidden" name="sect" value="<?=$_REQUEST['sect']?>">
			<span class="name">Выводить по</span>				
			<select class="customSelect sort_sel" name="view" >
				<option <?=$_GET['view']=="9"?"selected='selected'":""?> >9</option>
				<option <?=$_GET['view']=="18"?"selected='selected'":""?> >18</option>
				<option <?=$_GET['view']=="36"?"selected='selected'":""?> >36</option>
			</select>
			</form>
		</div>
		<div class='clear'></div>
	</div>	
<?endif;?>

<?

$arSort = array(
		"названию" => array(
			'sort' => 'name',
			'order' => 'asc'
		),
		"дате" => array(
			'sort' => 'id',
			'order' => 'desc'
		),
	);

if (!empty($arResult['ITEMS']))
{
	if($arParams['MAIN']=='Y'):
	?>
	<div class='objects_wp container'>
        <div class="row">
            <div class='obj_ttl_wp col-3'>
                <div class='obj_ttl'>
                    <p class='ttl'>Портфолио</p>
                    <p class='sub' style="margin-bottom: 10px;">более 10 000 строительных объектов с <br/>применением оборудования <br/>“Терморос”</p>
                    <a class="sub link main" style="font-weight: bold; color: #749a4a;" href="/about_company/portfolio" >Все объекты</a>
                </div>
            </div>

            <ul class='objects_slider col'>
                    <?
                    foreach ($arResult['ITEMS'] as $key => $arItem)
                    {
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
                    $strMainID = $this->GetEditAreaId($arItem['ID']);
                    ?>
                    <?
                    unset($img);

                    if($arItem['DETAIL_PICTURE'])
                        $img = resize($arItem['DETAIL_PICTURE']['ID'], 320, 320, 3);
                    elseif($arItem['PREVIEW_PICTURE'])
                        $img = resize($arItem['PREVIEW_PICTURE']['ID'], 320, 320, 3);
                    else
                        $img = '';
                    ?>
                    <li id="<? echo $strMainID; ?>" >
                        <img width="360" height="360" class="img lozad" data-src='<?=$img;?>' class='obj_im'  alt=''>
                        <p class='o_loc'><?=$arItem['PROPERTIES']['CITY']['VALUE'];?></p>
                        <p class='o_name'><?=$arItem['NAME']?></p>
                        <a href='<?=$arItem['DETAIL_PAGE_URL']//$APPLICATION->GetCurPageParam("ID=".$arItem['ID'],array("ID"));?>' class='more_lnk'>
                            <div class='more_i'>
                                <img src='<?=SITE_TEMPLATE_PATH;?>/img/more_lnk.png' class='ico'  alt=''>
                                <p class='name'>подробнее</p>
                            </div>
                        </a>
                    </li>
                    <?
                    }
                    ?>

            </ul>

            <a href='' class='os_prev'></a>
            <a href='' class='os_next'></a>
        </div>
	</div>
	<?
	else:	
	
	
$rows = array_chunk($arResult['ITEMS'], 3);
?>	
				
				<div class='objects_wp'>
					
					<?
					foreach ($rows as $key => $row)
					{
					?>	
					<div class='objects_line'>
						<?
						foreach ($row as $key => $arItem)
						{
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
						$strMainID = $this->GetEditAreaId($arItem['ID']);
						?>
						<?
						unset($img);
					
						if($arItem['DETAIL_PICTURE'])
							$img = resize($arItem['DETAIL_PICTURE']['ID'], 320, 320, 3);
						elseif($arItem['PREVIEW_PICTURE'])
							$img = resize($arItem['PREVIEW_PICTURE']['ID'], 320, 320, 3);
						else
							$img = '';	
						?>
						<?//p($arItem['PROPERTIES']);?>
						<?//p($arItem['PROPERTIES']['CITY']['VALUE']);?>
						<?//p($arItem['PROPERTIES']['MORE_PICTURE']['VALUE']);?>
						<?//p($arItem['PROPERTIES']['SHOW_MP']['VALUE']);?>
						<?//p($arItem['PREVIEW_PICTURE']['ID']);?>
						<div id="<? echo $strMainID; ?>" class='object_item'>
							<img src='<?=$img;?>' class='obj_im'  alt=''>
							<p class='o_loc'><?=$arItem['PROPERTIES']['CITY']['VALUE'];?></p>
							<p class='o_name'><?=$arItem['NAME']?></p>
							<a href='<?=$arItem['DETAIL_PAGE_URL']//=$APPLICATION->GetCurPageParam("ID=".$arItem['ID'],array("ID"));?>' class='more_lnk'>
								<div class='more_i'>
									<img src='<?=SITE_TEMPLATE_PATH;?>/img/more_lnk.png' class='ico'  alt=''>
									<p class='name'>подробнее</p>
								</div>
							</a>
						</div>
						<?
						}
						?>
						<div class='clear'></div>
					</div>
					<?
					}
					?>

				</div>
				
				<?if($NAV["NavPageCount"]>$NAV["NavPageNomer"]){
				$page= $APPLICATION->GetCurPageParam("PAGEN_".$NAV["NavNum"]."=".$NAV["NavPageNomerNext"]."&LAZI_".$NAV["NavNum"]."=Y", array("PAGEN_".$NAV["NavNum"], "LAZI_".$NAV["NavNum"]));
				?>
				<div class="show"></div><a href='<?=$page?>' class='show_more'></a>
				<?}?>
					
				<?
				if ($arParams["DISPLAY_BOTTOM_PAGER"])
				{
				?><? echo $arResult["NAV_STRING"]; ?><?
				}
				?>
				
	<?
	endif; // nomain
	
}else{
?>
	<?if($arParams['WATCHED'] != 'Y' && $arParams['NON_OUTTEXT'] != 'Y'):?>
	<p class="no-items">К сожалению, по Вашему запросу сегодня ничего не найдено.</p>
	<?endif;?>
<?}?>

<?if($arParams['MAIN']!='Y'):?>
</div>	
<?endif;?>