
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- track
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `track`;


CREATE TABLE `track`
(
	`title` VARCHAR(255),
	`composer` VARCHAR(255),
	`original_filename` VARCHAR(255),
	`converted_filename` VARCHAR(255),
	`original_file_md5` VARCHAR(32),
	`is_metadata_complete` INTEGER,
	`is_enabled` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`),
	UNIQUE KEY `track_U_1` (`original_file_md5`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- playlist
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `playlist`;


CREATE TABLE `playlist`
(
	`title` VARCHAR(255),
	`is_enabled` INTEGER,
	`author` VARCHAR(255),
	`description` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- playlist_has_track
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `playlist_has_track`;


CREATE TABLE `playlist_has_track`
(
	`playlist_id` INTEGER,
	`track_id` INTEGER,
	`position` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`),
	INDEX `playlist_has_track_FI_1` (`playlist_id`),
	CONSTRAINT `playlist_has_track_FK_1`
		FOREIGN KEY (`playlist_id`)
		REFERENCES `playlist` (`id`),
	INDEX `playlist_has_track_FI_2` (`track_id`),
	CONSTRAINT `playlist_has_track_FK_2`
		FOREIGN KEY (`track_id`)
		REFERENCES `track` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- post
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `post`;


CREATE TABLE `post`
(
	`title` VARCHAR(255),
	`body` TEXT,
	`is_enabled` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- job
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `job`;


CREATE TABLE `job`
(
	`handler` VARCHAR(255),
	`data` TEXT,
	`status` TINYINT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- link
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `link`;


CREATE TABLE `link`
(
	`title` TEXT,
	`url` TEXT,
	`description` TEXT,
	`link_category_id` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`),
	INDEX `link_FI_1` (`link_category_id`),
	CONSTRAINT `link_FK_1`
		FOREIGN KEY (`link_category_id`)
		REFERENCES `link_category` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- link_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `link_category`;


CREATE TABLE `link_category`
(
	`name` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
