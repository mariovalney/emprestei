<?php

namespace App\Database;

interface Database
{
    public function getInstance();

    public function create();

    public function insert();

    public function query();

    public function delete();

    public function update();
}
