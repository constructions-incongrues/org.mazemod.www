<?php
class mmFileUploadForm extends sfForm
{

  public function configure()
  {
    // Define schema
    $widget_schema = new sfWidgetFormSchema(
      array('file'              => new sfWidgetFormInputFile(),
            'is_playlist'       => new sfWidgetFormInputCheckbox(),
            'playlist_author'   => new sfWidgetFormInput(),
            'playlist_title'    => new sfWidgetFormInput())
    );

    // HTML "name" attribute format.
//    $widget_schema->setNameFormat('upload[%s]');

    $this->setWidgetSchema($widget_schema);

    // Semantic decorator
    $this->widgetSchema->setFormFormatterName('list');

    // Validators
    $validators = array('file'            => new sfValidatorFile(array('mime_types' => array('audio/x-mod', 'application/x-zip'))),
                        'playlist_author' => new sfValidatorString(array('required' => false)),
                        'playlist_title'  => new sfValidatorString(array('required' => false)));
    $this->setValidators($validators);
  }

}