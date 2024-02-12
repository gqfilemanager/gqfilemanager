<?php

if (!@include_once("./conf/config.inc.php"))
 include_once("../conf/config.inc.php");

ini_set('magic_quotes_gpc', 1);
ini_set('session.use_trans_sid', 0);

if (isset($session_save_path)) session_save_path($session_save_path);
session_start();

if ( !isset($_SESSION['session_loggedin']) && $phpfm_auth )
{
 exit("<font color='#CC0000'>Access Denied!</font>");
}
 


?>
