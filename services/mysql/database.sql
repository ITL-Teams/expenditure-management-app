DROP DATABASE IF EXISTS expenditure_management;

CREATE DATABASE expenditure_management;
USE expenditure_management;

CREATE TABLE user_credentials (
    id                  VARCHAR(255) NOT NULL,
    email               VARCHAR(255) NOT NULL,
    firstName           VARCHAR(255) NOT NULL,
    lastName            VARCHAR(255) NOT NULL,
    user_password       VARCHAR(255) NOT NULL,
    user_signature      VARCHAR(255) NOT NULL,
    isEnterpriseAccount CHAR(0) DEFAULT NULL,
    accountVerified     CHAR(0) DEFAULT NULL,
    hasTwoFactorAuth    CHAR(0) DEFAULT NULL,
    tfa_key             VARCHAR(255) DEFAULT NULL,
    UNIQUE (email),

    PRIMARY KEY (id)
);

CREATE TABLE agreement (
    id                  VARCHAR(255) NOT NULL,
    account_id          VARCHAR(255) NOT NULL,
    budget_id           VARCHAR(255) NOT NULL,
    client_name         VARCHAR(255) NOT NULL,
    agreement_message   VARCHAR(2500) NOT NULL,
    agreement_signature VARCHAR(255) NOT NULL,

    PRIMARY KEY (id)
);

INSERT INTO user_credentials
VALUES ('b76c4ae8-7abf-4eef-8ed4-498736b117f1', 'admin@ema.com', 'Admin', 'Admin', '$2a$08$KDLvCZiGRTTgJE1U7hJYkO/6SVMi4qYrg8NJowGc0QnjVVY0YA6qy', '', NULL, '', '', 'JBSWY3DPEHPK3PXP');

INSERT INTO agreement
VALUES ('123qwe123qwe', 'b76c4ae8-7abf-4eef-8ed4-498736b117f1', '123', 'Admin', 'message', 'asdad12312das');
