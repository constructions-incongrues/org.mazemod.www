<?php
function mm_url_for_random_gfx($sf_root_dir, $url_root)
{
  // Get available artworks
  $artwork_root_dir = sprintf('%s/web/images/gfx/', $sf_root_dir);
  $finder = new sfFinder();
  $artworks = $finder->name('*.png')->name('*.gif')->in($artwork_root_dir);

  // Generate appropriate paths
  $artworks_uris = array();
  foreach ($artworks as $artwork_filepath)
  {
    $artworks_uris[] = sprintf('%s/images/gfx/%s', $url_root, basename($artwork_filepath));
  }

  // Return an arbitrary artwork
  return $artworks_uris[array_rand($artworks_uris)];
}