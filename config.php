<?php
// Conditions for requests
// Date/time
$date_min = strtotime("1900-01-01");


$hours = [
    'morning_open' => strtotime('09:00'),
    'morning_close' => strtotime('12:00'),
    'afternoon_open' => strtotime('14:00'),
    'afternoon_close' => strtotime('18:00')
];

// Regexes
$RX_ADDRESS = '/^[a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñý\d]{1}[a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñý\d\s-]{0,254}$/';
$RX_NAME = '/^[a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñý]{1}[a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñý\s-]{0,49}$/';
$RX_ZIP = '/^\d{5}$/';
$RX_PHONE = '/^\d{10}$/';
$RX_TIME = '/^((0|1)\d|2[0-3]):[0-5]\d$/';

// Others
$date_format = 'Y-m-d';
$time_format = 'H:i';