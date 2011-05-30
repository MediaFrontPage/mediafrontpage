<?php
require_once('config.php');
$_SESSION['loggedin'] = false;
?>
<?php
/* Redirect browser */
header("Location: index.php");
/* Make sure that code below does not get executed when we redirect. */
exit;
?>