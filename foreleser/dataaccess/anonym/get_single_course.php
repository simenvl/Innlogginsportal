<?php
require_once "./classes/DatabaseConnection.php";

function get_single_course($id)
{
    try {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'select id, course_code, course_name, lectur_id, pin_code from courses where id = ?';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);

        $stmt->execute();
        $results = $stmt->fetch();

    } catch (PDOException $e){
        return null;
    }

    return $results;
}