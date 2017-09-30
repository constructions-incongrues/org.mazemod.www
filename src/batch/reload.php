<?php
/*
 * CONCEPTS : 
 *  - no database writes
 *  - no writes in input directory
 */

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

// TODO : turn into a symfony task
$configuration = ProjectConfiguration::getApplicationConfiguration('backend', 'prod', true);
$context = sfContext::createInstance($configuration);

$input_dir = $_SERVER['argv'][1];
$finder = new sfFinder();
if ($source_files = $finder->name('*.mod'));

// Setup logging
$logger = $context->getLogger();
$logger->log('{mmReload} Execution started');

// Configure all directories
if (!isset($_SERVER['argv'][1]))
{
  throw new RuntimeException('Please provide input directory as script\'s first argument');
}
$input_dir = $_SERVER['argv'][1];
$work_dir = sprintf('%s/converter/workspace/work', sfConfig::get('sf_upload_dir'));
$sources_dest_dir = sprintf('%s/chip/sources', sfConfig::get('sf_web_dir'));
$mp3_dest_dir = sprintf('%s/chip/mp3', sfConfig::get('sf_web_dir'));

// Check for sanity
$logger->log('{mmReload} Checking for sanity');
if (!is_readable($input_dir))
{
  throw new RuntimeException(sprintf('"%s" must be readable', $input_dir));
}
if (!is_writable($work_dir))
{
  throw new RuntimeException(sprintf('"%s" must be writable', $work_dir));
}
if (!is_writable($sources_dest_dir))
{
  throw new RuntimeException(sprintf('"%s" must be writable', $sources_dest_dir));
}
if (!is_writable($mp3_dest_dir))
{
  throw new RuntimeException(sprintf('"%s" must be writable', $mp3_dest_dir));
}
$logger->log('{mmReload} All sanity checks successful');

// Grab all mod and xm files in input directory
$logger->log(sprintf('{mmReload} Looking for chips in "%s"', $input_dir));
$finder = new sfFinder();
if ($input_files = $finder->name('*.mod')->name('*.xm')->in($input_dir))
{
  $logger->log(sprintf('{mmReload} Found %d input files in "%s"', count($input_files), $input_dir));
  $computed_files_count = 0;
  $reloaded_files_count = 0;
  foreach ($input_files as $input_file)
  {
    $logger->log(sprintf('{mmReload} Computing "%s"', $input_file));
    
    // Get MD5 sum
    $md5 = md5_file($input_file);
    $logger->debug(sprintf('{mmReload} MD5 sum of "%s" is "%s"', $input_file, $md5));
    
    // Search for corresponding record in database
    if ($propel_track = TrackPeer::retrieveByOriginalFileMd5($md5))
    {
      $track_basename = sprintf('%s - %s', $propel_track->getComposer(), $propel_track->getTitle());
      $logger->log(sprintf('{mmReload} Found matching database entry "%s" for sum "%s"', $track_basename, $md5));
      
      // Skip treatment if mod + mp3 already exist in CDN
      $dest_source_filepath = sprintf('%s/%s.%s', $sources_dest_dir, $track_basename, strtolower(pathinfo($input_file, PATHINFO_EXTENSION)));
      $dest_mp3_filepath = sprintf('%s/%s.mp3', $mp3_dest_dir, $track_basename);
      if (file_exists($dest_source_filepath) && file_exists($dest_mp3_filepath))
      {
        $logger->log('{mmReload} File does not need to be reloaded');
        continue;
      }
      
      // Copy input file to working directory
      $source_filepath = sprintf('%s/%s.%s', $work_dir, $track_basename, strtolower(pathinfo($input_file, PATHINFO_EXTENSION)));
      if (!file_exists($source_filepath))
      {
        if (!copy($input_file, $source_filepath))
        {
          throw new RuntimeException(sprintf('An error occured while copying "%s" to "%s"', $input_file, $source_filepath));
        }
      }
      
      // Convert file
      $logger->log(sprintf('{mmReload} Converting "%s"', $source_filepath));
      $converted_mp3_filepath = mmSoundConverter::convert($source_filepath);
      
      // Move files to CDN
      $logger->log(sprintf('{mmReload} Moving "%s" to "%s"', $source_filepath, $dest_source_filepath));
      rename($source_filepath, $dest_source_filepath);
      $logger->log(sprintf('{mmReload} Moving "%s" to "%s"', $converted_mp3_filepath, $dest_mp3_filepath));
      rename($converted_mp3_filepath, $dest_mp3_filepath);
      
      // Increment counter
      $reloaded_files_count += 1;
    }
    else
    {
      $logger->log(sprintf('{mmReload} No matching record found for sum "%s", skipping', $md5));
    }
    
    // Continue to next file
    $logger->log(sprintf('{mmReload} %d out of %d files computed', ++$computed_files_count, count($input_files)));
  }
  // Summary
  $logger->log(sprintf('{mmReload} %d out of %d files where reloaded', $reloaded_files_count, count($input_files)));
}
else
{
  $logger->log(sprintf('{mmReload} Did not find any interesting files in "%s", exiting', $input_dir));
}

$logger->log('{mmReload} Execution ended');

// Exit with nil return value
exit(0);