<?php

require_once "./classes/DatabaseConnection.php";

function verify_lectur($email, $password){
    try
    {
        $email_lower = strtolower($email);
        $instance = \classes\DatabaseConnection::getInstance();
        $connection = $instance->getConnection();

        $sql = 'CALL verifyLectur(?)';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $email_lower, PDO::PARAM_STR);

        $stmt->execute();

        if(!$stmt->rowCount())
        {
            return false;
        }

        $results = $stmt->fetchAll();

        if(!password_verify($password, $results[0]['password']) || is_null($results[0]['active']))
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
