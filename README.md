﻿# Google-Authenticator-using-PHP

#### Download or clone the repository in the htdocs folder of your xampp.

#### You can rename the folder to testing.

#### Install the following packages using composer
> composer require pragmarx/google2fa <br>
> composer require bacon/bacon-qr-code

#### Start the Apache and MySQL services from the XAMPP Control Panel.

#### Setup the database:
    1. Goto browser and type localhost/phpmyadmin .
    2. Click on the Import button in menu and choose the file testing.sql and click on Import button.

#### Run the code in browser by typing the url - localhost/testing or localhost/[folder-name in which you have code]

#### Steps for Execution:
    1. In Login page Enter username, password and click Submit.
    2. You will be redirected to the QR code verification page.
        - Scan the QR code using the Google Authenticator App in your mobile and you will get new OTP after every 30 secs.
        - Enter the OTP and click on Verify button.
    3. You will be redirected to the Home page.
