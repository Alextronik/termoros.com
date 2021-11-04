<?
require(dirname(__FILE__) . "/events.php");
require(dirname(__FILE__) . "/agents.php");
include_once(dirname(__FILE__) . "/include/search.php");
require($_SERVER['DOCUMENT_ROOT'] . "/local/classes/loader.php");
\Bitrix\Main\Loader::includeModule('redreams.partners');


if($_SERVER['HOME'] !== '/home/tmrsite') define("SITE_PROD",true);


//Костыли... Не захотели в 1С хранить инфу.
$extraTextInItem = 'Действует акция, подробности уточняйте у менеджеров';
$extraTextItemArr = array(
    'TWIN ALPHA 13',
    'TWIN ALPHA 16',
    'TWIN ALPHA 20',
    'TWIN ALPHA 25',
    'TWIN ALPHA 30',
    'TWIN ALPHA 30R',
);
// используется в section
function checkCDEKallow($arItem)
{
    if ($arItem[208]["QUANTS"] > 0)
    {
        if ($arItem["PROPERTIES"]["CML2_TRAITS"]["DESCRIPTION"])
        {
            foreach($arItem["PROPERTIES"]["CML2_TRAITS"]["DESCRIPTION"] as $k => $v)
            {
                if ($arItem["PROPERTIES"]["CML2_TRAITS"]["VALUE"][$k])
                {

                    $traitsCDEK[$arItem["PROPERTIES"]["CML2_TRAITS"]["DESCRIPTION"][$k]] = $arItem["PROPERTIES"]["CML2_TRAITS"]["VALUE"][$k];
                }
            }
        }

        $weight = $traitsCDEK["Вес, кг"];
        $width = round($traitsCDEK["Ширина, м"]*100, 0);
        $height = round($traitsCDEK["Высота, м"]*100, 0);
        $length = round($traitsCDEK["Глубина, м"]*100, 0);

        if ($weight > 0 && $width > 0 && $height > 0 && $length > 0 )
        {
            return true;
        }
    }

    return false;
}


function resendFailureEmail()
{
    global $DB;
    $results = $DB->Query("UPDATE b_event SET SUCCESS_EXEC = 'N' WHERE SUCCESS_EXEC = 'F' AND DATE_INSERT > '".date("Y-m-d H:i:s", time() - 60*60*5)."' LIMIT 50");
    return "resendFailureEmail();";
}


function v($a)
{
    global $USER;
    if ($USER->IsAdmin() || $USER->GetID() == 191)
    {
        var_dump($a);
    }
}

/** convert to utf-8 or cp1251
 * @param $text
 * @param bool $cod
 * @return string
 */
function ct($text,$cod = true){
    $code = ($cod) ? 'utf-8' : 'cp1251';
    return mb_convert_encoding($text, $code, mb_detect_encoding($text));
}

function get_size( $bytes )
{
    if ( $bytes < 1000 * 1024 ) {
        return number_format( $bytes / 1024, 2 ) . " KB";
    }
    elseif ( $bytes < 1000 * 1048576 ) {
        return number_format( $bytes / 1048576, 2 ) . " MB";
    }
    elseif ( $bytes < 1000 * 1073741824 ) {
        return number_format( $bytes / 1073741824, 2 ) . " GB";
    }
    else {
        return number_format( $bytes / 1099511627776, 2 ) . " TB";
    }
}
// convert "," to "." in number
function toNumber($target){
    $switched = str_replace(',', '.', $target);
    if(is_numeric($target)){
        return intval($target);
    }elseif(is_numeric($switched)){
        return floatval($switched);
    } else {
        return $target;
    }
}

function isMob()
{
    //v($_COOKIE);
    $result = false;

    if($_COOKIE['IS_MOBILE'] == true){
        return $result = true;
    }
    if(empty($_COOKIE['IS_MOBILE'])){
        $detect = new \Bitrix\Conversion\Internals\MobileDetect;
        if($detect->isMobile()) {
            setcookie("IS_MOBILE", 1,time()+3600);
            $result = true;
        }
    }
    return $result;
}

// Закрываем службу доставки CDEK, если товара нет в наличии в Москве.

AddEventHandler('ipol.sdek', 'onCompabilityBefore', 'onCompabilityBeforeSDEK'); //подписываемся на событие
function onCompabilityBeforeSDEK($order, $conf, $keys) {
    //функция, где $order - данные о заказе, $conf - настройки доставки, $keys - коды профилей доставки, которые будут выбраны
    //AddMessage2Log($order);

    if(!cmodule::includeModule('iblock')) return;
    if(!cmodule::includeModule('catalog')) return;
    if(!cmodule::includeModule('sale')) return;

    $profile = array('pickup', 'courier'); //профиль, который оставим: pickup - самовывоз, courier - курьер

    foreach($order['ITEMS'] as $item)
    {
        //get CML2_ARTICLE
        $res = CIBlockElement::GetPropertyValues(4, array('ACTIVE' => 'Y', "ID" => $item['PRODUCT_ID']), true, array('ID' => array("421")));
        $ar = $res->GetNext();
        $article = $ar[421];

        //get TIP_SKLADSKOGO_ZAPASA
        /*
        $res = CIBlockElement::GetPropertyValues(4, array('ACTIVE' => 'Y', "ID" => $item['PRODUCT_ID']), true, array('ID' => array("650")));
        $ar = $res->GetNext();
        if ($ar[650] != 8357 && substr($article,0,9) != 'EU.ST3092')
        {
            return false;
        }*/

        $prodIds[] = $item['PRODUCT_ID'];
    }

    if ($prodIds)
    {
        $storeId = 208; //Москва
        $rsStore = CCatalogStoreProduct::GetList(array(), array('PRODUCT_ID' => $prodIds, 'STORE_ID' => $storeId), false, false, array('PRODUCT_ID', 'STORE_ID', 'STORE_NAME', 'AMOUNT'));
        while($arStore = $rsStore->Fetch())
        {
            //AddMessage2Log($arStore);
            $prodAmounts[$arStore['PRODUCT_ID']] = $arStore['AMOUNT'];
            if ($arStore['AMOUNT'] < 1)
            {
                return false;
            }
        }
    }
    foreach($order['ITEMS'] as $item)
    {
        if ($item["QUANTITY"] > $prodAmounts[$item['PRODUCT_ID']])
        {
            return false;
        }
    }

    return $profile;
}

AddEventHandler('ipol.sdek', 'onBeforeDimensionsCount', 'handleGoods');
function handleGoods(&$arOrderGoods){

    if(!CModule::includeModule('iblock')) return;

    foreach($arOrderGoods as $key => $arGood){
        //$elt = CIBlockElement::GetList(array(),array('ID'=>$arGood['PRODUCT_ID']),false,false,array('ID','PROPERTY_CML2_TRAITS'))->Fetch();
        // get CML2_TRAITS
        $res = CIBlockElement::GetPropertyValues(4, array('ACTIVE' => 'Y', "ID" => $arGood['PRODUCT_ID']), true, array('ID' => 943));
        while ($row = $res->GetNext())
        {
            foreach($row["DESCRIPTION"][943] as $k => $v)
            {
                if ($v == 'Ширина, м') $width = $row[943][$k];
                if ($v == 'Высота, м') $height = $row[943][$k];
                if ($v == 'Глубина, м') $length = $row[943][$k];
                if ($v == 'Вес, кг') $weight = $row[943][$k];
            }
        }

        if ($width) $width *= 1000;
        if ($height) $height *= 1000;
        if ($length) $length *= 1000;
        if ($weight) $weight *= 1000;

        if($width && $height && $length && $weight){
            $arOrderGoods[$key]['DIMENSIONS'] = array(
                "LENGTH" => (int)$width,
                "WIDTH"  => (int)$length,
                "HEIGHT" => (int)$height,
            );

            $arOrderGoods[$key]['WEIGHT'] = (int)$weight;

        }

        //AddMessage2Log($arOrderGoods);
    }
}



