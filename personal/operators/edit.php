<?
define('LEFTBAR3', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Редактирование оператора");
\Bitrix\Main\Loader::includeModule('redreams.partners');

$operatorID = $_REQUEST['oID'];

if(\Redreams\Partners\partner::isCurator() && $operatorID) {
	
	$by = "id";
	$order = "asc";
	$filter = array(
		'ID' => $operatorID,
	);
	$dbUser = \CUser::GetList($by, $order, $filter, array('*', "SELECT" => array('UF_*')));
	$u = $dbUser->GetNext();
	
	
	if (!in_array($USER->GetID(), $u["UF_CURATOR_ID"])) die('pnhdlb');
	
	
	if ($_POST)
	{
		if (!$_POST['F']) $errors[] = 'Поле Фамилия обязательно для заполнения';
		if (!$_POST['email']) $errors[] = 'Поле Email обязательно для заполнения';
		if (!$_POST['contractorsIDs']) $errors[] = 'Необходимо выбрать контрагентов для оператора';
		
		
		if (!$errors)
		{
			$user = new CUser;
			$arFields = Array(
			  "NAME"              => $_POST['N'],
			  "LAST_NAME"         => $_POST['F'],
			  "SECOND_NAME"         => $_POST['O'],
			  "EMAIL"             => $_POST['email'],
			  "LOGIN"             => $_POST['email'],
			  "LID"               => "ru",
			  "ACTIVE"            => "Y",
			  "GROUP_ID"          => array(13),
			  "UF_CURATOR_ID"  => array($USER->GetID()),
			  "UF_OPERATOR_CONTRACTOR_XML_ID"  => $_POST['contractorsIDs'],
			);
			
			if ($_POST['pwd'])
			{
				$arFields = Array(
					"PASSWORD"          => $_POST['pwd'],
					"CONFIRM_PASSWORD"  => $_POST['pwd'],
				);
			}

			$ID = $user->Update($operatorID, $arFields);
			if (intval($ID) > 0)
				$success = TRUE;
			else
				$success = FALSE;
		}
	}
	$contractors = [];
	$fieldsFilter['USER_ID'] = $USER->GetID();
	$res = \CSaleOrderUserProps::GetList([], $fieldsFilter);
	while($ar = $res->GetNext())
	{
		$contractors[] = $ar;
	}
	
	?>
	<?
	if ($errors)
	{
		foreach($errors as $e)
		{
			echo '<b style="color:red">'.$e.'</b><br>';
		}
	}
	
	
	
	?>
	<? if ($success) { ?>
		<p style="color:green">Оператор успешно отредактирован</p>
	<? } ?>
	<form method="post">
		<input type="hidden" name="oID" value="<?=$operatorID?>">
		<table>
			<tr>
				<td>Фамилия<sup style="color:red;">*</sup></td>
				<td><input type="text" name="F" value="<?=$_POST['F']?$_POST['F']:$u["LAST_NAME"]?>"/></td>
			</tr>
			<tr>
				<td>Имя</td>
				<td><input type="text" name="N" value="<?=$_POST['N']?$_POST['N']:$u["NAME"]?>" /></td>
			</tr>
			<tr>
				<td>Отчество</td>
				<td><input type="text" name="O" value="<?=$_POST['O']?$_POST['O']:$u["SECOND_NAME"]?>" /></td>
			</tr>
			<tr>
				<td>Email<sup style="color:red;">*</sup></td>
				<td><input type="text" name="email" value="<?=$_POST['email']?$_POST['email']:$u["EMAIL"]?>" /></td>
			</tr>
			<tr>
				<td>Пароль<sup style="color:red;">*</sup></td>
				<td><input type="password" name="pwd" value="<?=$_POST['pwd']?>" /></td>
			</tr>
			<tr>
				<td>Контрагенты<sup style="color:red;">*</sup></td>
				<td>
				<select name="contractorsIDs[]">
					<?foreach($contractors as $c) { ?>
						<?
						$selected = '';
						if ($_POST)
						{
							foreach($_POST['contractorsIDs'] as $cID)
							{
								if ($c["ID"] == $cID) $selected = 'selected="selected"';
							}
						}
						else
						{
							$fieldsFilter['ID'] = $u["UF_OPERATOR_CONTRACTOR_XML_ID"];
							$res = \CSaleOrderUserProps::GetList([], $fieldsFilter);
							while($ar = $res->GetNext())
							{
								if ($ar["ID"] == $c["ID"]) $selected = 'selected="selected"';
							}
						}
						?>
						<option <?=$selected?> value="<?=$c["ID"]?>"><?=$c["NAME"]?></option>
					<? } ?>
				</select>
				</td>
			</tr>
			<tr>
				<td><input type="submit" value="Отправить"></td>
				<td></td>
			</tr>
		</table>
	</form>
	<?
	
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>