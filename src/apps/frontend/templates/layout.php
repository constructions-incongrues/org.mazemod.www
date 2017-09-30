<?php use_helper('mmBase') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/images/ico/favicon.ico" />

<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/css/original.css?v=3" title="original" />

<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/css/ie6.css" />
<![endif]-->

<link rel="alternate" type="application/atom+xml" title="Mazemod news" href="<?php echo sfConfig::get('app_feeds_posts_url', url_for('@feeds_posts')) ?>" />

</head>

<body>
<div id="container">

    <ul id="navbar">

      <li class="ico1"> <?php echo link_to('news', '@pages_news', array('title' => 'News', 'rel' => 'history')) ?> </li>
      <li class="ico2"> <?php echo link_to('about', '@pages_infos', array('title' => 'About', 'rel' => 'history')) ?></li>
  	  <li class="ico3"> <?php echo link_to('playlists', '@pages_playlist', array('title' => 'Playlist', 'rel' => 'history')) ?> </li>
  	  <li class="ico4"> <?php echo link_to('links', '@pages_links', array('title' => 'Links', 'rel' => 'history')) ?> </li>
  	  <li class="ico5"> <?php echo link_to('contact', '@pages_contact', array('title' => 'Contact', 'rel' => 'history')) ?> </li>

    </ul> <!-- #navbar -->

  <div id="gfx">
    <?php echo image_tag(mm_url_for_random_gfx(sfConfig::get('sf_root_dir'), $sf_request->getRelativeUrlRoot()), array('height' => '480px', 'width' => '320px')) ?>
  </div> <!-- #gfx -->

  <div id="player">

  <?php include_partial('global/player', array('base_url' => sfConfig::get('app_player_base_url'),
                                               'debug'    => sfConfig::get('app_player_debug', 'false'))) ?>

  </div> <!-- #player -->

  <div id="contents">
    <?php echo $sf_data->getRaw('sf_content') ?>
  </div>

<div id="footer">
  <div id="mailing">

  <form action="http://groups.google.com/group/mazemod/boxsubscribe">
    <p>
      <label for="mail">mailing list</label>
      <input type="text" name="email" class="champs" id="email" />
      <input type=submit name="sub" value="Ok" class="valid" />
    </p>
    </form>

  </div> <!-- #mailing -->

<div id="rss_ico"><a href="<?php echo sfConfig::get('app_feeds_posts_url', url_for('@feeds_posts')) ?>">rss</a> -
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="donate">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="HY3QPCR3NZ5HQ">
<input type="submit" value="donate" name="submit" class="donate-add" alt="donate">
</form>
</div>

  </div> <!-- #footer -->

</div> <!-- #container -->

<script type="text/javascript">

$(document).ready(function() {
  // Register player
//  swfobject.registerObject("mazemod_player", "9.0.0");

  $.jheartbeat.set({
    url: '<?php echo $sf_request->getScriptName() ?>/artwork/random.html',
    delay: 3600000,
    div_id: 'gfx'
  }, function () {});

  // Initialize history plugin.
  // The callback is called at once by present location.hash.
  $.historyInit(pageload);

  // Turn all navigation links into jquery history enabled links
  $("a[@rel=history]").each(function() {
    var pagename = $(this).attr('href').split('/').pop();
    $(this).attr('href', '<?php echo $sf_request->getScriptName() ?>/#' + pagename);
  });

  // set onlick event for buttons
  $("a[@rel=history]").click(function() {
    var hash = this.href;
    hash = hash.replace(/^.*#/, '');
    // moves to a new page.
    // pageload is called at once.
    $.historyLoad(hash);
    return false;
  });

});

$(document).ajaxSend(function(evt, request, settings) {
  $('#gfx').html('<img src="<?php echo $sf_request->getRelativeUrlRoot() ?>/images/loader.gif" />');
});
$(document).ajaxComplete(function(evt, request, settings) {
  if (settings.url.indexOf('random.html') == -1)
  {
    $('#gfx').load('<?php echo $sf_request->getScriptName() ?>/artwork/random.html');
  }
});

pageload = function(hash) {
  if (hash)
  {
    $('#contents').load(hash, function() {
      // Setup flash enabled links
      $('a.player-playlist').click(function() {
        document.getElementById('mazemod_player').parleAvecFlash($(this).attr('href'));
        return false;
      });
    });
  }
};

getPlayer = function(gid) {
  if(navigator.appName.indexOf("Microsoft") != -1) {
    return window[gid];
  } else {
    return document[gid];
  }
};

</script>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-4768135-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>

</body>
</html>
