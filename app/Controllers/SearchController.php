<?php


namespace App\Controllers;

use Database_model;
use Menu_model;

class SearchController extends BaseController
{
    private $menu_model;
    private $database_model;
    private $data;

    use extra_functions;

    /**
     * SearchController constructor.
     */
    public function __construct() {
        $this->menu_model = new Menu_model();
        $this->database_model = new Database_model();
    }

    public function searchGetObservations($filter) {
        $observations = $this->database_model->getObservationDescription($filter);
        foreach ($observations as $o) {
            $o->encoded_image = $this->encode_image($o->imageData, $o->imageType);
        }
        $result['ob'] = $observations;
        if($result['ob'] != null) {
            return view('searchObservation', $result);
        }
        return "<h5>".lang('app.Observations').":</h5>
                <p>".lang('app.No_observations_found')."</p>";
    }

    public function searchGetGroups($filter) {
        $result['group'] = $this->database_model->getGroup($filter);
        if($result['group'] != null) {
            return view('searchGroup', $result);
        }
        return '<h5>'.lang('app.Groups').':</h5>
                <p>'.lang('app.No_groups_found').'</p>';
    }

    public function searchGetUsers($filter) {
        $filter = str_replace("SPACE", " ", $filter);
        $users = $this->database_model->getUsersSearch($filter);
        foreach ($users as $u) {
            $u->encoded_image = $this->encode_image($u->p_imagedata, $u->p_imagetype);
        }
        $result['user'] = $users;
        if($result['user'] != null) {
            return view('searchUser', $result);
        }
        return "<h5>".lang('app.Users').":</h5>
                <p>".lang('app.No_users_found')."</p>";
    }

    public function search() {
        $this->set_common_data('arrow_back', session()->get('lastMainPageLink'),'search');

        $search_data['placeholder'] = lang('app.Start_typing_in_the_search_bar');
        $this->data['content'] = view('search',$search_data);
        $this->data['title'] = lang('app.Search');

        $this->data['menu_items'] = $this->menu_model->get_menuitems(session()->get('lastMainPageLink'));
        $this->data['scripts_to_load'] = array('search.js');
        $this->data['scripts_to_load_from_net'] = array('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js');
        return view("mainTemplate", $this->data);
    }

}