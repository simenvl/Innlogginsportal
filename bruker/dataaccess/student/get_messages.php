<?php

require_once "./classes/DatabaseConnection.php";

function get_messages($student)
{
    try {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'SELECT msg_id, msg, student, answer, fname
                FROM messages, lecturers
                WHERE student = ?';

        $stmt = $connection->prepare($sql);
        $stmt ->bindValue(1, $student, PDO::PARAM_INT);

        $stmt->execute();
        $results = $stmt->fetchAll();

    } catch (PDOException $e){
        echo $e;
        return null;
    }

    return $results;
}