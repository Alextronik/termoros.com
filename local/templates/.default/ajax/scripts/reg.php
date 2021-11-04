<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:main.register",
    "reg",
    array(
        "USER_PROPERTY_NAME" => "",
        "SEF_MODE" => "Y",
        "SHOW_FIELDS" => array(
        ),
        "REQUIRED_FIELDS" => array(
        ),
        "AUTH" => "Y",
        "USE_BACKURL" => "Y",
        "SUCCESS_PAGE" => "",
        "SET_TITLE" => "N",
        "USER_PROPERTY" => array(
        ),
        "SEF_FOLDER" => "/",
        "COMPONENT_TEMPLATE" => "reg"
    ),
    false
);?>
