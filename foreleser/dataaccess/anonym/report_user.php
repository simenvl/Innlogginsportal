<?php

require_once "./classes/DatabaseConnection.php";

function report_user($message, $msg_id, $student, $lecturer)
{
    try
    {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'INSERT INTO reports (message, msg_id, student_id, lectur_id) VALUES (?,?,?,?)';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $message, PDO::PARAM_LOB);
        $stmt->bindValue(2, $msg_id, PDO::PARAM_INT);
        $stmt->bindValue(3, $student, PDO::PARAM_INT);
        $stmt->bindValue(4, $lecturer, PDO::PARAM_INT);

        $stmt->execute();

    }
    catch (PDOException $e)
    {
        return false;
    }

    return true;
}