<?php
include 'includes/crypto.php';
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

$encodedApiKey = htmlspecialchars($_GET["apikey"]);
$decodedApiKey = Crypto::decrypt_openssl($encodedApiKey);
$response = array(
  "encodedApiKey" => $encodedApiKey,
  "apiKey" => $decodedApiKey,);
echo json_encode($response);
?>
