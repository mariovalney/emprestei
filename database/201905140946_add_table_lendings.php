<?php

$this->database->create('lendings', [
    'ID          BIGINT    AUTO_INCREMENT',
    'object_id   BIGINT    NOT NULL',
    'lender_id   BIGINT    NOT NULL',
    'date_start  DATETIME  DEFAULT CURRENT_TIMESTAMP',
    'date_end    DATETIME',
    'PRIMARY KEY (ID)',
    'FOREIGN KEY (object_id) REFERENCES objects(ID)',
    'FOREIGN KEY (lender_id) REFERENCES lenders(ID)',
]);
