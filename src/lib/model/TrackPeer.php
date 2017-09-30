<?php

/**
 * Subclass for performing query and update operations on the 'track' table.
 *
 *
 *
 * @package lib.model
 */
class TrackPeer extends BaseTrackPeer
{
  public static function retrieveByOriginalFileMd5($md5_sum, Criteria $criteria = null)
  {
    $c = new Criteria();
    $c->add(TrackPeer::ORIGINAL_FILE_MD5, $md5_sum);
    return TrackPeer::doSelectOne($c);
  }
  
  public static function doSelectEnabled(Criteria $c = null)
  {
    if (!$c)
    {
      $c = new Criteria();
    }
    $c->add(TrackPeer::CONVERTED_FILENAME, null, Criteria::ISNOTNULL);
    $c->add(TrackPeer::IS_ENABLED, true);
    $c->add(TrackPeer::IS_METADATA_COMPLETE, true);
    
    return TrackPeer::doSelect($c);
  }
}
