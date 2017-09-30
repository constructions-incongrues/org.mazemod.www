<?php $movie_url = sprintf('%s/swf/MzMd_Fier.swf?ub=%s&db=%s&rev=%d', $sf_request->getRelativeUrlRoot(), urlencode($base_url), $debug, 244); ?>

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
	codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"
	width="436" height="240">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="movie" value="<?php echo $movie_url ?>" />
	<param name="quality" value="high" />
	<param name="bgcolor" value="#000000" />
	<param name="id" value="mazemod_player">
	<embed src="<?php echo $movie_url ?>" width="436" height="240"
		quality="high" bgcolor="#000000" allowScriptAccess="sameDomain"
		type="application/x-shockwave-flash"
		pluginspage="http://www.macromedia.com/go/getflashplayer" id="mazemod_player" /></object>
