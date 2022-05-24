<?php


class Database_model
{
    private $db;

    /**
     * database_model constructor
     */
    use \App\Controllers\extra_functions;
    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    /**
     * I was not sure what kind of functions you guys need because most of it depends on the implementation of your part.
     * But here is a list of functions you can use to get/add information information in the database.
     * If you want to add more you can find information on this webpage https://codeigniter.com/user_guide/database/examples.html#
     */


    /**
     * @param $username
     * @param $password
     * @param $email
     * @return int = 0 if query failed, 1 if query executed successfully.
     */
    public function insertUser ($username, $password, $email,$originpassword) {
        // check if user already exists or not
        //TODO: change the condition to check if it exists or not
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.user WHERE username="'.$username.'") AS result;');
        if ($query->getRow()->result) {
            return 0;
        }
        $data = ['username'=> $username,
                 'password' => $password,
                 'email' => $email,
                'origin_password' => $originpassword
        ];
        $this->db->table('user')->insert($data);
        return 1;
    }


    /**
     * @param $name
     * @param $points
     * @return int = 0 if query failed, 1 if query executed successfully.
     */
    public function insertSpecie ($name, $scienticificName, $points, $description) {
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.specie WHERE specieName="'.$name.'") AS result;');
        if ($query->getRow()->result) {
            return 0;
        }
        $data = ['specieName'=> $name, 'scientificName' => $scienticificName ,'points' => $points,'specieDescription' => $description];
        $this->db->table('specie')->insert($data);
        return 1;
    }


    /**
     * @param $name
     * @param $description
     * @return int = 0 if query failed, 1 if query executed successfully.
     */
    public function insertGroup ($name, $description) {
        $userid=session()->get('id');
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.userGroup WHERE name="'.$name.'" AND admin = "'.$userid.'" ) AS result;');
        if ($query->getRow()->result) {
            return 0;
        }
        $data = ['name'=> $name, 'description' => $description,'admin'=>$userid];
        $this->db->table('userGroup')->insert($data);
        $newgroupid=$this->db->query('SELECT * FROM a20ux6.userGroup WHERE name="'.$name.'" AND admin = "'.$userid.'" ;')->getRow()->id;
        $data2 = ['groupID'=>$newgroupid,'userID'=>$userid];
        $this->db->table('userGroupMapping')->insert($data2);
        return 1;
    }


    /**
     * @param $imageData
     * @param $imageProperties
     * @param $description
     * @param $location
     * @param $date
     * @param $time
     * @param $specieID
     * @param $userID
     * @param $userNote
     * @return int = 0 if query failed, 1 if query executed successfully.
     */
    public function insertObservation($imageData, $imageProperties,$description, $location, $date, $time , $specieID, $userID, $userNote) {
        //check if specie exists
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.specie WHERE id="'.$specieID.'") AS result;');
        if (!$query->getRow()->result) {
            return 0;
        }
        //check if user exists
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.user WHERE id="'.$userID.'") AS result;');
        if (!$query->getRow()->result) {
            return 0;
        }
        $data = [
            'imageData' => $imageData,
            'imageType' => $imageProperties,
            'description'=>$description,
            'location' => $location,
            'date' => $date,
            'time' => $time,
            'specieID' => $specieID,
            'userID' => $userID,
            'userNote' => $userNote
        ];
        $this->db->table('observation')->insert($data);
        return 1;
    }

    /**
     * @param $userID_A = is this the best option?
     * @param $userID_B = is this the best option?
     * @return int = 0 if query failed, 1 if query executed successfully.
     */
    public function insertFriendsMapping($userID_A, $userID_B) {
        if ($userID_A == $userID_B) return 0;
        // check if both users exist
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.user WHERE id="'.$userID_A.'") AS result;');
        if (!$query->getRow()->result) return 0;
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.user WHERE id="'.$userID_B.'") AS result;');
        if (!$query->getRow()->result) return 0;
        //check if friend mapping already exists (query takes care of both directions)
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.friendsMapping 
                                                     WHERE (userID_A="'.$userID_A.'" AND userID_B="'.$userID_B.'" AND requestStatus = "0") OR (userID_A="'.$userID_B.'" AND userID_B="'.$userID_A.'" AND requestStatus = "0")) 
                                                     AS result;');
        if ($query->getRow()->result) return 0;

        $data = ['userID_A'=> $userID_A, 'userID_B' => $userID_B];
        $this->db->table('friendsMapping')->insert($data);
        return 1;
    }

    /**
     * @param $userGroupID = is this the best option?
     * @param $observationID = is this the best option?
     * @return int = 0 if query failed, 1 if query executed successfully.
     */
    public function insertGroupObservationMapping($userGroupID, $observationID) {
        // check if both entities exist
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.userGroup WHERE id="'.$userGroupID.'") AS result;');
        if (!$query->getRow()->result) return 0;
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.observation WHERE id="'.$observationID.'") AS result;');
        if (!$query->getRow()->result) return 0;
        //check if mapping already exists
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.groupObservationMapping 
                                                     WHERE userGroupID="'.$userGroupID.'" AND observationID="'.$observationID.'") 
                                                     AS result;');
        if ($query->getRow()->result) return 0;

        $data = ['userGroupID'=> $userGroupID, 'observationID' => $observationID];
        $this->db->table('groupObservationMapping')->insert($data);
        return 1;
    }

    /**
     * @param $userID = is this the best option?
     * @param $groupID = is  this the best option?
     * @return int = 0 if query failed, 1 if query executed successfully.
     */
    public function insertUserGroupMapping($userID, $groupID) {
        // check if both entities exist
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.userGroup WHERE id="'.$groupID.'") AS result;');
        if (!$query->getRow()->result) return 0;
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.user WHERE id="'.$userID.'") AS result;');
        if (!$query->getRow()->result) return 0;
        //check if mapping already exists
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.userGroupMapping
                                                     WHERE userID="'.$userID.'" AND groupID="'.$groupID.'") 
                                                     AS result;');
        if ($query->getRow()->result) return 0;

        $data = ['userID'=> $userID, 'groupID' => $groupID];
        $this->db->table('userGroupMapping')->insert($data);
        return 1;
    }

    /**
     * @param $userID
     * @return array|array[]|object[]
     */
    public function getUser($userID) {
        $query = $this->db->query('SELECT * FROM a20ux6.user WHERE id = "'.$userID.'";');
        return $query->getRow();
    }

    public function getUsersSearch($userName) {
        $query = $this->db->query('SELECT * FROM a20ux6.user WHERE username LIKE "%'.$userName.'%";');
        return $query->getResult();
    }

    /**
     * @param $email input
     * @return array|array[]|object[]
     */
    public function getUserByEmail($email) {
        $query = $this->db->query('SELECT * FROM a20ux6.user WHERE email = "'.$email.'"  LIMIT 1 ;');
        return $query->getRow();
    }

    /**
     * @param $userName
     * @return array|array[]|object[]
     */
    public function getUserID($userName) {
        $query = $this->db->query('SELECT user.id FROM a20ux6.user WHERE username = "'.$userName.'";');
        return $query->getRow();
    }

    /**
     * @param $userID
     * @return array|array[]|object[]
     */
    public function getGroupsFromUser($userID) {
        $query = $this->db->query('SELECT g.id as id, name, description,g.admin
                                        FROM a20ux6.userGroup as g
                                        INNER JOIN a20ux6.userGroupMapping as m on g.id = m.groupID
                                        WHERE m.userID = "'.$userID.'";');
        return $query->getResult();
    }

    /**
     * @param $groupid
     * @return array|array[]|object[]
     */
    public function getGroupMemberNumber($groupid) {
        $query = $this->db->query('SELECT COUNT(*) AS count 
                                        FROM a20ux6.userGroupMapping 
                                        WHERE groupID="'.$groupid.'";');
        return $query->getRow();
    }

    /**
     * @param $groupName
     * @return array|array[]|object[]
     */
    public function getGroupID($groupName) {
        $query = $this->db->query('SELECT id
                                        FROM a20ux6.userGroup
                                        WHERE userGroup.name="'.$groupName.'";');
        return $query->getRow();
    }

    /**
     * @param $groupname_filter, $userID
     * @return array|array[]|object[]
     * This function return te group id by group name and the current user id
     */
    public function getGroupName($groupname_filter, $userID){
        $query = $this->db->query('SELECT m.groupID,m.userID,g.name,g.description,g.admin 
                                        FROM a20ux6.userGroup as g 
                                        INNER JOIN a20ux6.userGroupMapping as m
                                        ON g.id=m.groupID 
                                        WHERE g.name = "'.$groupname_filter.'" AND userID = "'.$userID.'";');
        return $query->getRow();
    }

    /**
     * @param $groupid
     * @return array|array[]|object[]
     * This function return all the user information of a group
     */
    public function getUsersFromGroup($groupid) {
        $query = $this->db->query('SELECT * FROM a20ux6.userGroupMapping AS t1 INNER JOIN a20ux6.user AS t2 ON t1.userID = t2.id
                                        where groupID = "'.$groupid.'" 
                                        ORDER BY username;');
        return $query->getResult();
    }

    public function getGroup($Search) {
        $query = $this->db->query('SELECT * FROM a20ux6.userGroup WHERE name LIKE "%'.$Search.'%";');
        return $query->getResult();
    }

    /**
     * @param $userID
     * @param $groupID
     * @return array|array[]|object[]
     * This function deletes a user from a group
     */
    public function deleteUserFromGroup($userID, $groupID) {
        $query = $this->db->query('DELETE FROM a20ux6.userGroupMapping WHERE (userID = "'.$userID.'" AND groupID = "'.$groupID.'");');
        return $query->getResult();
    }

    /**
     * @param $userID
     * @param $groupID
     * @return array|array[]|object[]
     * This function returns all the friends of the user that are not yet in the current group, so he can choose to add a friend
     */
    public function getFriendsToAdd($userID, $groupID) {
        $query = $this->db->query('SELECT * FROM (SELECT u.id, username
                                        FROM a20ux6.friendsMapping as m , a20ux6.user as u
                                        WHERE CASE WHEN m.userID_A = "'.$userID.'" THEN m.userID_B = u.id
			                                        WHEN m.userID_B = "'.$userID.'" THEN m.userID_A = u.id
		                                        END) AS friends WHERE friends.id NOT IN (SELECT userID 
                                                FROM a20ux6.userGroupMapping WHERE groupID = "'.$groupID.'");');
        return $query->getResult();
    }

    /**
     * @param $userID
     * @param $groupID
     * @return int = 0 if query failed, 1 if query executed successfully.
     * This function adds a user to a group
     */
    public function addFriendToGroup($userID, $groupID) {
        $data = ['userID'=> $userID,
            'groupID' => $groupID
        ];
        $this->db->table('userGroupMapping')->insert($data);
        return 1;
    }


    /**
     * @param $userID
     * @return array|array[]|object[]
     */
    public function getFriendsFromUser($userID) {
        $query = $this->db->query('SELECT u.id, username, email, points, weeklyPoints, monthlyPoints,p_imagedata,p_imagetype, m.id AS mappingID
                                        FROM a20ux6.friendsMapping as m , a20ux6.user as u
                                        WHERE CASE WHEN m.userID_A = "'.$userID.'" THEN m.userID_B = u.id
			                                        WHEN m.userID_B = "'.$userID.'" THEN m.userID_A = u.id
		                                        END
		                                        AND m.requestStatus = 1
		                                        ORDER BY username;');
        return $query->getResult();
    }

    /**
     * @param $userID
     * @return array|array[]|object[]
     */
    public function getFriendRequestsFromUser($userID) {
        $query = $this->db->query('SELECT u.id AS userID, username, m.id AS mappingID
                                        FROM a20ux6.friendsMapping AS m
                                        INNER JOIN a20ux6.user AS u ON m.userID_A= u.id
                                        WHERE requestStatus = 0 AND m.userID_B = "'.$userID.'";');
        return $query->getResult();
    }

    /**
     * @param $userID_A
     * @param $userID_B
     * @return mixed
     */
    public function getFriendrequestStatus($userID_A, $userID_B) {
        $query = $this->db->query('SELECT m.requestStatus AS status
                                        FROM a20ux6.friendsMapping AS m
                                        WHERE (m.userID_A = "'.$userID_A.'" AND m.userID_B = "'.$userID_B.'") OR (m.userID_A="'.$userID_B.'" AND m.userID_B = "'.$userID_A.'");');
        $result = $query->getRowArray();
        if (is_null($result)){
            return 3;
        }
        return $query->getRowArray()['status'];
    }



    /**
     * @param $userID
     * @return array|array[]|object[]
     */
    public function getUserFriendCount($userID) {
        $query = $this->db->query('SELECT count(m.id) as friendCount
                                        FROM a20ux6.friendsMapping as m , a20ux6.user as u
                                        WHERE CASE WHEN m.userID_A = "'.$userID.'" THEN m.userID_B = u.id
			                                        WHEN m.userID_B = "'.$userID.'" THEN m.userID_A = u.id
		                                        END;');
        return $query->getResult();
    }
    /**
     * @param $userID
     * @return array|array[]|object[]
     */
    public function getUserpoint($userID) {
        $query = $this->db->query('SELECT u.points as pointCount
                                        FROM a20ux6.user as u where u.id = "'.$userID.'"');
        return $query->getResult();
    }

    /**
     * @param $userID
     * @return array|array[]|object[]
     */
    public function getUserDescription($userID) {
        $query = $this->db->query('SELECT u.p_description as description
                                        FROM a20ux6.user as u where u.id = "'.$userID.'"');
        return $query->getResult();
    }

    /**
     * @param $userID
     * @return array|array[]|object[]
     */
    public function getUserProfilePicture($userID) {
        $query = $this->db->query('SELECT u.p_imagetype as imagetype, u.p_imagedata as imagedata
                                        FROM a20ux6.user as u where u.id = "'.$userID.'"');
        return $query->getResult();
    }



    /**
     * @param $userID
     * @return array|array[]|object[]
     */
    public function getTrophysFromUser($userID) {
        $query = $this->db->query('SELECT name, description
                                        FROM a20ux6.trophy as t
                                        INNER JOIN a20ux6.userTrophyMapping as m on t.id = m.trophyID
                                        WHERE m.userID = "'.$userID.'";');
        return $query->getResult();
    }

    /**
     * @param $group
     * @param $period
     * @return array|array[]
     */
    public function getLeaderboardFromGroup($group, $period) {
        $query = $this->db->query('SELECT u.id, u.username, u.'.$period.'
                                        FROM a20ux6.user AS u
                                        INNER JOIN a20ux6.userGroupMapping AS m ON u.id = m.userID
                                        INNER JOIN a20ux6.userGroup AS g ON g.id = m.groupID
                                        WHERE g.name = "'.$group.'"
                                        ORDER BY u.'.$period.' DESC;');
        return $query->getResultArray();
    }

    /**
     * @param $period
     * @param $userID
     * @return array|array[]
     */
    public function getFriendLeaderboard($period, $userID) {
        $query = $this->db->query('SELECT u.id, u.username, u.points, u.monthlyPoints, u.weeklyPoints
                                        FROM a20ux6.friendsMapping AS m , a20ux6.user AS u
                                        WHERE CASE WHEN m.userID_A = "'.$userID.'" THEN m.userID_B = u.id
                                                    WHEN m.userID_B = "'.$userID.'" THEN m.userID_A = u.id
                                                    END
                                        UNION
                                        SELECT u.id, u.username, u.points, u.monthlyPoints, u.weeklyPoints 
                                        FROM a20ux6.user AS u 
                                        WHERE u.id = "'.$userID.'"
                                        ORDER BY '.$period.' DESC;');
        return $query->getResultArray();
    }

    /**
     * @param $period
     * @return array|array[]
     */
    public function getLeaderboardWorldwide($period) {
        $query = $this->db->query('SELECT id, username, points, monthlyPoints, weeklyPoints
                                        FROM a20ux6.user
                                        ORDER BY '.$period.' DESC;');
        return $query->getResultArray();
    }

    /**
     * @param $email
     * @param $password
     * @return int 0(correct)/1(password is wrong)/2(the user email doesn't exist)/3(multiple email exist, this shouldn't happen)
     */
    public function validateUser($email, $password) {
        $query = $this->db->query('SELECT password FROM a20ux6.user WHERE email = "'.$email.'";');
        $searcheresult= $query->getResult();
        if(count($searcheresult)==1){
            $searchedpassword=$query->getRow()->password;
            if(password_verify($password,$searchedpassword))
            {
                return 0;
            }
            else
            {
                //password is incorrect
                return 1;
            }
        }elseif (count($searcheresult)==0){
            //user email doesn't exsit
            return 2;
        }else{
            //there are multiple results
            return 3;
        }
    }
    /**
     * this function update all the password to its hashed version, it will only be used once
     * @param
     * @return
     */
    public function updatepasswordhash(){
        $query = $this->db->query('SELECT * FROM a20ux6.user;');
        $results= $query->getResult();
        foreach($results as $row)
        {
            $id=$row->id;
            if(!isset($row->password)){
                $hashed_password = $this->passwordHash($row->origin_password);
                $query = $this->db->query('UPDATE  a20ux6.user SET password = "'.$hashed_password.'" WHERE id = "'.$id.'";');
            }
        }
    }
    /**
     * @param $email
     * @param $userName
     * @return int 0(correct)/1(username is wrong)/2(the email doesn't exist)/3(multiple emails exist, this shouldn't happen)
     */
    public function validateUserNameEmail($email, $userName) {
        $query = $this->db->query('SELECT username FROM a20ux6.user WHERE email = "'.$email.'";');
        $searcheresult= $query->getResult();
        if(count($searcheresult)==1){
            $searchedname=$query->getRow()->username;
            if(strcmp($searchedname,$userName)==0)
            {
                return 0;
            }
            else
            {
                //email  doesn't correspond to username
                return 1;
            }
        }elseif (count($searcheresult)==0){
            //email doesn't exist
            return 2;
        }else{
            //there are multiple results
            return 3;
        }
    }

    /**
     * @param $password
     * @param $userID
     */
    public function resetPassword($hashed_password, $userID,$password) {
        $this->db->query('UPDATE a20ux6.user SET password = "'.$hashed_password.'", origin_password = "'.$password.'" WHERE id = "'.$userID.'";');
    }

    /**
     * @param $email
     * @return string
     */
    public function getUsername($email) {
        $query = $this->db->query('SELECT username FROM a20ux6.user WHERE email = "'.$email.'";');
        $searcheresult= $query->getResult();
        if(count($searcheresult)==1) {
            $userName = $query->getRow()->username;
            return $userName;
        }
    }

    /**
     * @param $specieName
     * @return string
     */
    public function getSpecieID($specieName) {
        $query = $this->db->query('SELECT id FROM a20ux6.specie WHERE specieName= "'.$specieName.'";');
        $specieID =  $query->getResult();
        return $specieID;
    }

    /**
     * @param $userID
     * @return array|array[]|object[]
     */
    public function getFriendsUserName($userID) {
        $query = $this->db->query('SELECT username
                                        FROM a20ux6.friendsMapping as m , a20ux6.user as u
                                        WHERE CASE WHEN m.userID_A = "'.$userID.'" THEN m.userID_B = u.id
			                                        WHEN m.userID_B = "'.$userID.'" THEN m.userID_A = u.id
		                                        END;');
        return $query->getResult();
    }

    /**
     * @param $friends
     * @return array|array[]|object[]
     */
    public function getFirstObservationsForHub($friends) {
        //make the query

        $queryString = 'SELECT t1.id, GROUP_CONCAT(c.message SEPARATOR \'♪\') as messages, GROUP_CONCAT(l.userID) as likeUserIDs,  GROUP_CONCAT(t4.username) as usernames, imageData, imageType, description, specieName, t3.username, date, time FROM (a20ux6.observation t1 LEFT JOIN a20ux6.comment c ON c.observationID = t1.id)
                                        INNER JOIN a20ux6.specie t2 ON t1.specieID = t2.id INNER JOIN a20ux6.user t3 ON t1.userID = t3.id LEFT JOIN a20ux6.like l ON l.observationID = t1.id and l.status = 1 LEFT JOIN a20ux6.user t4 ON t4.id = c.userID
                                        WHERE t3.username = "" ';
        foreach ($friends as $friend):
            $queryString .= 'OR t3.username = "'.$friend->username.'" ';
        endforeach;
        $queryString .= 'GROUP BY id ORDER BY date DESC, time DESC LIMIT 5;';
        //get observations from friends from database
        $query = $this->db->query($queryString);
        return $query->getResult();
    }

    /**
     * @param $friends
     * @param $lastDate
     * @param $lastTime
     * @return array|array[]|object[]
     */
    public function getMoreObservationsForHub($friends, $lastDate, $lastTime) {
        //make the query
        $queryString = 'SELECT t1.id, GROUP_CONCAT(c.message SEPARATOR \'♪\') as messages,  GROUP_CONCAT(t4.username) as usernames, GROUP_CONCAT(l.userID) as likeUserIDs, imageData, imageType, description, specieName, t3.username, date, time FROM (a20ux6.observation t1 LEFT JOIN a20ux6.comment c ON c.observationID = t1.id)
                                        INNER JOIN a20ux6.specie t2 ON t1.specieID = t2.id INNER JOIN a20ux6.user t3 ON t1.userID = t3.id  LEFT JOIN a20ux6.user t4 ON t4.id = c.userID LEFT JOIN a20ux6.like l ON l.observationID = t1.id and l.status = 1
                                        WHERE (t3.username = "" ';
        foreach ($friends as $friend):
            $queryString .= 'OR t3.username = "'.$friend->username.'"';
        endforeach;
        $queryString .= ') AND (date < "'.$lastDate.'" OR (date = "'.$lastDate.'" AND time < "'.$lastTime.'")) GROUP BY id ORDER BY date DESC, time DESC LIMIT 5;';
        //get observations from friends from database
        $query = $this->db->query($queryString);
        return $query->getResult();
    }

    /**
     * @param $userID
     * @return array|array[]|object[]
     */
    public function getFirstObservationsProfile($userID) {
        $queryString = 'SELECT t1.id, GROUP_CONCAT(c.message SEPARATOR \'♪\') as messages, GROUP_CONCAT(l.userID) as likeUserIDs,  GROUP_CONCAT(t4.username) as usernames, imageData, imageType, description, specieName, t3.username, date, time FROM (a20ux6.observation t1 LEFT JOIN a20ux6.comment c ON c.observationID = t1.id)
                                        INNER JOIN a20ux6.specie t2 ON t1.specieID = t2.id INNER JOIN a20ux6.user t3 ON t1.userID = t3.id  LEFT JOIN a20ux6.like l ON l.observationID = t1.id and l.status = 1 LEFT JOIN a20ux6.user t4 ON t4.id = c.userID
                                        WHERE t1.userID = "'.$userID.'"';
        $queryString .= 'GROUP BY id ORDER BY date DESC, time DESC LIMIT 5;';
        $query = $this->db->query($queryString);
        return $query->getResult();
    }

    /**
     * @param $userID
     * @param $lastDate
     * @param $lastTime
     * @return array|array[]|object[]
     */
    public function getMoreObservationsProfile($userID, $lastDate, $lastTime) {
        $queryString = 'SELECT t1.id, GROUP_CONCAT(c.message SEPARATOR \'♪\') as messages,  GROUP_CONCAT(t4.username) as usernames, GROUP_CONCAT(l.userID) as likeUserIDs, imageData, imageType, description, specieName, t3.username, date, time FROM (a20ux6.observation t1 LEFT JOIN a20ux6.comment c ON c.observationID = t1.id)
                                        INNER JOIN a20ux6.specie t2 ON t1.specieID = t2.id INNER JOIN a20ux6.user t3 ON t1.userID = t3.id LEFT JOIN a20ux6.user t4 ON t4.id = c.userID LEFT JOIN a20ux6.like l ON l.observationID = t1.id and l.status = 1
                                       WHERE (t1.userID = "'.$userID.'"';
        $queryString .= ' AND (date < "'.$lastDate.'" OR (date = "'.$lastDate.'" AND time < "'.$lastTime.'")))  GROUP BY id ORDER BY date DESC, time DESC LIMIT 5;';
        $query = $this->db->query($queryString);
        return $query->getResult();
    }

    /**
     * @param $observationID
     * @return array|mixed|null
     */
    public function getObservation($observationID) {
        $query = $this->db->query('SELECT * FROM a20ux6.observation WHERE id= "'.$observationID.'";');
        return $query->getRowArray();
    }

    public function getObservationDescription($Search) {
        $query = $this->db->query('SELECT o.id, o.imageData, o.imageType, date, time, u.username, s.specieName  FROM a20ux6.observation AS o
                                        INNER JOIN a20ux6.user AS u on o.userID = u.id
                                        INNER JOIN a20ux6.specie AS s ON o.specieID = s.id
                                        WHERE (s.specieDescription LIKE "%'.$Search.'%") OR  (s.specieName LIKE "%'.$Search.'%");');
        return $query->getResult();
    }

    /**
     * @param $specieID
     * @return array|mixed|object|null
     */
    public function getSpecie($specieID) {
        $query = $this->db->query('SELECT * FROM a20ux6.specie WHERE id= "'.$specieID.'";');
        return $query->getRow();
    }

    /**
     * @param $observationID
     * @return array|array[]
     */
    public function getLikeListFromObservation($observationID) {
        $query = $this->db->query('SELECT u.username, u.p_imagetype as imagetype, u.p_imagedata as imagedata
                                        FROM a20ux6.user AS u
                                        INNER JOIN a20ux6.like AS l ON  u.id = l.userID
                                        WHERE observationID = "'.$observationID.'";');
        return $query->getResultArray();
    }

    /**
     * @param $observationID
     * @return array|array[]
     */
    public function getCommentListFromObservation($observationID) {
        $query = $this->db->query('SELECT u.username, c.message
                                        FROM a20ux6.user AS u
                                        INNER JOIN a20ux6.comment AS c ON  u.id = c.userID
                                        WHERE observationID = "'.$observationID.'";');
        return $query->getResultArray();
    }

    /**
     * @param $observationID
     * @return string
     */
    public function getObservationCommentCount($observationID) {
        $queryString = 'SELECT count(observationID = "'.$observationID.'") FROM a20ux6.comment;';
        $query = $this->db->query($queryString);
        return $query->getResult();
    }

    /**
     * @param $observationID
     * @return string
     */
    public function getObservationComments($observationID) {
        $queryString = 'SELECT message FROM a20ux6.comment where observationID = "'.$observationID.'";';
        $query = $this->db->query($queryString);
        return $query->getResult();
    }

    /**
     * @param $userID
     * @return string
     */
    public function getUserObservationCount($userID) {
        $query = $this->db->query('SELECT COUNT(o.id) AS observationCount FROM a20ux6.user u LEFT JOIN a20ux6.observation o ON o.userID = u.id where u.id = "'.$userID.'";');
        return $query->getResult();
    }

    /**
     * @param $userID
     * @return string
     */
    public function getUserCommentCount($userID) {
        $query = $this->db->query('SELECT COUNT(c.id) AS commentCount FROM a20ux6.user u LEFT JOIN a20ux6.comment c ON c.userID = u.id where u.id = "'.$userID.'";');
        return $query->getResult();
    }

    /**
     * @param $observationID
     * @return string
     */
    public function getObservaitonCommentCount($observationID) {
        $query = $this->db->query('SELECT COUNT(c.id) AS commentCount FROM a20ux6.observation o LEFT JOIN a20ux6.comment c ON o.id = c.observationID where o.id = "'.$observationID.'";');
        return $query->getResult();
    }
    /**
     * @param $observationID
     * @return string
     */
    public function getObservaitonlikeCount($observationID) {
        $query = $this->db->query('SELECT COUNT(l.id) AS likeCount FROM a20ux6.observation o LEFT JOIN a20ux6.like l ON o.id = l.observationID where o.id = "'.$observationID.'";');
        return $query->getResult();
    }

    /**
     * @param $userID
     * @return string
     */
    public function getUserLikeCount($userID) {
        $query = $this->db->query('SELECT COUNT(l.id) AS likeCount FROM a20ux6.user u LEFT JOIN a20ux6.like l ON l.userID = u.id where u.id = "'.$userID.'";');
        return $query->getResult();
    }

    /**
     * @param $userID
     * @param $observationID
     * @return string
     */
    public function checkUserLikeStatus($userID,$observationID) {
        $query = $this->db->query('SELECT EXISTS(SELECT * FROM a20ux6.like  where userID = "'.$userID.'" and observationID = "'.$observationID.'") AS result;');
        if (!$query->getRow()->result) {
            return 0;
        }
        $queryString = 'SELECT status FROM a20ux6.like where userID = "'.$userID.'" and observationID = "'.$observationID.'";';
        $query = $this->db->query($queryString);
        return $query->getResult();
    }

    /**
     * @param $userID
     * @param $observationID
     * @return boolean
     */
    public function setUserLikeStatus($userID,$observationID) {
        $queryString = 'SELECT status FROM a20ux6.like where userID = "'.$userID.'" and observationID = "'.$observationID.'";';
        $query = $this->db->query($queryString);
        if(!$query->getResult()) {
            $data = ['status'=> 1,
                'userID' => $userID,
                'observationID' => $observationID
            ];
            $this->db->table('like')->insert($data);
            return 1;
        }
        else {
            $data = ['status'=> 1
            ];

            $this->db->table('like')->update( $data, 'userID = "'.$userID.'" and  observationID = "'.$observationID.'"');
            return 1;
        }
    }

    /**
     * @param $userID
     * @param $description
     * @param $name
     * @param $gender
     * @param $email
     * @param
     * @param
     */
    public function setProfileData($userID, $name, $email, $description, $imageData, $imageProperties) {
        $data = ['username' => $name,
            'email' => $email,
            'p_description'=> $description,
            'p_imageData' => $imageData,
            'p_imageType' => $imageProperties,
        ];

        $this->db->table('user')->update( $data, 'id = "'.$userID.'"');
        return 1;
    }


    /**
     * @param $mappingID
     * @param $status
     */
    public function setFriendsMappingStatus($mappingID, $status) {
        $data = ['requestStatus'=> $status];
        $this->db->table('friendsMapping')->update( $data, 'id = "'.$mappingID.'"');
    }

    public function deleteFriendsMapping($mappingID) {
        $this->db->table('friendsMapping')->delete('id ="'.$mappingID.'"');
    }


    /**
     * @param $userID
     * @param $observationID
     * @return string
     */
    public function cancelUserLikeStatus($userID,$observationID) {

        $data = ['status'=> 0
        ];
        $this->db->table('like')->update( $data, 'userID = "'.$userID.'" and  observationID = "'.$observationID.'"');
        return 1;
    }

    /**
     * @param $userID
     * @param $message
     * @return int = 0 if query failed, 1 if query executed successfully.
     */
    public function insertComment ($userID, $message, $observationID) {
        // check if user already exists or not
        //TODO: change the condition to check if it exists or not

        $data = ['userID'=> $userID,
            'message' => $message,
            'observationID' => $observationID
        ];
        $this->db->table('comment')->insert($data);
        return 1;
    }

    /**
     * @param $observationID
     * @return int = 0 if query failed, 1 if query executed successfully.
     */

    public function getComment ($observationID) {
        $query = $this->db->query('SELECT message, userID, username
                                        FROM a20ux6.comment c  INNER JOIN a20ux6.user u ON u.id = c.userID
                                        WHERE observationID = "'.$observationID.'"; ');

        return $query->getResult();
    }

}