function SetGeoIp(){

    CModule::IncludeModule("iblock");
    CModule::IncludeModule("main");
    CModule::IncludeModule("sale");

    if (!$_SESSION['STORES'] || count($_SESSION['STORES']) < 5)
    {
        //v(123);
        $res = \Bitrix\Sale\Location\LocationTable::getList(array(
            'filter' => array("!CITY_ID" => false),
            'select' => array('*', 'NAME_RU' => 'NAME.NAME', )
        ));
        while($item = $res->fetch())
        {
            $arCityIds[$item['NAME_RU']] = $item['ID'];
            $arCityNames[$item['ID']] = $item['NAME_RU'];
        }

        ksort($arCityIds);

        CModule::IncludeModule("catalog");

        $arSelect = Array('ID', 'TITLE');
        $arFilter = Array('ACTIVE'=>'Y');
        $res = CCatalogStore::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->GetNext())
        {
            //p($ob);
            preg_match('/\((.+)\)/', $ob['TITLE'], $rpl);
            if($rpl[1] == 'СПб') $rpl[1] = 'Санкт-Петербург';
            //$arStores[$rpl[1]] = array("ID" => $ob['ID'], "CITY_ID" => $_SESSION['GEOIP']['city_list'][$rpl[1]], 'STORE_NAME' => $rpl[1]);
            $arStores[$rpl[1]] = array("ID" => $ob['ID'], "CITY_ID" => $arCityIds[$rpl[1]], 'STORE_NAME' => $rpl[1]);
        }
        $_SESSION['STORES'] = $arStores;
    }

    if(CModule::IncludeModule("altasib.geoip")){
        if (!$_SESSION['GEOIP'])
        {
            $arData = ALX_GeoIP::GetAddr();
        }

        if (!$_SESSION['GEOIP']['city']) $_SESSION['GEOIP']['city'] = 'Москва';


        global $USER;
        if ($USER->GetID())
        {
            $rsUser = CUser::GetList(($by="ID"), ($order="desc"), array("ID"=>$USER->GetID()),array("SELECT"=>array("UF_*")));
            $arUser = $rsUser->Fetch();
        }
        /*
        $res = \Bitrix\Sale\Location\LocationTable::getList(array(
            'filter' => array("!CITY_ID" => false),
            'select' => array('*', 'NAME_RU' => 'NAME.NAME', )
        ));
        while($item = $res->fetch())
        {
            $arCityIds[$item['NAME_RU']] = $item['ID'];
            $arCityNames[$item['ID']] = $item['NAME_RU'];
        }

        ksort($arCityIds);
        */

        if(!$_SESSION['GEOIP']['curr_city_id'] || !$_SESSION['GEOIP']['curr_city_name'])
        {
            $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                'filter' => array("!CITY_ID" => false),
                'select' => array('*', 'NAME_RU' => 'NAME.NAME', )
            ));
            while($item = $res->fetch())
            {
                $arCityIds[$item['NAME_RU']] = $item['ID'];
                $arCityNames[$item['ID']] = $item['NAME_RU'];
            }

            ksort($arCityIds);

            $_SESSION['GEOIP']['curr_city_id'] = $arCityIds[$_SESSION['GEOIP']['city']];
            $_SESSION['GEOIP']['curr_city_name'] = $arCityNames[$_SESSION['GEOIP']['curr_city_id']];
        }

        if ($_SESSION['GEOIP']["inetnum"]) unset($_SESSION['GEOIP']["inetnum"]);
        //if ($_SESSION['GEOIP']["country"]) unset($_SESSION['GEOIP']["country"]);
        //if ($_SESSION['GEOIP']["region"]) unset($_SESSION['GEOIP']["region"]);
        //if ($_SESSION['GEOIP']["district"]) unset($_SESSION['GEOIP']["district"]);
        if ($_SESSION['GEOIP']["lat"]) unset($_SESSION['GEOIP']["lat"]);
        if ($_SESSION['GEOIP']["lng"]) unset($_SESSION['GEOIP']["lng"]);
        if ($_SESSION['GEOIP']["lng"]) unset($_SESSION['GEOIP']["lng"]);

        if ($arUser['UF_GEO'] && ($_SESSION['GEOIP']['curr_city_id'] != $arUser['UF_GEO'] || ($_SESSION['GEOIP']['curr_city_id'] == $arUser['UF_GEO'] && $_SESSION['GEOIP']['curr_city_id'] != 129 && $_SESSION['GEOIP']['curr_city_name'] == 'Москва')))
        {
            $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                'filter' => array("!CITY_ID" => false),
                'select' => array('*', 'NAME_RU' => 'NAME.NAME', )
            ));
            while($item = $res->fetch())
            {
                $arCityIds[$item['NAME_RU']] = $item['ID'];
                $arCityNames[$item['ID']] = $item['NAME_RU'];
            }

            ksort($arCityIds);

            $_SESSION['GEOIP']['curr_city_id'] = $arUser['UF_GEO'];
            $_SESSION['GEOIP']['curr_city_name'] = $arCityNames[$_SESSION['GEOIP']['curr_city_id']];
        }

        if (!$_SESSION['GEOIP']['curr_city_id']) $_SESSION['GEOIP']['curr_city_id'] = 129;
        if (!$_SESSION['GEOIP']['curr_city_name']) $_SESSION['GEOIP']['curr_city_name'] = 'Москва';


        if(!$_SESSION['GEOIP']['curr_phones']){
            $arSelect = Array('IBLOCK_ID','NAME','ID');
            $arFilter = Array("IBLOCK_ID"=>23, "ACTIVE"=>"Y", "NAME" => $_SESSION['GEOIP']['curr_city_name']);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageCount"=>1), $arSelect);
            while($ob = $res->GetNextElement())
            {
                //p($ob->GetProperty('PHONE'));
                $arPhones = $ob->GetProperty('PHONE');
                //$arOblparts = $ob->GetProperty('OBLPARTS');

                if($arPhones['VALUE'])
                    $_SESSION['GEOIP']['curr_phones'] = $arPhones['VALUE'];
                else
                    $_SESSION['GEOIP']['curr_phones'] = array();
            }
        }



        //region detected
        if(!$_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]){


            $reg = \Bitrix\Sale\Location\LocationTable::getList(array(
                'filter' => array(
                    '=ID' => array($_SESSION['GEOIP']['curr_city_id']),
                    '=PARENT.NAME.LANGUAGE_ID' => LANGUAGE_ID,
                    '=PARENT.TYPE.NAME.LANGUAGE_ID' => LANGUAGE_ID,
                ),
                'select' => array(
                    'NAME_RU' => 'PARENT.NAME.NAME',
                    'TYPE_CODE' => 'PARENT.TYPE.CODE',
                    'PARENT_ID',
                )
            ));
            while($itemreg = $reg->fetch())
            {
                //p($itemreg);

                $currRegion = $itemreg['NAME_RU'];

                if ($itemreg["TYPE_CODE"] == 'SUBREGION')
                {
                    $rez = \Bitrix\Sale\Location\LocationTable::getList(array(
                            'filter' => array(
                                '=ID' => array($itemreg["PARENT_ID"]),
                                '=PARENT.NAME.LANGUAGE_ID' => LANGUAGE_ID,
                                '=PARENT.TYPE.NAME.LANGUAGE_ID' => LANGUAGE_ID,
                            ),
                            'select' => array(
                                'NAME_RU' => 'PARENT.NAME.NAME',
                                'TYPE_CODE' => 'PARENT.TYPE.CODE',
                            )
                        )
                    );
                    while($region = $rez->fetch())
                    {
                        $currRegion = $region['NAME_RU'];

                    }
                }
            }

            //p($currRegion);
            if($currRegion){
                //p($currRegion);
                $arSelect = Array('IBLOCK_ID','NAME','ID');
                $arFilter = Array("IBLOCK_ID"=>23, "ACTIVE"=>"Y", "PROPERTY_OBLPARTS" => $currRegion);
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageCount"=>1), $arSelect);
                while($ob = $res->GetNextElement())
                {
                    $arCity = $ob->GetFields();

                    if($_SESSION['STORES'][$arCity['NAME']]){
                        $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']] = $_SESSION['STORES'][$arCity['NAME']];
                        $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['STORE_NAME'] = $arCity['NAME'];
                        $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['SKIP'] = TRUE;
                    }
                }
            }

            //p($_SESSION['STORES']);
        }



    }else{
        echo 'geoip module error';
    }
}

