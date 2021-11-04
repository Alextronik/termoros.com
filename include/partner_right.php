<?$isPartner = \Redreams\Partners\partner::isPartner()?>
<?if($isPartner){
?>
<div class='pm_block pm_right col-12 col-md-3'>
    <a href='/personal/techsupport/' class='tp'>Техническая поддержка</a>

	<?
	$cUser = new CUser; 
	$sort_by = "ID";
	$sort_ord = "ASC";
	$arFilter = array(
	   "ID" => $USER->GetID(),
	);
	$arSelect = array(
		'*'
	);
	$arSelect["SELECT"] = array('UF_*');
	$dbUsers = $cUser->GetList($sort_by, $sort_ord, $arFilter, $arSelect);
	$u = $dbUsers->Fetch(); 
		
	\Bitrix\Main\Loader::includeModule('redreams.partners');
	
	if ($u)
	{
		$man = new \Redreams\Partners\manager();
	
		if ($u["UF_MANAGER"]) $manager = $man->getlist(array('UF_XML_ID' => $u["UF_MANAGER"]))[0];
		if ($u["UF_MAIN_MANAGER"]) $mainManager = $man->getlist(array('UF_XML_ID' => $u["UF_MAIN_MANAGER"]))[0];
	}
	
	if ($manager || $mainManager) {
	?>
	<div class='pm_section'>
		<? if ($manager) { ?>
		<p class='ttl'>С Вами работает</p>
		<? 
		$fioArr = explode(" ", $manager["UF_FIO"]);
		unset($fioArr[2]);
		$newFio = implode(" ", $fioArr);
		?>
		<p><b><?=$newFio?></b></p>
		<? if ($manager['UF_PHOTO']) { ?>
			<? $imgFile = CFile::ResizeImageGet($manager['UF_PHOTO'], array('width'=>120, 'height'=>120), BX_RESIZE_IMAGE_EXACT, true);?>
			<img src="<?=$imgFile['src']?>">
		<? } ?>
			<p>Менеджер сопровождения<br>
			<span style="font-size:12px;">(оформление и консультации по заказам)</span>
		</p>
		<? if (substr($manager["UF_PHONE"], 0, 4) == 'доб.') $manager["UF_PHONE"] = '+7 (499) 500 00 01, '.$manager["UF_PHONE"];?>			
		<? if ($manager["UF_PHONE"]) { ?><p><b><? if ($manager["UF_WORKPHONE"]) { ?><?=$manager["UF_WORKPHONE"]?><br><? } ?><?=$manager["UF_PHONE"]?></b></p><? } ?>
		<? if ($manager["UF_EMAIL"]) { ?><a href='mailto:<?=$manager["UF_EMAIL"]?>' class='green_lnk'><?=$manager["UF_EMAIL"]?></a><? } ?>
		<? } ?>
		<? if ($mainManager) { ?>
		<p class='ttl'></p>
		<? 
		$fioArr = explode(" ", $mainManager["UF_FIO"]);
		unset($fioArr[2]);
		$newFio = implode(" ", $fioArr);
		?>
		<p><b><?=$newFio?></b></p>
			<? if ($mainManager['UF_PHOTO']) { ?>
				<? $imgFile = CFile::ResizeImageGet($mainManager['UF_PHOTO'], array('width'=>120, 'height'=>120), BX_RESIZE_IMAGE_EXACT, true);?>
				<img src="<?=$imgFile['src']?>">
			<? } ?>
			<p>Менеджер по развитию<br>
			<span style="font-size:12px;">(вопросы коммерческих условий и развития сотрудничества)</span>
		</p>
		<? if (substr($mainManager["UF_PHONE"], 0, 4) == 'доб.') $mainManager["UF_PHONE"] = '+7 (499) 500 00 01, '.$mainManager["UF_PHONE"];?>
		<? if ($mainManager["UF_PHONE"]) { ?><p><b><? if ($mainManager["UF_WORKPHONE"]) { ?><?=$mainManager["UF_WORKPHONE"]?><br><? } ?><?=$mainManager["UF_PHONE"]?></b></p><? } ?>
		<? if ($mainManager["UF_EMAIL"]) { ?><a href='mailto:<?=$mainManager["UF_EMAIL"]?>' class='green_lnk'><?=$mainManager["UF_EMAIL"]?></a><? } ?>
		<?/*<a href='' class='btn'>связаться с менеждером</a>*/?>
		<? } ?>
	</div>
	<?
	}
	?>
    <div class='pm_section add'>
        <form class="ADD2BASKET" action="ADD2BASKET">
            <p class='ttl'>Добавить товары в корзину</p>
            <div class='inp_wp row'>
                <input type='text' name="ATR" class='inp_self col-7' value='' placeholder='Введите артикул'>
                <input type='text' name="quantity" class='inp_self col-3' value='1'>
                <input type="hidden" name="action" value="ADD2BASKET">
                <p class="col-1">шт.</p>
            </div>
            <a href='' class='btn quick_basket'>Добавить в корзину</a>
            <a href='/catalog/' class='green_lnk'>Перейти в каталог продукции</a>
        </form>
    </div>
    <div class='pm_section'>
        <?/*<div class="disabled_pt"><div class="txt">Функционал появится в скором времени</div><div class="bg_wr"></div></div>*/?>
        <p class='ttl'>Скачайте приложения</p>
        <p>Партнерский кабинет всегда в кармане</p>
        <a href='https://itunes.apple.com/us/app/%D1%82%D0%B5%D1%80%D0%BC%D0%BE%D1%80%D0%BE%D1%81/id1314411160' target="_blank" class='app_lnk al1'><img src='<?=SITE_TEMPLATE_PATH?>/img/app1.png'></a>
        <a href='https://play.google.com/store/apps/details?id=com.termoros.termoros' target="_blank" class='app_lnk al2'><img src='<?=SITE_TEMPLATE_PATH?>/img/app2.png'></a>
    </div>

</div>
<?}?>