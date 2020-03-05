<?php

require_once "./classes/DatabaseConnection.php";

function activate_users($id)
{
    try {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'UPDATE lecturers SET active = 1 WHERE lectur_id = ?';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);

        $stmt->execute();

    } catch (PDOException $e){
        return false;
    }

    return true;
}