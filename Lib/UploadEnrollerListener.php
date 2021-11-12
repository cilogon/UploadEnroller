<?php

App::uses('CakeEventListener', 'Event');
App::uses('PetitionDocument', 'UploadEnroller.Model');

class UploadEnrollerListener implements CakeEventListener {

  public function implementedEvents() {
    return array(
      'Controller.beforeRender' => 'modifyView'
    );
  }

  public function modifyView(CakeEvent $event) {
    // The subject of the event is a Controller object.
    $controller = $event->subject();

    // We only intend to intercept the CoPetitions controller.
    if(!$controller->name === "CoPetitions") {
      return true;
    }

    // If the action is view then set the plugin.
    if($controller->action == "view") {
      $petition_id = $controller->CoPetition->id;

      $petitionDocumentModel = new PetitionDocument();
      $args = array();
      $args['conditions']['PetitionDocument.co_petition_id'] = $petition_id;
      $args['contain'] = false;

      $petitionDocument = $petitionDocumentModel->find('first', $args);

      if(!empty($petitionDocument)) {
        $controller->plugin = "UploadEnroller";
        $controller->set("petitionDocument", $petitionDocument);
      }
    }

    // Fall through and return true.
    return true;
  }
}
