<?php 
require_once 'phpmailer/PHPMailerAutoload.php';

$message = "Test Email By Hardik";

$smmail = new PHPMailer();
$smmail->IsSMTP(); // enable SMTP
$smmail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$smmail->SMTPAuth = true; // authentication enabled
	
//$smmail->SMTPSecure = 'ssl';
$smmail->SMTPSecure = '';

$smmail->Host = "findbo.dk";
	
$smmail->Port = 25;
	
$smmail->IsHTML(true);
	
$smmail->Username = "noreply.findbo";
//$smmail->Username = "info.findbo";

$smmail->Password = "d3EUJR4CrWpiN6ux";
//$smmail->Password = "FindboDK89";

$smmail->SetFrom("noreply@findbo.dk", "Findbo");
	
$smmail->Subject = 'test email';

$smmail->MsgHTML($message);

$smmail->AddAddress( trim("hardik@desireinfoway.com") );

if($smmail->Send())
{
	echo "sent";
}
else
{
	echo $smmail->ErrorInfo;
}
?>