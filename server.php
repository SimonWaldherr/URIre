<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header('X-Powered-By:0xBADCAB1E');
$string = urldecode($_GET['url']);
include "./urire.php";

print_r(urire($string));

?>
