<?php
/**
 * Displays enabled playlists
 *
 * @actionparam   array   $playlists    An array of Playlist instances
 */
?>

<div id="text">

  <?php foreach ($playlists as $playlist): ?>

    <?php include_partial('pages/playlist/full', array('playlist' => $playlist)); ?>

  <?php endforeach; ?>

</div>