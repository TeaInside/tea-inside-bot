<?php

require __DIR__."/../../autoload.php";

$input = '{
    "message_id": 3087562,
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
    "date": 1506702849,
    "text": "qwe"
}';

$app = new Bot($input);
$app->run();