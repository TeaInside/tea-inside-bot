<?php

require __DIR__."/../../autoload.php";
require __DIR__."/../../config/telegram.php";

$a = file_get_contents("php://input");
print shell_exec("nohup /usr/bin/php ".__DIR__."/cli.php \"".urlencode($a)."\" >> ".LOG_DIR."/nohup.out 2>&1 &");
