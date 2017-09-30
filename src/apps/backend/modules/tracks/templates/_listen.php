<?php if ($track->getConvertedFileName()): ?>

  <object
    type="application/x-shockwave-flash"
    data="<?php echo $sf_request->getRelativeUrlRoot() ?>/swf/dewplayer-mini.swf?showtime=1&mp3=<?php echo rawurlencode($track->getLocationFromSfRequest($sf_request)) ?>"
    width="200" height="20">
  <param name="movie" value="<?php echo $sf_request->getRelativeUrlRoot() ?>/dewplayer-mini.swf?showtime=1&mp3=<?php echo rawurlencode($track->getLocationFromSfRequest($sf_request)) ?>" />
  </object>

<?php else: ?>

  <p>En cours de conversion... Un peu de patience !</p>

<?php endif; ?>
