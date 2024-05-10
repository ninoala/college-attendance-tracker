<?php
    @session_start();
    require_once "../includes/dbinfo.php";
    require_once "../includes/functions.php";
    include "../includes/header.php";
?>

<section class="section">
    <h1 class="heading-primary heading-primary--form">Delete a student record:</h1>

    <?php
        //connect to the db, display an error and terminate script if connection is unsuccessful
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno() != 0){
            die("<p>Could not connect to DB: ".$mysqli->connect_error."</p>");	
        }

        //check if a primary key is set, sanitize it, construct and execute a query, fetch the result, and store retrieved info in variables
        if (isset($_GET["primarykey"])){
            fetchStudentInfoAndSetSession($_GET["primarykey"]);
        }
        
        //echo the info of the student record being deleted on the page
        echo "<p class='green'>".$_SESSION["firstname"]." ".$_SESSION["lastname"]." ".$_SESSION["id"]."</p>";
        
        //close the db connection
        $mysqli->close();
    ?>

    <form action="../processors/delete-record-processor.php" method="get" class="form">
        <fieldset class="form__fieldset form__fieldset--delete">
            <legend class="form__legend">Are you sure you would like to delete the record above?</legend>
            <div class="form__flex-container">
                <input type="radio" id="yes" name="radio" value="yes" class="form__radio">
                <label for="yes" class="form__label">Yes</label>
                <input type="radio" id="no" name="radio" value="no" class="form__radio" checked> 
                <label for="no" class="form__label">No</label>
            </div>
            <input type="hidden" name="primarykey" value="<?php echo $_SESSION["primarykey"]; ?>">
            <div class="btns-container">
                <button type="submit" value="result" class="submit-btn">Submit</button>
                <a href="table.php" class="submit-btn">Back to table</a>
            </div>
        </fieldset>
    </form>
</section>

<?php include '../includes/footer.php'; ?>