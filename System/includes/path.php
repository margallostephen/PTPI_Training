<?php

$systemFolder = "System";
$systemTitle = "PRIMA TECH PHILS., INC.";
$pluginFolder = "/Assets/";

function randomNum() {
    return '?v=' . rand(1000, 9999);
}

if (!function_exists('getPath')) {

    function getPath($plugin)
    {
        global $pluginFolder;
        return $pluginFolder . $plugin . randomNum();
    }
}