function getSections($IBLOCK_ID, $sort=false, $extFilter=false){
    CModule::IncludeModule("iblock");

    if($sort){
        $by = $sort;
        $order = 'asc';
    }
    $arFilter = Array('IBLOCK_ID'=>$IBLOCK_ID, 'GLOBAL_ACTIVE'=>'Y', "ACTIVE" => 'Y');
    if ($extFilter) $arFilter = array_merge($arFilter, $extFilter);
    $db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true);
    while($item = $db_list->fetch())
    {
        //p($item);
        $result[$item['NAME']] = $item['ID'];
    }



    if($result[$_SESSION['GEOIP']['curr_city_name']])
        $result['CURRENTCITY_ID'] = $result[$_SESSION['GEOIP']['curr_city_name']];

    //p($result);

    return $result;
}

//CAgent::AddAgent("flagNew();");
function flagNew(){
    //AddMessage2Log("Агент tyt");
    CModule::IncludeModule('iblock');

    $arSelect = Array("ID", "NAME", "ACTIVE", "PROPERTY_NOVINKA", "PROPERTY_NEW_TOV");
    $arFilter = Array("IBLOCK_ID" => 4, "ACTIVE" => "Y", "!PROPERTY_NOVINKA" => false);
    $res = CIBlockElement::GetList(Array("NAME" => "ASC"), $arFilter, false, array(), $arSelect);//array("nTopCount" => 1000)

    while($data = $res->GetNext()){
        //p(strtotime($data['PROPERTY_NOVINKA_VALUE']));
        //p(strtotime('-6 month'));
        //p($data['PROPERTY_NEW_TOV_VALUE']);
        if(strtotime('-6 month') < strtotime($data['PROPERTY_NOVINKA_VALUE']) && $data['PROPERTY_NEW_TOV_VALUE'] != 'Y'){
            CIBlockElement::SetPropertyValuesEx($data['ID'], 4, array("NEW_TOV" => 7796));
            echo "upd: set" . $data['ID'];
        }elseif(strtotime('-6 month') > strtotime($data['PROPERTY_NOVINKA_VALUE']) && $data['PROPERTY_NEW_TOV_VALUE'] == 'Y'){
            CIBlockElement::SetPropertyValuesEx($data['ID'], 4, array("NEW_TOV" => false));
            echo "upd: unset" . $data['ID'];
        }
    }

    return 'flagNew();';
}


function p($a) {
    global $USER;

    if($USER->isAdmin() || $USER->GetID() == 191){
        var_dump($a);
    }
}
function is_ajax(){
    if($_REQUEST['ajax']=='y'||$_REQUEST['ajax']=='Y'){
        return true;
    }
    return false;
}

function resize_str($str, $size, $easy = false, $end_str = '...') {
    $str = strip_tags($str);
    if (strlen($str) > $size) {
        if ($easy == true) {
            $str = substr($str, 0, $size) . $end_str;
        } else {
            $tmp_str = substr($str,0,$size + 1);
            if (substr($tmp_str, -1) != ' ') {
                $tmp_str = substr($str, 0, $size);
                $tmp_str = substr($str, 0, strrpos($tmp_str, ' '));
                if ($tmp_str == '') {
                    $tmp_str = substr($str, 0, $size) . $end_str;
                } else {
                    $tmp_str .= $end_str;
                }
            } else {
                $tmp_str = substr($str, 0, $size) . $end_str;
            }
            $str = $tmp_str;
        }
    }
    return $str;
}

function ajax_start(){
    global $APPLICATION;
    $APPLICATION->RestartBuffer();
}

function ajax_end(){
    die();
}


function add2fav($ID)
{
    global $USER;

    $arFav = array();

    if($USER->isAuthorized())
    {
        $arFav = getFav();
        if(!is_array($arFav))
        {
            $arFav = array();
        }

        if(!in_array($ID,$arFav))
        {
            $user = new CUser;

            $arFav[] = $ID;

            $fields = Array(
                "UF_FAV" =>serialize($arFav),
            );

            $user->Update($USER->GetID(), $fields);
        }
    }
    else
    {
        if($_SESSION['fav'])
        {
            $arFav = unserialize($_SESSION['fav']);
        }

        if(!is_array($arFav))
        {
            $arFav = array();
        }



        $arFav[] = $ID;

        //print_r($arFav);

        $_SESSION['fav'] = serialize($arFav);
    }

}

function removeFromFav($ID)
{
    global $USER;
    $arFav = array();

    if($USER->isAuthorized())
    {
        $arFav = getFav();
        if(!is_array($arFav))
        {
            $arFav = array();
        }

        if(in_array($ID,$arFav))
        {
            foreach($arFav as $k => $v)
            {
                if($ID==$v)
                {
                    unset($arFav[$k]);
                }
            }

            $user = new CUser;
            //$arFav[] = $ID;
            $fields = Array(
                "UF_FAV" =>serialize($arFav),
            );
            $user->Update($USER->GetID(), $fields);
        }
    }
    else
    {
        if($_SESSION['fav'])
        {
            $arFav = unserialize($_SESSION['fav']);
        }

        foreach($arFav as $k => $v)
        {
            if($ID==$v)
            {
                unset($arFav[$k]);
            }
        }

        $_SESSION['fav'] = serialize($arFav);
    }
}

function getFav()
{
    global $USER;
    if($USER->isAuthorized())
    {
        $rsUser = CUser::GetList(($by="ID"), ($order="desc"), array("ID"=>$USER->GetID()),array("SELECT"=>array("UF_*")));
        while ($arUser = $rsUser->Fetch())
        {


            if($arUser["UF_FAV"]||$_SESSION['fav'])
            {


                if(is_array(unserialize($arUser["UF_FAV"]))||$_SESSION['fav'])
                {

                    if($_SESSION['fav']){

                        $arProp = array();
                        if($arUser["UF_FAV"])
                            $arProp = unserialize($arUser["UF_FAV"]);

                        $arSess = unserialize($_SESSION['fav']);
                        return array_merge($arSess, $arProp);
                    }else{
                        return unserialize($arUser["UF_FAV"]);
                    }
                }
                else
                {
                    return array();
                }

            }
            else
            {
                return array();
            }
        }
    }
    else
    {
        if($_SESSION['fav'])
        {
            return unserialize($_SESSION['fav']);
        }
        return array();
    }
}

function getDelayOrders(){
    global $USER;
    if($USER->isAuthorized())
    {
        $rsUser = CUser::GetList(($by="ID"), ($order="desc"), array("ID"=>$USER->GetID()),array("SELECT"=>array("UF_*")));
        while ($arUser = $rsUser->Fetch())
        {
            if($arUser["UF_ORDS"])
            {
                return unserialize($arUser["UF_ORDS"]);
            }
        }
    }
}



function resize($id, $width, $height, $met = 3, $water=false){
    $props = array('1' => BX_RESIZE_IMAGE_PROPORTIONAL_ALT, '2'=> BX_RESIZE_IMAGE_PROPORTIONAL, '3' => BX_RESIZE_IMAGE_EXACT);
    $resizemethod = $props[$met];

    if($water){
        $arFilters = Array(array("name" => "watermark", "alpha_level"=> "100", "position" => "bottomcenter", "size"=>"real", "file"=>$_SERVER['DOCUMENT_ROOT']."/bitrix/templates/electrodus/img/watermark.png"));
        $file = CFile::ResizeImageGet($id, array('width'=> $width, 'height'=> $height), $resizemethod, true, $arFilters);

    }else
        $file = CFile::ResizeImageGet($id, array('width'=> $width, 'height'=> $height), $resizemethod, true, array("name" => "sharpen", "precision" => 15), false, false);


    return $file['src'];
}


function my_onBeforeResultAdd($WEB_FORM_ID, $arFields, &$arrVALUES)
{
    global $APPLICATION;

    if ($_REQUEST['policy_required'] && !$_REQUEST['policy_agree'])
    {
        $APPLICATION->ThrowException('Данные не могут быть отправлены, т.к. вы не согласны с условиями обработки данных', 'policy');
    }


    if ($WEB_FORM_ID == 1)
    {
        if($_SESSION['uploaded_file'])
        {
            $arFile = CFile::MakeFileArray($_SESSION['uploaded_file']);
            $arrVALUES["form_file_6"] = $arFile;
            unset($_SESSION['uploaded_file']);
            unset($_SESSION['uploaded_file_name']);
        }
        else
        {		// если значение не подходит - отправим ошибку.
            //$APPLICATION->ThrowException('FILE');
        }
    }

    if ($WEB_FORM_ID == 5)
    {
        if($_SESSION['uploaded_file'])
        {
            $arFile = CFile::MakeFileArray($_SESSION['uploaded_file']);
            $arrVALUES["form_file_56"] = $arFile;
            unset($_SESSION['uploaded_file']);
            unset($_SESSION['uploaded_file_name']);
        }
        else
        {		// если значение не подходит - отправим ошибку.
            //$APPLICATION->ThrowException('FILE');
        }
    }

    if ($WEB_FORM_ID == 7)
    {
        if($_SESSION['uploaded_file'])
        {
            $arFile = CFile::MakeFileArray($_SESSION['uploaded_file']);
            $arrVALUES["form_file_65"] = $arFile;
            unset($_SESSION['uploaded_file']);
            unset($_SESSION['uploaded_file_name']);
        }
        else
        {		// если значение не подходит - отправим ошибку.
            //$APPLICATION->ThrowException('FILE');
        }
    }

}

