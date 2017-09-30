<div id="navbar">

<ul>
  <?php if ($num_uncomplete_tracks): ?>
    <li><?php echo link_to(sprintf('edit incomplete mods (%d)', $num_uncomplete_tracks), '@tracks_uncomplete') ?></li>
  <?php endif; ?>
  <li><?php echo link_to('add new mods', '@uploader_file') ?></li>
  <li><?php echo link_to('browse the library', '@tracks') ?></li>
  <li><?php echo link_to('manage playlists', '@playlists') ?></li>
  <li><?php echo link_to('manage news', '@news') ?></li>
  <li><?php echo link_to('manage links', '@links') ?></li>
  <li><?php echo link_to('manage links categories', '@links_categories') ?></li>
  <li><?php echo link_to('chat w/ the crew !', 'http://mazemod.campfirenow.com/room/173345') ?></li>
</ul>
</div>
