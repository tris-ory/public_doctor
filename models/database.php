<?php

class Database
{
    private static $instance;
    private $type = 'mysql';
    private $host = '127.0.0.1';
    private $port = '3306';
    private $dbname = 'doctolib';
    private $username = 'docto';
    private $password = 'docto';
    private $charset = 'utf8';
    private $dbh;

    private function __construct()
    {
        try {
            $this->dbh = new PDO(
                $this->type . ':host=' . $this->host . '; port=' . $this->port . '; dbname=' . $this->dbname . '; charset=' . $this->charset,
                $this->username,
                $this->password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
            //$this->dbh->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
        } catch (PDOException $e) {
            echo 'Erreur' . $e->getMessage();
            die();
        }
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getDbh()
    {
        return $this->dbh;
    }

}