<?php
$to = $_POST['toEmail'];
$subject = $_POST['fieldSubject']; 

// Get file info
$tmpName = $_FILES['attachment']['tmp_name']; 
$fileType = $_FILES['attachment']['type']; 
$fileName = $_FILES['attachment']['name']; 

if (file($tmpName)) { 
  $file = fopen($tmpName,'rb'); 
  $data = fread($file,filesize($tmpName)); 
  fclose($file); 

  $randomVal = md5(time()); 
  $mimeBoundary = "==Multipart_Boundary_x{$randomVal}x"; 

  $headers = "From: $fromName"; 

  $headers .= "\nMIME-Version: 1.0\n"; 
  $headers .= "Content-Type: multipart/mixed;\n" ;
  $headers .= " boundary=\"{$mimeBoundary}\""; 

  $message = "This is test email\n\n";
  $data = base64_encode($data); 
} 

$result = mail ("$to", "$subject", "$message", "$headers"); 

if($result){
  echo "A email has been sent to: $to";
 }
else{
  echo "Error while sending email";
}