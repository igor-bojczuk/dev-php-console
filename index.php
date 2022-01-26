<?php
include 'crypto.php';
header('Content-type: application/json');
$encodedApiKey = htmlspecialchars($_GET["apikey"]);
$decodedApiKey = Crypto::decrypt_openssl($encodedApiKey);
$response = array(
  "encodedApiKey" => $encodedApiKey,
  "apiKey" => $decodedApiKey,);
echo json_encode($response);
?>
