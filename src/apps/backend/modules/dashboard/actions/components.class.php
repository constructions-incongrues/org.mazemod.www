<?php
class dashboardComponents extends sfComponents
{
  public function executeMenu()
  {
    // Number of tracks that need metadata
    $c = new Criteria();
    $c->add(TrackPeer::IS_METADATA_COMPLETE, false);
    $num_uncomplete_tracks = TrackPeer::doCount($c) or 0;

    // Pass informations to view
    $this->num_uncomplete_tracks = $num_uncomplete_tracks;
  }
}
?>