<?php
require_once "./classes/DatabaseConnection.php";

function send_message($student, $course, $message, $courseid){
    try
    {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'CALL sendMessage(?,?,?,?)';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $student, PDO::PARAM_INT);
        $stmt->bindValue(2, $course, PDO::PARAM_INT);
        $stmt->bindValue(3, $message, PDO::PARAM_STR);
        $stmt->bindValue(4, $courseid, PDO::PARAM_INT);

        $stmt->execute();
    }
    catch (PDOException $e)
    {
        return false;
    }

    return true;
}