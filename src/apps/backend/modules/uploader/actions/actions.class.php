<?php

/**
 * uploader actions.
 *
 * @package    h
 * @subpackage uploader
 * @author     Michel Bertier <mbertie@parishq.net>
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class uploaderActions extends sfActions
{
  /**
   * First step : the user uploads a mod file or an archive containing several mod files.
   */
  public function executeFile(sfWebRequest $request)
  {
    // Instanciate form
    $upload_form = new mmFileUploadForm();

    // Handle form submission
    if ($request->isMethod('post'))
    {
      // Bind submitted values to the form
      $upload_form->bind($request->getParameter('file'), $request->getFiles());

      // Validate form
      if ($upload_form->isValid())
      {
        $file = $upload_form->getValue('file');
        $uploaded_files = array();

        // If file is an archive, extract it
        if ($file->getType() == 'application/x-zip')
        {
          // TODO : write autoloader
          require_once '/usr/share/php/ezc/Base/base.php';
          ezcBase::autoload('ezcBaseException');
          ezcBase::autoload('ezcBaseFileException');
          ezcBase::autoload('ezcBaseFilePermissionException');
          ezcBase::autoload('ezcBaseStruct');
          ezcBase::autoload('ezcArchive');
          ezcBase::autoload('ezcArchiveFile');
          ezcBase::autoload('ezcArchiveMime');
          ezcBase::autoload('ezcArchiveCharacterFile');
          ezcBase::autoload('ezcArchiveZip');
          ezcBase::autoload('ezcArchiveLocalFileHeader');
          ezcBase::autoload('ezcArchiveCentralDirectoryEndHeader');
          ezcBase::autoload('ezcArchiveCentralDirectoryHeader');
          ezcBase::autoload('ezcArchiveFileStructure');
          ezcBase::autoload('ezcArchiveStatMode');
          ezcBase::autoload('ezcArchiveEntry');

          $archive = ezcArchive::open($file->getTempName());
          foreach ($archive as $entry)
          {
            // TODO : real mimetype checking
            // TODO : xm files should work too
            if (substr($entry->getPath(), -4) == '.mod')
            {
              $archive->extractCurrent(sprintf('%s/converter/workspace/incoming', sfConfig::get('sf_upload_dir')));
              $uploaded_files[] = sprintf('%s/converter/workspace/incoming/%s', sfConfig::get('sf_upload_dir'), $entry->getPath());
            }
          }
        }
        // Only a single mod file
        else
        {
          // Save file the new mods directory
          $file_path = sprintf('%s/converter/workspace/incoming/%s', sfConfig::get('sf_upload_dir'), $file->getOriginalName());
          $file->save($file_path);
          $uploaded_files[] = $file_path;
        }

        // Save files to session
        $this->getUser()->setAttribute('uploaded_files', $uploaded_files);

        // Redirect user to next action
        $this->redirect('@uploader_confirm');
      }
    }

    // Pass form to the view
    $this->upload_form = $upload_form;
  }

  /**
   * Second step : the user is given a chance to fix tracks metadata
   */
  public function executeConfirm(sfWebRequest $request)
  {
    // If no tracks in session, redirect to first step
    $this->redirectUnless($uploaded_files = $this->getUser()->getAttribute('uploaded_files'), '@uploader_file');

    // Used in the executeFinish action to give feedback to the user
    $tracks_statuses = array('success' => array(), 'error' => array());

    // Create an edition form for each uploaded track
    $track_forms = array();
    foreach ($uploaded_files as $file)
    {
      $form = new mmUploadedModForm();
      $form->setModFile($file);
      $track_forms[] = $form;
    }

    // Handle form submission
    if ($request->isMethod('post'))
    {
      $tracks_data = $request->getParameter('track');
      $i = 0;
      foreach ($track_forms as $form)
      {
        // TODO : bad smell here
        $track_data = array(
          'file'      => $tracks_data[$i++]['file'],
          'composer'  => $tracks_data[$i++]['composer'],
          'title'     => $tracks_data[$i++]['title'],
          'tags'      => $tracks_data[$i++]['tags'],
        );
        $form->bind($track_data);

        if ($form->isValid())
        {
          // Add track to database
          $track = new Track();
          $track->setComposer($form->getValue('composer'));
          $track->setTitle($form->getValue('title'));
          $track->setTags($form->getValue('tags'));
          $track->setOriginalFilename($form->getValue('file'));
          $track->setOriginalFileMd5(md5_file(sprintf('%s/converter/workspace/incoming/%s', sfConfig::get('sf_upload_dir'), $form->getValue('file'))));
          $track->setIsMetadataComplete(false);
          $track->setIsEnabled(false);
          
          // Catch exceptions thrown because of duplicate records
          try
          {
            $track->save();
            $tracks_statuses['success'][] = $track;
          }
          catch (PropelException $e)
          {
            $tracks_statuses['error'][] = $track;
            continue;
          }
        }
      }

      // Put processed tracks statuses into session
      $this->getUser()->setAttribute('tracks_statuses', $tracks_statuses);

      // Redirect to next step
      $this->redirect('@uploader_finish');
    }

    // Pass forms to view
    $this->track_forms = $track_forms;
  }

  /**
   * Last step : tell the user that he has to wait for the conversion to happen.
   */
  public function executeFinish()
  {
    // If no tracks in session, redirect to first step
    $this->redirectUnless($tracks_statuses = $this->getUser()->getAttribute('tracks_statuses'), '@uploader_file');

    // Pass list of uploaded files to view
    $this->tracks_statuses = $tracks_statuses;

    // Clear session
    $this->getUser()->getAttributeHolder()->remove('uploaded_files');
    $this->getUser()->getAttributeHolder()->remove('tracks_statuses');
  }
}
