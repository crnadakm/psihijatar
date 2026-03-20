<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo 'error';
}

$secretKey = '6LewI14gAAAAAG5ErHkKPXLjkOGOCMCasPKSf20K';
$captcha = $_POST['g-recaptcha-response'];

$ip = $_SERVER['REMOTE_ADDR'];
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
$responseKeys = json_decode($response,true);

if((int)$responseKeys["success"] !== 1) {
    echo 'error';
    die;
}

// Define some constants
define( "RECIPIENT_NAME", "Email sa Web stranice" );
define( "RECIPIENT_EMAIL", "dobar@psihijatar.info" );
//define( "RECIPIENT_EMAIL", "deki.stojkovic87@gmail.com" );
define( "EMAIL_SUBJECT", "Email sa web stranice" );
//define( "EMAIL_SUBJECT", "$subject" );

// Read the form values
$success = false;
$senderName = isset( $_POST['senderName'] ) ? preg_replace( "/[^\.\-\' a-zA-Z0-9]/", "", $_POST['senderName'] ) : "";
$senderEmail = isset( $_POST['senderEmail'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['senderEmail'] ) : "";
//$subject = isset( $_POST['subject'] ) ? preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['subject'] ) : "";
$message = isset( $_POST['message'] ) ? preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message'] ) : "";

// If all values exist, send the email
if ( $senderName && $senderEmail && $message ) {
  $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
  $headers = "From: " . $senderName . " <" . $senderEmail . ">";
  $success = mail( $recipient, EMAIL_SUBJECT , $message, $headers );
}

// Return an appropriate response to the browser
if ( isset($_GET["ajax"]) ) {
  echo $success ? "success" : "error";
} else {
?>
<html>
  <head>
    <title>Thanks!</title>
  </head>
  <body>
  <?php if ( $success ) echo "<p>Hvala Vam što ste nam poslali poruku. Javićemo Vam se ubrzo.</p>" ?>
  <?php if ( !$success ) echo "<p>Molimo pokušajte ponovo.</p>" ?>
  <p>Click your browser's Back button to return to the page.</p>
  </body>
</html>
<?php
}
?>