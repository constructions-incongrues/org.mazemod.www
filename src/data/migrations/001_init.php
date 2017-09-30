<?php

/**
 * Migrations between versions 000 and 001.
 */
class Migration001 extends sfMigration
{
  /**
   * Migrate up to version 001.
   */
  public function up()
  {
    $this->loadSql(dirname(__FILE__).'/001_init.sql');
  }

  /**
   * Migrate down to version 000.
   */
  public function down()
  {
    $this->executeSQL('SET FOREIGN_KEY_CHECKS=0');

    $this->executeSQL('DROP TABLE track');
    $this->executeSQL('DROP TABLE playlist');
    $this->executeSQL('DROP TABLE playlist_has_track');
    $this->executeSQL('DROP TABLE post');
    $this->executeSQL('DROP TABLE job');
    $this->executeSQL('DROP TABLE sf_job');
    $this->executeSQL('DROP TABLE sf_job_log');
    $this->executeSQL('DROP TABLE sf_job_queue');
    $this->executeSQL('DROP TABLE sf_tag');
    $this->executeSQL('DROP TABLE sf_tagging');

    $this->executeSQL('SET FOREIGN_KEY_CHECKS=1');
  }
}