AddEventHandler("main", "OnBeforeUserRegister", Array("regfunc", "OnBeforeUserRegisterHandler"));
class regfunc
{
    function OnBeforeUserRegisterHandler(&$arFields)
    {
        $arFields["EMAIL"] = $arFields["LOGIN"];
    }
}


AddEventHandler('form', 'onBeforeResultAdd', 'my_onBeforeResultAdd');

AddEventHandler('sale', 'OnSaleStatusOrder', 'my_onOrderStatusChange');
function my_onOrderStatusChange($ID, $STATUS)
{

    CModule::IncludeModule('main');
    CModule::IncludeModule('sale');
    CModule::IncludeModule('catalog');

    if ($ID)
    {
        $order = CSaleOrder::GetByID($ID);
        $ps = '';
    }

    //Можно оплатить заказ
    if ($order["PAY_SYSTEM_ID"] == 15 && $STATUS != 'N' && $STATUS != 'CA' && $STATUS == 'FF' && $order["PAYED"] != "Y" && $ID)
    {
        $arUpdateOrderFields = false;

        //if ($order["ID_1C"] && substr($order["ID_1C"], 0, 2) == 'ГВ')
        //{
        $arUpdateOrderFields = array(
            "PAY_SYSTEM_ID" => 15,
        );
        //}

        /*if ($order["ID_1C"] && substr($order["ID_1C"], 0, 2) == 'ТД')
        {
            $arUpdateOrderFields = array(
                "PAY_SYSTEM_ID" => 14,
            );
        }*/
        if ($arUpdateOrderFields)
        {
            CSaleOrder::Update($order["ID"], $arUpdateOrderFields);
        }

        $rsUser = CUser::GetByID($order["USER_ID"]);
        $arUser = $rsUser->Fetch();


        $fields = array(
            "ORDER_ID" => $ID,
            "EMAIL" => $arUser["EMAIL"],
            "TEXT" => $ID.'-'.$STATUS.' - '.$order["PAY_SYSTEM_ID"].' - '.$ps
        );
        CEvent::Send("SALE_ORDER_STATUS_CHANGE_EVENT", "s1", $fields);
    }

    //Заказ оплачен
    if (($order["PAY_SYSTEM_ID"] == 14 || $order["PAY_SYSTEM_ID"] == 15) && $STATUS == 'CA' && $order["EXTERNAL_ORDER"] != "Y")
    {

        if ($_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]["ID"])
        {
            $arSelect = Array('ID', 'TITLE', 'EMAIL');
            $arFilter = Array('ACTIVE'=>'Y', 'ID' => $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]["ID"]);
            $dbRes = CCatalogStore::GetList(Array(), $arFilter, false, Array(), $arSelect);
            $arStore = $dbRes->GetNext();
            if ($arStore && $arStore['EMAIL'])
            {
                $storeEmail = $arStore['EMAIL'];
            }
        }

        $rsUser = CUser::GetByID($order["USER_ID"]);
        $arUser = $rsUser->Fetch();

        $email = 'site@termoros.com';
        if ($storeEmail) $email = $storeEmail;
        $copyEmail = 'site@termoros.com,kovalenko@termoros.com';

        if ($order['DELIVERY_ID'] == 'sdek:pickup' || $order['DELIVERY_ID'] == 'sdek:courier')
        {
            $email = 'anisimov@termoros.com,kovalenko@termoros.com';
        }

        $fields = array(
            "ORDER_ID" => $ID,
            "EMAIL" => $email,
            "EMAIL_COPY" => $copyEmail,
            "TEXT" => $ID.'-'.$STATUS.' - '.$order["PAY_SYSTEM_ID"].' - '.$ps
        );
        CEvent::Send("SALE_ORDER_STATUS_CHANGE_EVENT_PAY", "s1", $fields);
    }

    //Заказ оплачен
    if (($order["PAY_SYSTEM_ID"] == 14 || $order["PAY_SYSTEM_ID"] == 15) && $STATUS == 'CA' && $order["EXTERNAL_ORDER"] == "Y")
    {

        $email = 'site@termoros.com';
        $copyEmail = '';

        $fields = array(
            "ORDER_ID" => $ID,
            "EMAIL" => $email,
            "EMAIL_COPY" => $copyEmail,
            "TEXT" => $ID.'-'.$STATUS.' - '.$order["PAY_SYSTEM_ID"].' - '.$ps
        );

        CEvent::Send("SALE_ORDER_STATUS_CHANGE_EVENT_PAY", "s1", $fields);

    }

    if ($STATUS == 'FF' && $ID)
    {
        //Письмо партнерам, что счет готов
        if ($order["PAY_SYSTEM_ID"] == 1 && $order["EXTERNAL_ORDER"] != "Y")
        {

            $rsUser = CUser::GetByID($order["USER_ID"]);
            $arUser = $rsUser->Fetch();

            $arGroups = CUser::GetUserGroup($order["USER_ID"]);
            if ($arUser["XML_ID"] && in_array(11 ,$arGroups))
            {
                $fields = array(
                    "ORDER_ID" => $ID,
                    "EMAIL" => $arUser["EMAIL"],
                    "TEXT" => $ID.'-'.$STATUS.' - '.$order["PAY_SYSTEM_ID"].' - '.$ps
                );
                CEvent::Send("BILL_CREATED", "s1", $fields, "N");
            }
        }

    }

    if ($STATUS == 'N' && $ID && $order["PAY_SYSTEM_ID"] == 15 && ($order['DELIVERY_ID'] == 'sdek:pickup' || $order['DELIVERY_ID'] == 'sdek:courier') && $order["EXTERNAL_ORDER"] != "Y")
    {
        $arUpdateOrderFields = array(
            "STATUS_ID" => "FF"
        );
        $rr = CSaleOrder::Update($order["ID"], $arUpdateOrderFields);
    }

    /*if ($STATUS == 'N' && $ID && $order["PAY_SYSTEM_ID"] == 15 && $order['DELIVERY_ID'] == 'sdek:courier' && $order["EXTERNAL_ORDER"] != "Y")
    {
        $arUpdateOrderFields = array(
            "PAY_SYSTEM_ID" => 15,
            "STATUS_ID" => "FF"
        );
        $rr = CSaleOrder::Update($order["ID"], $arUpdateOrderFields);
    }*/

}

AddEventHandler('main', 'OnBeforeEventSend', "MailtplSend");

