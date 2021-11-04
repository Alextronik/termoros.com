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

	$NAV=array(
		"NavPageCount"=>$arResult["NAV_RESULT"]->NavPageCount,
		"NavPageNomer"=>$arResult["NAV_RESULT"]->NavPageNomer,
		"NavPageNomerNext"=>$arResult["NAV_RESULT"]->NavPageNomer+1,
		"NavNum"=>$arResult["NAV_RESULT"]->NavNum,
	);
	$templateData["NAV"]=$NAV;
	
if (!empty($arResult['ITEMS']))
{
?>	
	<div class="tech_docs">
		<div class="sorting_block">
			
			<div class="sorting_wp">
				<p class="name">Сортировать по</p>
				<?foreach($arSort as $key=>$arsort){
				?>
				<?$class="";
				$ord="asc"?>
				<?if($_GET["sort"]==$arsort["sort"])
					$class="active"?>
				<?if($_GET["order"]=="asc"){
					$ord="desc";
				}
				?>
					<a href='<?=$APPLICATION->GetCurPageParam("sort=".$arsort["sort"]."&order=".$ord,array("sort","order"));?>' class='<?=$class?>'><?=$key?></a>
					<?
				}?>
			</div>
			
			<div class="sorting_view">
				<form method="get">
				<span class="name">Выводить по</span>				
				<select class="customSelect sort_sel" name="view" >
					<option <?=$_GET['view']=="15"?"selected='selected'":""?> >15</option>
					<option <?=$_GET['view']=="30"?"selected='selected'":""?> >30</option>
					<option <?=$_GET['view']=="60"?"selected='selected'":""?> >60</option>
				</select>
				</form>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="tech_documentation">
					
			<table class="tech_table">
				<?
				foreach ($arResult['ITEMS'] as $key => $arItem)
				{
					$filearray = false;
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
					$strMainID = $this->GetEditAreaId($arItem['ID']);
					?>
					<?
					unset($file);
					?>
					
					<?if($arParams['PRICES'] == 'Y'):?>
					<?
					$path = CFile::GetPath($arItem['PROPERTIES']['ZIP']['VALUE']);
					$file = CFile::GetByID($arItem['PROPERTIES']['ZIP']['VALUE'])->fetch();
					
						if(!$arItem['PROPERTIES']['ZIP']['VALUE']){
							$path = '/upload/pricelists/'.$arItem['PROPERTIES']['FILE_PATH_ZIP']['VALUE'];
							$filesize = substr((filesize('../..'.$path)/1024)/1024, 0, 4);
							$filearray = date("d.m.Y", filemtime('../..'.$path));
							//p($path);
							$fileformat = substr($path, -4, 4);				
							//p($arItem['PROPERTIES']['FILE_PATH_ZIP']);
							
							$path = '/upload/pricelists/'.$arItem['PROPERTIES']['FILE_PATH_ZIP']['VALUE'].'?'.rand(10000, 99999).'';
						}else{
							$filesize = substr($file['FILE_SIZE']/1000000, 0, 4);
							$filearray = substr($arItem['TIMESTAMP_X'], 0, 10);
							$fileformat = substr($file['ORIGINAL_NAME'], -4, 4);					
						}
					?>
					<?else:?>
						<?
						if($arItem['PROPERTIES']['FILE']['VALUE']){
							$path = CFile::GetPath($arItem['PROPERTIES']['FILE']['VALUE']);
							$file = CFile::GetByID($arItem['PROPERTIES']['FILE']['VALUE'])->fetch();
							$filesize = substr($file['FILE_SIZE']/1000000, 0, 4);
							$fileformat = substr($file['ORIGINAL_NAME'], -4, 4);					
						}
						elseif ($arItem['PROPERTIES']['FILE_PATH']['VALUE']) 
						{
							
							$path = '/upload/manuals/'.$arItem['PROPERTIES']['FILE_PATH']['VALUE'].'?'.rand(10000, 99999).'';
							$filesize = substr((filesize($_SERVER['DOCUMENT_ROOT'].'/upload/manuals/'.$arItem['PROPERTIES']['FILE_PATH']['VALUE'])/1024)/1024, 0, 4);
							//$filearray = date("d.m.Y", filectime($_SERVER['DOCUMENT_ROOT'].$path));
							//p($path);
							
							$fileformat = substr('/upload/manuals/'.$arItem['PROPERTIES']['FILE_PATH']['VALUE'], -4, 4);				
							//p($arItem['PROPERTIES']['FILE_PATH_ZIP']);
						}
						
						?>
					<?endif;?>
					<?//p($arItem['PROPERTIES']['FILE_PATH']);?>
					<tr id="<? echo $strMainID; ?>" >
						<td class="inp">
							<input id="name<?=$arItem['ID']?>" type="checkbox" class="customCheckbox">
							<label for="name<?=$arItem['ID']?>" ><?=$arItem['NAME']?></label>
						</td>
						
						<td class="type">
							<?if($fileformat):?><?=$fileformat?><?else:?> - <?endif;?>
						</td>
						<?if($filearray):?>
						<td class="type">
							<?if($filearray):?><?=$filearray?><?else:?> - <?endif;?>
						</td>
						<?endif;?>						
						<td class="size">
							<?if($filesize):?><?=$filesize?> Мб<?else:?> - <?endif;?>
						</td>
						
						<td class="action">
							<a title="Скачать этот файл" href="<?=$path;?>" target="_blank" class="download"></a>
						</td>
					</tr>
				<?
				}
				?>
				
			</table>
					
			<div class="inp_wrap">
				<!--<input type="checkbox" class="customCheckbox">
				<label>Выбрать все</label>-->
			</div>
			<a href="" class="down_selected">скачать выбранные</a>
			<div class="clear"></div>
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
				/**/?>
	</div>	
	<?
}else{
?>
	<div class="tech_docs">
	<?if($arParams['WATCHED'] != 'Y' && $arParams['NON_OUTTEXT'] != 'Y'):?>
	<p class="no-items">Ничего не найдено, попробуйте изменить условия поиска</p>
	<?endif;?>
	</div>
<?}?>