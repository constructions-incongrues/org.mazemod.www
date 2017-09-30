<?php

/**
 * Playlist form base class.
 *
 * @package    form
 * @subpackage playlist
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BasePlaylistForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'       => new sfWidgetFormInput(),
      'is_enabled'  => new sfWidgetFormInputCheckbox(),
      'author'      => new sfWidgetFormInput(),
      'description' => new sfWidgetFormTextarea(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'id'          => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'title'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_enabled'  => new sfValidatorBoolean(array('required' => false)),
      'author'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description' => new sfValidatorString(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
      'id'          => new sfValidatorPropelChoice(array('model' => 'Playlist', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('playlist[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Playlist';
  }


}
