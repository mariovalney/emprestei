<?php

Database::create('lenders', [
    'ID          BIGINT       AUTO_INCREMENT',
    'name        VARCHAR(255) NOT NULL',
    'email       VARCHAR(255) NOT NULL',
    'phone       VARCHAR(255) NOT NULL',
    'PRIMARY KEY (ID)',
]);
