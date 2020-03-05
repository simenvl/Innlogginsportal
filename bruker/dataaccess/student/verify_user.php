<?php

require_once "./classes/DatabaseConnection.php";

function verify_user($email, $password){
    try
    {
        $email_lower = strtolower($email);
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'CALL verifyUser(?)';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $email_lower, PDO::PARAM_STR);

        $stmt->execute();

        if(!$stmt->rowCount())
        {
            return false;
        }

        $results = $stmt->fetchAll();

        if(!password_verify($password, $results[0]['password']))
        {
            return false;
        }
    }
    catch (PDOException $e)
    {
        return false;
    }

    foreach ($results as $key => $val)
    {
        foreach($val as $key2 => $val2)
        {
            $_SESSION[$key2] = $val2;
        }
    }

    unset($_SESSION['password']);
    $_SESSION['logged_in'] = true;

    return true;
}