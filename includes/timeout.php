<?php

@session_start();

require_once "config.php";

if( isset($_SESSION['timeLastActive']) ){
	$timeNow = time();
	$timeLastAcive 	= $_SESSION['timeLastActive'];
	$timeSinceLastRequest = $timeNow - $timeLastAcive;
	if($timeSinceLastRequest > TIMEOUT_IN_SECONDS){
		echo "<p>Timeout has been exceeded!</p>";
		$_SESSION["errormessages"] = array("<p>You have been logged out due to inactivity</p>");
		header("location: logout.php");
		die();
	}else{
		$_SESSION['timeLastActive'] = time();
	}

}else{
	$_SESSION["errormessages"] =  array("<p>You need to login to view content</p>");
	header("location: form.php");
	die();
}