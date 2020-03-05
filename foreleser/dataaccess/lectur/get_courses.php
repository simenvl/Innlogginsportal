<?php

require_once "./classes/DatabaseConnection.php";

function get_courses($id)
{
    try {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'select course_code, course_name from courses where lectur_id = ?';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);

        $stmt->execute();
        $results = $stmt->fetchAll();

    } catch (PDOException $e){
        return null;
    }

    return $results;
}