<?php

require __DIR__."/../../autoload.php";

$input = '{
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
            "id": -1001128531173,
            "title": "Tea Inside",
            "type": "supergroup"
        },
        "date": 1506750221,
        "text": "dapet materi dari mana?\nlink dong"
    }
}';

$app = new Bot($input);
$app->run();