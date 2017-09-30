<?php

/**
 * Subclass for representing a row from the 'playlist' table.
 *
 *
 *
 * @package lib.model
 */
class Playlist extends BasePlaylist
{
  /**
   * Returns playlist tracks.
   *
   * @return  array   An array of Track instances
   */
  public function getTracks($only_enabled = true)
  {
    // Fetch track relationships
    $c = new Criteria();
    if ($only_enabled)
    {
      $c->add(TrackPeer::IS_ENABLED, true);
    }
    $c->add(PlaylistHasTrackPeer::PLAYLIST_ID, $this->getId());
    $c->addAscendingOrderByColumn(PlaylistHasTrackPeer::POSITION);

    // Extract tracks from relationships
    $tracks = array();
    if ($relationships = PlaylistHasTrackPeer::doSelectJoinTrack($c))
    {
      foreach ($relationships as $relationship)
      {
        $tracks[] = $relationship->getTrack();
      }
    }

    return $tracks;
  }

  public function getNumberOfTracks()
  {
    return count($this->getTracks(false));
  }
}
