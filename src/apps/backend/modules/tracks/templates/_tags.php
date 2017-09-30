<?php echo input_auto_complete_tag('track[tags]',
                                   $track->getTagsAsString(),
                                   'tracks/tags',
                                   array(),
                                   array('tokens' => ',', 'use_style' => true)) ?>
