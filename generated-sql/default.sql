
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- background
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `background`;

CREATE TABLE `background`
(
    `age` INTEGER NOT NULL,
    `gender` TINYINT(1) NOT NULL,
    `house_members` INTEGER NOT NULL,
    `zipcode` INTEGER NOT NULL,
    `nationality` VARCHAR(50) NOT NULL,
    `dob` DATETIME NOT NULL,
    `user_id` INTEGER NOT NULL,
    UNIQUE INDEX `user_id` (`user_id`),
    CONSTRAINT `background_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- event
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `event`;

CREATE TABLE `event`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `location` VARCHAR(50) NOT NULL,
    `description` VARCHAR(80) NOT NULL,
    `start_date` DATETIME NOT NULL,
    `end_date` DATETIME NOT NULL,
    `venue_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `venue_id` (`venue_id`),
    CONSTRAINT `event_ibfk_1`
        FOREIGN KEY (`venue_id`)
        REFERENCES `venue` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- event_image
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `event_image`;

CREATE TABLE `event_image`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(25) NOT NULL,
    `path` VARCHAR(25) NOT NULL,
    `event_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `event_id` (`event_id`),
    CONSTRAINT `event_image_ibfk_1`
        FOREIGN KEY (`event_id`)
        REFERENCES `event` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- organization
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `organization`;

CREATE TABLE `organization`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `user_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `user_id` (`user_id`),
    CONSTRAINT `organization_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- pass
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `pass`;

CREATE TABLE `pass`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `type_pass` TINYINT(1) NOT NULL,
    `qr_code` VARCHAR(255) NOT NULL,
    `user_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `user_id` (`user_id`),
    CONSTRAINT `pass_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- subscribed_event
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `subscribed_event`;

CREATE TABLE `subscribed_event`
(
    `user_id` INTEGER NOT NULL,
    `event_id` INTEGER NOT NULL,
    INDEX `user_id` (`user_id`),
    INDEX `event_id` (`event_id`),
    CONSTRAINT `subscribed_event_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `subscribed_event_ibfk_2`
        FOREIGN KEY (`event_id`)
        REFERENCES `event` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50),
    `username` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email_addr` VARCHAR(50) NOT NULL,
    `role` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `username` (`username`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- venue
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `venue`;

CREATE TABLE `venue`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `address` VARCHAR(50) NOT NULL,
    `parking_info` VARCHAR(50) NOT NULL,
    `org_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `org_id` (`org_id`),
    CONSTRAINT `venue_ibfk_1`
        FOREIGN KEY (`org_id`)
        REFERENCES `organization` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- venue_image
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `venue_image`;

CREATE TABLE `venue_image`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `path` VARCHAR(50) NOT NULL,
    `venue_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `venue_id` (`venue_id`),
    CONSTRAINT `venue_image_ibfk_1`
        FOREIGN KEY (`venue_id`)
        REFERENCES `venue` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
