<?php

ini_set("display_errors", true);

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
if (file_exists(__DIR__."/vendor/autoload.php")) {
    require __DIR__."/vendor/autoload.php";
} else {
    require __DIR__."/config.php";
    function ___load_class($class)
    {
        require __DIR__."/src/".str_replace("\\", "/", $class).".php";
    }
    spl_autoload_register("___load_class");
}

