<?php
    @session_start();
    require_once "../includes/config.php";
    require_once "../includes/dbinfo.php";
    require_once "../includes/timeout.php";
    require_once "../includes/functions.php";
    include "../includes/header.php";
?>

<section class="section section--table">
    <h1 class="heading-primary heading-primary--form">Welcome to Web Scripting 103, <?php echo $_SESSION["username"]; ?></h1>

    <?php 
        if (isset($_SESSION["username"])) {
            //create connection to the db and retrieve students info/throw an error if connection is unsuccessful
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (mysqli_connect_errno() != 0){
                die("<p>Could not connect to DB: ".$mysqli->connect_error."</p>");	
            }
            $query = "SELECT id, firstname, lastname, primarykey, week1, week2, week3, week4 FROM students ORDER BY primarykey;";
            $result = $mysqli->query($query);

            //put the number of student records available into a variable and echo it on the page
            $numberOfRecordsInResult = $result->num_rows;
            echo "<p class='form__paragraph form__paragraph--table'>Number of students in your class: <span class='green'> ".$numberOfRecordsInResult."</span></p>";
            
            //echo explanation and buttons to add student, save attendance and logout
            echo "<p class='form__paragraph form__paragraph--explanation'>Please mark the checkboxes next to the names of students present in class each week, then click 'Save Attendance' to save your changes.</p>";
            echo "<div class='btns-container'><a href='add-record.php' class='submit-btn'>Add a student</a>";
            echo "<button type='submit' class='submit-btn' form='attendance-form'>Save Attendance</button>";
            echo "<a href='../processors/logout-processor.php' class='submit-btn'>Logout</a></div>";

            //if there are any error messages related to filling out/processing this form, echo them on the page
            displayMessages("errormessages");

            //display success messages if any
            displayMessages("messages");

            //start of the form for processing purposes and table
            echo "<form class='form--attendance' id='attendance-form' method='post' action='../processors/attendance-processor.php'>";
            echo "<table class='table'>";
            echo "<tr>";

            //define column names and map them to desired display names
            $columnNamesMap = array(
                "id" => "Student ID",
                "firstname" => "First Name",
                "lastname" => "Last Name",
                "week1" => "Week 1",
                "week2" => "Week 2",
                "week3" => "Week 3",
                "week4" => "Week 4",
            );

            //render table headers
            foreach ($columnNamesMap as $columnName) {
                if ($columnName != 'Edit' && $columnName != 'Delete') {
                    echo "<th>".$columnName."</th>";
                }
            }
            echo "<th>Edit</th>";
            echo "<th>Delete</th>";
            echo "</tr>";

            //render table rows
            while ($oneRecord = $result->fetch_assoc()) {
                echo "<tr>";
                
                //render student information
                foreach ($oneRecord as $columnName => $value) {
                    if ($columnName == 'primarykey') continue; //skip rendering the primary key

                    elseif (strpos($columnName, 'week') !== false) { //render checkboxes for each week
                        echo "<td>";
                        $weekNumber = substr($columnName, -1); // Extract the week number from the column name
                        $checkboxName = "week$weekNumber" . "_" . $oneRecord['primarykey']; //construct the name attribute
                        //hidden input field to ensure unchecked checkboxes still submit a value
                        echo "<input type='hidden' name='$checkboxName' value='0'>";
                        echo "<input type='checkbox' name='$checkboxName' value='1'";
                        if ($value == 1) {
                            echo " checked"; //check the checkbox if attendance is recorded
                        }
                        echo ">";
                        echo "</td>";

                    } else {
                        echo "<td>".$value."</td>"; //render regular cell for non-week columns
                    }
                }
                
                //render Edit and Delete buttons
                $primaryKey = $oneRecord["primarykey"];
                echo "<td><a href='edit-record.php?primarykey=".$primaryKey."'><img src='../assets/edit.svg' alt='Edit icon' class='svg-icon'></a></td>";
                echo "<td><a href='delete-record.php?primarykey=".$primaryKey."'><img src='../assets/delete.svg' alt='Delete icon' class='svg-icon'></a></td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</form>";

        } else {
            $errors[] = "<p class='red'>You need to login first to have access to this page</p>";
            $_SESSION["errormessages"] = $errors;
            header("location: ../index.php");
            die();
        }
    ?>
</section>

<?php include "../includes/footer.php"; ?>