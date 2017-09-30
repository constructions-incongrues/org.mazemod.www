<?php
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

// TODO : obtain environment and debug variables values from cli
$configuration = ProjectConfiguration::getApplicationConfiguration('backend', 'prod', true);
$context = sfContext::createInstance($configuration);

// Select jobs to be run
$c = new Criteria();
$c->add(JobPeer::STATUS, 0);
$idle_tasks = JobPeer::doSelect($c);
foreach ($idle_tasks as $idle_task)
{
  $handler_classname = $idle_task->getHandler();
  $job = new $handler_classname($configuration);

  // Mark task as "running"
  $idle_task->setStatus(1);
  $idle_task->save();
  $job->run(unserialize($idle_task->getData()));

  // Mark task as "finished"
  $idle_task->setStatus(2);
  $idle_task->save();
}
