<?php

require __DIR__."/../../autoload.php";

use Telegram as B;

/*
$msg = "
<b>Circle CI Report</b>:
- Starting node
- Enabling sudo
- Applying container tweaks
- cmd: rm -f /etc/apt/sources.list.d/{google.list,google-chrome.list,typesafe-apt.list}; if [ -e /home/ubuntu/.config ]; then chown -R ubuntu /home/ubuntu/.config; fi; echo 'export PATH=/opt/google-cloud-sdk/bin:\$PATH' >> /home/ubuntu/.circlerc
- Host fingerprint: 4e:51:15:51:02:b7:c5:59:b2:da:2a:c7:c1:15:d4:35
- You can now SSH into this VM if your SSH public key is added:
    <code>$ ssh -p 64594 ubuntu@18.221.109.33</code>
  Use the same SSH public key that you use for GitHub.

- Checkout using deploy key: 27:36:83:70:2a:ec:1b:0b:08:a1:a5:75:88:40:0c:a6
- Permanently added 'github.com,192.30.253.113' (RSA) to the list of known hosts.

- cmd: USE_PRECOMPILE=true sudo -E circleci-install php 7.1.0
- circleci-php-7.1.0 is already the newest version.

- cmd: git init
- cmd: git pull https://github.com/TeaInside/tea-inside-bot
- cmd: composer install --prefer-source --no-interaction -vvv
- cmd: phpunit
- cmd: php build

- Test results uploaded.
- Disable SSH

<b>Success! Your tests passed on CircleCI!</b>
";

B::sendMessage(
    [
        "text"		 => $msg,
        "chat_id"	 => -1001128531173,
        "parse_mode" => "HTML"
    ]
);*/
