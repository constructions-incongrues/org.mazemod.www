<?php

/**
 * Job form base class.
 *
 * @package    form
 * @subpackage job
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseJobForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'handler'    => new sfWidgetFormInput(),
      'data'       => new sfWidgetFormTextarea(),
      'status'     => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'id'         => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'handler'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'data'       => new sfValidatorString(array('required' => false)),
      'status'     => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'id'         => new sfValidatorPropelChoice(array('model' => 'Job', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('job[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Job';
  }


}
