<?php

/**
 * Track form base class.
 *
 * @package    form
 * @subpackage track
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseTrackForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'                => new sfWidgetFormInput(),
      'composer'             => new sfWidgetFormInput(),
      'original_filename'    => new sfWidgetFormInput(),
      'converted_filename'   => new sfWidgetFormInput(),
      'original_file_md5'    => new sfWidgetFormInput(),
      'is_metadata_complete' => new sfWidgetFormInputCheckbox(),
      'is_enabled'           => new sfWidgetFormInputCheckbox(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'id'                   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'title'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'composer'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'original_filename'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'converted_filename'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'original_file_md5'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'is_metadata_complete' => new sfValidatorBoolean(array('required' => false)),
      'is_enabled'           => new sfValidatorBoolean(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(array('required' => false)),
      'updated_at'           => new sfValidatorDateTime(array('required' => false)),
      'id'                   => new sfValidatorPropelChoice(array('model' => 'Track', 'column' => 'id', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Track', 'column' => array('original_file_md5')))
    );

    $this->widgetSchema->setNameFormat('track[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Track';
  }


}
