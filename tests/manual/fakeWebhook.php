<?php

require __DIR__."/../../autoload.php";

$input = '{
    "message_id": 3091348,
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
        "first_name": "Ammar",
        "last_name": "F",
        "username": "ammarfaizi2",
        "type": "private"
    },
    "date": 1506742730,
    "reply_to_message": {
        "message_id": 3091343,
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
            "first_name": "Ammar",
            "last_name": "F",
            "username": "ammarfaizi2",
            "type": "private"
        },
        "date": 1506742728,
        "text": "asdf"
    },
    "text": "zxcv"
}';

$app = new Bot($input);
$app->run();