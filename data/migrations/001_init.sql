
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
#-- sf_job
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_job`;


CREATE TABLE `sf_job`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(30),
	`sf_job_queue_id` INTEGER  NOT NULL,
	`type` VARCHAR(50),
	`tries` INTEGER,
	`max_tries` INTEGER,
	`is_recurring` INTEGER,
	`retry_delay` INTEGER,
	`params` LONGTEXT,
	`message` TEXT,
	`priority` INTEGER default 0,
	`created_at` DATETIME,
	`scheduled_at` DATETIME,
	`completed_at` DATETIME,
	`last_tried_at` DATETIME,
	`status` INTEGER default 2,
	PRIMARY KEY (`id`),
	INDEX `sf_job_FI_1` (`sf_job_queue_id`),
	CONSTRAINT `sf_job_FK_1`
		FOREIGN KEY (`sf_job_queue_id`)
		REFERENCES `sf_job_queue` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- sf_job_log
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_job_log`;


CREATE TABLE `sf_job_log`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_job_id` INTEGER  NOT NULL,
	`execution` INTEGER,
	`priority_name` VARCHAR(10),
	`message` VARCHAR(255),
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `sf_job_log_FI_1` (`sf_job_id`),
	CONSTRAINT `sf_job_log_FK_1`
		FOREIGN KEY (`sf_job_id`)
		REFERENCES `sf_job` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- sf_job_queue
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_job_queue`;


CREATE TABLE `sf_job_queue`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50)  NOT NULL,
	`scheduler_name` VARCHAR(50),
	`scheduler_params` TEXT,
	`status` INTEGER default 0,
	`requested_status` INTEGER default 0,
	`polling_delay` INTEGER default 10,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `name` (`name`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- sf_tag
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_tag`;


CREATE TABLE `sf_tag`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100),
	`is_triple` INTEGER,
	`triple_namespace` VARCHAR(100),
	`triple_key` VARCHAR(100),
	`triple_value` VARCHAR(100),
	PRIMARY KEY (`id`),
	KEY `name`(`name`),
	KEY `triple1`(`triple_namespace`),
	KEY `triple2`(`triple_key`),
	KEY `triple3`(`triple_value`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- sf_tagging
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_tagging`;


CREATE TABLE `sf_tagging`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`tag_id` INTEGER  NOT NULL,
	`taggable_model` VARCHAR(30),
	`taggable_id` INTEGER,
	PRIMARY KEY (`id`),
	KEY `tag`(`tag_id`),
	KEY `taggable`(`taggable_model`, `taggable_id`),
	CONSTRAINT `sf_tagging_FK_1`
		FOREIGN KEY (`tag_id`)
		REFERENCES `sf_tag` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
