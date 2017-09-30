<div id="container">

  <h2>What happened to my tracks ?</h2>

  <?php if ($tracks_statuses['success']): ?>
    <h3>Successfully added to the library :</h3>
  <?php endif; ?>

  <ul>
  <?php foreach ($tracks_statuses['success'] as $track): ?>

    <li><?php echo link_to($track->getOriginalFilename(), '@tracks?action=edit&id='.$track->getId()) ?></li>

  <?php endforeach; ?>
  </ul>

  <?php if ($tracks_statuses['error']): ?>
    <h3>Not added to the library due to an error (probably duplicates) :</h3>
  <?php endif; ?>


  <ul>
  <?php foreach ($tracks_statuses['error'] as $track): ?>

    <li><?php echo $track->getOriginalFilename() ?></li>

  <?php endforeach; ?>
  </ul>
</div> <!--  #container -->