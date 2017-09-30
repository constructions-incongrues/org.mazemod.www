<?php

/**
 * Link form base class.
 *
 * @package    form
 * @subpackage link
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseLinkForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'            => new sfWidgetFormTextarea(),
      'url'              => new sfWidgetFormTextarea(),
      'description'      => new sfWidgetFormTextarea(),
      'link_category_id' => new sfWidgetFormPropelSelect(array('model' => 'LinkCategory', 'add_empty' => true)),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'id'               => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'title'            => new sfValidatorString(array('required' => false)),
      'url'              => new sfValidatorString(array('required' => false)),
      'description'      => new sfValidatorString(array('required' => false)),
      'link_category_id' => new sfValidatorPropelChoice(array('model' => 'LinkCategory', 'column' => 'id', 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
      'id'               => new sfValidatorPropelChoice(array('model' => 'Link', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('link[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Link';
  }


}
