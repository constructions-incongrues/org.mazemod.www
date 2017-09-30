<?php

/**
 * Subclass for representing a row from the 'link_category' table.
 *
 *
 *
 * @package lib.model
 */
class LinkCategory extends BaseLinkCategory
{
  /**
   * Returns all links belonging to the category, sorted by alphabetical order.
   *
   * @param   Criteria    $criteria
   * @param   Connection  $con
   *
   * @return array
   */
  public function getLinksByAlphabeticalOrder(Criteria $criteria = null, Connection $con = null)
  {
    if (!$criteria)
    {
      $criteria = new Criteria();
    }

    $criteria->addAscendingOrderByColumn(LinkPeer::TITLE);

    return $this->getLinks($criteria);
  }

  public function __toString()
  {
    return $this->getName();
  }
}
