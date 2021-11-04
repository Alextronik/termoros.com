<style>
    body .pm_midd {flex-wrap: wrap;
        align-items: flex-start;
        align-content: flex-start;}
</style>
<div class="partner_page">
<div class='partner_mainblock row'>
    <div class='pm_block pm_left col-12 col-md-3'>
		<? if(\Redreams\Partners\partner::isCurator()) { ?>
		<a href='operators/' class='btn_act'>Управление операторами</a>
		<? } ?>
		<a href='start/' class='btn_start'>С чего начать?</a>
		<a href='act/' class='btn_act'>Запросить акт сверки</a>

        <div class='pm_section'>
            <p class='ttl'>Мои данные</p>
            <p><?=$USER->GetEmail()?></p>
            <a href='/personal/profile/' class='green_lnk'>Изменить</a>
            <?php
            $APPLICATION->IncludeComponent('redreams:partner.contractors', '');
            ?>
            <?$ID = \CSaleOrder::GetList(['ID'=>'DESC'],['USER_ID'=>$USER->GetID()])->Fetch()['ID']?>
            <?if($ID):?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:sale.personal.order.detail",
                "partner_page",
                Array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "3600",
                    "CACHE_TYPE" => "A",
                    "COMPONENT_TEMPLATE" => ".default",
                    "CUSTOM_SELECT_PROPS" => array(""),
                    "ID" =>$ID,
                    "PATH_TO_CANCEL" => "",
                    "PATH_TO_LIST" => "",
                    "PATH_TO_PAYMENT" => "payment.php",
                    "PICTURE_HEIGHT" => "110",
                    "PICTURE_RESAMPLE_TYPE" => "1",
                    "PICTURE_WIDTH" => "110",
                    "PROP_1" => array(""),
                    "PROP_2" => array(""),
                    "PROP_3" => array(""),
                    "SET_TITLE" => "N"
                )
            );?>
            <?endif?>
        </div>

    </div>

    <div class='pm_midd col-12 col-md-6 px-3 d-flex'>

        <a href='/catalog/' class='pm_link pl1 col-12 col-md-4'>
            <div class='pm_wp'>
                <img src='<?=SITE_TEMPLATE_PATH?>/img/pl1.png' class='pl_ico'>
                сформировать<br/>заказ
            </div>
        </a>
        <a href='/technical_support/tech_documentation/' class='pm_link pl2 col-12 col-md-4'>
            <div class='pm_wp'>
                <img src='<?=SITE_TEMPLATE_PATH?>/img/pl2.png' class='pl_ico'>
                Техническая<br/>документация
            </div>
        </a>
        <a href='/buyers/prices/' class='pm_link pl3 col-12 col-md-4'>
            <div class='pm_wp'>
                <img src='<?=SITE_TEMPLATE_PATH?>/img/pl3.png' class='pl_ico'>
                прайс-листы
            </div>
        </a>
        <a href='/buyers/download_catalog/' class='pm_link pl4 col-12 col-md-4'>
            <div class='pm_wp'>
                <img src='<?=SITE_TEMPLATE_PATH?>/img/pl4.png' class='pl_ico'>
                скачать каталог
            </div>
        </a>
        <a href='/buyers/promotions/' class='pm_link pl5 col-12 col-md-4'>
            <div class='pm_wp'>
                <img src='<?=SITE_TEMPLATE_PATH?>/img/pl5.png' class='pl_ico'>
                акции
            </div>
        </a>
        <a href='/technical_support/training/' class='pm_link pl6 col-12 col-md-4'>
            <div class='pm_wp'>
                <img src='<?=SITE_TEMPLATE_PATH?>/img/pl6.png' class='pl_ico'>
                обучение
            </div>
        </a>
        <a class='pm_link pl7 col-12 col-md-4' href="/catalog/sales/" >
            <?/*<div class="disabled_pt"><div class="txt">Функционал появится в скором времени</div><div class="bg_wr"></div></div>*/?>
            <div class='pm_wp'>
                <img src='<?=SITE_TEMPLATE_PATH?>/img/pl7.png' class='pl_ico'>
                Распродажа
            </div>
        </a>
        <a href='/api/index.php' class='pm_link pl8 col-12 col-md-4'>
            <!--div class="disabled_pt"><div class="txt">API</div><div class="bg_wr"></div></div-->
            <div class='pm_wp'>
                <img src='<?=SITE_TEMPLATE_PATH?>/img/API.png' class='pl_ico'>
                Скачать каталог<br/>и персональные цены<br>в csv,xml & json
            </div>
        </a>
        <a class='pm_link pl9 col-12 col-md-4' href="/promotion_materials/">
            <div class='pm_wp'>
                <img src='<?=SITE_TEMPLATE_PATH?>/img/pl9.png' class='pl_ico'>
                рекламная<br/>поддержка
            </div>
        </a>

    </div>
    <?include($_SERVER['DOCUMENT_ROOT']."/include/partner_right.php")?>
    <?/*
	<div class='partner_credit_wp'>
        <div class="disabled_pt"><div class="txt">Функционал появится в скором времени</div><div class="bg_wr"></div></div>
        <div class='partner_credit'>
            <p class='ttl'>Кредитная информация</p>
            <div class='pc_block'>
                <span class='val min'>0</span>
                <span class='val max'>500 000</span>
                <div class='progress' style='width:70%;'>
                    <span class='value'>350 000</span>
                </div>
            </div>
            <span>руб.</span>
        </div>
        <div class='pc_summary'>
            <p><span>Кредитный лимит</span>500 000 руб.</p>
            <p><span>Использовано</span>350 000 руб.</p>
            <p><span>Свободный остаток</span>150 000 руб.</p>
            <p class='last'><span>Дата погашения</span>150 000 руб. /  23.09.2016</p>
        </div>
    </div>
	*/?>
	<?if (0 && $USER->GetID() == 191) { ?>
		<?
		\Bitrix\Main\Loader::includeModule('redreams.partners');
		$credit = new \Redreams\Partners\credit();
		
		$credits = $credit->getlist(array('UF_PARTNER' => $USER->GetID()));
		$credits = $credit->getlist(array('UF_PARTNER' => 1485));
		if ($credits) { 
			//$query->setSelect(['ID','UF_PARTNER','UF_CREDIT_OVERALL','UF_LIMIT_OVERALL','UF_PAYMENT_DATE','UF_CREDIT_SUM']);
			
			$totalSum = $credits[0]['UF_CREDIT_OVERALL'];
			$totalLimit = $credits[0]['UF_LIMIT_OVERALL'];
			
			if ($totalLimit < $totalSum) $totalLimit = $totalSum;
			
			foreach($credits as $credit)
			{
				
				if ($credit['UF_PAYMENT_DATE'])
				{
					$creditDateTimeArr = explode(" ", $credit['UF_PAYMENT_DATE']);
					$creditDate = $creditDateTimeArr[0];
					$credit['CREDIT_DATE'] = $creditDate;
					$creditDateArr = explode("-", $creditDate);
					
					$creditWidth = (int)$totalSum/$totalLimit * 100;
					
					
					
					$creditDateUnix = mktime(0,0,0, $creditDateArr[1], $creditDateArr[2]+1, $creditDateArr[0]);
					
					if (time() > $creditDateUnix)
					{
						$fails += $credit['UF_CREDIT_SUM'];
					}
					else
					{						
						$futureCredits[] = $credit;
					}
					
				}
				else
				{					
					$futureCredits[] = $credit;
				}
				
			}
			?>
			<div class='partner_credit_wp'>
				<div class='partner_credit'>
					<p class='ttl'>Кредитная информация</p>
					<div class='pc_block'>
						<span class='val min'>0</span>
						<span class='val max'><?=number_format($totalLimit, 2, ',', ' ')?></span>
						<div class='progress' style='width:<?=$creditWidth?>%;'>
							<span class='value'><?=number_format($totalSum, 2, ',', ' ')?></span>
						</div>
						<? if ($fails) { ?>
							<? $failsWidth = (int)$fails/$totalLimit * 100;?>
							
							<div class='progress' style='width:<?=$failsWidth?>%;background-color:#b03d1d;'>
								<span class='value' style="top:250%;color:#b03d1d;"><?=number_format($fails, 2, ',', ' ')?></span>
							</div>
						<? } ?>
					</div>
					<span>руб.</span>
				</div>
				<div class='pc_summary'>
					<?if ($fails) { ?><p class='last' style="color: #b03d1d;"><b><span>Просрочено!</span><?=number_format($fails, 2, ',', ' ')?> руб.</b></p><? } ?>
					<p><span>Кредитный лимит</span><?=number_format($totalLimit, 2, ',', ' ')?> руб.</p>
					<p><span>Использовано</span><?=number_format($totalSum, 2, ',', ' ')?> руб.</p>
					<p><span>Свободный остаток</span><?=number_format($totalLimit-$totalSum, 2, ',', ' ')?> руб.</p>
					
					<?if ($futureCredits) { ?>
					<p class='last'><span>Погашения: </span></p>
					<?foreach($futureCredits as $credit) { ?>
						<p><b style="color: #b03d1d;"><?=number_format($credit['UF_CREDIT_SUM'], 2, ',', ' ')?> руб.</b> /  <?=($credit['CREDIT_DATE'])?$credit['CREDIT_DATE']:'Дата не указана'?></p>
					<? } ?>
					<? } ?>
				</div>
			</div>
		<? } ?>
	<? } ?>
    <div class='clear'></div>
</div>

<div class='clear'></div>
<?/*
<div class='partner_ban'>
    <a href='/brands/gekon/'><img src='<?=SITE_TEMPLATE_PATH?>/img/partner_ban.jpg'></a>
</div>
*/?>
</div>