<?php

require __DIR__."/../../autoload.php";
require __DIR__."/../../config/telegram.php";

$a = file_get_contents("php://input");
filr_put_contents("a.tmp", json_encode(json_decode($a), 128));
print shell_exec("nohup /usr/bin/php ".__DIR__."/cli.php \"".urlencode($a)."\" >> ".LOG_DIR."/nohup.out 2>&1 &");