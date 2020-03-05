<?php
require_once "./classes/DatabaseConnection.php";

function change_password_user($id, $old, $new){
    try
    {
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'select password from users where user_id = :id';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        if(!$stmt->rowCount())
        {
            return false;
        }

        $results = $stmt->fetchAll();
        if(!password_verify($old, $results[0]['password']))
        {
            return false;
        }
    }
    catch (PDOException $e)
    {
        return false;
    }

    $sql2 = "CALL changePasswordUser(?,?)";

    $stmt2 = $connection->prepare($sql2);
    $stmt2->bindValue(1, $id, PDO::PARAM_STR);
    $stmt2->bindValue(2, $new, PDO::PARAM_STR);

    $updated = $stmt2->execute();

    if(!$updated) {
        return false;
    }

    return true;
}