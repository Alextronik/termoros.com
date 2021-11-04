<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;?>
			</div><!--end row-->
		</div><!--end .container.bx-content-section-->
	</div><!--end .workarea-->

	<footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <p class="copyright font-alt">&copy; <?=date("Y")?>&nbsp;ТЕРМОРОС</p>
                </div>
                <div class="col-sm-6 text-right">
                    <!--div class="footer-social-links"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a><a href="#"><i class="fa fa-skype"></i></a>
                    </div-->
                    <div class="main-link"><a href="/">Перейти на основной сайт ТЕРМОРОС</a></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "page",
                            "AREA_FILE_SUFFIX" => "f_inc_1",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default",
                        ),
                        false
                    );?>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "page",
                            "AREA_FILE_SUFFIX" => "f_inc_2",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default",
                        ),
                        false
                    );?>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "page",
                            "AREA_FILE_SUFFIX" => "f_inc_3",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default",
                        ),
                        false
                    );?>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "page",
                            "AREA_FILE_SUFFIX" => "f_inc_4",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default"
                        ),
                        false
                    );?>
                </div>
            </div>
        </div>
	</footer>
</div> <!-- //bx-wrapper -->
<!--JavaScripts-->
<?php
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/lib/bootstrap/dist/js/bootstrap.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/lib/wow/dist/wow.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/lib/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/lib/isotope/dist/isotope.pkgd.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/lib/imagesloaded/imagesloaded.pkgd.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/lib/flexslider/jquery.flexslider.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/lib/owl.carousel/dist/owl.carousel.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/lib/smoothscroll.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/lib/magnific-popup/dist/jquery.magnific-popup.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/lib/simple-text-rotator/jquery.simple-text-rotator.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/plugins.js");
Asset::getInstance()->addJs("/bitrix/templates/termoros/js/radio.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/plugins.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/main.js");
?>

<script>
	BX.ready(function(){
		var upButton = document.querySelector('[data-role="eshopUpButton"]');
		BX.bind(upButton, "click", function(){
			var windowScroll = BX.GetWindowScrollPos();
			(new BX.easing({
				duration : 500,
				start : { scroll : windowScroll.scrollTop },
				finish : { scroll : 0 },
				transition : BX.easing.makeEaseOut(BX.easing.transitions.quart),
				step : function(state){
					window.scrollTo(0, state.scroll);
				},
				complete: function() {
				}
			})).animate();
		})
	});
</script>
</main>
</body>
</html>