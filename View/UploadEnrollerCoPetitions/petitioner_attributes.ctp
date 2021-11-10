<?php

  // Add page title
  $params = array();
  $params['title'] = $title_for_layout;
  
  print $this->element("pageTitleAndButtons", $params);
?>

<div style="clear: both;">
<p><?php print _txt('pl.uploadenroller.upload.instruction.detailed'); ?></p>
</div>

<?php

  $submit_label = _txt('op.add');

  $args = array();
  $args['type'] = 'file';
  $args['inputDefaults']['label'] = false;
  $args['inputDefaults']['div'] = false;


  print $this->Form->create(false, $args);

  if(!empty($vv_co_petition_id)) {
    print $this->Form->hidden('CoPetition.id', array('default' => $vv_co_petition_id)) . "\n";
  }
  
  if(!empty($vv_petition_token)) {
    print $this->Form->hidden('CoPetition.token', array('default' => $vv_petition_token)) . "\n";
  }

  if(!empty($vv_efwid)) {
    print $this->Form->hidden('co_enrollment_flow_wedge_id', array('default' => $vv_efwid)) . "\n";
  }


  // Add breadcrumbs
  print $this->element("coCrumb");
  //$this->Html->addCrumb(filter_var($title_for_layout,FILTER_SANITIZE_SPECIAL_CHARS));
?>


<div>
  <ul id="petition_document_upload" class="fields form-list">
    <li>
      <div class="field-name">
        <?php print _txt('pl.uploadenroller.upload.instruction.brief'); ?>
      </div>
      <div class="field-info">
        <?php
          print $this->Form->file('PetitionDocument.documentFile');
        ?>
      </div>
    </li>
    <li class="fields-submit">
      <div class="field-name"></div>
      <div class="field-info">
        <?php print $this->Form->submit(_txt('op.upload')); ?>
      </div>
    </li>
  </ul>
</div>

<?php print $this->Form->end(); ?>
