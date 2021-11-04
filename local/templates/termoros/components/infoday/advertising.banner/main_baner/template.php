<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Conversion\Internals\MobileDetect;
$detect = new MobileDetect;
/** @var TYPE_NAME $arResult */
foreach($arResult["BANNERS"] as $banner) {
	$bannerWeights[$banner["WEIGHT"]][] = $banner;
}
//p($arResult);
?>
<div class='main_slider container'>
	<div class='row'>
        <div class="col-12 col-md-9 offset-md-3 ms_block">
            <ul class='slider_block'>
                <?
                foreach($bannerWeights as $banerArr){
                    shuffle($banerArr);
                    foreach($banerArr as $baner){
                        if($detect->isMobile())
                        {
                            $file = CFile::ResizeImageGet($baner['IMAGE_ID'], array('width'=>640, 'height'=>192), BX_RESIZE_IMAGE_EXACT, true);
                        }else
                            $file = CFile::ResizeImageGet($baner['IMAGE_ID'], array('width'=>1280, 'height'=>385), BX_RESIZE_IMAGE_EXACT, true);
                        ?>
                        <li>
                            <a href="<?=$baner['URL']?>?id=<?=$baner['ID']?>&event1=<?=$baner['STAT_EVENT_1']?>&event2=<?=$baner['STAT_EVENT_2']?>&event3=<?=$baner['CONTRACT_ID']?>+/+[<?=$baner['ID']?>]+[<?=$baner['TYPE_SID']?>]+<?=str_replace(" ", "+", $baner['NAME'])?>" >
                                <img class="img lozad" data-src="<?=$file['src']?>" src="<?=$file['src']?>"  alt='' />
                            </a>
                            <!--a href="/bitrix/rk.php?id=<?=$baner['ID']?>&event1=<?=$baner['STAT_EVENT_1']?>&event2=<?=$baner['STAT_EVENT_2']?>&event3=<?=$baner['CONTRACT_ID']?>+/+[<?=$baner['ID']?>]+[<?=$baner['TYPE_SID']?>]+<?=str_replace(" ", "+", $baner['NAME'])?>&goto=<?=urlencode($baner['URL'])?>" >
                                <img class="img lozad" data-src="<?=$file['src']?>" src="<?=$file['src']?>"  alt='' />
                            </a-->
                        </li>
                        <?
                    }
                }
                ?>

            </ul>
            <?if(count($arResult["BANNERS"]) > 1):?>
                <a href='' class='ms_prev cent'></a>
                <a href='' class='ms_next cent'></a>
            <?endif;?>
        </div>
	</div>
</div>
