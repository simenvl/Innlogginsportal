<?php

require_once "./classes/DatabaseConnection.php";

function get_messages_answers($course_id)
{
    try
    {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'SELECT msg_id, msg, answer, student
                FROM messages where course_id = ?';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $course_id, PDO::PARAM_INT);

        $stmt->execute();
        $results = $stmt->fetchAll();
    }
    catch (PDOException $e)
    {
        return null;
    }

    return $results;
}