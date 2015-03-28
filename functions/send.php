<?php

/* Replacement send.php eliminating dependency on squirrelmail
Requires phpmailer class to be installed. (http://phpmailer.sourceforge.net)
What is $smtp_helo ?
- tendays: that's what is send as parameter to the smtp HELO command
when contacting the mail server  */

require_once (FS_PATH . "vars.php");

require_once (FS_PATH . "class.phpmailer.php");

require_once (FS_PATH . "functions/tools.php");

function send_message($from,$to,$subject,$body) {
  global $smtp_server,$sender_name,$smtp_helo,$smtp_auth,$smtp_user,$smtp_pass,$unsecure_login,$lang;

  if ($unsecure_login) { // on dev system, don't send real emails ...
    echo "<div class='dontprint'><pre>From: $from\n";
    echo "To: $to\n";
    echo "Subject: $subject\n\n";
    echo $body;
    echo "EOD</pre></div>";
    return true;
  }
  $mail = new PHPMailer();
  $mail->IsSMTP();      	// send via SMTP
  $mail->Host     = $smtp_server;
  $mail->Helo     = $smtp_helo;
  $mail->SMTPAuth = $smtp_auth;
  if ($smtp_auth) {
    $mail->Username = $smtp_user;
    $mail->Password = $smtp_pass;
  }
  $mail->From     = $from;
  $mail->FromName = $sender_name;
  $mail->AddAddress($to);
  // $mail->AddReplyTo();
  // $mail->WordWrap = 50;
  // $mail->AddAttachment("/var/tmp/file.tar.gz");      // no attachments for now
  $mail->IsHTML(true);  	// send as HTML?
  $mail->Subject  =  $subject;
  $mail->Body     =  $body;
  if(!$mail->Send())  {
    kaboom(sprintf($lang["err_smtp"],$to,$mail->ErrorInfo ));
    return false;
  }
  $mail->ClearAddresses();
  $mail->ClearAttachments();
  return true;
}

?>
