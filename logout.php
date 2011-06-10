<?php
require_once('config.php');
$_SESSION['loggedin'] = false;
echo true;
session_destroy();     // this might be more appropriate
exit;
?>