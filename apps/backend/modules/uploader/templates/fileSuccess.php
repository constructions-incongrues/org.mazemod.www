<div id="container">
<?php use_helper('Form') ?>

<H1>add new mods</H1>

<div id="upload-mods">


<form method="POST" enctype="multipart/form-data">
  <?php echo $upload_form ?>
  <?php echo submit_tag() ?>
</form>
</div> <!-- #upload-mods -->
</div> <!-- #container -->
