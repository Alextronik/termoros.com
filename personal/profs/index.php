<?
define('LEFTBAR3', 'Y');
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if(!Redreams\Partners\partner::isPartner())
{
	$APPLICATION->SetTitle("Мои адреса");
}
else
{
	$APPLICATION->SetTitle("Контрагенты");
}

?>
	<div class="profilepage <?if(Redreams\Partners\partner::isPartner()):?>agent_block<?endif?>">
	<div class='user_profiles'>

			<!--<div class='acc_type'>
				<form class="acc_type_form">
					<input type='radio' <?if($_REQUEST['user_type']==1):?>checked<?endif?> onchange="$('.acc_type_form').submit();" name="user_type" value="1" class='custom_radio' id='r1'><label for='r1'>Физическое лицо</label>
					<input type='radio' <?if($_REQUEST['user_type']==2):?>checked<?endif?> onchange="$('.acc_type_form').submit();" name="user_type" value="2"  class='custom_radio' id='r2'><label for='r2'>Юридическое лицо</label>
				</form>
			</div>-->

			<?	if($_REQUEST['add'])
				{
					CModule::IncludeModule("sale");
					$arFields = array(
					   "NAME" => $_REQUEST['add'] == 1 ? "Новый профиль" : "Новый профиль",
					   "USER_ID" => $USER->GetID(),
					   "PERSON_TYPE_ID" => $_REQUEST['add']
					);
					$USER_PROPS_ID = CSaleOrderUserProps::Add($arFields);
					LocalRedirect('/personal/profs/?added='.$USER_PROPS_ID);
				}
				if(is_set($_REQUEST['delete']))
				{
					CModule::IncludeModule("sale");
					$del = CSaleOrderUserProps::Delete($_REQUEST['delete']);
					//if($del) echo 'удалено';
					//else 'не удалено';
					LocalRedirect('/personal/profs/');
				}

				?>
				<?if($USER->isAuthorized()):?>
				<?$APPLICATION->IncludeComponent("bitrix:sale.personal.profile", "template", array(
						"SEF_MODE" => "N",
						"SEF_FOLDER" => "/personal/profs/",
						"PER_PAGE" => "12",
						"USE_AJAX_LOCATIONS" => "N",
						"SET_TITLE" => "N"
					),
					false
				);?>
				<?endif;?>
				<?
				if(is_set($_REQUEST['ID']))
				{
					//LocalRedirect('/personal/profs/');
				}
				?>

		</div>
		</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>