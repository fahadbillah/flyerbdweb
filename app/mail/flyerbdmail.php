<?php 
require_once '../mail/phpmailer/class.phpmailer.php';

$data = json_decode(file_get_contents("php://input"));
/*echo $data->name;
echo $data->email;
echo $data->feedback;*/

if($data->name==="" || $data->email==="" || $data->feedback===""){
	return 0;
}
$senderName = trim($data->name);
$senderEmail = trim($data->email);
$senderFeedback = trim($data->feedback);
$receiverName = "FlyerBD Developer Team";
$Subject = "FlyerBD Feedback";
$msg = "Name: ".$senderName."\r\nEmail: ".$senderEmail."\r\nFeedback: ".$senderFeedback;

$to = 'gan.mahmud@gmail.com,murshed.soudi@gmail.com,billah22@gmail.com';

if(mail($to, $Subject, $msg))
	return true;
else
	return false;

/*$mail = new PHPMailer;

$mail->isSMTP();   */                                   // Set mailer to use SMTP
/*$mail->Host = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup server
$mail->Port       = 587;    
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'AKIAJXGHEY76LTLY5CYQ';                            // SMTP username
$mail->Password = 'At7MVdoCOlTe5P9+RVI9b+tMsF6WVxLjkQf0eu2p8ABy';    // SMTP password
$mail->SMTPSecure = 'tls'; */                                   // Set mailer to use SMTP


/*$mail->Host = 'mail.flyerbd.com';  // Specify main and backup server
$mail->Port       = 26;    
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'info@flyerbd.com';                            // SMTP username
$mail->Password = '080722';    // SMTP password
//$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
$SMTPDebug	= true;

$mail->SetFrom('fahadbillah@yahoo.com', $Subject);

$mail->addAddress('gan.mahmud@gmail.com', 'Gan'); 
$mail->addAddress('billah22@gmail.com', 'Fahad'); 
$mail->addAddress('murshed.soudi@gmail.com', 'Soudi'); 
$mail->addReplyTo($senderEmail, $senderName);


//$mail->WordWrap = 50;                                 // Set word wrap to 50 characters

//$mail->isHTML(true);                                  // Set email format to HTML

//$message = $body;

$mail->Subject = $Subject;
$mail->Body    = $msg;
//$mail->AltBody = $message;


if(!$mail->send()) {
	//echo 'Message could not be sent.';
	//echo 'Mailer Error: ' . $mail->ErrorInfo;
	//exit();
	return false;
}
return true;*/
//echo "Mail sent!";
//header('Location: http://staging.iquantum.com.au/glenvill.com.au/thanks-contact/');

?>