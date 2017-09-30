<div id="text">

<?php foreach ($posts as $post): ?>

  <h1><?php echo $post->getCreatedAt('y.m.d') ?> - <?php echo $post->getTitle() ?></h1>

  <p><?php echo $post->getBody() ?></p>

<?php endforeach; ?>

</div> <!-- #text -->
