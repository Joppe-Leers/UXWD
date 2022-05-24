<?php

class Profile_model
{
    /**
     * Profile_model constructor
     */
    public function __construct()
    {

    }
    function changeLikeStatus ($observationID) {

        $userID = session()->get('id');
        $query_result = $this->database_model->setUserLikeStatus($userID, $observationID);
        return;
    }

    function sendComment ($comment, $observationID) {

        $userID = session()->get('id');
        $query_result = $this->database_model->insertComment($userID, $comment, $observationID);//insertComment ($userID, $message, $observationID)
        return;
    }

    function cancelLikeStatus ($observationID) {
        $userID = session()->get('id');
        $this->database_model->cancelUserLikeStatus($userID, $observationID);
        return;
    }

    function getUsername () {
        return session()->get('username');
    }

    function checkUserLikeStatus ($observationID) {
        $userID = session()->get('id');
        $status = $this->database_model->checkUserLikeStatus($userID, $observationID);
        return $status;
    }

    function sendFriendRequest($userID_reciever) {
        if(!$this->database_model->insertFriendsMapping(session()->get('id'), $userID_reciever)) {
            $this->debug_to_console("failed to insert friendsmapping");
        }
        return "<p>$userID_reciever</p>";
    }

    function acceptFriendRequest($mappingID) {
        $this->database_model->setFriendsMappingStatus($mappingID, 1);
        return "<p>$mappingID</p>";
    }

    function declineFriendRequestOrDelete($mappingID) {
        $this->database_model->deleteFriendsMapping($mappingID);
        return "<p>$mappingID</p>";
    }
}