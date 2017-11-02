<?php

require __DIR__."/../../config/line.php";
require __DIR__."/../../autoload.php";

print LINE::push(json_decode(urldecode($argv[1]), true))['content'];