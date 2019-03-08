<?php
session_start();
require_once '../config/autoload.php';
require_once '../config/config.php';
require_once '../config/custom_routing.php';
require_once '../config/database.php';
require_once '../config/site_owner.php';

spl_autoload_register(function($class_name) {

    if (strpos($class_name, '_helper')) {
        $class_name = 'tg_helpers/'.$class_name;
    }

    require_once $class_name . '.php';
});