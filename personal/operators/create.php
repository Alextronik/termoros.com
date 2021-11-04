<?
define('LEFTBAR3', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Создание оператора");
\Bitrix\Main\Loader::includeModule('redreams.partners');

if(\Redreams\Partners\partner::isCurator()) {
	
	if ($_POST)
	{
		if (!$_POST['F']) $errors[] = 'Поле Фамилия обязательно для заполнения';
		if (!$_POST['email']) $errors[] = 'Поле Email обязательно для заполнения';
		if (!$_POST['pwd']) $errors[] = 'Поле Пароль обязательно для заполнения';
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
			  "PASSWORD"          => $_POST['pwd'],
			  "CONFIRM_PASSWORD"  => $_POST['pwd'],
			  "UF_CURATOR_ID"  => array($USER->GetID()),
			  "UF_OPERATOR_CONTRACTOR_XML_ID"  => $_POST['contractorsIDs'],
			);

			$ID = $user->Add($arFields);
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
		<p style="color:green">Оператор успешно добавлен</p>
	<? } else { ?>
	<form method="post">
		<table>
			<tr>
				<td>Фамилия<sup style="color:red;">*</sup></td>
				<td><input type="text" name="F" value="<?=$_POST['F']?>"/></td>
			</tr>
			<tr>
				<td>Имя</td>
				<td><input type="text" name="N" value="<?=$_POST['N']?>" /></td>
			</tr>
			<tr>
				<td>Отчество</td>
				<td><input type="text" name="O" value="<?=$_POST['O']?>" /></td>
			</tr>
			<tr>
				<td>Email<sup style="color:red;">*</sup></td>
				<td><input type="text" name="email" value="<?=$_POST['email']?>" /></td>
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
						foreach($_POST['contractorsIDs'] as $cID)
						{
							if ($c["ID"] == $cID) $selected = 'selected="selected"';
						}
						?>
						<option <?=$selected?> value="<?=$c["ID"]?>"><?=$c["NAME"]?></option>
					<? } ?>
				</select>
				</td>
			</tr>
			<tr>
				<td><input type="submit" value="Создать"></td>
				<td></td>
			</tr>
		</table>
	</form>
	<?
	}
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>