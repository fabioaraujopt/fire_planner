<?php

Class database
{
    public static function mySqlPDO(){
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $db = "Planner";
        
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
        }
        return $conn;
    }
}


