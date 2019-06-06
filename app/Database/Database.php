<?php

namespace App\Database;

interface Database
{
    public static function getInstance();

    public function create(string $table, array $columns);

    public function select(string $table, array $where );

    public function insert(string $table, array $values);

    public function update(string $table, array $values, array $where);

    public function delete(string $table, array $where = []);
}
