<?php

namespace App\Database;

use PDO;

class Mysql implements Database
{
    /** @var PDO */
    private $conn;

    /** @var string */
    private $dns;

    /** @var string */
    private $db;

    /** @var string */
    private $host;

    /** @var int */
    private $port;

    /** @var string */
    private $user;

    /** @var string */
    private $pass;


    /**
     * Creating connection
     */
    public function __construct()
    {
        if (! defined('DB_NAME') || ! defined('DB_HOST') || ! defined('DB_USER') || ! defined('DB_PASS') ) {
            die('Check database info in config.php');
        }

        $this->db = DB_NAME;
        $this->host = DB_HOST;
        $this->port = DB_PORT;
        $this->user = DB_USER;
        $this->pass = DB_PASS;

        $this->dns = 'mysql:host=' . $this->host . ':' . $this->port . ';dbname=' . $this->db;

        try {
            $this->conn = new PDO($this->dns, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
        } catch (PDOException $ex) {
            die("Error to connect with Database");
        }
    }

    /**
     * Retrieve a instance
     *
     * @return
     */
    public function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Create a table if not exits
     *
     * @param  string $table
     * @param  array $columns
     *
     * @return
     */
    public function create($table, $columns) {
        $columns = implode(',', array_values($columns));

        $query = "CREATE TABLE IF NOT EXISTS $table ($columns)";

        $result = $this->conn->exec($query);
    }

    public function insert() {}
    public function query() {}
    public function delete() {}
    public function update() {}
}
