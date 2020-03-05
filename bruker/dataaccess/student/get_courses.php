<?php

require_once "./classes/DatabaseConnection.php";

function get_courses()
{
    try {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'select id, course_name, lectur_id from courses';

        $stmt = $connection->prepare($sql);

        $stmt->execute();
        $results = $stmt->fetchAll();

    } catch (PDOException $e){
        return null;
    }

    return $results;
}