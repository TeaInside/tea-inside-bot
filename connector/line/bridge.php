<?php

require __DIR__."/../../autoload.php";
require __DIR__."/../../config/line.php";

print LINE::push(json_decode(urldecode($argv[1]), true))['content'];