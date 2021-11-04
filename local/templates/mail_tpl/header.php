<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <style type="text/css">
        /* Client-specific Styles */

        #outlook a {padding:0;}
        body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
        .ExternalClass {width:100%;}
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {line-height: 100%;}
        #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}

        /* End reset */
    </style>
    <?
    /*
    This is commented to avoid Project Quality Control warning
    $APPLICATION->ShowHead();
    $APPLICATION->ShowTitle();
    $APPLICATION->ShowPanel();
    */
    ?>
</head>
<body>
<? if (\Bitrix\Main\Loader::includeModule('mail')) : ?>
    <?=\Bitrix\Mail\Message::getQuoteStartMarker(true); ?>
<? endif; ?>
<?
$protocol = \Bitrix\Main\Config\Option::get("main", "mail_link_protocol", 'https', $arParams["SITE_ID"]);
$serverName = $protocol."://".$arParams["SERVER_NAME"];
?>
<table id="main_mail" cellpadding="0" cellspacing="0" width="100%" style="max-width:1024px;border-collapse: collapse;border-spacing: 0;border:0;background: #ffffff;margin:0 auto;">
	<tr>
		<td colspan="2" style='height:85px;'>
			<a href='https://www.termoros.com/' style='text-decoration:none;cursor:pointer;'><img src='https://www.termoros.com/local/templates/mail_tpl/logo.png' style='border:0;width:240px;height:65px;margin:0 ;display:block;background:#ffffff;' alt=''></a>
		</td>
        <td colspan="1"></td>
        <td colspan="2" style="text-align:right;">
            <a style="float:right;margin:0 0;padding:0;font-weight:bold;font-size: 1.2rem;line-height: 16px;color: #383838;display: block;text-align:right;" href="mailto:info@termoros.com" target="_blank"><span>info@termoros.com</span></a><br>
            <span style="float:right;margin:0 0;padding:0;font-weight:bold;font-size: 1.2rem;line-height: 16px;color: #383838;display: block;text-align:right;">7 (499) 500 00 01</span><br>
            <span style="float:right;margin:0 0;padding:0;font-weight:bold;font-size: 1.2rem;line-height: 16px;color: #383838;display: block;text-align:right;">8 (800) 550 33 45</span>
        </td>
	</tr>

	<tr>
		<td style='text-align:center;padding:0 0; background:#3e457c; vertical-align:middle; height:20px;border:0;'>
			<a href='/catalog/' style="margin:0 50px 0 0;padding:0;font-weight:bold;font-size: 1rem;line-height: 1.2rem;color: #ffffff;text-transform:uppercase;display:inline-block;vertical-align:middle;text-decoration:none;">КАТАЛОГ</a>
        </td>
        <td style='text-align:center;padding:0 0; background:#3e457c; vertical-align:middle; height:20px;border:0;'>
			<a href='/technical_support/training/' style="margin:0 50px 0 0;padding:0;font-weight:bold;font-size: 1rem;line-height: 1.2rem;color: #ffffff;text-transform:uppercase;display:inline-block;vertical-align:middle;text-decoration:none;">ОБУЧЕНИЕ</a>
        </td>
        <td style='text-align:center;padding:0 0; background:#3e457c; vertical-align:middle; height:20px;border:0;'>
			<a href='/technical_support/' style="margin:0 50px 0 0;padding:0;font-weight:bold;font-size: 1rem;line-height: 1.2rem;color: #ffffff;text-transform:uppercase;display:inline-block;vertical-align:middle;text-decoration:none;">ТЕХПОДДЕРЖКА</a>
        </td>
        <td style='text-align:center;padding:0 0; background:#3e457c; vertical-align:middle; height:20px;border:0;'>
            <a href='/personal/' style="margin:0 50px 0 0;padding:0;font-weight:bold;font-size: 1rem;line-height: 1.2rem;color: #ffffff;text-transform:uppercase;display:inline-block;vertical-align:middle;text-decoration:none;">ЛИЧНЫЙ КАБИНЕТ</a>
        </td>
        <td style='text-align:center;padding:0 0; background:#3e457c; vertical-align:middle; height:20px;border:0;'>
            <a href='/contacts/' style="margin:0 50px 0 0;padding:0;font-weight:bold;font-size: 1rem;line-height: 1.2rem;color: #ffffff;text-transform:uppercase;display:inline-block;vertical-align:middle;text-decoration:none;">КОНТАКТЫ</a>
		</td>
	</tr>

	<tr>
		<td colspan="5" style="padding:1rem 1rem 1rem 1rem; text-align: center;">