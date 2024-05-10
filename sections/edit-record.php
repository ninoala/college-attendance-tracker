<?php
    @session_start();
    require_once "../includes/dbinfo.php";
    require_once "../includes/functions.php";
    include "../includes/header.php";

    //connect to the db, display an error and terminate script if connection is unsuccessful
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (mysqli_connect_errno() != 0){
        die("<p>Could not connect to DB: ".$mysqli->connect_error."</p>");	
    }

    //check if a primary key is set, sanitize it, construct and execute a query, fetch the result, and store retrieved info in variables
    if (isset($_GET["primarykey"])){
        fetchStudentInfoAndSetSession($_GET["primarykey"]);
    }
?>

<section class="section">
    <form action="../processors/edit-record-processor.php" method="post" class="form">
        <h1 class="heading-primary heading-primary--form">Edit student info:</h1>

        <fieldset class="form__fieldset">
            <label for="firstname" class="form__label">First Name:</label>
            <input type="text" name="firstname" value="<?php echo $_SESSION["firstname"]; ?>" class="form__input">

            <label for="lastname" class="form__label">Last Name:</label>
            <input type="text" name="lastname" value="<?php echo $_SESSION["lastname"]; ?>" class="form__input">

            <label for="id" class="form__label">Student Number:</label>
            <input type="text" name="id" value="<?php echo $_SESSION["id"]; ?>" class="form__input">

           <?php
                //if there are any error messages related to filling out/processing this form, echo them on the page
                displayMessages("errormessages");
            ?>

            <div class="btns-container">
                <button type="submit" class="submit-btn">Edit Record</button>
                <a href="table.php" class="submit-btn">Back to table</a>
            </div>
        </fieldset>
    </form>
</section>

<?php include "../includes/footer.php"; ?>
