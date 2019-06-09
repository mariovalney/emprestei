<?php

$this->database->create('things', [
    'ID          BIGINT       AUTO_INCREMENT',
    'name        VARCHAR(255) NOT NULL',
    'type        VARCHAR(255) NOT NULL',
    'note        VARCHAR(255)',
    'PRIMARY KEY (ID)',
]);
