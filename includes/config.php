<?php
@session_start();
/*
this page is for storing application wide configuration values
other scripts can require_once() this file if they need access to this data
*/

/*
timeout duration
----------------
the number of seconds to allow between requests
log user out if they exceed this timeout

//one hour
  const TIMEOUT_IN_SECONDS = 3600 
//change to a lower value for testing, eg:
  const TIMEOUT_IN_SECONDS = 3;
*/
const TIMEOUT_IN_SECONDS = 3600;

?>