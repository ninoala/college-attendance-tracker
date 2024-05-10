<?php
    @session_start();
    require_once "includes/config.php";
    require_once "includes/functions.php";
    include "includes/header.php";
?>

<section class="section">
    <h1 class="heading-primary">Fraser River College <br/> Attendance Tracker</h1>

    <h2 class="heading-secondary">Please sign in with your instructor credentials:</h2>

    <?php
        //if user just created a new account and is redirected back to the login form, display this message:
        if (isset($_SESSION["account_created"]) && $_SESSION["account_created"] === true) {
            echo "<p class='green'>Account successfully created, please login now:</p>";
            unset($_SESSION["account_created"]);
        }
    ?>

    <form method="post" action="processors/login-form-processor.php" class="form">
        <fieldset class="form__fieldset">
            <label for="username" class="form__label">Username:</label>
            <input type="text" name="username" class="form__input">
        </fieldset>

        <fieldset class="form__fieldset">
            <label for="password" class="form__label">Password:</label>
            <input type="password" name="password" id="password" class="form__input">
        </fieldset>

        <p class="form__paragraph">Need an account? You can <a href="sections/new-account.php" class="form__link">register here</a> or please use 'demo/demo' to login</p>

        <?php
            //if there are any error messages related to filling out/processing this form, echo them on the page
            displayMessages("errormessages");
        ?>

        <button type="submit" class="submit-btn">Login</button>
    </form>
</section>

<?php include "includes/footer.php"; ?>

