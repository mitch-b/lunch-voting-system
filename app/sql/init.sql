GRANT ALL PRIVILEGES ON lunch_voting_system.* TO 'lvs'@'%' IDENTIFIED BY 'lvs';
GRANT ALL PRIVILEGES ON lunch_voting_system.* TO 'lvs'@'localhost' IDENTIFIED BY 'lvs';

USE lunch_voting_system

CREATE TABLE restaurant (
    id INT(11) AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    pin CHAR(32) NOT NULL
);

-- ported from mitchbarry.cms "users" now called 'account'
CREATE TABLE IF NOT EXISTS `account` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(32) NOT NULL,
  `password` VARCHAR(32) NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`user_id`)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    frequency VARCHAR(1) NOT NULL DEFAULT 'W', -- 'M' monthly; 'W' weekly;
    status VARCHAR(20) DEFAULT 'NOT_SETUP'
);

-- make pin identity column?
CREATE TABLE pins (
    pin VARCHAR(255) NOT NULL
);

CREATE TABLE groups (
    user_id INT(11) AUTO_INCREMENT,
    group_name VARCHAR(100) NOT NULL,
    PRIMARY KEY (`user_id`, `group_name`)
);

INSERT INTO user (email, frequency) VALUES (

)