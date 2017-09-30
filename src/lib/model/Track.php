<?php

/**
 * Subclass for representing a row from the 'track' table.
 *
 *
 *
 * @package lib.model
 */
class Track extends BaseTrack
{
  /**
   * Returns track's tags as a comma separated list
   * @return string
   */
  public function getTagsAsString()
  {
    return implode(', ', $this->getTags());
  }

  public function getLocationFromSfRequest(sfWebRequest $request)
  {
    return sprintf('%s%s/chip/mp3/%s',
                   $request->getUriPrefix(),
                   $request->getRelativeUrlRoot(),
                   rawurlencode($this->getConvertedFilename()));
  }

  public function getPath($sf_root_dir)
  {
    return sprintf('%s/web/chip/sources/%s', $sf_root_dir, $this->getOriginalFilename());
  }

  public function __toString()
  {
    return sprintf('%s - %s', $this->getComposer(), $this->getTitle());
  }
}

sfPropelBehavior::add('Track', array('sfPropelActAsTaggableBehavior'));