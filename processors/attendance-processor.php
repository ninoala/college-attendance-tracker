<?php
    @session_start();
    require_once "../includes/config.php";
    require_once "../includes/dbinfo.php";
    require_once "../includes/timeout.php";

    //establish a database connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    //this whole block processes the attendance checkboxes values
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($_POST as $key => $value) {
            //check if the submitted data is related to checkbox values
            if (strpos($key, "week") !== false) {
                //extract student ID and week number from the input name
                $parts = explode("_", $key);
                $studentId = $parts[1];
                $weekNumber = substr($parts[0], -1); //extract the week number from the input name
                //determine the checkbox value and, since both the checkbox and hidden input have the same name, 
                //we prioritize the checkbox value if it's set, otherwise use the hidden input value
                $checkboxValue = isset($_POST[$key]) ? $_POST[$key] : $_POST[$key."_hidden"];
                //update the database with the checkbox value, use prepared statements to prevent SQL injection
                $sql = "UPDATE students SET week$weekNumber = ? WHERE primarykey = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ii", $checkboxValue, $studentId);
                if ($stmt->execute()) {
                    $messages[] = "<p class='green'>Attendance updated successfuly!</p>";
                } else {
                    echo "Error updating attendance: " . $stmt->error;
                }
            }
        }
        
        //since every checkbox is processed within the loop and gets its own message, we only display one message here
         if (!empty($messages)) {
            $firstMessage = reset($messages);
            $messages = array($firstMessage);
            $_SESSION["messages"] = $messages;
         }
         header("location: ../sections/table.php");
         $mysqli->close();
         die();        
    }
