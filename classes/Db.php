<?php

/**
 * Created by PhpStorm.
 * User: Эд
 * Date: 17.03.2016
 * Time: 22:10
 */
class Db
{
    private $conf_db_host = 'mysql:host=localhost;dbname=api';
    private $conf_db_user = 'root';
    private $conf_db_pass = '';

    static protected $_pdo;

    static function pdo()
    {
        if (!self::$_pdo)
        $pdo = new PDO(self::$conf_db_host, self::$conf_db_user, self::$conf_db_pass);

        return $pdo;
    }

}