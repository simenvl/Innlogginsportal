<?php

require_once "./classes/DatabaseConnection.php";

function add_answer($answer, $msg_id)
{
    try
    {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'UPDATE messages SET answer = ? WHERE msg_id = ?';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $answer, PDO::PARAM_STR);
        $stmt->bindValue(2, $msg_id, PDO::PARAM_LOB);

        $stmt->execute();

    }
    catch (PDOException $e)
    {
        return false;
    }

    return true;
}