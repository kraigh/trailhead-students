<?php
if(isset($_POST['contact-email'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "kraigory@gmail.com";
    $email_subject = "Website Contact Form Message";


    function died($error) {
        echo $error;
        die();
    }

    // validation expected data exists
    if(!isset($_POST['contact-name']) ||
        !isset($_POST['contact-email']) ||
        !isset($_POST['contact-message'])) {
        died('We are sorry, but one or more fields are missing. Please fill out all fields.');
    }

    $name = $_POST['contact-name']; // required
    $email_from = $_POST['contact-email']; // required
    $message = $_POST['contact-message']; // required

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
    $email_message = "Form details below.\n\n";

    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Message: ".clean_string($message)."\n";


// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);
?>

<!-- include your own success html here -->

Thank you for contacting us. We will be in touch with you very soon.

<?php
}
?>
