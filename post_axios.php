<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
session_start();
$time = date('r');
echo "data: The server time is: {$time} \n\n";
echo "data: {$_SESSION['file']} \n\n";

flush();
?>