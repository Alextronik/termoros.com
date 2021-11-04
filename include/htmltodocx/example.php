<?php
require_once 'phpword/PHPWord.php';

$phpword_object = new PHPWord();
$section = $phpword_object->createSection();

$phpword_object->addTitleStyle(1, array('size'=>20, 'color'=>'000000', 'bold'=>true));
/*
$phpword_object->addFontStyle('rStyle', array('bold'=>true, 'italic'=>true, 'size'=>16));
$phpword_object->addParagraphStyle('pStyle', array('align'=>'left', 'spaceAfter'=>100));
*/
$section->addTitle($FIO, 1);
$section->addText('фыв фыв цйауц аа');

// Save File
$h2d_file_uri = tempnam('', 'htd');
$objWriter = PHPWord_IOFactory::createWriter($phpword_object, 'Word2007');
$objWriter->save($h2d_file_uri);

// Download the file:
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=example.docx');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($h2d_file_uri));
ob_clean();
flush();
$status = readfile($h2d_file_uri);
unlink($h2d_file_uri);
exit;
