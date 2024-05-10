<?php 
    @session_start();
    require_once "../includes/config.php";
    require_once "../includes/dbinfo.php";
    $errors = array();

    //check if username is provided and validate its length
    if (isset($_POST["username"])) {
        $username = trim($_POST["username"]);
        if (empty($username)) {
            $errors[] = "<p class='red'>Please provide a desired username</p>";
        } elseif (strlen($username) < 4) {
            $errors[] = "<p class='red'>Your username must be at least 4 characters long</p>";
        }
    }

    //session variable for username input field to retain its value after clicking the submit button 
    $_SESSION["submitted_username"] = $_POST["username"];

    //check if password is provided and validate its format
    if (isset($_POST["password"])) {
        $password = trim($_POST["password"]);
        if (empty($password)) {
            $errors[] = "<p class='red'>Please provide a desired password</p>";
        } elseif (!preg_match("/^(?=.*[A-Z])(?=.*[0-9]).{4,}$/", $password)) {
            $errors[] = "<p class='red'>Password must be at least 4 characters long and contain at least 1 number and 1 capital letter</p>";
        }
    }

    //check if password repeat is provided and if it matches the password
    if (isset($_POST["password-repeat"])) {
        $passwordRepeat = trim($_POST["password-repeat"]);
        if (empty($passwordRepeat)) {
            $errors[] = "<p class='red'>Please repeat your desired password</p>";
        } elseif ($password != $passwordRepeat) {
            $errors[] = "<p class='red'>Provided passwords do not match, please check your input again</p>";
        }
    }

    //trim email string if provided
    if (isset($_POST["email"])) {
        $email = trim($_POST["email"]);
    }

    //display only the first error message, if any
    if (!empty($errors)) {
        $firstError = reset($errors);
        $errors = array($firstError);
    }

    //save new acct info and proceed to login form or stay at the new acct form
    if (count($errors) > 0) {
        $_SESSION["errormessages"] = $errors;
        header("location: ../sections/new-account.php");
        die();
    } else {
        //connect to db
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno() != 0) {
            $errors[] = "<p class='red'>Could not connect to DB: " . $mysqli->connect_error . "</p>";
        }
        //create a query that inserts new user's info into the db
        $query = $mysqli->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $query->bind_param("sss", $username, $password, $email);

        if ($query->execute()) {
            $_SESSION["submitted_username"] = '';
            $_SESSION["account_created"] = true;
            header("location: ../index.php");
            die();
        }
    }

?>