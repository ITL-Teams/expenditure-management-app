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

CREATE TABLE company_budgets (
    id                  VARCHAR(255) NOT NULL,
    owner_id            VARCHAR(255) NOT NULL,
    budget_name         VARCHAR(255) NOT NULL,
    budget_limit        INT NOT NULL,
    budget_percentage   INT DEFAULT 100,  
    active_budget       BIT(1) DEFAULT 1,
    PRIMARY KEY (id)
);

CREATE TABLE charges (
    charge_id           VARCHAR(255) NOT NULL,
    collaborator_id     VARCHAR(255) NOT NULL, 
    title               VARCHAR(255) NOT NULL,
    charge_date         DATETIME NOT NULL,
    amount              INT NOT NULL,
    PRIMARY KEY (charge_id)
);

CREATE TABLE collaborators(
    id                  INT AUTO_INCREMENT,
    collaborator_id     VARCHAR(255) NOT NULL,
    budget_id           VARCHAR(255) NOT NULL,
    collaborator_name   VARCHAR(255) NOT NULL,
    budget_percentage   INT NOT NULL,
    budget_quantity     INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
);

CREATE TABLE agreement (
    id                  VARCHAR(255) NOT NULL,
    account_id          VARCHAR(255) NOT NULL,
    budget_id           VARCHAR(255) NOT NULL,
    client_name         VARCHAR(255) NOT NULL,
    agreement_message   VARCHAR(255) DEFAULT NULL,
    agreement_signature VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO user_credentials
VALUES ('b76c4ae8-7abf-4eef-8ed4-498736b117f1', 'admin@ema.com', 'Admin', 'Admin', '$2a$08$KDLvCZiGRTTgJE1U7hJYkO/6SVMi4qYrg8NJowGc0QnjVVY0YA6qy', '', NULL, '', '', 'JBSWY3DPEHPK3PXP');

INSERT INTO agreement
VALUES ('123qwe123qwe', 'b76c4ae8-7abf-4eef-8ed4-498736b117f1', '123', 'Admin', 'message', 'asdad12312das');
