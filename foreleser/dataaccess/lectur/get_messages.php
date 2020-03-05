<?php

require_once "./classes/DatabaseConnection.php";

function get_messages($lectur_id)
{
    try
    {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'SELECT msg_id, msg 
                FROM messages WHERE lectur = ? AND answer IS NULL';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $lectur_id, PDO::PARAM_INT);

        $stmt->execute();
        $results = $stmt->fetchAll();

    }
    catch (PDOException $e)
    {
        return null;
    }

    return $results;
}