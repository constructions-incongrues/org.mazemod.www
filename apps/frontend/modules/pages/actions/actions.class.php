<?php

/**
 * pages actions.
 *
 * @package    h
 * @subpackage pages
 * @author     Michel Bertier <mbertie@rparishq.net>
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class pagesActions extends sfActions
{
  /**
   * "Informations" page.
   */
  public function executeInfos()
  {
    return sfView::SUCCESS;
  }

  /**
   * "Playlist" page. Displays enabled playlists. User can see tracks, author and play the music.
   */
  public function executePlaylist()
  {
    // Fetch enabled playlists, most recent first
    $c = new Criteria();
    $c->add(PlaylistPeer::IS_ENABLED, true);
    $c->addDescendingOrderByColumn(PlaylistPeer::CREATED_AT);
    $playlists = PlaylistPeer::doSelect($c); // TODO : should join on track table

    // Pass playlists to view
    $this->playlists = $playlists;

    return sfView::SUCCESS;
  }

  /**
   * "Links" page.
   */
  public function executeLinks()
  {
    // TODO : make links sortable and dynamic
    return sfView::SUCCESS;
    
    // Fetch categories
    $c = new Criteria();
    $c->addAscendingOrderByColumn(LinkCategoryPeer::NAME);
    $link_categories = LinkCategoryPeer::doSelect($c);

    // Pass variables to view
    $this->link_categories = $link_categories;

    return sfView::SUCCESS;
  }

  /**
   * "Contact" page.
   */
  public function executeContact()
  {
    return sfView::SUCCESS;
  }

  /**
   * "Credits" page.
   */
  public function executeCredits()
  {
    return sfView::SUCCESS;
  }
  /**
   * "News" page.
   */
  public function executeNews()
  {
    // Fetch latest news
    $c = new Criteria();
    $c->add(PostPeer::IS_ENABLED, true);
    $c->addDescendingOrderByColumn(PostPeer::CREATED_AT);
    $posts = PostPeer::doSelect($c) or array();

    // Pass posts to view
    $this->posts = $posts;
  }

}
