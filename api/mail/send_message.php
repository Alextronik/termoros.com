<?
$to      = 'lysov@termoros.com';
$subject = 'Ошибка на сайте';
$message = 'Ошибка на сайте: '."\r\n"."URL: ".$_GET['url'];
$headers = 'From: site@termoros.com' . "\r\n" .
    'Reply-To: site@termoros.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>