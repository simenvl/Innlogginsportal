<?php

require_once "./classes/DatabaseConnection.php";

function get_messages()
{
    try {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'SELECT msg_id, msg, student 
                FROM messages';

        $stmt = $connection->prepare($sql);

        $stmt->execute();
        $results = $stmt->fetchAll();

    } catch (PDOException $e){
        return null;
    }

    return $results;
}