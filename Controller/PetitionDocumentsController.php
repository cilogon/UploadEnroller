<?

App::uses('StandardController', 'Controller');

class PetitionDocumentsController extends StandardController {
  // Class name, used by Cake
  public $name = "PetitionDocuments";

  // This controller needs a CO to be set
  public $requires_co = true;
  

  function isAuthorized() {
    $roles = $this->Role->calculateCMRoles();

    // Construct the permission set for this user, which will also be passed to the view.
    $p = array();
    
    // Determine what operations this user can perform
    $p['index'] = ($roles['cmadmin'] || $roles['coadmin']);
    $p['send_file'] = ($roles['cmadmin'] || $roles['coadmin']);

    $this->set('permissions', $p);
    return $p[$this->action];
  } 

  function index() {
    $this->set('title_for_layout', _txt('pl.uploadenroller.petition.title'));

    $coId = $this->params['named']['co'];

    // Find petitions in the PendingApproval state.
    $args = array();
    $args['conditions']['CoPetition.status'] = PetitionStatusEnum::PendingApproval;
    $args['conditions']['CoPetition.deleted'] = false;
    $args['contain'] = false;

    $pendingPetitions = $this->PetitionDocument->CoPetition->find('all', $args);

    $pendingPetitionIds = array();
    foreach ($pendingPetitions as $p) {
      $pendingPetitionIds[] = $p['CoPetition']['id'];

    }

    // Find any petition documents associated with the pending petitions.
    $args = array();
    $args['conditions']['PetitionDocument.co_petition_id'] = $pendingPetitionIds;
    $args['contain']['CoPetition']['EnrolleeCoPerson'] = array('Name', 'EmailAddress');

    $petitionDocuments = $this->PetitionDocument->find('all', $args);

    $this->set("coId", $coId);
    $this->set("petitionDocuments", $petitionDocuments);
  }

  function send_file($id) {

    $args = array();
    $args['conditions']['PetitionDocument.id'] = $id;
    $args['contain'] = false;

    $petitionDocument = $this->PetitionDocument->find('first', $args);
    $path = $petitionDocument['PetitionDocument']['filename'];
    $basename = basename($path);

    $this->autoRender = false;

    $args = array();
    $args['download'] = true;
    $args['name'] = $basename;

    $this->response->file($path, $args);
  }
}
