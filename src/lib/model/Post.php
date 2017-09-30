<?php

/**
 * Subclass for representing a row from the 'post' table.
 *
 *
 *
 * @package lib.model
 */
class Post extends BasePost
{
  /**
   * TODO : implement real transliteration.
   */
  public function getStrippedTitle()
  {
    $text = strtolower($this->getTitle());

    // strip all non word chars
    $text = preg_replace('/\W/', ' ', $text);
    // replace all white space sections with a dash
    $text = preg_replace('/\ +/', '-', $text);
    // trim dashes
    $text = preg_replace('/\-$/', '', $text);
    $text = preg_replace('/^\-/', '', $text);

    return $text;
  }

  /**
   * TODO : Implement permalinks form posts.
   */
  public function getLink()
  {
    return 'http://www.mazemod.org';
  }
}
