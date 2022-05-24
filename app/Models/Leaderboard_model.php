<?php


class Leaderboard_model
{
    /**
     * Leaderboard_model constructor
     */
    public function __construct()
    {

    }

    public function set_leaderboard_data($person_list, $period) {
        //fill in the first podium data
        if(isset($person_list[0])) {
            $leaderboard_data['id_first'] = $person_list[0]['id'];
            $leaderboard_data['name_first'] = $person_list[0]['username'];
            $leaderboard_data['points_first'] = $person_list[0][$period];
        }
        if(isset($person_list[1]))
        {
            $leaderboard_data['id_second'] = $person_list[1]['id'];
            $leaderboard_data['name_second'] = $person_list[1]['username'];
            $leaderboard_data['points_second'] = $person_list[1][$period];
        }
        if(isset($person_list[2]))
        {
            $leaderboard_data['id_third'] = $person_list[2]['id'];
            $leaderboard_data['name_third'] = $person_list[2]['username'];
            $leaderboard_data['points_third'] = $person_list[2][$period];
        }
        //fill in all the others places
        $leaderboard_data['persons_list'] = array();

        $worse_then_tenth_flag = 0;
        $current_user = 0;
        for ($i = 3; $i < count((array)$person_list); $i++) {
            array_push($leaderboard_data['persons_list'], array('place'=>($i+1), 'name'=>$person_list[$i]['username'], 'point'=>$person_list[$i][$period], 'id'=>$person_list[$i]['id']));
            if (session()->get('id') == $person_list[$i]['id'] && $i > 9) {
                $worse_then_tenth_flag = 1;
                $current_user = array('place'=>($i+1),'name'=>$person_list[$i]['username'], 'point'=>$person_list[$i][$period], 'id'=>$person_list[$i]['id']);
            }
        }
        if ($worse_then_tenth_flag) {
            $leaderboard_data['user_placeholder'] = '<li class="list-group-item list-group-item-action d-flex justify-content-between bg-secondary">
                                                        <h1>...</h1>
                                                     </li>
                                                     <a class="w-100 active" href="'.base_url().'/otheruserprofile/'.$current_user["id"].'">
                                                         <li class="list-group-item list-group-item-action d-flex justify-content-between bg-secondary">
                                                                <h5 class="mb-0">'.$current_user["place"].'. '.$current_user["name"].'</h5>
                                                                <!--<img src="'.base_url().'/image/profile.png">-->
                                                                <h5 class="mb-0">'.$current_user["point"].'</h5>
                                                         </li>
                                                     </a>';
        }
        else {
            $leaderboard_data['user_placeholder'] = "";
        }
        return $leaderboard_data;
    }
}