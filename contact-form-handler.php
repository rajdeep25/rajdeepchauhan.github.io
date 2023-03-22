<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form fields and sanitize the data
  $name = strip_tags(trim($_POST["name"]));
  $name = str_replace(array("\r","\n"),array(" "," "),$name);
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $message = trim($_POST["message"]);

  // Check that all fields are filled out
  if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("HTTP/1.1 400 Bad Request");
    echo "Please fill out all required fields.";
    exit;
  }

  // Set the recipient email address
  $recipient = "rajdeep2798chauhan@gmail.com";

  // Set the email subject
  $subject = "New message from $name";

  // Build the email content
  $email_content = "Name: $name\n";
  $email_content .= "Email: $email\n\n";
  $email_content .= "Message:\n$message\n";

  // Set the email headers
  $headers = "From: $name <$email>";

  // Send the email
  if (mail($recipient, $subject, $email_content, $headers)) {
    header("HTTP/1.1 200 OK");
    echo "Thank You! Your message has been sent.";
  } else {
    header("HTTP/1.1 500 Internal Server Error");
    echo "Oops! Something went wrong and we couldn't send your message.";
  }

} else {
  header("HTTP/1.1 403 Forbidden");
  echo "There was a problem with your submission, please try again.";
}
?>
