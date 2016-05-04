<?php
/**
 * 
 * @author    Mrqi<https://github.com/mrqi>
 */
function print_line($buf, $arg)
{
    static $max_requests;

    $max_requests++;

    if ($max_requests == 10) {
        event_base_loopexit($arg);
    }

    // print the line
    echo event_buffer_read($buf, 4096);
}

function error_func($buf, $what, $arg)
{
    // handle errors
}

$base = event_base_new();
$eb = event_buffer_new(STDIN, "print_line", NULL, "error_func", $base);

event_buffer_base_set($eb, $base);
event_buffer_enable($eb, EV_READ);

event_base_loop($base);