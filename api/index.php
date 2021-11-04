<?
define('LEFTBAR3', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<? /** @var TYPE_NAME $APPLICATION */
$APPLICATION->SetTitle("API");?>
<? \Bitrix\Main\Loader::includeModule('redreams.partners');
$xmlid = \Redreams\Partners\partner::getXMLID();
$file0 = "/bitrix/catalog_export/export_partners_prices.csv";
$file1 = "/bitrix/catalog_export/export_partners_full.csv";
$file2 = "/bitrix/catalog_export/export_all.xml";
$stat0 = stat($_SERVER['DOCUMENT_ROOT'].$file0);
$stat1 = stat($_SERVER['DOCUMENT_ROOT'].$file1);
$stat2 = stat($_SERVER['DOCUMENT_ROOT'].$file2);
$file0_size = get_size($stat0['size']);
$file1_size = get_size($stat1['size']);
$file2_size = get_size($stat2['size']);
if((\Redreams\Partners\partner::isPartner() && $xmlid) || $USER->IsAdmin()) {?>
        <style>
            body .partner_page .table-fields td{font-size:0.8rem!important;padding:0.4rem;line-height: unset;}
        </style>
    <div class="partner_page">
        <div class='partner_mainblock'>

            <div class='pm_midd' style="width: auto">
                <h2>Общая выгрузка каталога товаров:</h2>
                <hr>

                <p>Файл обновляется раз в сутки.<br>
                    Содержит краткую версию нашего каталога в <span class="red">csv (размер: <?=$file0_size?>, UTF-8, разделитель ";", первая строка - названия колонок)</span><br>
                    <br>Содержит поля: <br>
                    <table class="table table-striped table-sm table-bordered table-fields">
                        <tr><?//XML_ID	NAME	DETAIL_PAGE_URL	DETAIL_PICTURE	BRAND	ARTICLE	CATEGORY	QUANTITY_CENTRAL_WAREHOUSE	RETAIL_PRICE	RECOMMENDED_PRICE?>
                            <td>XML_ID</td><td>NAME</td><td>DETAIL_PAGE_URL</td><td>DETAIL_PICTURE</td><td>BRAND</td><td>ARTICLE</td><td>CATEGORY</td><td>QUANTITY_CENTRAL_WAREHOUSE</td><td>RETAIL_PRICE</td><td>RECOMMENDED_PRICE</td>
                        </tr>
                        <tr>
                            <td>GUID из 1С</td><td>Название</td><td>URL</td><td>Основная картинка</td><td>Бренд</td><td>Артикул</td><td>Категория в каталоге</td><td>Количество на центральном складе</td><td>Розничная цена</td><td>Рекомендованная цена</td>
                        </tr>
                    </table>



                    <a href="<?=$file0?>" download>https://<?=SITE_SERVER_NAME.$file0?></a>
                    <br><br>
                    Или полную версию, в которой также содержится большинство технических характеристик товаров, размер: <?=$file1_size?>:<br>
                    <a href="<?=$file1?>" download>https://<?=SITE_SERVER_NAME.$file1?></a>
                    <br><br>
                    Или вариат в ХМЛ - yml Яндекс.Маркет, размер: <?=$file2_size?>, с атрибутами <br><span class="red">available, url, price(РРЦ), currencyId(RUR),categoryId, picture, vendor, model</span><br>
                    <a href="<?=$file2?>" download>https://<?=SITE_SERVER_NAME.$file2?></a>
                </p>
                <br>
                <h2>Выгрузка с персональными ценами :</h2>
                <hr>
                <a href="/api/v0/getCSV.php?partner=<?=$xmlid?>&file=Y" target="_blank">https://www.termoros.com/api/v0/getCSV.php?partner=<?=$xmlid?>&file=Y</a>
                <p>Файл генерируется реалтайм за 10-15 секунд<br>
                    Содержит краткую версию нашего каталога в <span class="red">csv (UTF-8, разделитель ";", первая строка - названия колонок)</span><br>
                    <br>Содержит поля: <br>
                    <table class="table table-striped table-sm table-bordered table-fields">
                        <tr><?//XML_ID	NAME	DETAIL_PAGE_URL	DETAIL_PICTURE	BRAND	ARTICLE	CATEGORY	QUANTITY_CENTRAL_WAREHOUSE	RETAIL_PRICE	RECOMMENDED_PRICE?>
                            <td>XML_ID</td><td>NAME</td><td>DETAIL_PAGE_URL</td><td>DETAIL_PICTURE</td><td>BRAND</td><td>ARTICLE</td><td>CATEGORY</td><td>QUANTITY_CENTRAL_WAREHOUSE</td><td>RETAIL_PRICE</td><td>RECOMMENDED_PRICE</td><td>PERSONAL_PRICE</td>
                        </tr>
                        <tr>
                            <td>GUID из 1С</td><td>Название</td><td>URL</td><td>Основная картинка</td><td>Бренд</td><td>Артикул</td><td>Категория в каталоге</td><td>Количество на центральном складе</td><td>Розничная цена</td><td>Рекомендованная цена</td><td>Персональная цена</td>
                        </tr>
                    </table>
                    Также можно использовате GET или POST запрос для получения в формате json с параметрами json=Y и partner,<br>
                    равным Вашему уникальному идентификатору партнера = <span class="red"><?=$xmlid?></span><br>
                    например GET = <a href="/api/v0/getCSV.php?partner=<?=$xmlid?>&json=Y" target="_blank">https://www.termoros.com/api/v0/getCSV.php?partner=<?=$xmlid?>&json=Y</a>
                </p>
            </div>
        </div>
    </div>

<?}else LocalRedirect("/");?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
