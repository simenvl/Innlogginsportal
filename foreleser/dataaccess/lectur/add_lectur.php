<?php

require_once "./classes/DatabaseConnection.php";

function add_lectur($fname, $lname, $email, $password, $image){
    try
    {
        $email_lower = strtolower($email);
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'CALL addLectur(?,?,?,?,?)';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $fname, PDO::PARAM_STR);
        $stmt->bindValue(2, $lname, PDO::PARAM_STR);
        $stmt->bindValue(3, $email_lower, PDO::PARAM_STR);
        $stmt->bindValue(4, $password, PDO::PARAM_STR);
        $stmt->bindValue(5, $image, PDO::PARAM_STR);

        $stmt->execute();
    }
    catch (PDOException $e)
    {
        return false;
    }


    return true;
}

