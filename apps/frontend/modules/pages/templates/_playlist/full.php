<?php
/**
 * Displays the full view of a playlist
 *
 * @viewparam   Playlist    $playlist
 */
?>

<h1><?php echo $playlist->getTitle() ?> - <?php echo $playlist->getAuthor() ?></h1>

<ul>
  <!-- Playlist tracks -->
  <?php foreach ($playlist->getTracks() as $track): ?>

    <li><?php echo $track->getComposer() ?> - <?php echo $track->getTitle() ?></li>

  <?php endforeach; ?>

</ul>

  <!-- Playlist actions -->
  <p>
    <?php echo link_to('Play', '@playlist_tracks?sf_format=xspf&playlist_id='.$playlist->getId(), array('class' => 'player-playlist')) ?>
    -
    <?php echo link_to('Download', '@playlist_tracks?sf_format=zip&playlist_id='.$playlist->getId()) ?>
    -
    <?php echo link_to('Readme', '@playlist_tracks?sf_format=txt&playlist_id='.$playlist->getId()) ?>
  </p>
