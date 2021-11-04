<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?php
\Bitrix\Main\Loader::includeModule('redreams.partner');
if($_REQUEST['ID'] && \Redreams\Partners\partner::isPartner())
{
    \Redreams\Partners\contractor::sendEditRequest();
}
