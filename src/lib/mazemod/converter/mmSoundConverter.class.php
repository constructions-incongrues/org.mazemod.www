<?php
class mmSoundConverter
{
  // TODO : throw custom exceptions
  public static function convert($filepath, $mikmod_bin = '/usr/bin/mikmod', $lame_bin = '/usr/bin/lame')
  {
    // Sanity checks
    if (!is_executable($mikmod_bin))
    {
      throw new RuntimeException(sprintf('"%s" must be executable', $mikmod_bin));
    }
    if (!is_executable($lame_bin))
    {
      throw new RuntimeException(sprintf('"%s" must be executable', $lame_bin));
    }

    // Go to work directory
    chdir(dirname($filepath));

    // Guess file extension
    $file_parts = explode('.', $filepath);
    $file_extension = array_pop($file_parts);
    $tmp_filename = sprintf('%s.wav', uniqid('mm_'));

    // Convert module to WAV
    $return_value = 1;
    $command_output = array();
    $cmd = sprintf('%s -d4,file=%s -X -q %s 2>&1', $mikmod_bin, $tmp_filename, escapeshellarg($filepath));
    exec($cmd, $command_output, $return_value);
    if ($return_value !== 0)
    {
      throw new RuntimeException(sprintf('An error occured while running command "%s"', $cmd));
    }

    // Convert WAV to MP3
    $return_value = 1;
    $command_output = array();
    $cmd = sprintf('%s %s %s 2>&1', $lame_bin, escapeshellarg(dirname($filepath).'/'.$tmp_filename), escapeshellarg(basename($filepath, $file_extension).'mp3'));
    exec($cmd, $command_output, $return_value);
    if ($return_value !== 0)
    {
      throw new RuntimeException(sprintf('An error occured while running command "%s"', $cmd));
    }

    // Delete intermediate WAV file
    $wav_filepath = sprintf('%s/%s', dirname($filepath), $tmp_filename);
    if (file_exists($wav_filepath))
    {
      unlink($wav_filepath);
    }
    
    // Return path to mp3 file
    return sprintf('%s/%smp3', dirname($filepath), basename($filepath, $file_extension));
  }

}
?>