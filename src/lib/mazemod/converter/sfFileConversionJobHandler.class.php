<?php

class sfFileConversionJobHandler
{
  /**
   * @var ProjectConfiguration
   */
  private $configuration;
  
  /**
   * @var sfLogger
   */
  private $logger;

  /**
   * Initialiazes logger.
   */
  public function __construct(ProjectConfiguration $configuration)
  {
    $this->configuration = $configuration;
    $this->logger = new sfConsoleLogger($configuration->getEventDispatcher());
  }

  public function run(array $params)
  {
    $this->performSanityChecks($params);

    $source_files = $params['files'];

    // TODO : warn on file error (missing, conversion error), but do not interrupt
    foreach ($source_files as $source_filepath)
    {
      // Convert file. The converted file goes in the same directory as the source file.
      // TODO : update file status in backend
      $this->logger->log(sprintf('[%s] Starting conversion for file "%s"', date('r'), $source_filepath));
      $destination_filepath = mmSoundConverter::convert($source_filepath);
      $this->logger->log(sprintf('[%s] Conversion of file "%s" successful', date('r'), $source_filepath));

      // Move files to CDN
      $dest_source = sprintf('%s/sources/%s', $params['destination_dir'], basename($source_filepath));
      $dest_mp3 = sprintf('%s/mp3/%s', $params['destination_dir'], basename($destination_filepath));
      rename($source_filepath, $dest_source);
      rename($destination_filepath, $dest_mp3);

      // Insert track into database
      $md5_original_file =  md5_file($dest_source);
      if (!$track = TrackPeer::retrieveByOriginalFileMd5($md5_original_file))
      {
        $track = new Track();
        $track->setOriginalFileMd5($md5_original_file);
      }
      $track->setOriginalFilename(basename($source_filepath));
      $track->setConvertedFilename(basename($destination_filepath));
      $track->setIsEnabled(false);
      $track->setIsMetadataComplete(false);
      $track->save();
    }
  }

  private function performSanityChecks(array $params)
  {
    if (!is_dir($params['destination_dir'].'/sources/'))
    {
      throw new RuntimeException(sprintf('"%s" must be a directory', $params['destination_dir'].'/sources/'));
    }
    if (!is_writable($params['destination_dir'].'/sources/'))
    {
      throw new RuntimeException(sprintf('Directory "%s" must be writable', $params['destination_dir'].'/sources/'));
    }
    if (!is_dir($params['destination_dir'].'/mp3/'))
    {
      throw new RuntimeException(sprintf('"%s" must be a directory', $params['destination_dir'].'/mp3/'));
    }
    if (!is_writable($params['destination_dir'].'/mp3/'))
    {
      throw new RuntimeException(sprintf('Directory "%s" must be writable', $params['destination_dir'].'/mp3/'));
    }

  }
}
?>