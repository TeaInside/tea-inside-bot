<?php

use System\Hub\Singleton;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class DB
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
        $this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    }

    /**
     * Call any PDO method.
     * @param   string $method
     * @param   array  $param
     * @return  mixed
     */
    public static function __callStatic($method, $param)
    {
        return self::getInstance()->pdo->{$method}(...$param);
    }
}


function pc($exe, $st)
{
    if (! $exe) {
        var_dump($st->errorInfo());
        die;
    }
}