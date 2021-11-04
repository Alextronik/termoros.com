<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//p($arResult);
?>
<div class='main_slider'>
	<div class='container'>
        <ul class='slider_block'>
            <?
                foreach($arResult["BANNERS"] as $baner){
                    $file = CFile::ResizeImageGet($baner['IMAGE_ID'], array('width'=>1280, 'height'=>385), BX_RESIZE_IMAGE_EXACT, true);
                ?>
                    <li><img src="<?=$file['src']?>"></li>
                    <?
                }
            ?>

        </ul>
        <a href='' class='ms_prev'></a>
        <a href='' class='ms_next'></a>
	</div>
</div>
