<?php
session_start();
$count = file_get_contents("count.txt");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$output = ['count' => $count, 'total_records' => $_SESSION['total_recs']];
echo "data: ". json_encode($output) . "\n\n";
session_write_close();
flush();