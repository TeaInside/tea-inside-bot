<?php

require __DIR__."/../../autoload.php";
require __DIR__."/../../config/line.php";

$a = file_get_contents("php://input");
/*$a = '{
    "events": [
        {
            "type": "message",
            "replyToken": "dd09494b34a44ea6938071e3bf9eb66d",
            "source": {
                "groupId": "Ce20228a1f1f98e6cf9d6f6338603e962",
                "userId": "Uadc81288db14210ff9b062e0605b805f",
                "type": "group"
            },
            "timestamp": 1509627226770,
            "message": {
                "type": "text",
                "id": "6931596169680",
                "text": "Nyepakne mental, ono kimia mania"
            }
        }
    ]
}';*/

shell_exec("nohup /usr/bin/php ".__DIR__."/cli.php \"".urlencode($a)."\" >> ".LOG_DIR."/line.out 2>&1 &");