function MailtplSend(&$arFields, &$arTemplate){

    global $USER;

    //Отправляем пароль пользователю при регистрации после оформления заказа
    if ($arTemplate['ID'] == 2)
    {
        CModule::IncludeModule('main');

        $user = new CUser;
        $new_password = randString(8);

        if ($arFields["USER_ID"])
        {
            $arFields["PWD"] = $new_password;

            $fields = Array(
                "PASSWORD"          => $new_password,
                "CONFIRM_PASSWORD"  => $new_password,
            );
            $user->Update($arFields["USER_ID"], $fields);
        }
        else
        {
            $arFields["PWD"] = "";
        }

        $mess = $arTemplate["MESSAGE"];
        foreach($arFields as $keyField => $arField){
            $mess = str_replace('#'.$keyField.'#', $arField, $mess);
        }
        $arTemplate["MESSAGE"] = $mess;

    }


    if($arTemplate['ID'] == 33){

        $arTemplate['BODY_TYPE'] = 'html';

        CModule::IncludeModule('main');


        CModule::IncludeModule('iblock');
        CModule::IncludeModule('sale');
        CModule::IncludeModule('catalog');

        $arrStatus = array('N'=>'Принят', 'P'=>'Оплачен', 'F'=>'Выполнен');

        if ($arOrder = CSaleOrder::GetByID($arFields['ORDER_ID'])){
            //p($arOrder);
        }

        $db_vals = CSaleOrderPropsValue::GetList(
            array("SORT" => "ASC"),
            array(
                "ORDER_ID" => $arFields['ORDER_ID'],
            )
        );



        /*
        $filter = Array(
            "EMAIL" => $arFields['EMAIL'],
        );
        $rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter); // выбираем пользователей
        while($user = $rsUsers->GetNext()):
            $arUser = $user;
        endwhile;
        */

        $orderPropTable = "";
        $orderPropTable .= "
				<p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Текущий статус заказа:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$arrStatus[$arOrder['STATUS_ID']]."</span></p>			
				<p style='margin:0px 0 30px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: block;text-align:left;'>Сумма заказа:
				<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 24px;line-height: 24px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$arOrder['PRICE']."</span>
				<span style='margin:0px 0 0 5px;padding:0;font-weight:bold;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;text-transform:uppercase;'>руб. -</span>
				</p>";


        $userID = $arOrder["USER_ID"];

        if ($userID)
        {
            $rsUser = CUser::GetByID($userID);
            $arUser = $rsUser->Fetch();


            $arGroups = CUser::GetUserGroup($arUser["ID"]);

            //Партнер. Смена email отправителя для
            if ($arUser["XML_ID"] && in_array(11 ,$arGroups))
            {
                $orderPropTable .= "
				<p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Заказ из личного кабинета партнера</p>";

                $cUser = new CUser;
                $sort_by = "ID";
                $sort_ord = "ASC";
                $arFilter = array(
                    "ID" => $arUser["ID"],
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
                }

                if ($manager && $manager["UF_EMAIL"])
                {
                    $arFields['SALE_EMAIL'] = $manager["UF_EMAIL"];
                    $arTemplate['BCC'] = $manager["UF_EMAIL"];
                    //$arTemplate['EMAIL_FROM'] = $manager["UF_EMAIL"];
                }
            }
            //Смена email отправителя для розницы в зависимости от склада
            elseif ($_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]["ID"])
            {
                $arSelect = Array('ID', 'TITLE', 'EMAIL');
                $arFilter = Array('ACTIVE'=>'Y', 'ID' => $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]["ID"]);
                $dbRes = CCatalogStore::GetList(Array(), $arFilter, false, Array(), $arSelect);
                $arStore = $dbRes->GetNext();
                if ($arStore && $arStore['EMAIL'])
                {
                    $arFields['SALE_EMAIL'] = $arStore['EMAIL'];
                    //$arTemplate['SALE_EMAIL'] = $arStore['EMAIL'];
                    //$arTemplate['EMAIL_FROM'] = $arStore['EMAIL'];

                    if ($arOrder["PERSON_TYPE_ID"] != 1)
                    {
                        $arFields['BCC'] = $arStore['EMAIL'];
                        //$arFields['BCC'] = 'lizocom2@mail.ru';
                    }/*else{
                                $arFields['BCC'] = 'kovalenko@termoros.com';
                            }*/

                }
                else
                {
                    $arFields['SALE_EMAIL'] = 'site@termoros.com';
                    //$arFields['BCC'] = 'kovalenko@termoros.com';
                }
            }
            else
            {
                $arFields['SALE_EMAIL'] = 'site@termoros.com';
                //$arFields['BCC'] = 'kovalenko@termoros.com';
            }
            //Bitrix\Main\Diag\Debug::writeToFile($arFields,'$arFields');
        }


        /*
        global $USER;

        \Bitrix\Main\Loader::includeModule('redreams.partners');
        $isXML = \Redreams\Partners\partner::getXMLID();
        if ($isXML)
        {
            $orderPropTable .= "
        <p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Заказ из личного кабинета партнера</p>";
        }
        */

        /*
        $to      = 'lysov@termoros.com';
        $subject = 'Партнер';
        $message = "ID: ".$USER->GetID()."\r\nGroups: ".implode(",",$USER->GetUserGroupArray())."\r\nEmail: ".$USER->GetEmail()."\r\nXML_ID: ".\Redreams\Partners\partner::getXMLID();
        $headers = 'From: info@termoros.com' . "\r\n" .
            'Reply-To: info@termoros.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
        */

        $orderPropTable .= "\n";

        $orderPropTable .= "
				<p style='margin:0px 0 10px 0px;padding:0;font-weight:bold;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Данные вашей учетной записи</p>
				<p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>E-mail:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$arFields['EMAIL']."</span></p>";

        $orderPropTable .= "\n";

        $orderPropTable .= "<p style='margin:30px 0 10px 0px;padding:0;font-weight:bold;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;text-transform:uppercase;'>Параметры заказа</p>
				<p style='margin:0px 0 10px 0px;padding:0;font-weight:bold;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Личные данные</p>";
        $orderPropTable .= "\n";

        $commentProps = "\n".'EMail: '.$arFields['EMAIL']."\n";



        while($arVals = $db_vals->Fetch()){
            if($arVals['CODE'] == 'LOCATION' || $arVals['CODE'] == 'CONTRACTOR_ID' || $arVals['CODE'] == 'ZIP' || $arVals['CODE'] == 'ROISTAT_VISIT' || $arVals['CODE'] == 'CDEK_ID' || $arVals['CODE'] == 'IPOLSDEK_CNTDTARIF' || $arVals['CODE'] == 'CDEK_CITY_ID' || $arVals['CODE'] == 'EXTERNAL_ORDER' || $arVals['CODE'] == 'EXTERNAL' || $arVals['CODE'] == 'FIO') {
                continue;
                $arLocs = CSaleLocation::GetByID($arVals['VALUE']);
                $arVals['VALUE'] = $arLocs['CITY_NAME'];
            }
            if($arVals){
                $orderPropTable .= "
				<p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>".$arVals["NAME"].":<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$arVals["VALUE"]."</span></p>";
                $orderPropTable .= "\n";
                $commentProps .= $arVals["NAME"].': '.$arVals["VALUE"]."\n";
            }
        }

        /*if($arOrder['USER_DESCRIPTION']){
        $orderPropTable .= "<p style='font-size:13px;line-height:15px;font-family:tahoma;color:#384756;padding: 0 0 0px 0;width:100%;margin: 0;float:left'>Комментарий пользователя: ".$arOrder['USER_DESCRIPTION']."</p>";
        $orderPropTable .= "\n";
        }*/

        $orderPropTable .= "<p style='margin:0px 0 10px 0px;padding:0;font-weight:bold;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Оплата и доставка</p>";
        $orderPropTable .= "\n";

        if ($arPaySys = CSalePaySystem::GetByID($arOrder['PAY_SYSTEM_ID'], $arOrder['PERSON_TYPE_ID'])){
            $orderPropTable .= "<p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Платежная система:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$arPaySys["NAME"]."</span></p>";
            //$arPaySys["PSA_NAME"]
            $orderPropTable .= "\n";

            $commentProps .= 'Платежная система: '.$arPaySys["NAME"]."\n";
        }

        if ($arDelivery = CSaleDelivery::GetByID($arOrder['DELIVERY_ID'])){
            $orderPropTable .= "<p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Доставка:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$arDelivery["NAME"]."</span></p>";
            $orderPropTable .= "\n";
            $commentProps .= 'Доставка: '.$arDelivery["NAME"]."\n";
        }
        else{
            $expl = explode(':', $arOrder['DELIVERY_ID']);
            $arDelivery = CSaleDeliveryHandler::GetBySID($expl[0]);
            if($arrDeliv = $arDelivery->GetNext()){
                $orderPropTable .= "<p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Доставка:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$arrDeliv['NAME']."</span></p>";
                $orderPropTable .= "\n";
            }
        }

        //$orderPropTable .= "<p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Оплачен:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>Нет</span></p>";
        //$orderPropTable .= "\n";

        if ($_SESSION['GEOIP']['curr_city_name'])
        {
            //GEOIP

            $orderPropTable .= "<p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Регион/Город (GeoIP):<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$_SESSION['GEOIP']['curr_city_name']."</span></p>";
            $orderPropTable .= "\n";

            if ($_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['STORE_NAME'])
            {

                $orderPropTable .= "<p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Выбранный склад:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['STORE_NAME']."</span></p>";
                $orderPropTable .= "\n";

            }

            if ($arOrder['USER_DESCRIPTION']) {
                $orderPropTable .= "\nКомментарий пользователя:\n".$arOrder['USER_DESCRIPTION'];
            }

            $commentProps .= 'Регион (GeoIP): '.$_SESSION['GEOIP']['curr_city_name']."\n";
        }
        else
        {
            $orderPropTable .= "<p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Регион/Город (GeoIP):<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>Не определен</span></p>";
            $orderPropTable .= "\n";

            if ($_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['STORE_NAME'])
            {

                $orderPropTable .= "<p style='margin:0px 0 10px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Выбранный склад:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>Не определен</span></p>";
                $orderPropTable .= "\n";

            }

            if ($arOrder['USER_DESCRIPTION']) {
                $orderPropTable .= "\nКомментарий пользователя:\n".$arOrder['USER_DESCRIPTION'];
            }

            $commentProps .= 'Регион (GeoIP): Не определен'."\n";


        }


        if ($arOrder["ID"] && $arOrder["EXTERNAL_ORDER"] != "Y")
        {
            $arF = array(
                'COMMENTS' => "\nКомментарий пользователя:\n".$arOrder['USER_DESCRIPTION']."\n\nПараметры заказа:".$arOrder['COMMENTS']."\n".$commentProps
            );
            CSaleOrder::Update($arOrder["ID"], $arF);
        }



        $orderPropTable .= "<p style='margin:45px 0 20px 0px;padding:0;font-weight:bold;font-size: 30px;line-height: 32px;color: #363535;font-family: Arial, Helvetica;display: block;text-align:left;'>Состав заказа</p>";
        $orderPropTable .= "\n";

        /**/

        $orderPropTable .= "
					<table style='width:800px;border-collapse: separate;border-spacing: 0px 10px;border:0;background: #ffffff;margin:0 auto;font-family: Arial, Helvetica;'>
						<tr>
						
						<th style='text-align:center;padding:10px 0;background:#ffffff; vertical-align:middle; text-align:left;border-top:1px solid #ced3d6;border:0 solid #ced3d6;font-size:14px;line-height:16px;color:#9a9fab;font-weight:bold;'>
						Товар</th>
						
						<th style='text-align:center;padding:10px 0;background:#ffffff; vertical-align:middle; text-align:left;border-top:1px solid #ced3d6;border:0 solid #ced3d6;font-size:14px;line-height:16px;color:#9a9fab;font-weight:bold;'>
						Кол-во</th>
						
						<th style='text-align:center;padding:10px 0;background:#ffffff; vertical-align:middle; text-align:left;border-top:1px solid #ced3d6;border:0 solid #ced3d6;font-size:14px;line-height:16px;color:#9a9fab;font-weight:bold;'>
						Наличие</th>
						
						<th style='text-align:center;padding:10px 0;background:#ffffff; vertical-align:middle; text-align:left;border-top:1px solid #ced3d6;border:0 solid #ced3d6;font-size:14px;line-height:16px;color:#9a9fab;font-weight:bold;'>
						</th>
						
					</tr>";
        $orderPropTable .= "\n";


        // собираем корзину
        $arrsumm = 0;
        $dbBasketItems = CSaleBasket::GetList(
            array("NAME" => "ASC"),
            array("ORDER_ID" => $arFields['ORDER_ID']),
            false,
            false,
            array("ID", "PRODUCT_ID", "NAME", "QUANTITY", "PRICE", "CURRENCY", "DISCOUNT_PRICE","BASE_PRICE")
        );


        if (!$_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID'])
        {
            $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID'] = 208;
        }

        while ($arBasketItems = $dbBasketItems->Fetch()){

            unset($arFieldss);
            unset($arProps);

            //p($arBasketItems);
            $arSelect = Array("ID", "IBLOCK_ID", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "DETAIL_PICTURE", "NAME");
            $arFilter = Array("ID"=>$arBasketItems['PRODUCT_ID'], "IBLOCK_ID"=>4, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>5), $arSelect);
            while($ob = $res->GetNextElement())
            {

                $arFieldss = $ob->GetFields();
                $arProps = $ob->GetProperties();
                //$arItemsIds[$arFieldss['ID']] = $arFieldss['PROPERTY_CML2_LINK_VALUE'];
                //p($arFieldss);

            }

            if($_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID']){
                $rsStore = CCatalogStoreProduct::GetList(array(), array('PRODUCT_ID' => $arBasketItems['PRODUCT_ID'], 'STORE_ID' => $_SESSION['STORES'][$_SESSION['GEOIP']['curr_city_name']]['ID']), false, false, array('PRODUCT_ID', 'STORE_ID', 'STORE_NAME', 'AMOUNT'));
                while($arStore = $rsStore->Fetch()){
                    $StoreQuans[$arStore['PRODUCT_ID']] = $arStore['AMOUNT'];

                }
            }



            if(!$StoreQuans[$arBasketItems['PRODUCT_ID']]){
                $StoreQuans[$arBasketItems['PRODUCT_ID']] = 0;
            }

            $arBasketItems['DISCOUNT_PRICE'] = $arBasketItems['BASE_PRICE'] - $arBasketItems['PRICE'];

            $quantityitems += $arBasketItems['QUANTITY'];
            $arrsumm += $arBasketItems['PRICE']*$arBasketItems['QUANTITY'];
            $discsumm += $arBasketItems['DISCOUNT_PRICE']*$arBasketItems['QUANTITY'];
            $fullsumm += ($arBasketItems['DISCOUNT_PRICE']+$arBasketItems['PRICE'])*$arBasketItems['QUANTITY'];

            if($arFieldss['DETAIL_PICTURE'])
                $img = resize($arFieldss['DETAIL_PICTURE'], 135, 135, 2);
            else
                $img = '/bitrix/templates/termoros/img/no_bg.png';

            unset($basePrice);
            $basePrice = CPrice::GetBasePrice($arBasketItems["PRODUCT_ID"]);

            //<img src='http://#SERVER_NAME#/".$img."' alt='' style='padding:10px;float:left;margin-right:9px;border:1px solid #dbdbdb;width:auto;max-width:83px;height:auto;max-height:83px'>
            /*$orderPropTable .= "
            <tr>
                <td style='text-align:center;padding:0 0;background:#ffffff; vertical-align:middle; text-align:left;height:135px;width:135px;border-top:1px solid #ced3d6;border-bottom:1px solid #ced3d6;border-left:1px solid #ced3d6;'>
                    <img src='http://www.termoros.com/".$img."' style='border:0;max-width:100%;max-height:100%;margin:0 auto ;display:block;' alt=''>
                </td>
                <td style='text-align:left;padding:15px 10px 0 15px;width:210px;background:#ffffff; vertical-align:top; text-align:left;border-top:1px solid #ced3d6;border-bottom:1px solid #ced3d6;'>
                    <a href='http://www.termoros.com".$arFieldss['DETAIL_PAGE_URL']."' style='margin:0px 0 5px 0;padding:0;font-weight:bold;font-size: 18px;line-height: 20px;color: #242424;font-family: Arial, Helvetica;display:block;text-decoration:none;'>".$arBasketItems['NAME']."</a>
                    <p style='margin:0px 0 10px 0px;padding:0;font-size: 13px;line-height: 15px;color: #a2a2a2;font-family: Arial, Helvetica;display: block;text-align:left;'>Арт. ".$arProps['CML2_ARTICLE']['VALUE']."</p>
                    <hr style='display:block;width:75px;height:2px;background:#d7d9d8;margin:0 0 25px 0;border:0;' />
                    <p style='margin:0px 0 0 0px;padding:0;font-weight:normal;font-size: 24px;line-height: 26px;color: #2c2c2c;font-family: Arial, Helvetica;display: block;text-align:left;'>
                        ".intval($arBasketItems['PRICE'])."
                        <span style='margin:0px 0 0 5px;padding:0;font-weight:bold;font-size: 13px;line-height: 15px;color: #2c2c2c;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;text-transform:uppercase;'>руб. -</span>
                    </p>
                </td>
                <td style='text-align:left;padding:15px 10px 0 0;width:165px;background:#ffffff; vertical-align:top; text-align:left;border-top:1px solid #ced3d6;border-bottom:1px solid #ced3d6;'>";
                */
            /*if($arProps['KOLLEKTSIYA']['VALUE']){
            $orderPropTable .= "
                <p style='margin:0px 0 5px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Коллекция:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$arProps['KOLLEKTSIYA']['VALUE']."</span></p>";
            }if($arProps['MATERIAL']['VALUE']){
            $orderPropTable .= "
                <p style='margin:0px 0 5px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Материал:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$arProps['MATERIAL']['VALUE']."</span></p>";
            }if($arProps['SHIRINA']['VALUE']){
            $orderPropTable .= "
                <p style='margin:0px 0 5px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Ширина:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$arProps['SHIRINA']['VALUE']." см</span></p>";
            }if($arProps['VYSOTA']['VALUE']){
            $orderPropTable .= "
                <p style='margin:0px 0 5px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Высота:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$arProps['VYSOTA']['VALUE']." см</span></p>";
            }if($arProps['DLINA']['VALUE']){
            $orderPropTable .= "
                <p style='margin:0px 0 5px 0px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Длина:<span style='margin:0px 0 0 10px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".$arProps['DLINA']['VALUE']." см</span></p>";
            }*/
            /*$orderPropTable .= "</td>
            <td style='text-align:left;padding:0 10px 0 0;width:85px;background:#ffffff; vertical-align:middle; text-align:left;border-top:1px solid #ced3d6;border-bottom:1px solid #ced3d6;'>
                <p style='margin:0px 0  0px;padding:0;font-weight:normal;font-size: 18px;line-height: 20px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>".intval($arBasketItems['QUANTITY'])."<span style='margin:0px 0 0 5px;padding:0;font-weight:normal;font-size: 13px;line-height: 15px;color: #000000;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;text-transform:uppercase;'>шт.</span></p>
            </td>
            <td style='text-align:left;padding:0 20px 0 0;background:#ffffff; vertical-align:middle; text-align:right;border-top:1px solid #ced3d6;border-bottom:1px solid #ced3d6;border-right:1px solid #ced3d6;'>
                <p style='margin:0px 0 0 0px;padding:0;font-weight:normal;font-size: 24px;line-height: 26px;color: #2c2c2c;font-family: Arial, Helvetica;display: block;text-align:right;'>
                    ".intval($arBasketItems['PRICE']*$arBasketItems['QUANTITY'])."
                    <span style='margin:0px 0 0 5px;padding:0;font-weight:bold;font-size: 13px;line-height: 15px;color: #2c2c2c;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;text-transform:uppercase;'>руб. -</span>
                </p>
            </td>
        </tr>";*/

            $orderPropTable .= "
				<tr>
					
					<td style='padding:10px 10px;background:#ffffff; vertical-align:middle; text-align:left;height:110px;width:240px;border-top:1px solid #ced3d6;border:1px solid #ced3d6;'>
						<a href='http://www.termoros.com".$arFieldss['DETAIL_PAGE_URL']."' style='margin: 0 0px;padding:0;font-weight:bold;font-size: 13px;line-height: 18px;color: #363535;font-family: Arial, Helvetica;display: block;text-align:left;text-decoration:none;'>".$arBasketItems['NAME']."</a>
						<p style='margin: 0 0px;padding:0;font-size: 13px;line-height: 18px;color: #363535;font-family: Arial, Helvetica;display: block;text-align:left;'>Код: ".$arProps['CML2_ARTICLE']['VALUE']."</p>
						<!--<p style='margin: 0 0px;padding:0;font-size: 13px;line-height: 18px;color: #363535;font-family: Arial, Helvetica;display: block;text-align:left;'>Гидравлические характеристики: 1/2\" мм  -  20-50 А/мин</p>-->						
						<p style='margin: 5px 0 0px;font-weight:bold;padding:0;font-size: 13px;line-height: 18px;color: #363535;font-family: Arial, Helvetica;display: block;text-align:left;'>
							<span style='margin: 0 5px 0px 0;padding:0;font-size: 18px;line-height: 20px;color: #3b393f;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".round($arBasketItems['PRICE'], 2)."</span>руб.
						</p>
					
					</td>
					
					<td style='padding:10px 10px;background:#ffffff; vertical-align:middle; text-align:left;height:110px;width:auto;border-top:1px solid #ced3d6;border:1px solid #ced3d6;'>
						<p style='margin: 0 0px;padding:0;font-size: 13px;line-height: 18px;color: #363535;font-family: Arial, Helvetica;display: block;text-align:left;'>".intval($arBasketItems['QUANTITY'])." шт.</p>
					</td>
					";

            if (abs($StoreQuans[$arBasketItems['PRODUCT_ID']]))
            {
                $orderPropTable .= "<td style='padding:10px 10px;background:#ffffff; vertical-align:middle; text-align:left;height:110px;width:auto;border-top:1px solid #ced3d6;border:1px solid #ced3d6;'>
						<p style='margin: 0 0px;padding:0;font-size: 13px;line-height: 18px;color: #363535;font-family: Arial, Helvetica;display: block;text-align:left;'>В наличии: ".abs($StoreQuans[$arBasketItems['PRODUCT_ID']])." шт.</p>
						</td>";
            }
            else
            {
                $orderPropTable .= "<td style='padding:10px 10px;background:#ffffff; vertical-align:middle; text-align:left;height:110px;width:auto;border-top:1px solid #ced3d6;border:1px solid #ced3d6;'>
						<p style='margin: 0 0px;padding:0;font-size: 13px;line-height: 18px;color: #363535;font-family: Arial, Helvetica;display: block;text-align:left;'>Наличие уточняйте у менеджеров</p>
						</td>";
            }


            $orderPropTable .= "<td style='padding:10px 10px;background:#ffffff; vertical-align:middle; text-align:right;height:110px;width:auto;border-top:1px solid #ced3d6;border:1px solid #ced3d6;'>
						<p style='margin: 0 0px;font-weight:bold;padding:0;font-size: 13px;line-height: 18px;color: #363535;font-family: Arial, Helvetica;display: block;text-align:left;'>
							<span style='margin: 0 5px 0px 0;padding:0;font-size: 18px;line-height: 20px;color: #3b393f;font-family: Arial, Helvetica;display: inline-block;vertical-align:baseline;text-align:left;'>".round($arBasketItems['PRICE']*$arBasketItems['QUANTITY'], 2)."</span>руб.
						</p>
					</td>
					
				</tr>
				";

        }

        $orderPropTable .= "</table>";
        $orderPropTable .= "\n";

        $orderPropTable .= "<div style='display:block;margin:15px 0 80px 515px;padding:0;'>
				<p style='margin:0 0 15px 0px;padding:0;font-weight:bold;font-size: 18px;line-height: 20px;color: #262626;font-family: Arial, Helvetica;display: block;text-align:left;'>Параметры заказа</p>
						
						<div style='display:block;margin:0 0 12px 0;padding:0;'>
							<p style='display: inline-block;vertical-align: baseline;width: 120px;font-size: 13px;line-height: 15px;color: #242424;margin:0;padding:0;'>Товаров</p>
							<p style='display: inline-block;vertical-align: baseline;max-width: 165px;font-size: 13px;line-height: 15px;color: #242424;text-transform: uppercase;margin:0;padding:0;'>
							<span style='font-size: 13px;line-height: 15px;color: #242424;width: 60px;text-align: right;display: inline-block;vertical-align: baseline;margin: 0 5px 0 0;'>".$quantityitems."</span>шт.</p>
						</div>
						<div style='display:block;margin:0 0 12px 0;padding:0;'>
							<p style='display: inline-block;vertical-align: baseline;width: 120px;font-size: 13px;line-height: 15px;color: #242424;margin:0;padding:0;'>Стоимость заказа</p>
							<p style='display: inline-block;vertical-align: baseline;max-width: 165px;font-size: 13px;line-height: 15px;color: #242424;text-transform: uppercase;margin:0;padding:0;'>
							<span style='font-size: 13px;line-height: 15px;color: #242424;width: 60px;text-align: right;display: inline-block;vertical-align: baseline;margin: 0 5px 0 0;'>".round($fullsumm, 2)."</span>РУБ.</p>
						</div>
						<div style='display:block;margin:0 0 12px 0;padding:0;'>
							<p style='display: inline-block;vertical-align: baseline;width: 120px;font-size: 13px;line-height: 15px;color: #d24a43;margin:0;padding:0;'>Скидка</p>
							<p style='display: inline-block;vertical-align: baseline;max-width: 165px;font-size: 13px;line-height: 15px;color: #d24a43;text-transform: uppercase;margin:0;padding:0;'>
							<span style='font-size: 13px;line-height: 15px;color: #d24a43;width: 60px;text-align: right;display: inline-block;vertical-align: baseline;margin: 0 5px 0 0;'>".round($discsumm, 2)."</span> РУБ.</p>
						</div>";

        if ($arOrder["PRICE_DELIVERY"])
        {
            $orderPropTable .= "<div style='display:block;margin:0 0 12px 0;padding:0;'>
							<p style='display: inline-block;vertical-align: baseline;width: 120px;font-size: 13px;line-height: 15px;color: #242424;margin:0;padding:0;'>Доставка</p>
							<p style='display: inline-block;vertical-align: baseline;max-width: 165px;font-size: 13px;line-height: 15px;color: #242424;text-transform: uppercase;margin:0;padding:0;'>
							<span style='font-size: 13px;line-height: 15px;color: #242424;width: 60px;text-align: right;display: inline-block;vertical-align: baseline;margin: 0 5px 0 0;'>".round($arOrder["PRICE_DELIVERY"], 2)."</span> РУБ.</p>
						</div>";
        }


        $orderPropTable .= "<div style='display:block;margin:0 0 12px 0;padding:0;'>	
							<p style='display: inline-block;vertical-align: baseline;width: 90px;font-size: 16px;line-height: 18px;color: #242424;margin:0;padding:0;font-weight:bold;'>Итого</p>
							<p style='display: inline-block;vertical-align: baseline;max-width: 165px;font-size: 13px;line-height: 15px;color: #242424;text-transform: uppercase;font-weight:bold;margin:0;padding:0;'> 
							<span style='font-size: 24px;line-height: 26px;color: #242424;width: auto;text-align: right;display: inline-block;vertical-align: baseline;margin: 0 5px 0 0;font-weight:bold;'>".round($arOrder['PRICE'], 2)."</span> РУБ.</p>
						</div>
						
					</div>";
        $orderPropTable .= "\n";

        $arFields['ORDER_LIST'] = $orderPropTable;
        //	p($orderPropTable);

        $mess = $arTemplate["MESSAGE"];

    }






    //$mess = $arTemplate["MESSAGE"];
    //$arTemplate["MESSAGE"] = $header.$mess.$footer;

    $mess = $arTemplate["MESSAGE"];
    foreach($arFields as $keyField => $arField){
        $mess = str_replace('#'.$keyField.'#', $arField, $mess);

        $arTemplate["MESSAGE"] = $mess;

        if ($arOrder["EXTERNAL_ORDER"] == "Y")
        {
            $arFields['EMAIL'] = 'site@termoros.com';
            $arFields = array();
            //AddMessage2Log($arOrder['1C_ID'].' '.$arFields['EMAIL'].' '.$arOrder["EXTERNAL_ORDER"]);

            if ($arOrder["STATUS_ID"] == "N" || !$arOrder["STATUS_ID"])
            {
                $status = array(
                    'STATUS_ID' => "FF"
                );
                CSaleOrder::Update($arOrder["ID"], $status);
            }

            //For Roistat filter
            if ($arOrder["PERSON_TYPE_ID"] == 1) $orderPropID = 46;
            elseif ($arOrder["PERSON_TYPE_ID"] == 2) $orderPropID = 48;
            elseif ($arOrder["PERSON_TYPE_ID"] == 3) $orderPropID = 47;

            if ($arProp = CSaleOrderProps::GetList(array(), array('ID' => $orderPropID))->Fetch()) {
                CSaleOrderPropsValue::Add(array(
                    'NAME' => $arProp['NAME'],
                    'CODE' => $arProp['CODE'],
                    'ORDER_PROPS_ID' => $arProp['ID'],
                    'ORDER_ID' => $arOrder["ID"],
                    'VALUE' => 1,
                ));
            }

            return false;

            //unset($arFields);
            //unset($arTemplate);
            //break;
        }
        else
        {





        }


    }

    if($USER->isAdmin()){
        //p($arTemplate["MESSAGE"]);
        //die();
    }

}

