<?php

class PetitionDocument extends AppModel {
  // Define class name for cake
  public $name = "PetitionDocument";

  // Add behaviors
  public $actsAs = array('Containable');

  // Association rules from this model to other models
  public $belongsTo = array(
    "CoPetition"
  );

  // Default display field for cake generated views
  public $displayField = "PetitionDocument.id";

  // Default ordering for find operations
  public $order = array("PetitionDocument.id");

  // Validation rules for table elements
  public $validate = array(
    'co_petition_id' => array(
      'rule' => 'numeric',
      'required' => true,
      'allowEmpty' => false
    ),
    'filename' => array(
      'content' => array(
        'rule' => array('maxLength', 256),
        'required' => true,
        'allowEmpty' => false,
        'message' => 'A filename must be provided'
      ),
      'filter' => array(
        'rule' => array('validateInput')
      )
    )
  );

  // We need to override the parent method defined in AppModel.php since
  // our model does not itself record co_id and it is not based on other
  // models like CoPerson or the like for which the parent can infer.
  public function findCoForRecord($id) {

    $args = array();
    $args['conditions']['PetitionDocument.id'] = $id;
    $args['contain'] = 'CoPetition';

    $petitionDocument = $this->find('first', $args);

    if(!empty($petitionDocument['CoPetition'])) {
      $coId = $petitionDocument['CoPetition']['co_id'];
      return $coId;
    }

    // We could not find the petition using the petition document ID
    // so as a last try invoke the parent method.
    return parent::findCoForRecord($id);
  }
}
