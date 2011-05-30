<?php
require_once("config.php");
If (!$authsecured) {
    header('Location: index.php');
    exit;
}
if (isset($_POST['user']) && isset($_POST['password'])) {
    if ($_POST['user']==$authusername && $_POST['password']==$authpassword) {
        // OK
        $_SESSION['loggedin'] = true;
        header('Location: index.php');
        exit;
    } else {
        echo "Bad login credentials. <a href=\"login.php\">Try again</a>";
    }
} else {
    // not logging in
    header('Location: login.php');
    exit;
}
?>

