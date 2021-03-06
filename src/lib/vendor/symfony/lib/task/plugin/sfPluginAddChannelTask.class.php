<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/sfPluginBaseTask.class.php');

/**
 * Installs a plugin.
 *
 * @package    symfony
 * @subpackage task
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfPluginAddChannelTask.class.php 10197 2008-07-10 08:44:22Z fabien $
 */
class sfPluginAddChannelTask extends sfPluginBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('name', sfCommandArgument::REQUIRED, 'The channel name'),
    ));

    $this->namespace = 'plugin';
    $this->name = 'add-channel';

    $this->briefDescription = 'Add a new PEAR channel';

    $this->detailedDescription = <<<EOF
The [plugin:add-channel|INFO] task add a new PEAR channel:

  [./symfony plugin:add-channel symfony.plugins.pear.example.com|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $this->logSection('plugin', sprintf('add channel "%s"', $arguments['name']));

    $this->getPluginManager()->getEnvironment()->registerChannel($arguments['name']);
  }
}
