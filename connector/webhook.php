<?php

require __DIR__."/../autoload.php";
$input = urlencode(file_get_contents("php://input"));

/*$input = '{
		    "update_id": 344262043,
		    "message": {
		        "message_id": 27024,
		        "from": {
		            "id": 243692601,
		            "is_bot": false,
		            "first_name": "Ammar",
		            "last_name": "F",
		            "username": "ammarfaizi2",
		            "language_code": "en-US"
		        },
		        "chat": {
		            "id": 243692601,
		            "title": "Tea Inside",
		            "type": "private"
		        },
		        "date": 1506750221,
		        "text": ""
		    }
		}';
*/

shell_exec("nohup /usr/bin/php ".__DIR__."/cli.php \"".urlencode($input)."\" >> ".LOG_DIR."/nohup.out 2>&1 &");