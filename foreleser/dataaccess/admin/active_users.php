<?php

require_once "./classes/DatabaseConnection.php";

function active_users($sql)
{
    try {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $stmt = $connection->prepare($sql);

        $stmt->execute();
        $results = $stmt->fetchAll();

    } catch (PDOException $e){
        return null;
    }

    return $results;
}