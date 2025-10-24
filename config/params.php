<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'smsSender' => [
        'apiKey' => $_ENV['SMS_API_KEY'],
        'sender' => $_ENV['SMS_SENDER'],
        'url' => $_ENV['SMS_URL'],
        'timeout' => intval($_ENV['SMS_SEND_TIMEOUT']),
    ],
];
