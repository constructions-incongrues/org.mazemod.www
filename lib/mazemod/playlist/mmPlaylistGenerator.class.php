<?php
/**
 * Used to generate playlists XSPF documents out of database data.
 *
 * @todo  Use decorator pattern ?
 */
class mmPlaylistGenerator
{

# -- PROPERTIES

  /**
   * Holds propel playlist instance.
   *
   * @var Playlist
   */
  private $playlist;

  /**
   * Holds playlist's tracks.
   *
   * @var array
   */
  private $tracks;

  /**
   * Holds playlist's author name.
   *
   * @var string
   */
  private $author;

  /**
   * Holds playlist's title.
   *
   * @var string
   */
  private $title;

  /**
   * Holds playlist's description.
   *
   * @var string
   */
  private $description;

  /**
   * Holds File_XSPF instance.
   *
   * @var File_XSPF
   */
  private $xspf;

# -- PUBLIC API

  /**
   * Instanciates File_XSPF document.
   */
  public function __construct()
  {
    set_include_path(get_include_path() . PATH_SEPARATOR . '/usr/share/php');

    // Instanciate XSPF document
    $error_level = error_reporting(E_ALL & ~E_STRICT);
    require 'File/XSPF.php';
    $this->xspf = new File_XSPF();
  }

  /**
   * Set database playlist to be used to generate XSPF document.
   *
   * @param Playlist $playlist
   */
  public function setPlaylist(Playlist $playlist)
  {
    // Populate data
    $this->setAuthor($playlist->getAuthor());
    $this->setTitle($playlist->getTitle());
    $this->setDescription($playlist->getDescription());
    $this->setTracks($playlist->getTracks());
  }

  /**
   * Sets playlist tracks from database
   *
   * @param array $tracks An array of Track instances
   */
  public function setTracks(array $tracks)
  {
    $this->tracks = $tracks;
  }

  /**
   * Sets playlist author.
   *
   * @param string $author
   */
  public function setAuthor($author)
  {
    $this->author = $author;
  }

  /**
   * Sets playlist title.
   *
   * @param string $title
   */
  public function setTitle($title)
  {
    $this->title = $title;
  }

  /**
   * Sets playlist description.
   *
   * @param string $description
   */
  public function setDescription($description)
  {
    $this->description = $description;
  }

  /**
   * Returns playlist as an XSPF document
   *
   * @return string
   */
  public function toString()
  {
    // Set metadata
    $this->xspf->setCreator($this->author);
    $this->xspf->setTitle($this->title);
    $this->xspf->setAnnotation($this->description);

    // Add tracks
    foreach ($this->tracks as $track)
    {
      $t = new File_XSPF_Track();
      $track_location = sprintf('%s%s/chip/mp3/%s', sfContext::getInstance()->getRequest()->getUriPrefix(),
                                                    sfContext::getInstance()->getRequest()->getRelativeUrlRoot(),
                                                    $track->getConvertedFilename());
      $t->addLocation(new File_XSPF_Location($track->getLocationFromSfRequest(sfContext::getInstance()->getRequest())));
      $t->setTitle($track->getTitle());
      $t->setCreator($track->getComposer());
      $this->xspf->addTrack($t);
    }

    return $this->xspf->toString();
  }
}