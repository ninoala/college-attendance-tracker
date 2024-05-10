<?php
    @session_start();

    //a function to display available error messages/success messages on the page
    function displayMessages($type) {
        if (isset($_SESSION[$type]) && !empty($_SESSION[$type])) {
            echo "<div class='$type'>";
            foreach ($_SESSION[$type] as $message) {
                echo $message;
            }
            echo "</div>";
            unset($_SESSION[$type]);
        }
    }

    //a function to fetch student info by primary key and set session variables
    function fetchStudentInfoAndSetSession($primaryKey) {
        global $mysqli;
        //sanitize the primary key
        $primaryKey = $mysqli->real_escape_string($primaryKey);
        //construct and execute the query
        $query = "SELECT firstname, lastname, id, primarykey FROM students WHERE primarykey='$primaryKey'";
        $result = $mysqli->query($query);
        //fetch the result and store retrieved info in variables
        if ($result && $record = $result->fetch_assoc()) {
            $_SESSION["primarykey"] = $record["primarykey"];
            $_SESSION["firstname"] = $record["firstname"];
            $_SESSION["lastname"] = $record["lastname"];
            $_SESSION["id"] = $record["id"];
        }
    }   
?>