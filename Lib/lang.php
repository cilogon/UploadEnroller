<?php
  
global $cm_lang, $cm_texts;

// When localizing, the number in format specifications (eg: %1$s) indicates the argument
// position as passed to _txt.  This can be used to process the arguments in
// a different order than they were passed.

$cm_upload_enroller_texts['en_US'] = array(
  // Error messages
  'er.uploadenroller.copetition.id.none' => 'Cannot find petition with ID %1$s',
  
  // Plugin texts
  'pl.uploadenroller.upload.instruction.detailed' => 'Please attach a completed data request form. A <a href="/registry/local-resources/AGHA-Forms.pdf" target="blank_form">blank copy of the form is available here</a>.',
  'pl.uploadenroller.upload.instruction.brief' => 'Upload your document',
  'pl.uploadenroller.upload.title' => 'Attach Your Completed Data Request Form',
  'pl.uploadenroller.petition.title' => 'Pending Petition Uploaded Documents',
  'pl.uploadenroller.index.table.heading.name' => 'Enrollee Name',
  'pl.uploadenroller.index.table.heading.email' => 'Enrollee Email',
  'pl.uploadenroller.index.table.heading.document' => 'Uploaded Document',
  'pl.uploadenroller.petition.view.document' => 'Uploaded Document',
);
