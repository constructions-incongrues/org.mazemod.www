<?php

/**
 * Post form base class.
 *
 * @package    form
 * @subpackage post
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BasePostForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'      => new sfWidgetFormInput(),
      'body'       => new sfWidgetFormTextarea(),
      'is_enabled' => new sfWidgetFormInputCheckbox(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'id'         => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'title'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'body'       => new sfValidatorString(array('required' => false)),
      'is_enabled' => new sfValidatorBoolean(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'id'         => new sfValidatorPropelChoice(array('model' => 'Post', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('post[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Post';
  }


}
