<?php

/**
 * feeds actions.
 *
 * @package    h
 * @subpackage feeds
 * @author     Michel Bertier <mbertie@parishq.net>
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class feedsActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executePosts()
  {
    $feed = new sfAtom1Feed();

    $feed->setTitle('Mazemod news');
    $feed->setLink('http://www.mazemod.org/');

    $c = new Criteria;
    $c->add(PostPeer::IS_ENABLED, true);
    $c->addDescendingOrderByColumn(PostPeer::CREATED_AT);
    $c->setLimit(20);
    $posts = PostPeer::doSelect($c);

    foreach ($posts as $post)
    {
      $item = new sfFeedItem();
      $item->setTitle($post->getTitle());
      $item->setLink($post->getLink());
      $item->setAuthorName('The Mazemod crew');
      $item->setPubdate($post->getCreatedAt('U'));
      $item->setUniqueId($post->getStrippedTitle());
      $item->setDescription(strip_tags($post->getBody()));
      $item->setContent($post->getBody());
      $feed->addItem($item);
    }

    $this->getResponse()->setContentType('application/atom+xml');

    $this->feed = $feed;
  }
}
