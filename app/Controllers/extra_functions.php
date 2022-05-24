<?php


namespace App\Controllers;


trait extra_functions
{
    private function set_common_data($header_icon_1, $back_route, $header_icon_2) {
        $this->data['base_url'] = base_url();
        $this->data['header_icon_1'] = $header_icon_1;
        $this->data['header_icon_2'] = $header_icon_2;
        $this->data['back_route'] = $back_route;
    }

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    function fetchObservationLikeHTML ($observationID) {
        $query_result = $this->database_model->getLikeListFromObservation($observationID);

        $like_data['like_list'] = array();
        foreach ($query_result as $like) {
            $image = $this->encode_image($like['imagedata'],$like['imagetype']);

            array_push($like_data['like_list'], array('username'=>$like['username'],'pic'=>$image));
        }
        return view('observationLikeList', $like_data);
    }

    function fetchObservationCommentHTML ($observationID) {
        $query_result = $this->database_model->getCommentListFromObservation($observationID);
        $comment_data['comment_list'] = array();
        foreach ($query_result as $comment) {
            array_push($comment_data['comment_list'], array('username'=>$comment['username'], 'message'=>$comment['message']));
        }
        return view('observationCommentList', $comment_data);
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

    public function deleteUserFromGroup($memberID, $groupID, $groupName) {
        $this->database_model->deleteUserFromGroup($memberID, $groupID);
        return redirect()->to(base_url().'/groupmembers/'.$groupName);
    }

    public function addFriendToGroup($friendName, $groupName) {
        $userID = $this->database_model->getUserID($friendName);
        $groupID = $this->database_model->getGroupID($groupName);
        $this->database_model->addFriendToGroup($userID->id, $groupID->id);
        return;
    }

    private function passwordHash($password){
        return password_hash($password,PASSWORD_BCRYPT);
    }



    public function encode_image($file, $mime)
    {
        $base64   = base64_encode($file);
        return ('data:' . $mime . ';base64,' . $base64);
    }
}