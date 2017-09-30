<?php

class sfFileSelectionJobHandler
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

  /**
   * Looks for mod and xm files in the workspace's incoming directory.
   * If files are found :
   *  - they are moved to workspace's work directory
   *  - a conversion job including all found files is inserted in the "conversions" queue
   */
  public function run(array $params)
  {
    // Sanity checks
    $this->performSanityChecks($params);

    // Check for lock
    $lock_file = sprintf('%s/lock', $params['incoming_dir']);
    if (!file_exists($lock_file))
    {
      // Create lock
      file_put_contents($lock_file, time());
      
      try
      {
        // Find files
        $finder = new sfFinder();
    
        $this->logger->log(sprintf('Looking for MOD and XM files in "%s"', $params['incoming_dir']));
        if ($files = $finder->name('*.xm')->name('*.mod')->in($params['incoming_dir']))
        {
    
          $this->logger->log(sprintf('Found %d file(s)', count($files)));
    
          // Move files to work dir
          // TODO : check if file does not already exist in the database
          $work_files = array();
          foreach ($files as $src_filepath)
          {
            $dest_filepath = escapeshellcmd(sprintf('%s/%s', $params['work_dir'], basename($src_filepath)));
            if (!rename($src_filepath, $dest_filepath))
            {
              $this->logger->warning((sprintf('Error writing "%s"', $dest_filepath)));
              continue;
            }
            $this->logger->log(sprintf('Moved "%s" to "%s"', $src_filepath, $dest_filepath));
            $work_files[] = $dest_filepath;
          }
    
          if (count($work_files))
          {
            // Create conversion task
            $job = new Job();
            $job->setHandler('sfFileConversionJobHandler');
            $job->setData(serialize(array('files' => $work_files, 'destination_dir' => $params['cdn_rootdir'])));
            $job->setStatus(0);
            $job->save();
            $this->logger->log(sprintf('Inserted new job for converting "%d" file(s)', count($work_files)));
          }
        }
        else
        {
          $this->logger->info(sprintf('No files in "%s", exiting', $params['incoming_dir']));
        }
        
        // Remove lock
        unlink($lock_file);
      }
      // OK now i understand this "finally" stuff in python :P
      catch (Exception $e)
      {
        // Remove lock
        unlink($lock_file);
        
        // Raise exception
        throw $e;
      }
    }
    else
    {
      // Warn about lock
      $this->logger->warning(sprintf('Found lock in "%s", exiting', $lock_file));
    }
  }

  /**
   * Make sure that everything will work as expected.
   */
  private function performSanityChecks(array $job_params)
  {
    $required_keys = array('incoming_dir', 'work_dir', 'cdn_rootdir');
    $required_dirs_names = $required_keys;
    foreach ($required_keys as $key)
    {
      if (!isset($job_params[$key]))
      {
        throw new RuntimeException(sprintf('The job parameter "%s" is required', $key));
      }
    }

    foreach ($required_dirs_names as $name)
    {
      if (!is_dir($job_params[$name]))
      {
        throw new RuntimeException(sprintf('Directory "%s" does not exist', $job_params[$name]));
      }

      if (!is_writable($job_params[$name]))
      {
        throw new RuntimeException(sprintf('Directory "%s" should be writeable', $job_params[$name]));
      }
    }
  }
}
?>