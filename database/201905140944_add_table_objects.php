<?php

$this->database->create('objects', [
    'ID          BIGINT       AUTO_INCREMENT',
    'name        VARCHAR(255) NOT NULL',
    'type        VARCHAR(255) NOT NULL',
    'description VARCHAR(255)',
    'PRIMARY KEY (ID)',
]);
