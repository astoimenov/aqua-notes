<?php

if (!function_exists('dd')) {
    function dd($value)
    {
        dump($value);
        die;
    }
}
