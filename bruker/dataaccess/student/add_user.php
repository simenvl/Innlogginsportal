<?php

require_once "./classes/DatabaseConnection.php";

function add_user($name, $password, $email, $course, $year){
    try
    {
        $email_lower = strtolower($email);
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'CALL addUser(?,?,?,?,?)';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $name, PDO::PARAM_STR);
        $stmt->bindValue(2, $password, PDO::PARAM_STR);
        $stmt->bindValue(3, $email_lower, PDO::PARAM_STR);
        $stmt->bindValue(4, $course, PDO::PARAM_INT);
        $stmt->bindValue(5, $year, PDO::PARAM_INT);

        $stmt->execute();
    }
    catch (PDOException $e)
    {
        return false;
    }

    return true;
}