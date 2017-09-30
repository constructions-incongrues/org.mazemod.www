<?php

/**
 * PlaylistHasTrack form base class.
 *
 * @package    form
 * @subpackage playlist_has_track
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BasePlaylistHasTrackForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'playlist_id' => new sfWidgetFormPropelSelect(array('model' => 'Playlist', 'add_empty' => true)),
      'track_id'    => new sfWidgetFormPropelSelect(array('model' => 'Track', 'add_empty' => true)),
      'position'    => new sfWidgetFormInput(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'id'          => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'playlist_id' => new sfValidatorPropelChoice(array('model' => 'Playlist', 'column' => 'id', 'required' => false)),
      'track_id'    => new sfValidatorPropelChoice(array('model' => 'Track', 'column' => 'id', 'required' => false)),
      'position'    => new sfValidatorInteger(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
      'id'          => new sfValidatorPropelChoice(array('model' => 'PlaylistHasTrack', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('playlist_has_track[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PlaylistHasTrack';
  }


}
