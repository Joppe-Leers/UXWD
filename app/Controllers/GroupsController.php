<?php /** @noinspection PhpUnused */


namespace App\Controllers;


use Database_model;
use Group_model;
use Menu_model;

class GroupsController extends BaseController
{
    private $menu_model;
    private $database_model;
    private $group_model;
    private $data;

    use extra_functions;

    /**
     * LeaderboardController constructor.
     */
    public function __construct()
    {
        $this->group_model = new Group_model();
        $this->menu_model = new Menu_model();
        $this->database_model = new Database_model();
    }

    public function getUserID() {
        return session()->get('id');
    }

    public function groups() {
        $this->set_common_data('eco', null,'search');

        $userID = $this->getUserID();
        $this->data['groups'] = $this->group_model->getGroupsFromUser($userID);

        $this->data['menu_items'] = $this->menu_model->get_menuitems('groups');
        $this->data['content'] = view('groupsOverviewPage', $this->data); //replace by your own view
        $this->data['title'] = lang('app.Groups');
        $this->data['scripts_to_load'] = array('jquery-3.5.1.min.js', 'loading.js');
        session()->set('lastMainPageLink', 'groups');
        return view("mainTemplate", $this->data);
    }

    public function group($groupname_filter)
    {
        $this->set_common_data('arrow_back', 'groups','search');
        $userID = $this->getUserID();
        $thisUserID['thisUserID'] = $this->getUserID();
        $groupmembers = $this->group_model->getGroupMembersArray($groupname_filter, $userID);

        helper(['form']);
        $index = 1;
        $variableActive = $this->request->getVar('extra');
        if ($variableActive != null) {
            $getMoreObservations = $_GET['extra'];
            $lastDate = $_GET['lastDate'];
            $lastTime = $_GET['lastTime'];
            #$tomorrow = $_GET['tomorrow'];
            if (strcasecmp($getMoreObservations, 'true') == 0) {
                //get more observations from friends from current users
                $observations = $this->database_model->getMoreObservationsForHub($groupmembers, $lastDate, $lastTime);
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

        $observations = $this->database_model->getFirstObservationsForHub($groupmembers);

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
            $this->data['content'] = view('hubPage', $data2, $thisUserID); //load the hub page with data from group members
        }

        //check if submit comment
        if ($this->request->getMethod() === 'post')
        {
            $message= $this->request->getPost('message');
            $observationID = $this->request->getPost('obID');
            $this->database_model-> insertComment($userID,$message,$observationID);
            return redirect()->to($groupname_filter);
        }
        //comment function end

        $this->data['scripts_to_load'] = array('jquery-3.5.1.min.js','showMoreObservations.js', 'likeFunction.js', 'loading.js');
        $this->data['content'] = view('hubPage', $data2);
        $this->data['title'] = $groupname_filter;
        $this->data['menu_items'] = $this->menu_model->get_menuitems('groups');
        return view("mainTemplate", $this->data);
    }

    public function newgroup(){
        $this->data=[];
        $this->set_common_data('eco', null,'eco');
        helper(['form']);
        if ($this->request->getMethod() === 'post' && $this->validate([
                'groupname' => 'required|min_length[3]|max_length[50]|alpha_dash',
                'groupdescription'  => 'required|min_length[3]|max_length[255]'
            ]))
        {
            $groupname= $this->request->getPost('groupname');
            $groupdescription= $this->request->getPost('groupdescription');
            $this->database_model-> insertGroup($groupname,$groupdescription);

            session()->setFlashdata('success','Create a new group Successfulfly!');
            return redirect()->to('groups');
        }
        else
        {
            $this->data['content'] = view('newgroup'); //replace by your own view
            $this->data['title'] = lang('app.New_Group');
            $this->data['menu_items'] = $this->menu_model->get_menuitems('groups');
            return view("mainTemplate", $this->data);
        }
    }

    public function groupmembers($groupname_filter) {
        $this->set_common_data('arrow_back', 'groups','search');

        $userID = $this->getUserID();
        //get the groupid by the groupname and userid
        $groupid = $this->group_model->getGroupId($groupname_filter, $userID);
        $data['groupmembers']=$this->group_model->getGroupMembers($groupid);
        $data['groupID'] = $groupid;
        $data['groupName'] = $groupname_filter;
        $this->data['content'] = view('groupmembers',$data); //replace by your own view
        $this->data['title'] = lang('app.Group_Members');

        $this->data['menu_items'] = $this->menu_model->get_menuitems('groups');
        return view("mainTemplate", $this->data);
    }

    // show a list of friends that can be added to the group
    public function addGroupMembers($groupID, $groupName) {
        $this->set_common_data('arrow_back', 'groupmembers/'.$groupName,'search');

        // retrieve all the information needed from the database
        $this->data['friends'] = $this->group_model->getFriendsToAdd($groupID);
        $this->data['groupName'] = $groupName;

        $this->data['content'] = view('addGroupMembers', $this->data);
        $this->data['title'] = lang('app.Friend_List');

        $this->data['menu_items'] = $this->menu_model->get_menuitems('groups');
        $this->data['scripts_to_load'] = array('jquery-3.5.1.min.js', 'addFriendToGroup.js');
        return view("mainTemplate", $this->data);
    }


}