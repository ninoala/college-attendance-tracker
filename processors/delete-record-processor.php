<?php
    @session_start();
    require_once "../includes/dbinfo.php";

    //check the radio buttons input
    if (isset($_GET["radio"])) {
        if ($_GET["radio"] === 'yes') {

            //if user chose 'yes', connect to db
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (mysqli_connect_errno() != 0) {
                die("<p>Could not connect to DB: " . $mysqli->connect_error . "</p>");
            }
            
            //create a query that deletes a student record from the db/throws an error in case of failure
            $primaryKey = $_SESSION["primarykey"];
            $query = "DELETE FROM students WHERE primarykey='$primaryKey'";
            if ($mysqli->query($query)) {
                $messages[] = "<p class='green'>Record " . $_SESSION["firstname"] . " " . $_SESSION["lastname"] . " " . $_SESSION["id"] . " deleted successfully</p>";
                $_SESSION["messages"] = $messages;
                header("location: ../sections/table.php");
                $stmt->close();
                $mysqli->close();
                exit();
            } else {
                $messages[] = "<p class='red'>Sorry, something went wrong</p>";
                $_SESSION["messages"] = $messages;
                header("location: ../sections/table.php");
                $stmt->close();
                $mysqli->close();
                exit();
            }

        } else {
            //if user chose 'no', go back to the table
            $messages[] = "<p class='green'>Deletion of the record " . $_SESSION["firstname"] . " " . $_SESSION["lastname"] . " " . $_SESSION["id"] . " cancelled</p>";
            $_SESSION["messages"] = $messages;
            header("location: ../sections/table.php");
            $mysqli->close();
            exit();
        }
    }
?>