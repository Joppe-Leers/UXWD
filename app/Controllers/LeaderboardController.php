<?php /** @noinspection PhpUnused */


namespace App\Controllers;


use Database_model;
use Leaderboard_model;
use Menu_model;

class LeaderboardController extends BaseController
{
    private $menu_model;
    private $database_model;
    private $leaderboard_model;
    private $data;

    use extra_functions;

    /**
     * LeaderboardController constructor.
     */
    public function __construct() {
        $this->leaderboard_model = new Leaderboard_model();
        $this->menu_model = new Menu_model();
        $this->database_model = new Database_model();
    }

    public function fetchFriendsLeaderboard($period) {
        $query_result = $this->database_model->getFriendLeaderboard($period, session()->get('id'));
        return view('fetchLeaderboardHTML', $this->leaderboard_model->set_leaderboard_data($query_result, $period));
    }

    public function fetchWorldwideLeaderboard($period) {
        $query_result = $this->database_model->getLeaderboardWorldwide($period);
        return view('fetchLeaderboardHTML', $this->leaderboard_model->set_leaderboard_data($query_result, $period));
    }

    public function fetchGroupLeaderboard($group, $period) {
        $query_result = $this->database_model->getLeaderboardFromGroup($group, $period);
        return view('fetchLeaderboardHTML', $this->leaderboard_model->set_leaderboard_data($query_result, $period));
    }

    public function leaderboardSelect() {
        $this->cachePage(10);
        $this->set_common_data('eco', null,'search');
        $groups = $this->database_model->getGroupsFromUser(session()->get('id'));
        $this->data['groups']=array();
        foreach ($groups as $group)
        {
            $groupname=$group->name;
            array_push($this->data['groups'],$groupname);
        }
        $this->data['menu_items'] = $this->menu_model->get_menuitems('leaderboardSelect');
        $this->data['content'] = view('leaderboardSelect', $this->data);
        $this->data['title'] =  lang('app.Leaderboard');
        $this->data['scripts_to_load'] = array('jquery-3.5.1.min.js', 'loading.js');
        session()->set('lastMainPageLink', 'leaderboardSelect');
        return view("mainTemplate", $this->data);
    }

    public function leaderboard($filter) {
        $this->cachePage(10);
        $this->set_common_data('arrow_back', 'leaderboardSelect','search');

        $leaderboard_data['leaderboard_filter'] = $filter;
        // initially the monthly leaderboard is loaded
        switch ($filter) {
            case "friends":
                $leaderboard_data['leaderboard_content'] = $this->fetchFriendsLeaderboard('monthlyPoints');
                break;
            case "worldwide":
                $leaderboard_data['leaderboard_content'] = $this->fetchWorldwideLeaderboard('monthlyPoints');
                break;
            default:
                $leaderboard_data['leaderboard_content'] = $this->fetchGroupLeaderboard($filter, 'monthlyPoints');
        }

        $this->data['content'] = view('leaderboard', $leaderboard_data);
        $this->data['title'] = lang('app.Leaderboard');
        $this->data['menu_items'] = $this->menu_model->get_menuitems('leaderboardSelect');
        $this->data['scripts_to_load'] = array('leaderboard.js', 'jquery-3.5.1.min.js', 'loading.js');

        return view("mainTemplate", $this->data);
    }

}