<?php

namespace App\Support\Database\Drivers;

use Exception;
use PDO;
use PDOException;
use App\Support\Contracts\Database;
use App\Support\Logger;

class Mysql implements Database
{
    /** @var Mysql */
    private static $instance;

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
    private function __construct()
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
            $args = [
                PDO::MYSQL_ATTR_FOUND_ROWS => true,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
            ];

            $this->conn = new PDO($this->dns, $this->user, $this->pass, $args);
        } catch (PDOException $ex) {
            die("Error to connect with Database");
        }
    }

    /**
     * Avoid Cloning
     */
    private function __clone() {}

    /**
     * Avoid Unserialize
     */
    private function __wakeup() {}

    /**
     * Retrieve a instance
     *
     * @return
     */
    public static function getInstance()
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
    public function create(string $table, array $columns) {
        $columns = implode(',', array_values($columns));

        $query = "CREATE TABLE IF NOT EXISTS $table ($columns)";

        $result = $this->conn->exec($query);
    }

    /**
     * Perform a SELECT query
     *
     * @param  string $table
     * @param  array  $where
     *
     * @return array
     */
    public function select(string $table, array $where = [], $columns = '*', $afterWhere = '') {
        $where = $this->createWhereClause($where);

        $query = "SELECT $columns FROM $table WHERE $where->clause $afterWhere";

        $query = $this->conn->prepare($query);
        $query->execute($where->values);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Perform a INSERT INTO query
     *
     * @param  string $table
     * @param  array  $values
     *
     * @return integer
     */
    public function insert(string $table, array $values) {
        if (empty($values)) {
            return 0;
        }

        $columns = array_keys($values);
        $columns = '`' . implode('`,`', $columns) . '`';

        $placeholders = array_fill(0, count($values), '?');
        $placeholders = implode(',', $placeholders);

        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $query = $this->conn->prepare($query);

        try {
            $query->execute(array_values($values));
        } catch (Exception $e) {
            Logger::error($e->getMessage());
            return 0;
        }

        return $this->conn->lastInsertId();
    }

    /**
     * Perform a UPDATE query
     *
     * @param  string $table
     * @param  array  $values
     *
     * @return integer
     */
    public function update(string $table, array $values, array $where = []) {
        $data = [];
        foreach ($values as $key => $value) {
            $values[ $key ] = "$key = ?";
            $data[] = $value;
        }

        $values = implode(',', array_values($values));
        $where = $this->createWhereClause($where);

        $query = "UPDATE $table SET $values WHERE $where->clause";
        $query = $this->conn->prepare($query);

        try {
            $query->execute(array_merge($data, $where->values));
        } catch (Exception $e) {
            Logger::error($e->getMessage());
            return 0;
        }

        return $query->rowCount();
    }

    /**
     * Perform a DELETE query
     *
     * @param  string $table
     * @param  array  $values
     *
     * @return integer
     */
    public function delete(string $table, array $where = []) {
        $where = $this->createWhereClause($where);

        $query = "DELETE FROM $table WHERE $where->clause";
        $query = $this->conn->prepare($query);

        try {
            $query->execute($where->values);
        } catch (Exception $e) {
            Logger::error($e->getMessage());
            return 0;
        }

        return $query->rowCount();
    }

    /**
     * Return a WHERE clause
     *
     * @param  array  $where
     * @return object
     */
    private function createWhereClause(array $where)
    {
        if (empty($where)) {
            $where = ['1' => '1'];
        }

        $values = [];
        foreach ($where as $key => $comparison) {
            if (! is_array($comparison)) {
                $comparison = ['=', $comparison];
            }

            if (count($comparison) !== 2) {
                continue;
            }

            $where[ $key ] = "$key $comparison[0] ?";
            $values[] = $comparison[1];
        }

        $where = implode(' AND ', array_values($where));

        return (object) [
            'clause' => $where,
            'values' => $values,
        ];
    }
}