/**
 * @param $code
 *
 * @return int
 * @throws \Bitrix\Main\SystemException
 */
function getBrandXmlIdByCode($code)
{
    $cacheTime = 3600000;
    $cache = \Bitrix\Main\Data\Cache::createInstance();
    $propertyBrandValueId = 0;
    if ($cache->initCache($cacheTime, $code.'brands_menu1'))
    {
        $propertyBrandValueId = $cache->getVars();
    }
    else
    {
        $hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById(3)->fetch();
        \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData);
        $propertyBrandValueId = BrendTable::getList([
            'select' => ['UF_XML_ID'],
            'filter' => ['UF_LINK' => $code]
        ])->fetch()['UF_XML_ID'];

        if ($cache->startDataCache())
        {
            $cache->endDataCache($propertyBrandValueId);
        }
    }
    //p($propertyBrandValueId);
    return $propertyBrandValueId;
}

/**
 * @param $code
 *
 * @return array
 * @throws \Bitrix\Main\SystemException
 */
function getBrandXmlIdArrayByCode($code)
{

    $propertyBrandValueId = 0;

    $hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById(3)->fetch();
    \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData);
    $res = BrendTable::getList([
        'select' => ['UF_XML_ID'],
        'filter' => ['UF_LINK' => $code]
    ]);

    while($propertyBrandValueId = $res->fetch())
    {
        $returnArr[] = $propertyBrandValueId['UF_XML_ID'];
    }

    //p($propertyBrandValueId);
    return $returnArr;
}


