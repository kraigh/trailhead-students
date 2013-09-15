<?php
if(isset($_POST['vars'])) {
  $vars = json_decode($_POST['vars'], TRUE);

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "kraigory@gmail.com";
    $email_subject = "Website Contact Form Message";


    function died($error) {
        $response = array(
          'status' => '0',
          'message' => $error
          );

        echo json_encode($response);

        die();
    }

    // validation expected data exists
    if(!isset($vars['name']) ||
        !isset($vars['email']) ||
        !isset($vars['message'])) {
        died('We are sorry, but one or more fields are missing. Please fill out all fields.');
    }

    $name = $vars['name']; // required
    $email_from = $vars['email']; // required
    $message = $vars['message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The email address you entered does not appear to be valid.<br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$name)) {
    $error_message .= 'The name you entered does not appear to be valid.<br />';
  }
  if(strlen($message) < 2) {
    $error_message .= 'The message you entered do not appear to be valid.<br />';
  }
  if(strlen($error_message) > 0) {
    died($error_message);
  }
    $email_message = "Form details below. You may reply to this email, and it will be sent to the requestor.\n\n";

    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
    date_default_timezone_set('America/Chicago');
    $date = date('l, F d \a\t h:i A');

    $email_message .= "Submitted On: ".$date."\n\n";
    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Message: ".clean_string($message)."\n";


// create email headers
$headers = 'From: info@trailheadonline.org'."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);

$response = array(
  'status' => '1',
  'message' => 'success'
  );

echo json_encode($response);


}
?>
