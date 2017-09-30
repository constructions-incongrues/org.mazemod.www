<?php

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    // Player does not work when accessing http://mazemod.org
    if ($_SERVER['SERVER_NAME'] == 'mazemod.org')
    {
      header('Location: http://www.mazemod.org');
      exit;
    }
  }
}
