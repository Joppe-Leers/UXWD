<?php /** @noinspection PhpUnused */


namespace App\Controllers;


use Database_model;
use AddObservations_model;
use Menu_model;

class AddObservationsController extends BaseController
{
    private $menu_model;
    private $database_model;
    private $addObservations_model;
    private $data;

    use extra_functions;

    /**
     * LeaderboardController constructor.
     */
    public function __construct()
    {
        $this->addObservations_model = new AddObservations_model();
        $this->menu_model = new Menu_model();
        $this->database_model = new Database_model();
    }


    public function getUserID() {
        return session()->get('id');
    }


    public function addObservation() {
        $this->set_common_data('eco', null,'search');
        session()->set('lastMainPageLink', 'addObservation');
        //get current user
        $userID = $this->getUserID();

        helper(['form']);

        if ($this->request->getMethod() === 'post'&& $this->validate([
                'description'  => 'required|min_length[3]',
                'date'=>'required|min_length[6]|max_length[50]',
                'time'=>'required|min_length[4]|max_length[50]']))
        {

            $uploadedPicture = $this->request->getFile('picture');
            $imageProperties = $uploadedPicture->getMimeType();
            $im = imagecreatefromjpeg($uploadedPicture);
            ob_start();                      // Start output buffering
            imagejpeg($im,NULL,25);   // Generate JPEG into buffer
            $compressedImage=ob_get_contents();         // Load output buffer into $blob var
            ob_end_clean();                  // Clean up buffer

            $scientificName = $this->request->getPost('scientificName');
            $specieName = $this->request->getPost('specieName');
            $description = $this->request->getPost('description');
            $specieId = $this->addObservations_model->getSpecieId($specieName, $scientificName, $description);
            $location = $this->request->getPost('location');
            $date = $this->request->getPost('date');
            $time = $this->request->getPost('time');
            $userNote = $this->request->getPost('userNote');

            $this->database_model->insertObservation($compressedImage, $imageProperties, $description,$location, $date, $time, $specieId[0]->id, $userID, $userNote);
            return redirect()->to('hub');
        }

        $this->data['content'] = view('addobservation'); //replace by your own view
        $this->data['title'] = lang('app.Add_Observation');
        $this->data['menu_items'] = $this->menu_model->get_menuitems('addObservation');
        $this->data['scripts_to_load'] = array('jquery-3.5.1.min.js', 'plantAPI.js','previewPicture.js', 'loading.js');
        return view("mainTemplate", $this->data);
    }

    public function addObservationWithoutLogin() {
        $this->set_common_data('eco', null,'search');
        helper(['form']);
        $this->data['content'] = view('addObservationWithoutLogin'); //replace by your own view
        $this->data['title'] = lang('app.Add_Observation');
        $this->data['menu_items'] = $this->menu_model->get_menuitems('addObservation');
        $this->data['scripts_to_load'] = array('jquery-3.5.1.min.js', 'plantAPI.js','previewPicture.js', 'loading.js');
        return view("extraTemplate", $this->data);
    }

}