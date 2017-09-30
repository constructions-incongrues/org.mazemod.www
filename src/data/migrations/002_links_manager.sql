# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

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
