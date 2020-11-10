DROP DATABASE IF EXISTS example;

CREATE DATABASE example;
USE example;

CREATE TABLE client (
    id          VARCHAR(255),
    client_name VARCHAR(255) NOT NULL,

    PRIMARY KEY (id)
);
