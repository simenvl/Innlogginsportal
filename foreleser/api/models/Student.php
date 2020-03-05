<?php


namespace models;

use classes\DatabaseConnection;
use PDO;
use PDOException;

class Student
{
    private static $instance;
    private $user_id,
            $name,
            $email,
            $password,
            $course,
            $year,
            $error,
            $messageId,
            $count,
            $result;


    public function __construct()
    {
        require_once "../../classes/DatabaseConnection.php";
        self::$instance = DatabaseConnection::getInstance();
    }

    public function get($emailAdress)
    {
        try
        {
            $email_lower = strtolower($emailAdress);

            $connection = self::$instance->getConnection();
            $sql = 'CALL verifyUser(?)';

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(1, $email_lower, PDO::PARAM_STR);

            $stmt->execute();

            $result = $stmt->fetch();

            $this->user_id = $result['user_id'];
            $this->name = $result['name'];
            $this->email = $result['email'];
            $this->password = $result['password'];
            $this->course = $result['course'];
            $this->year = $result['year'];
            $this->count = $stmt->rowCount();

        }
        catch (PDOException $e)
        {
            $this->error = true;
        }
    }

    public function create()
    {
        try
        {
            $email_lower = strtolower($this->email);
            $connection = self::$instance->getConnection();

            $sql = 'CALL addUser(?,?,?,?,?)';

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(1, $this->name, PDO::PARAM_STR);
            $stmt->bindValue(2, $this->password, PDO::PARAM_STR);
            $stmt->bindValue(3, $email_lower, PDO::PARAM_STR);
            $stmt->bindValue(4, $this->course, PDO::PARAM_INT);
            $stmt->bindValue(5, $this->year, PDO::PARAM_INT);

            $stmt->execute();

            $this->user_id = $stmt->fetch()['user_id'];
        }
        catch (PDOException $e)
        {
            $this->error = true;
        }
    }

    public function get_courses()
    {
        try
        {
            $connection = self::$instance->getConnection();

            $sql = 'select * from courses';

            $stmt = $connection->prepare($sql);

            $stmt->execute();

            $this->count = $stmt->rowCount();

            $this->result = $stmt->fetchAll();

        }
        catch (PDOException $e)
        {
            $this->error = true;
        }

    }

    public function send_message($message)
    {
        try
        {
            $connection = self::$instance->getConnection();

            $sql = 'CALL sendMessage(?,?,?)';

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(1, $this->user_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $this->course, PDO::PARAM_INT);
            $stmt->bindValue(3, $message, PDO::PARAM_STR);

            $stmt->execute();

            $this->messageId = $stmt->fetch()['msg_id'];

        }
        catch (PDOException $e)
        {
            $this->error = true;
        }
    }

    public function get_message()
    {
        try
        {
            $connection = self::$instance->getConnection();

            $sql = 'SELECT msg_id, msg FROM messages WHERE student = ?';

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(1, $this->user_id, PDO::PARAM_INT);

            $stmt->execute();

            $this->count = $stmt->rowCount();
            $this->result = $stmt->fetchAll();
        }
        catch (PDOException $e)
        {
            $this->error = true;
        }
    }


    public function get_image($lecturer)
    {
        try
        {
            $connection = self::$instance->getConnection();

            $sql = 'SELECT image FROM lecturers WHERE lectur_id = ?';

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(1, $lecturer, PDO::PARAM_INT);

            $stmt->execute();

            $this->count = $stmt->rowCount();

            $this->result = $stmt->fetchAll();
        }
        catch (PDOException $e)
        {
            $this->error = true;
        }
    }


    public function getMessageId()
    {
        return $this->messageId;
    }

    public function getResult()
    {
        return $this->result;
    }


    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setCourse($course)
    {
        $this->course = $course;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getCourse()
    {
        return $this->course;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getCount()
    {
        return $this->count;
    }



}