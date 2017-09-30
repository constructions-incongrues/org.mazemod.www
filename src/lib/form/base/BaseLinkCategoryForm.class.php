<?php

/**
 * LinkCategory form base class.
 *
 * @package    form
 * @subpackage link_category
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseLinkCategoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'       => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'id'         => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'name'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'id'         => new sfValidatorPropelChoice(array('model' => 'LinkCategory', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('link_category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LinkCategory';
  }


}
