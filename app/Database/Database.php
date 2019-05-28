<?php

namespace App\Database;

interface Database
{
    public static function getInstance();

    public function create($table, $columns);

    public function insert();

    public function query();

    public function delete();

    public function update();
}
