<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?php
if($_FILES['upload_file']['size']>0) {

	if($_FILES['upload_file']['size']>5242880)
	{
		echo '		
			<script type="text/javascript">
			var files=parent.window.document.getElementById("files");
			files.innerHTML="<p class=\'error sub\' >Размер файла превышен!</p>";		
			</script>';
	}
	else
	{
		$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/upload/';
		$uploadfile = $uploaddir . basename($_FILES['upload_file']['name']);
		if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadfile)) {
			$_SESSION['uploaded_file'] = $uploadfile;
			$_SESSION['uploaded_file_name'] = $_FILES['upload_file']['name'];
		}
		elseif(is_file($uploadfile))
		{
			$_SESSION['uploaded_file'] = $uploadfile;
			$_SESSION['uploaded_file_name'] = $_FILES['upload_file']['name'];
		}
		else {
			//echo "Возможная атака с помощью файловой загрузки!\n";
		}

		echo'
			<script type="text/javascript">
			var files=parent.window.document.getElementById("files");
			files.innerHTML="<span>'.$_FILES['upload_file']['name'].'</span><a onclick='."'DeleteFile();'".' class='."'del'".'></a>";		
			</script>
		';
	}
	
	
	
}
?>
