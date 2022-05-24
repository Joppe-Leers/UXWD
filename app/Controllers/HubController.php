<?php
namespace App\Controllers;

use Database_model;
use Menu_model;
use Hub_model;
class HubController extends BaseController
{
    private $menu_model;
    private $database_model;
    private $hub_model;
    private $data;

    use \App\Controllers\extra_functions;

    public function __construct() {
        $this->hub_model = new Hub_model();
        $this->menu_model = new Menu_model();
        $this->database_model = new Database_model();
    }

    public function hub() {

        $this->set_common_data('eco',null, 'search');
        helper(['form']);
        $index = 1;
        //get current user
        $userID = session()->get('id');
        $thisUserID['thisUserID'] = session()->get('id');
        //get friends of current user
        $friendsArray = $this->database_model->getFriendsUserName($userID);

        //check if the url contains parameter for new observations
        $variableActive = $this->request->getVar('extra');
        if ($variableActive != null) {
            $getMoreObservations = $_GET['extra'];
            $lastDate = $_GET['lastDate'];
            $lastTime = $_GET['lastTime'];
            #$tomorrow = $_GET['tomorrow'];

            if (strcasecmp($getMoreObservations, 'true') == 0) {
                //get more observations from friends from current users
                $observations = $this->database_model->getMoreObservationsForHub($friendsArray, $lastDate, $lastTime);
                $data3['observations'] = $observations;
                if ($observations == null) {
                    $data3['upToDate'] = "";
                    return view('observationCards', $data3, $thisUserID);
                }
                if ($observations[0] == null) {
                    $data3['upToDate'] = "";
                    return view('observationCards', $data3, $thisUserID);
                }
                else {
                    $data3['upToDate'] = "";
                    foreach ($observations as $observation) {
                        $encoded_image = $this->encode_image($observation->imageData, $observation->imageType);
                        $observation->encoded_image = $encoded_image;
                    }
                    $data3['observations'] = $observations;
                    $this->data['content'] = view('hubPage', $data3, $thisUserID);
                    return view('observationCards', $data3, $thisUserID);
                }
            }
        }

        //get observations from friends from current users
        $observations = $this->database_model->getFirstObservationsForHub($friendsArray);
        $data2['observations'] = $observations;
        if ($observations == null) {
            $data2['upToDate'] = "You are up to date! Check your groups or search friends to see their observations";
            $this->data['content'] = view('hubPage', $data2, $thisUserID); //replace by your own view
        }
        else {
            $data2['upToDate'] = "";
            foreach ($observations as $observation) {
                $encoded_image = $this->encode_image($observation->imageData, $observation->imageType);
                $observation->encoded_image = $encoded_image;
            }
            $data2['observations'] = $observations;
            $this->data['content'] = view('hubPage', $data2, $thisUserID);
        }

        $this->data['title'] = lang('app.Observation_Feed');

        $this->data['menu_items'] = $this->menu_model->get_menuitems('hub');
        $this->data['scripts_to_load'] = array('jquery-3.5.1.min.js', 'showMoreObservations.js', 'likeFunction.js', 'loading.js');
        $this->data['scripts_to_load_from_net'] = array('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js');

        session()->set('lastMainPageLink', 'hub');
        return view("mainTemplate", $this->data);
    }
}
