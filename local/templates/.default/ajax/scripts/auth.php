<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:system.auth.form",
    "auth",
    array(
        "REGISTER_URL" => "",
        "FORGOT_PASSWORD_URL" => "",
        "PROFILE_URL" => "profile.php",
        "SHOW_ERRORS" => "Y",
        "COMPONENT_TEMPLATE" => "auth"
    ),
    false
);?>
