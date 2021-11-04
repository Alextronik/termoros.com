<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;
CJSCore::Init(array("fx"));

\Bitrix\Main\UI\Extension::load("ui.bootstrap4");
$curPage = $APPLICATION->GetCurPage(true);

// stylesheets-->
//Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/assets/lib/bootstrap/dist/css/bootstrap.min.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/assets/lib/animate.css/animate.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/assets/lib/components-font-awesome/css/font-awesome.min.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/assets/lib/et-line-font/et-line-font.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/assets/lib/flexslider/flexslider.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/assets/lib/owl.carousel/dist/assets/owl.carousel.min.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/assets/lib/owl.carousel/dist/assets/owl.theme.default.min.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/assets/lib/magnific-popup/dist/magnific-popup.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/assets/lib/simple-text-rotator/simpletextrotator.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/assets/css/style.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/assets/css/colors/default.css");
// fonts
Asset::getInstance()->addString("<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>");
Asset::getInstance()->addString("<link href='https://fonts.googleapis.com/css?family=Volkhov:400i' rel='stylesheet' type='text/css'>");
Asset::getInstance()->addString("<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>");
?><!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
	<title><?$APPLICATION->ShowTitle()?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
	<link rel="shortcut icon" type="image/x-icon" href="<?=SITE_DIR?>favicon.ico" />
	<? $APPLICATION->ShowHead(); ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-6448986-9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-6448986-9');
    </script>
</head>
<body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<main>
    <div class="page-loader">
        <div class="loader">Loading...</div>
    </div>
    <div class="result-loader">
        <div class="loader">Спасибо, Ваша заявка принята</div>
    </div>

	<header>
        <div class="container">
			<!--region bx-header-->
			<div class="row align-baseline text-center">
				<div class="col-12 col-md-3">
                    <a href="<?=$curPage?>"><img src="/local/templates/termoros/img/logo.png" class="logo" width="240" height="65" alt=""></a>
				</div>
                <div class="col-12 col-md-3 d-none d-sm-block">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "page",
                            "AREA_FILE_SUFFIX" => "h_inc_1",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default",
                        ),
                        false
                    );?>
                </div>
                <div class="col-12 col-md-3 d-none d-sm-block">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "page",
                            "AREA_FILE_SUFFIX" => "h_inc_2",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default",
                        ),
                        false
                    );?>
                </div>
                <div class="col-12 col-md-3 d-none d-sm-block">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "page",
                            "AREA_FILE_SUFFIX" => "h_inc_3",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default",
                        ),
                        false
                    );?>
                </div>
            </div>
		</div>
	</header>


