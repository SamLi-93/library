<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
<<<<<<< .mine
            'dsn' => 'mysql:host=127.0.0.1;dbname=lixin_db',
            'username' => 'root',
            'password' => 'root',
||||||| .r113
            'dsn' => 'mysql:host=127.0.0.1;dbname=kejian2_job_db',
            'username' => 'root',
            'password' => 'root',
=======
            'dsn' => 'mysql:host=45.32.26.202;dbname=lixin_db',
            'username' => 'admin',
            'password' => 'Admin1-1',
>>>>>>> .r128
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
