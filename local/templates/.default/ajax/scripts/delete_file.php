<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?php

	unlink($_SESSION['uploaded_file']);	
	unset($_SESSION['uploaded_file']);

?>
