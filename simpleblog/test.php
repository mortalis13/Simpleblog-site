<?php
  // mail('caffeinated@example.com', 'My Subject', "test");

  $to      = 'roman.unforgiven@gmail.com';
  $subject = 'the subject';
  $message = 'hello';
  $headers = 'From: stangerroman@gmail.com';

  mail($to, $subject, $message, $headers);

  echo "Message sent: \n";
  echo $headers.'\n';
  echo $message;
?>
