<?php
Class database
{
    public static function mySqlPDO(){
        $servername = "localhost";
        $username = "root";
        $password = "123";
        $db = "focor_fire_planner";
        
        try
        {
        $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        catch
        (PDOException $e)
        {
		$conn = false;
		print_r($e);
        }
        return $conn;
    }
}


