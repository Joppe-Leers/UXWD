<?php


namespace App\Controllers;

use Database_model;
use Menu_model;

class FriendsController extends BaseController
{
    private $menu_model;
    private $database_model;
    private $data;

    use \App\Controllers\extra_functions;

    /**
     * FriendsController constructor.
     */
    public function __construct() {
        $this->menu_model = new Menu_model();
        $this->database_model = new Database_model();
    }

    function acceptFriendRequest($mappingID) {
        $this->database_model->setFriendsMappingStatus($mappingID, 1);
        return "<p>$mappingID</p>";
    }

    function declineFriendRequestOrDelete($mappingID) {
        $this->database_model->deleteFriendsMapping($mappingID);
        return "<p>$mappingID</p>";
    }

    function sendFriendRequest($userID_reciever) {
        if(!$this->database_model->insertFriendsMapping(session()->get('id'), $userID_reciever)) {
            $this->debug_to_console("failed to insert friendsmapping");
        }
        return "<p>$userID_reciever</p>";
    }

    public function friendList() {
        $this->set_common_data('arrow_back', 'profile','search');

        // retrieve all the information needed from the database
        $this->data['requests'] = $this->database_model->getFriendRequestsFromUser(session()->get('id'));
        $friends = $this->database_model->getFriendsFromUser(session()->get('id'));
        foreach ($friends as $f) {
            $f->encoded_image = $this->encode_image($f->p_imagedata, $f->p_imagetype);
        }
        $this->data['friends'] = $friends;

        $this->data['content'] = view('friendList', $this->data);
        $this->data['title'] = lang('app.Friend_List');

        $this->data['menu_items'] = $this->menu_model->get_menuitems('profile');
        $this->data['scripts_to_load'] = array('friendlist.js');
        return view("mainTemplate", $this->data);
    }
}