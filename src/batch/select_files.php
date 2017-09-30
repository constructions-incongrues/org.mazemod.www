<?php

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

// TODO : obtain environment and debug variables values from cli
$configuration = ProjectConfiguration::getApplicationConfiguration('backend', 'prod', true);
$context = sfContext::createInstance($configuration);

$workspace_root = sprintf('%s/converter/workspace', sfConfig::get('sf_upload_dir'));
$params = array('incoming_dir' => $workspace_root.'/incoming',
                'work_dir'     => $workspace_root.'/work',
                'cdn_rootdir'  => sprintf('%s/web/chip', $context->getConfiguration()->getRootDir()));

$job = new sfFileSelectionJobHandler($configuration);
$job->run($params);