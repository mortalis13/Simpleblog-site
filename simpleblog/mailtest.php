<?php
  $to = "valbordruj@gmail.com";
  $subject = "Hi! ";
  $body = "TEST";
  $headers = "MIME-Version: 1.0";
  $headers.= "Content-type:text/html;charset=UTF-8";
  $headers.= "From: stangerroman@gmail.com";

  if(mail($to,$subject,$body,$headers)) echo "MAIL - OK";
  else echo "MAIL FAILED";
?>
