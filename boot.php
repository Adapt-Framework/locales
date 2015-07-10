<?php

/* Prevent Direct Access */
defined('ADAPT_STARTED') or die;

$adapt = $GLOBALS['adapt'];

$adapt->sanitize->add_unformat('phone', function($value){
    return preg_replace("/[\d+]/", "", $value);
}, "function(value){
    value = value.replace(/[^0-9]/g, '');
    return value;
}");

?>