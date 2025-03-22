<?php

session_start();

$_SESSION = [];


session_destroy();


header("Location: log.php");
exit();
?>