/**
 * @param $code
 *
 * @return mixed
 */
function getSectionIdByCode($code)
{
    global $CACHE_MANAGER;
    $cacheTime = 3600000;
    $cache = \Bitrix\Main\Data\Cache::createInstance();
    if ($cache->initCache($cacheTime, $code))
    {
        $sectionId = $cache->getVars();
    }
    else
    {
        $CACHE_MANAGER->StartTagCache($cache->getPath($code));
        $sectionId = CIBlockSection::GetList([], ['CODE' => $code, 'IBLOCK_ID' => 4], false, ['ID'])->GetNext()['ID'];
        $CACHE_MANAGER->RegisterTag('iblock_id_4');

        if ($cache->startDataCache())
        {
            $cache->endDataCache($sectionId);
        }

        $CACHE_MANAGER->EndTagCache();
    }

    return $sectionId;
}

/**
 * @param $brandXmlId
 *
 * @return mixed
 */
function getFirstSectionPathCodeByBrand($brandXmlId)
{
    global $CACHE_MANAGER;
    $cacheTime = 3600000;
    $cache = \Bitrix\Main\Data\Cache::createInstance();
    if ($cache->initCache($cacheTime, $brandXmlId.'getFirstSectionPathByBrand'))
    {
        $sectionUrl = $cache->getVars();
    }
    else
    {
        $CACHE_MANAGER->StartTagCache($cache->getPath($brandXmlId.'getFirstSectionPathByBrand'));
        $sectionsResult = CIBlockSection::GetList([], ['PROPERTY' => ['BREND' => $brandXmlId], 'IBLOCK_ID' => 4], false,
            ['SECTION_PAGE_URL', 'IBLOCK_SECTION_ID']);

        while ($section = $sectionsResult->GetNext())
        {
            if ($section['IBLOCK_SECTION_ID'] > 0)
            {
                $sectionUrl = $section['SECTION_PAGE_URL'];
                break;
            }
        }

        $CACHE_MANAGER->RegisterTag('iblock_id_4');

        $sectionUrl = substr($sectionUrl, 9);

        if ($cache->startDataCache())
        {
            $cache->endDataCache($sectionUrl);
        }

        $CACHE_MANAGER->EndTagCache();
    }

    return $sectionUrl;
}

function deactivateEndedActions()
{
    if (CModule::IncludeModule('iblock'))
    {
        $arFilter = array('IBLOCK_ID' => 5, 'ACTIVE'=>'Y', '<PROPERTY_END_DATE' => date("Y-m-d H:i:s"), "!PROPERTY_END_DATE" => false, "!PROPERTY_END_ACTION" => 1);
        $res = CIblockElement::GetList(
            array(),
            $arFilter,
            false,
            false,
            array()
        );
        while($ob = $res->GetNext())
        {
            CIBlockElement::SetPropertyValues($ob["ID"], $ob["IBLOCK_ID"], 1, 'END_ACTION');
        }
    }
}