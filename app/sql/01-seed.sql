USE lunch_voting_system;

-- account (CMS users)
INSERT INTO `lunch_voting_system`.`account` (`username`, `password`, `ip`) 
VALUES
    ('admin', 'admin', ''),
    ('user', 'user', '');

INSERT INTO `lunch_voting_system`.`groups` (`user_id`, `group_name`) 
VALUES
    (1, 'lvs_admin'),
    (2, 'guest');

