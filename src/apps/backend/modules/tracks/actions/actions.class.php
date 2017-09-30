<?php

/**
 * tracks actions.
 *
 * @package    h
 * @subpackage tracks
 * @author     Michel Bertier <mbertie@parishq.net>
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class tracksActions extends autotracksActions
{
  protected function addFiltersCriteria($c)
  {
    if ($this->getRequestParameter('filter') == 'uncomplete')
    {
      $c->add(TrackPeer::IS_METADATA_COMPLETE, false);
    }
  }

  public function executeTags()
  {

  }
}
