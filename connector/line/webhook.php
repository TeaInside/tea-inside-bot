<?php

require __DIR__."/../../config/line.php";
require __DIR__."/../../autoload.php";

shell_exec("nohup /usr/bin/php ".__DIR__."/cli.php \"".urlencode(file_get_contents("php://input"))."\" >> ".LOG_DIR."/line.out 2>&1 &");