<?php

/**
 * Migrations between versions 001 and 002.
 *
 * Added : links are now managed in database.
 */
class Migration002 extends sfMigration
{
  /**
   * Migrate up to version 002.
   */
  public function up()
  {
    $this->loadSql(dirname(__FILE__).'/002_links_manager.sql');
  }

  /**
   * Migrate down to version 001.
   */
  public function down()
  {
    $this->executeSQL('SET FOREIGN_KEY_CHECKS=0');

    $this->executeSQL('DROP TABLE link');
    $this->executeSQL('DROP TABLE link_category');

    $this->executeSQL('SET FOREIGN_KEY_CHECKS=1');
  }
}
