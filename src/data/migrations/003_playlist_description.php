<?php

/**
 * Migrations between versions 002 and 003.
 */
class Migration003 extends sfMigration
{
  /**
   * Migrate up to version 003.
   */
  public function up()
  {
    $this->executeSQL('ALTER TABLE `playlist` ADD `description` TEXT NULL');
  }

  /**
   * Migrate down to version 002.
   */
  public function down()
  {
    $this->executeSQL('ALTER TABLE `playlist` DROP `description`');
  }
}
