<?php
    @session_start();
    require_once "../includes/config.php";
    require_once "../includes/dbinfo.php";
    require_once "../includes/functions.php";
    include "../includes/header.php";
 
    //session variable for username input field to retain its value after clicking the submit button 
    $submittedUsername = isset($_SESSION["submitted_username"]) ? htmlspecialchars($_SESSION["submitted_username"]) : '';
?>

<section class="section section--new-account">
    <h1 class="heading-primary heading-primary--form">Please fill out the information to create a new account:</h1>

    <form method="post" action="../processors/new-account-processor.php" class="form">
        <fieldset class="form__fieldset">
            <label for="username" class="form__label">Create a username (at least 4 characters):</label>
            <input type="text" name="username" value="<?php echo $submittedUsername; ?>" class="form__input">
        </fieldset>

        <fieldset class="form__fieldset">
            <label for="password" class="form__label">Create a password (at least 4 characters, must contain at least 1 number and 1 capital letter):</label>
            <input type="password" name="password" id="password" class="form__input">
        </fieldset>

        <fieldset class="form__fieldset">
            <label for="password-repeat" class="form__label">Repeat your password:</label>
            <input type="password" name="password-repeat" id="password-repeat" class="form__input">
        </fieldset>

        <fieldset class="form__fieldset">
            <label for="email" class="form__label">Provide your email address(optional):</label>
            <input type="email" name="email" id="email" class="form__input">
        </fieldset>

        <?php
            //if there are any error messages related to filling out/processing this form, echo them on the page
            displayMessages("errormessages");
        ?>
        
        <div class="btns-container">
            <button type="submit" class="submit-btn">Create new account</button>
            <a href="../index.php" class="submit-btn">Back to login</a>
        </div>
    </form>
</section>

<?php include '../includes/footer.php'; ?>