<?php

class UploadEnroller extends AppModel {
  // Required by COmanage Plugins
  public $cmPluginType = "enroller";

  // Document foreign keys
  public $cmPluginHasMany = array(
    "CoPetition" => array("PetitionDocument")
  );

  // Add behaviors
  public $actsAs = array('Containable', 'Changelog' => array('priority' => 5));

  // Association rules from this model to other models
  public $belongsTo = array("CoEnrollmentFlowWedge");

  // Validation rules for table elements
  public $validate = array(
    'co_enrollment_flow_wedge_id' => array(
      'rule' => 'numeric',
      'required' => true,
      'allowEmpty' => false
    )
  );

  /**
   * Expose menu items.
   * 
   * @since COmanage Registry v1.1.0
   * @return Array with menu location type as key and array of labels, controllers, actions as values.
   */
  
  public function cmPluginMenus() {
    $menus = array();

    // The Plugin infrastructure automatically appends the CO ID.
    $menus["copeople"] = array("Pending Petition Documents" => array('controller' => 'petition_documents', 'action' => 'index'));

    return $menus;
  }
}
