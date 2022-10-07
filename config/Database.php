<?php

class Database {

    private static $dsn      = "mysql:host=localhost;dbname=projectdb;";
    private static $db_user  = 'root';
    private static $db_pass  = '';

    private static $conn = null;

    public static function connection()
    {
        try {
            self::$conn = new PDO(self::$dsn, self::$db_user, self::$db_pass);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return self::$conn;
    }
}

