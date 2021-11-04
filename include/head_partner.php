<?
\Bitrix\Main\Loader::includeModule('redreams.partners');
$arResult['CNT'] = \CSaleOrder::GetList([],['USER_ID'=>$USER->GetID()])->SelectedRowsCount();
?>
<?if(\Redreams\Partners\partner::isPartner()):?>
    <div class="head_partner">
        <div class="container">
            <div class="row align-items-center">
                <div class="username col-12 col-md-2"><a href="">Здравствуйте,<br> <?=resize_str($USER->GetFullName(),20,false)?>!</a><span>|</span><a href="/?logout=yes" class="logout">Выйти</a></div>

                <a href="/personal/profile/" class="my_i col-4 col-md-2">Мои данные</a>


                <div class="col-12 col-md-4 hm"><?php $APPLICATION->IncludeComponent('redreams:partner.contractors','head');?></div>


                <a href="/personal/order/" class="my_orders col-4 col-md-2">Мои заказы<span><?=$arResult['CNT']?></span></a>



                <a href="/personal/addr/" class="my_address col-4 col-md-2">Мои адреса</a>
            </div>
        </div><!-- .container-->
    </div>
<?endif?>
