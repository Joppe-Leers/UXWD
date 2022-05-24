<?php

class anobservation_model
{
    /**
     * anobservation_model constructor
     */
    public function __construct()
    {

    }
    function fetchObservationLikeHTML ($observationID) {
        $query_result = $this->database_model->getLikeListFromObservation($observationID);

        $like_data['like_list'] = array();
        $query = array();
        foreach ($query_result as $like) {
            $image = $this->encode_image($like['imagedata'],$like['imagetype']);

            array_push($like_data['like_list'], array('username'=>$like['username'],'pic'=>$image));
        }
        foreach ($query as $user) {
            $image = $this->database_model->getUserProfilePicture($user);
            $test= $this->encode_image('imagedata', 'imagetype');
            array_push($like_data['pic_list'], array($test=>$pic['profile_picture']));
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
}