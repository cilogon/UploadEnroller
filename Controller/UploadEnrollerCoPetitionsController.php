<?

App::uses('CoPetitionsController', 'Controller');
App::uses('PetitionDocument', 'UploadEnroller.Model');
 
class UploadEnrollerCoPetitionsController extends CoPetitionsController {
  // Class name, used by Cake
  public $name = "UploadEnrollerCoPetitions";
  public $uses = array("CoPetition");
   
  /**
   * Plugin functionality following petitionerAttributes step
   *
   * @param Integer $id CO Petition ID
   * @param Array $onFinish URL, in Cake format
   */
   
  protected function execute_plugin_petitionerAttributes($id, $onFinish) {
    // Use the petition id to find the petition
    $args = array();
    $args['conditions']['CoPetition.id'] = $id;
    $args['contain']                     = false;

    $coPetition = $this->CoPetition->find('first', $args);
    if (empty($coPetition)) {
      $this->log("ERROR: could not find petition with id $id. Displaying error to user and ending flow.");
      $this->Flash->set(_txt('er.uploadenroller.copetition.id.none', array($id)), array('key' => 'error'));
      $this->redirect("/");
      return;
    }

    // Set the CoPetition ID to use as a hidden form element.
    $this->set('co_petition_id', $id);

    // Save the onFinish URL to which we must redirect after receiving
    // the incoming POST data.
    if(!$this->Session->check('plugin.upload_enroller.onFinish')) {
      $this->Session->write('plugin.upload_enroller.onFinish', $onFinish);
    }

    // POST so process the uploaded document. 
    if($this->request->is('post')) {

      if(!empty($this->request->data['PetitionDocument']['documentFile']['tmp_name'])) {
        $baseDirectory = Configure::read('UploadEnroller.directory');
        $directory = $baseDirectory . "/" . $id;
        
        if(!mkdir($directory, 0755)) {
          $this->log("Failed to create directory $directory");
          $this->redirect($onFinish);
        }

        // TODO Need to sanitize the upload filename most likely.
        $dest = $directory . "/" . $this->request->data['PetitionDocument']['documentFile']['name'];
        $source = $this->request->data['PetitionDocument']['documentFile']['tmp_name'];

        if(!move_uploaded_file($source, $dest)) {
          $this->log("Failed to copy uploaded petition document from $source to $dest");
          $this->redirect($onFinish);
        }

        $petitionDocument = new PetitionDocument();
        $petitionDocument->clear();

        $data = array();
        $data['PetitionDocument'] = array();
        $data['PetitionDocument']['co_petition_id'] = $id;
        $data['PetitionDocument']['filename'] = $dest;

        if(!$petitionDocument->save($data)) {
          $this->log("Failed to record uploaded document for petition $id with filename $dest");
          $this->redirect($onFinish);
        }
      }

      $onFinish = $this->Session->consume('plugin.upload_enroller.onFinish');

      $this->redirect($onFinish);
    }

    // GET so fall through to display view for document upload.
    $this->set("title_for_layout", _txt('pl.uploadenroller.upload.title'));
 
  }
}
