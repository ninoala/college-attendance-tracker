<?php
    @session_start();
    require_once "config.php";
    date_default_timezone_set('America/Los_Angeles');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fraser River College | Attendance Tracker Login</title>
        <link rel="apple-touch-icon" sizes="180x180" href="localhost/college-tracker/assets/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="localhost/college-tracker/assets/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="localhost/college-tracker/assets/favicons/favicon-16x16.png">
        <link rel="manifest" href="localhost/college-tracker/assets/favicons/site.webmanifest">
        <link rel="stylesheet" href="http://localhost/college-tracker/css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    </head>
    <body>
        <header class='header'>
            <div class="header__logo-box">
                <a href="http://localhost/college-tracker/index.php" class="header__link"><img src="http://localhost/college-tracker/assets/logo.png" alt="Website Logo" class="header__img"></a>
            </div>

            <div class='header__time-box'>
                <?php echo date("Y-m-d")."<br/>".date("h:i A")." PST"; ?>
            </div>
        </header>