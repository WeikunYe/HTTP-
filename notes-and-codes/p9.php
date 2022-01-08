<?php
// Limits the maximum execution time
set_time_limit(0);
// Turn on output buffering
ob_start();
// Repeat a string
$pad = str_repeat(' ', 4000);

echo $pad, '<br />';
// Flush (send) the output buffer
ob_flush();
// Flush system output buffer
flush();

$i = 1;

while ($i++) {
    echo $pad, '<br />';
    echo $i, '<br />';
    ob_flush();
    flush();

    sleep(1);
}