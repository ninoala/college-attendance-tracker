<?php
    @session_start();
    require_once "../includes/dbinfo.php";
    require_once "../includes/functions.php";
    include "../includes/header.php";
?>

<section class="section">
    <h1 class='heading-primary heading-primary--form'>Add a student here:</h1>
    <form action="../processors/add-record-processor.php" method="post" class="form">
        <fieldset class="form__fieldset">
            <label for="firstname" class="form__label">First Name:</label>
            <input type="text" name="firstname" class="form__input">

            <label for="lastname" class="form__label">Last Name: </label>
            <input type="text" name="lastname" class="form__input">

            <label for="id" class="form__label">Student ID:</label>
            <input type="text" name="id" class="form__input">

            <div class="btns-container">
                <button type="submit" class="submit-btn">Add a student</button>
                <a href="table.php" class="submit-btn">Back to table</a>
            </div>

            <?php
                //if there are any error messages related to filling out/processing this form, echo them on the page
                displayMessages("errormessages");
            ?>
        </fieldset>
    </form>
</section>

<?php include "../includes/footer.php"; ?>
