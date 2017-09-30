<?php
/**
 * Displays playlist as XSPF.
 *
 * @actionparam   Playlist    $playlist
 */
?>
<?php include_partial('tracks/list.xspf', array('playlist' => $playlist));
