<?php
    @session_start();
    require_once "config.php";
    $currentYear = date("Y");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>
        <footer class='footer'>
            <p class="footer-text">&copy; <?php echo $currentYear ?> Yegor Nino | For education purposes only</p>
        </footer>
    </body>
</html>