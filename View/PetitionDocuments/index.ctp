<?php

  // Add breadcrumbs
  print $this->element("coCrumb");
  //$this->Html->addCrumb(_txt('ct.cous.pl'));

  // Add page title
  $params = array();
  $params['title'] = $title_for_layout;

  print $this->element("pageTitleAndButtons", $params);
?>

<div class="table-container">
  <table id="petitiondocuments">
    <thead>
      <tr>
        <th><?php print _txt('pl.uploadenroller.index.table.heading.name'); ?></th>
        <th><?php print _txt('pl.uploadenroller.index.table.heading.email'); ?></th>
        <th><?php print _txt('pl.uploadenroller.index.table.heading.document'); ?></th>
      </tr>
    </thead>

    <tbody>
      <?php $i = 0; ?>
      <?php foreach($petitionDocuments as $d): ?>
        <?php if(!empty($d['CoPetition']['status'])) : ?>
          <tr class="line<?php print ($i % 2)+1; ?>">
            <td>
              <?php
                $given = $d['CoPetition']['EnrolleeCoPerson']['Name'][0]['given'];
                $family = $d['CoPetition']['EnrolleeCoPerson']['Name'][0]['family'];

                $args = array();
                $args['plugin'] = null;
                $args['controller'] = 'co_petitions';
                $args['action'] = 'view';
                $args[] = $d['CoPetition']['id'];
                print $this->Html->link("$given $family", $args);
              ?>
            </td>
            <td>
              <?php
                $mail = $d['CoPetition']['EnrolleeCoPerson']['EmailAddress'][0]['mail'];

                $args = array();
                $args['plugin'] = null;
                $args['controller'] = 'co_people';
                $args['action'] = 'canvas';
                $args[] = $d['CoPetition']['enrollee_co_person_id'];
                print $this->Html->link("$mail", $args);
              ?>
            </td>
            <td>
              <?php
                $filename = $d['PetitionDocument']['filename'];
                $basename = basename($filename);

                $args = array();
                $args['plugin'] = 'upload_enroller';
                $args['controller'] = 'petition_documents';
                $args['action'] = 'send_file';
                $args['co'] = $coId;
                $args[] = $d['PetitionDocument']['id'];
                print $this->Html->link($basename, $args);
              ?>
            </td>
          </tr>

        <?php endif; ?>
      <?php $i++; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
