GRANT ALL PRIVILEGES ON lunch_voting_system.* TO 'lvs'@'%' IDENTIFIED BY 'lvs';

GRANT ALL PRIVILEGES ON lunch_voting_system.* TO 'lvs'@'localhost' IDENTIFIED BY 'lvs';

USE lunch_voting_system;


CREATE TABLE pins (
    `pin` CHAR(32) NOT NULL,
    PRIMARY KEY (`pin`)
);

CREATE TABLE restaurant (
    `pin` CHAR(32) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`pin`),
    FOREIGN KEY (`pin`) REFERENCES pins(`pin`)
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

-- frequency is 'M' monthly; 'W' weekly;
CREATE TABLE users (
    `id` INT AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) DEFAULT NULL,
    `frequency` VARCHAR(1) NOT NULL DEFAULT 'W',
    `status` VARCHAR(20) DEFAULT 'NOT_SETUP',
    PRIMARY KEY (`id`)
);

CREATE TABLE groups (
    `user_id` INT(11),
    `group_name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`user_id`, `group_name`)
);
