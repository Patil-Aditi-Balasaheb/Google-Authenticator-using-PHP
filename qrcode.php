<?php

// start server session
session_start();

// display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// including composer packages
require 'vendor\autoload.php';
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

// database connection
$con = mysqli_connect("localhost", "root", "", "testing");

if ($con) {
    if (isset($_POST['submit'])) {
        $username = $_POST['email'];
        $password = $_POST['password'];

        //to prevent from mysqli injection  
        $username = stripcslashes($username);
        $password = stripcslashes($password);
        $username = mysqli_real_escape_string($con, $username);
        $password = mysqli_real_escape_string($con, $password);

        $sql = "select * from user where email = '$username' and password = '$password'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            $retval = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
                $secret_key = $row['secret_key'];
            }

            if ($secret_key) {
                // initiate google2fa object
                $google2fa = new Google2FA();

                // generate a secret key and a test user
                $user = new stdClass();

                // $user->google2fa_secret = $google2fa->generateSecretKey();
                $user->google2fa_secret = $secret_key;

                // $user->email = 'abc@gmail.com';
                $user->email = $username;

                // store user data and key in server session
                $_SESSION['google2fa_user'] = $user;

                // app name
                $app = 'Test Google Authenticator';

                // generate a custom url from user data to provde to qr code generator
                $qrCodeUrl = $google2fa->getQRCodeUrl(
                    $app,
                    $user->email,
                    $user->google2fa_secret
                );

                // QR code generation
                // set up image renderer and writer
                $renderer = new ImageRenderer(
                    new RendererStyle(250),
                    new SvgImageBackEnd()
                );

                $writer = new Writer($renderer);

                // store Qr code image in the server
                // $writer->writeFile($qrCodeUrl, 'qrcode.svg');

                // create a string with the image data and base64 encode it
                $encoded_qr_data = base64_encode($writer->writeString($qrCodeUrl));

                // provide us with current password
                $current_otp = $google2fa->getCurrentOtp($user->google2fa_secret);
            }
        } else {
            echo "<script>alert('Username/Password Invalid !');document.location ='index.php';</script>";
        }
    } else {
        header("Location: index.php");
    }
}

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR code verification</title>

    <style>
        .container {
            text-align: center;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Mithiyaj</h1>
        <h2>QR code</h2>
        <p><img src="data:image/svg+xml;base64,<?= $encoded_qr_data; ?>" alt="QR code"></p>
        <p>One-time password at time of generation:
            <?= $current_otp; ?>
        </p>
        <h2>Verify Code</h2>
        One-time password: <input type="number" name="otp" id="otp" required />
        <input type="button" value="Verify" onclick="verify_otp();" />
    </div>
</body>

</html>

<script>

    let input_otp = document.getElementById('otp');
    const verify_otp = async () => {
        let otp = document.getElementById('otp').value;
        fetch('verify.php?otp=' + otp)
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                if (data.result == true) {
                    document.location = 'home.php';
                } else {
                    alert("Invalid QR code! Please try again!");
                }
            });
    }

</script>