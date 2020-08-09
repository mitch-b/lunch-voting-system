USE lunch_voting_system;

-- account (CMS users)
-- md5 hash of 'admin' and 'user'
INSERT INTO `lunch_voting_system`.`account` (`username`, `password`, `ip`) 
VALUES
    ('admin', '21232F297A57A5A743894A0E4A801FC3', ''),
    ('user', 'EE11CBB19052E40B07AAC0CA060C23EE', '');

INSERT INTO `lunch_voting_system`.`groups` (`user_id`, `group_name`) 
VALUES
    (1, 'administrator'),
    (1, 'lvs_admin'),
    (2, 'lvs_standard');

INSERT INTO `lunch_voting_system`.`users` (`name`, `email`, `frequency`, `status`)
VALUES 
    ('Mitchell Barry', 'mitch.barry+lvs@gmail.com', 'W', 'ACTIVE')
