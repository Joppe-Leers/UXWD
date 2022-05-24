<?php

class Hub_model
{
    /**
     * Hub_model constructor
     */
    public function __construct()
    {

    }
    function changeLikeStatus ($observationID) {

        $userID = session()->get('id');
        $this->database_model->setUserLikeStatus($userID, $observationID);
        return;
    }

    function sendComment ($comment, $observationID) {

        $userID = session()->get('id');
        $query_result = $this->database_model->insertComment($userID, $comment, $observationID);
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


}