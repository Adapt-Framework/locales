<?php

/* Prevent Direct Access */
defined('ADAPT_STARTED') or die;

$adapt = $GLOBALS['adapt'];

$adapt->sanitize->add_unformatter('phone', function($value){
    return preg_replace("/[\d+]/", "", $value);
});

?>