<?php

require_once "./classes/DatabaseConnection.php";

function get_comments()
{
    try {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'SELECT m.msg_id, m.msg, c.msg_id, c.comment 
                FROM messages m, comments c
                WHERE m.msg_id = c.msg_id';

        $stmt = $connection->prepare($sql);

        $stmt->execute();
        $results = $stmt->fetchAll();

    } catch (PDOException $e){
        return null;
    }

    return $results;
}