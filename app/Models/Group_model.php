<?php


class Group_model
{

    private $database_model;

    /**
     * AddObservations_model constructor
     */
    public function __construct()
    {
        $this->database_model = new Database_model();
    }

    public function getGroupsFromUser($userID) {
        $groups = $this->database_model->getGroupsFromUser($userID);
        $data['groups']=array();
        foreach ($groups as $group)
        {
            $groupname=$group->name;
            $groupId = $this->getGroupId($groupname, $userID);
            $groupdescription=$group->description;
            $groupmember=$this->database_model->getGroupMemberNumber($group->id)->count;
            $groupadmin=$group->admin;
            $grouparray=array($groupname,$groupdescription,$groupmember,$groupadmin,$groupId);
            array_push($data['groups'],$grouparray);
        }
        return $data['groups'];
    }

    public function getGroupMembersArray($groupname_filter, $userID) {
        //get the groupid by the groupname and userid
        $groupid = $this->getGroupId($groupname_filter, $userID);
        //get an array of userid of this group
        $query_result = $this->getGroupMembers($groupid);
        //get an array of user name of this group
        $groupmembers = array();
        foreach ($query_result as $row) {
            array_push($groupmembers, $this->database_model->getUser($row->userID));
        }
        return $groupmembers;
    }

    public function getGroupMembers($groupId) {
        return $this->database_model->getUsersFromGroup($groupId);
    }

    public function getGroupId($groupname_filter, $userID) {
        return $this->database_model->getGroupName($groupname_filter, $userID)->groupID;
    }

    public function getFriendsToAdd($groupID) {
        return $this->database_model->getFriendsToAdd(session()->get('id'), $groupID);
    }

}