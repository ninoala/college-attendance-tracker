<?php
    @session_start();
    require_once "../includes/dbinfo.php";

    //declare variables for student info and arrays for errors/messages
    $firstname = "";
    $lastname = "";
    $id = "";
    $errors = array();
    $messages = array();

    //this whole bunch of if statements check if the student info fields were set and trims the strings
    //and throws errors if fields are missing
    if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["id"])) {
        $firstname = trim($_POST["firstname"]);
        $lastname = trim($_POST["lastname"]);
        $id = trim($_POST["id"]);
    } else {
        $errors[] = "<p class='red'>You must fill out the form</p>";
    }

    if (!empty($firstname)) {
        $_SESSION["firstname"] = $firstname;
    } else {
        $errors[] = "<p class='red'>You must fill out the First Name field</p>";
    }

    if (!empty($lastname)) {
        $_SESSION["lastname"] = $lastname;
    } else {
        $errors[] = "<p class='red'>You must fill out the Last Name field</p>";
    }

    if (!empty($id)) {
        $_SESSION["id"] = $id;
    } else {
        $errors[] = "<p class='red'>You must fill out the Student ID field</p>";
    }

    //display errors if any
    if (count ($errors) > 0) {
        $_SESSION["errormessages"] = $errors;
        header("location: ../sections/add-record.php");
        die();

    } else {

        //connect to db
        $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
        if(mysqli_connect_errno() != 0){
            die("<p class='red'>Could not connect to DB: ".$mysqli->connect_error."</p>");	
        }

        //check if the input Student ID already exists in the database and throw an error if it does
        $checkQuery = "SELECT COUNT(*) AS count FROM students WHERE id='$id' AND primarykey != '$primaryKey'";
        $checkResult = $mysqli->query($checkQuery);
        $checkRow = $checkResult->fetch_assoc();
        $existingCount = $checkRow["count"];
        if ($existingCount > 0) {
            $errors[] = "<p class='red'>Student ID '$id' already exists. Please choose a different ID.</p>";
            $_SESSION["errormessages"] = $errors;
            header("location: ../sections/add-record.php");
            die();
        }

        //insert a new student record into the db
        $query = "INSERT INTO students (firstname, lastname, id) VALUES('$firstname', '$lastname', '$id');";
        $result = $mysqli->query( $query );
        if ($result) {
            $messages[] = "<p class='green'>" .$firstname. " " .$lastname. " " .$id. " inserted successfuly!</p>";
            $_SESSION["messages"] = $messages;
            header("location: ../sections/table.php");
            unset($_SESSION["firstname"]);
            unset($_SESSION["lastname"]);
            unset($_SESSION["id"]);
            die(); 
        } else {
            $messages[] = "<p class='red'>Something went wrong!</p>";
            $_SESSION["errormessages"] = $errors;
            header("location: ../sections/table.php");
            die();
        }

    }
?>