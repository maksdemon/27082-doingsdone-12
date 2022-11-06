<?php
session_start();
$_SESSION = [];
header ('Location: /templates/guestf.php');
exit;
