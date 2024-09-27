<?php

const DB_HOST = 'tips_mysql';
const DB_USER = 'root';
const DB_PASSWORD = 'root';
const DB_NAME = 'tips_db';

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
        echo($msg);
    } else {
        echo('Подключились в БД!<br>');
    }
}

function db_disconnect(?object $connection): void {
    $connection?->close();
}

function create_companies ($connection) {

    $create_companies = "
        CREATE TABLE IF NOT EXISTS companies (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            location VARCHAR(255) NOT NULL,
            industry VARCHAR(255) NOT NULL
        );
    ";
    if ($connection->query($create_companies) === TRUE) {
        echo 'Yes create_companies<br>';
    } else {
        echo 'No create_companies<br>';
    }

}

function create_employes ($connection) {

    $create_employes = "
        CREATE TABLE IF NOT EXISTS employers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            position VARCHAR(255) NOT NULL,
            salary DECIMAL(10, 2) NOT NULL,
            company_id INT,
            FOREIGN KEY (company_id) REFERENCES companies(id)
        );
    ";
    if ($connection->query($create_employes) === TRUE) {
        echo 'Yes create_employes<br>';
    } else {
        echo 'No create_employes<br>';
    }
}