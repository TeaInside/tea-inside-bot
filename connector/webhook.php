<?php

require __DIR__."/../autoload.php";
$input = urlencode(file_get_contents("php://input"));
shell_exec("nohup /usr/bin/php cli.php \"".urlencode($input)."\" >> ".LOG_DIR."/nohup.out 2>&1 &");