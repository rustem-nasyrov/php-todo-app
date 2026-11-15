<?php
declare(strict_types=1);

namespace Todo;

use PDO;

class Database
{
    public static function connect(): PDO
    {
        $dsn = 'pgsql:host=127.0.0.1;dbname=php_todos;';
        $user = (string)getenv('DB_USER');
        $pw = (string)getenv('DB_PASSWORD');

        return new \PDO(
            $dsn,
            $user,
            $pw,
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );

    }
}