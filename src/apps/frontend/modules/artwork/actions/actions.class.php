<?php

/**
 * artwork actions.
 *
 * @package    h
 * @subpackage artwork
 * @author     Michel Bertier <mbertie@parishq.net>
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class artworkActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeRandom()
  {
    // Select an arbitrary artwork and pass it to view
    sfLoader::loadHelpers(array('mmBase'));
    $this->artwork_uri = mm_url_for_random_gfx(sfConfig::get('sf_root_dir'), $this->getRequest()->getRelativeUrlRoot());

    // No layout !
    sfConfig::set('sf_web_debug', false);
  }
}
