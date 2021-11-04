<?
define('LEFTBAR3', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мои адреса");
?>
<div class="partner_page">
	<div class='partner_mainblock'>
		<div class='pm_block pm_left col-9'>
			<?$APPLICATION->IncludeComponent("redreams:partner.address", "");?>
		</div>
		<?include($_SERVER['DOCUMENT_ROOT']."/include/partner_right.php")?>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>