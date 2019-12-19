<?php
class Database {

    // dades bbdd
    private static $host = "localhost";
    private static $db_name = "agenda";
    private static $username = "root";
    private static $password = "";


    // get the database connection
    public static function getConnection(){

        $conn = null;

        try{

            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            $conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$username, self::$password, $options);

        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $conn;

    }
}
?>