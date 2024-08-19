<?php

function db_connect(): mysqli {
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    confirm_db_connect($connection);
    return $connection;
}

function confirm_db_connect(mysqli $connection): void {
    if($connection->connect_errno) {
        $msg = "Database connection failed: ";
        $msg .= $connection->connect_error;
        $msg .= " (" . $connection->connect_errno . ")";
        exit($msg);
    }
}

function db_disconnect(?object $connection): void {
    $connection?->close();
}