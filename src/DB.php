<?php

use System\Hub\Singleton;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 0.0.1
 * @license MIT
 */
class DB
{
    
    use Singleton;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";port=".DB_PORT, DB_USER, DB_PASS);
    }

    /**
     * Call static pdo.
     *
     * @param  string $method
     * @param  array  $param
     * @return mixed
     */
    public static function __callStatic($method, $param)
    {
        return self::getInstance()->pdo->{$method}(...$param);
    }
}


/**
 * Error query handler.
 */
function pc($exe, \PDOStatement $pdo)
{
    if (! $exe) {
        var_dump($pdo->errorInfo());
        exit(1);
    }
    return true;
}