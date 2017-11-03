<?php

ini_set("display_errors", true);

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
if (file_exists(__DIR__."/vendor/autoload.php")) {
    include __DIR__."/vendor/autoload.php";
} else {
    include "config/init.php";
    function ___load_class($class)
    {
        include __DIR__."/src/".str_replace("\\", "/", $class).".php";
    }
    spl_autoload_register("___load_class");
}

