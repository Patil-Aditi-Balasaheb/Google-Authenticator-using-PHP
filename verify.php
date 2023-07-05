<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor\autoload.php';
use PragmaRX\Google2FA\Google2FA;

$google2fa = new Google2FA();

$user = $_SESSION['google2fa_user'];
$otp = $_GET['otp'];

$valid = $google2fa->verifyKey($user->google2fa_secret, $otp);

$response = new stdClass();
$response->provided_otp = $otp;
$response->result = $valid;

if ($valid == true) {
    $_SESSION['user'] = "Yes";
}

$response = json_encode($response);
echo $response;

?>