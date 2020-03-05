<?php

require_once "./classes/DatabaseConnection.php";

function add_course($course_code, $course_name, $id){
    try
    {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'CALL addCourse(?,?,?)';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $course_code, PDO::PARAM_STR);
        $stmt->bindValue(2, $course_name, PDO::PARAM_STR);
        $stmt->bindValue(3, $id, PDO::PARAM_INT);

        $stmt->execute();
    }
    catch (PDOException $e)
    {
        return false;
    }

    return true;
}