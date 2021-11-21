<?php

$ftype = 0;
$fnsmr = 0;

header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
 header("Cache-Control: public");
 header("Content-Type: ".$ftype);
 header("Content-Transfer-Encoding: Binary");
 header("Content-Length:".filesize($fname));

?>