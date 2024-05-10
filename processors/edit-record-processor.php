<?php
    @session_start();
    require_once "../includes/dbinfo.php";

    //declare variables for student info and arrays for errors/messages
    $firstName = "";
    $lastName = "";
    $id = "";
    $primaryKey = $_SESSION["primarykey"];
    $errors = array();
    $messages = array();

    //this whole bunch of if statements check if the student info fields were set and trims the strings
    //and throws errors if fields are missing
    if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["id"])) {
        $firstName = trim($_POST["firstname"]);
        $lastName = trim($_POST["lastname"]);
        $id = trim($_POST["id"]);

        if (empty($firstName)) {
        $errors[] = "<p class='red'>You must fill out the First Name field</p>";
        }

        if (empty($lastName)) {
            $errors[] = "<p class='red'>You must fill out the Last Name field</p>";
        }

        if (empty($id)) {
            $errors[] = "<p class='red'>You must fill out the Student ID field</p>";
        }
    }

    //if there are errors, save them into session variable and terminate the script
    if ( count ($errors) > 0 ) {
        $_SESSION['errormessages'] = $errors;
        header("location: ../sections/edit-record.php");
        die();
    } else {
        //connect to db
        $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
        if( mysqli_connect_errno() != 0 ){
            die("<p class='red'>Could not connect to DB: ".$mysqli->connect_error."</p>");	
        }

        //check if the new ID already exists in the database and throw an error if it is a duplicate
        $checkQuery = "SELECT COUNT(*) AS count FROM students WHERE id='$id' AND primarykey != '$primaryKey'";
        $checkResult = $mysqli->query($checkQuery);
        $checkRow = $checkResult->fetch_assoc();
        $existingCount = $checkRow['count'];
        if ($existingCount > 0) {
            $errors[] = "<p class='red'>Student ID '$id' already exists. Please choose a different ID.</p>";
            $_SESSION["errormessages"] = $errors;
            header("location: ../sections/edit-record.php");
            die();
        }
        
        //create a query that updates a student record with user's input
        $query = "UPDATE students SET firstname='$firstName', lastname='$lastName', id='$id' WHERE primarykey='$primaryKey';";
        $result = $mysqli->query( $query );
        if ($result) {
            $messages[] = "<p class='green'>".$firstName." ".$lastName." ".$id." updated successfuly!</p>";
            $_SESSION["messages"] = $messages;
            header("location: ../sections/table.php");
            $mysqli->close();
            die(); 
        }
    }
?>