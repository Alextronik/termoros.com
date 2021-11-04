<?
define('LEFTBAR3', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Настройки операторов");
\Bitrix\Main\Loader::includeModule('redreams.partners');


if(\Redreams\Partners\partner::isCurator()) {
	
	?>
	<a href="create.php">Создать оператора</a>
	<?
	
	$by = "id";
	$order = "asc";
	$filter = array(
		'ACTIVE' => "Y",
		'GROUPS_ID' => array(13),
		'UF_CURATOR_ID' => $USER->GetID()
	);
	$dbUser = \CUser::GetList($by, $order, $filter, array('*', "SELECT" => array('UF_*')));
	while($bxUser = $dbUser->GetNext())
	{
		$operators[] = $bxUser;
	}
	
	if ($operators)
	{
		
		
		
		?>
		<table>
			<tr>
				<td>ID</td>
				<td>ФИО</td>
				<td>Контрагенты</td>
				<td>Действия</td>
			</tr>
		<?
		foreach($operators as $u)
		{
			$contractors = [];
			$fieldsFilter['ID'] = $u["UF_OPERATOR_CONTRACTOR_XML_ID"];
			$res = \CSaleOrderUserProps::GetList([], $fieldsFilter);
			while($ar = $res->GetNext())
			{
				$contractors[] = $ar;
			}
			
			//$fieldsFilter['USER_ID'] = $USER->GetID();
			
			
			?>
			<tr>
				<td><?=$u["ID"]?></td>
				<td><?=$u["LAST_NAME"]?> <?=$u["NAME"]?> <?=$u["SECOND_NAME"]?></td>
				<td><?
				foreach($contractors as $c){
					echo $c["NAME"].'<br>';
				}
				?></td>
				<td><a href="edit.php?oID=<?=$u["ID"]?>">Редактировать</a><br><a href="delete.php?oID=<?=$u["ID"]?>">Удалить</a></td>
			</tr>
			<?
		}
		?>
		</table>
		<?
		
	}
	
	
	
	
}
?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>