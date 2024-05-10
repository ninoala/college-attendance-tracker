<?php
    @session_start();
    require_once "../includes/config.php";
    require_once "../includes/dbinfo.php";
    $errors = array();

    //check whether both form fields are filled out and assign an empty string to the variable if not 
    if (isset($_POST["username"])) {
        $username = trim($_POST["username"]);
    } else {
        $username = "";
    }   

    if (isset($_POST['password'])) {
        $password = trim($_POST["password"]);
    } else {
        $password = "";
    }

    //give an error message if one field or both are empty
    if (empty($username) && empty($password)) {
        $errors[] = "<p class='red'>Please provide your username and your password</p>";
    } else {
        if (empty($username)) {
            $errors[] = "<p class='red'>Username must be filled out.</p>";
        }

        if (empty($password)) {
            $errors[] = "<p class='red'>Password must be filled out.</p>";
        }
    }

    //check whether username and password match the database and it is a case-sensitive match
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (mysqli_connect_errno() != 0) {
        $errors[] = "<p class='red'>Could not connect to DB: " . $mysqli->connect_error . "</p>";
    }

    $query = "SELECT username FROM users WHERE BINARY username='$username';";
    $result = $mysqli->query($query);
    if (!$result) {
        $errors[] = "<p class='red'>Error retrieving user information: " . $mysqli->error . "</p>";
    } else {
        if (!empty($username) && !empty($password) && $result->num_rows === 0) {
            //username not found
            $errors[] = "<p class='red'>Sorry, this username is not registered in our database</p>";
        } else {
            //username found, proceed to check password
            //separate query for password to ensure that error messages are displayed correctly to the user
            $passwordQuery = "SELECT password FROM users WHERE BINARY username='$username';";
            $passwordResult = $mysqli->query($passwordQuery);
            $passwordRow = $passwordResult->fetch_assoc();
            if (!empty($username) && !empty($password) && $passwordRow['password'] !== $password) {
                //password incorrect
                $errors[] = "<p class='red'>Sorry $username, the password is incorrect</p>";
            }
        }
    }

    //proceed to content or come back to login form
    if (count($errors) > 0) {
        $_SESSION["errormessages"] = $errors;
        header("location: ../index.php");
        die();
    } else {
        $_SESSION["username"] = $username;
        $_SESSION["timeLoggedIn"] = time();
        $_SESSION["timeLastActive"] = time();
        header("location: ../sections/table.php");
        die();
    }
?>
