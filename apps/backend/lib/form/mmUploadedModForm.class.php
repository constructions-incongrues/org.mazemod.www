<?php

?><?php
class mmUploadedModForm extends sfForm
{

  public function configure()
  {
    // Define schema
    $widget_schema = new sfWidgetFormSchema(
      array(
        'file'     => new sfWidgetFormInput(),
        'composer' => new sfWidgetFormInput(),
        'title'    => new sfWidgetFormInput(),
        'tags'     => new sfWidgetFormInput()
      )
    );

    // HTML "name" attribute format.
    $widget_schema->setNameFormat('track[][%s]');

    $this->setWidgetSchema($widget_schema);

    // Semantic decorator
    $this->widgetSchema->setFormFormatterName('list');

    // Validators
    $this->setValidators(
      array(
        'file'      => new sfValidatorString(),
        'composer'  => new sfValidatorString(),
        'title'     => new sfValidatorString(),
        'tags'      => new sfValidatorString(array('required' => false)),
      )
    );
  }

  public function setModFile($file_path)
  {
    // TODO : devrait être fait ailleurs
    $this->setDefault('file', basename($file_path));
    $infos = explode(' - ', basename($file_path, '.mod'));
    $this->setDefault('composer', $infos[0]);
    if (isset($infos[1]))
    {
      $this->setDefault('title', $infos[1]);
    }
  }

}