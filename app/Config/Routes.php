<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('AccountController');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//['filter' => 'noauth'], this website can only be shown when the user hasn't logged in
//['filter' => 'auth'], this website can only be shown when the user has logged in

/*
 * Login
 */
$routes->get('/', 'AccountController::login',['filter' => 'noauth']);
$routes->match(['get','post'],'forgotPassword', 'AccountController::forgotPassword',['filter' => 'noauth']);
$routes->match(['get','post'],'resetPassword/(:num)', 'AccountController::resetPassword/$1',['filter'=>'auth']);
$routes->match(['get','post'],'login', 'AccountController::login',['filter' => 'noauth']);
$routes->get('loginFromObservation', 'AccountController::loginFromObservation');
$routes->match(['get','post'],'register', 'AccountController::register',['filter' => 'noauth']);
$routes->get('logout','AccountController::logout');

//$routes->get('/', 'Maincontroller::login',['filter' => 'noauth']);
//$routes->match(['get','post'],'forgotPassword', 'Maincontroller::forgotPassword',['filter' => 'noauth']);
//$routes->match(['get','post'],'resetPassword/(:num)', 'Maincontroller::resetPassword/$1',['filter'=>'auth']);
//$routes->match(['get','post'],'login', 'Maincontroller::login',['filter' => 'noauth']);
//$routes->get('loginFromObservation', 'Maincontroller::loginFromObservation');
//$routes->match(['get','post'],'register', 'Maincontroller::register',['filter' => 'noauth']);
//$routes->get('logout','Maincontroller::logout');

/*
 * Hub
 */
$routes->get('/hub', 'HubController::hub',['filter'=>'auth']);
$routes->get('changeLikeStatus/(:num)','HubController::changeLikeStatus/$1',['filter'=>'auth']);
$routes->get('cancelLikeStatus/(:num)','HubController::cancelLikeStatus/$1',['filter'=>'auth']);
$routes->get('sendComment/(:any)/(:num)','HubController::sendComment/$1/$2',['filter'=>'auth']);
$routes->match(['get','post'],'hub', 'HubController::hub',['filter' => 'auth']);

/*
 * Observation
 */
$routes->get('anobservation/(:num)', 'AnobservationController::anobservation/$1',['filter'=>'auth']);
$routes->get('fetchObservationLikeHTML/(:num)', 'AnobservationController::fetchObservationLikeHTML/$1');
$routes->get('fetchObservationCommentHTML/(:num)', 'AnobservationController::fetchObservationCommentHTML/$1');

/*
 * Groups
 */
$routes->get('groups', 'GroupsController::groups',['filter'=>'auth']);
$routes->match(['get','post'],'group/(:alpha)', 'GroupsController::group/$1',['filter'=>'auth']);
$routes->match(['get','post'],'newgroup', 'GroupsController::newgroup',['filter'=>'auth']);
$routes->get('groupmembers/(:alpha)', 'GroupsController::groupmembers/$1',['filter'=>'auth']);
$routes->get('addGroupMembers/(:num)/(:alpha)', 'GroupsController::addGroupMembers/$1/$2',['filter'=>'auth']);
$routes->get('addFriendToGroup/(:any)/(:alpha)', 'GroupsController::addFriendToGroup/$1/$2',['filter'=>'auth']);
$routes->get('deleteUserFromGroup/(:num)/(:num)/(:alpha)', 'GroupsController::deleteUserFromGroup/$1/$2/$3',['filter'=>'auth']);

/*
 * AddObservation
 */
$routes->get('addObservation', 'AddObservationsController::addObservation');
$routes->match(['get','post'],'addObservation', 'AddObservationsController::addObservation');
$routes->get('addObservationWithoutLogin', 'AddObservationsController::addObservationWithoutLogin');
$routes->match(['get','post'],'addObservationWithoutLogin', 'AddObservationsController::addObservationWithoutLogin');

/*
 * Leaderboards
 */
$routes->get('leaderboardSelect', 'LeaderboardController::leaderboardSelect',['filter'=>'auth']);
$routes->get('leaderboard/(:alpha)', 'LeaderboardController::leaderboard/$1',['filter'=>'auth']);
$routes->get('fetchFriendsLeaderboard/(:alpha)', 'LeaderboardController::fetchFriendsLeaderboard/$1',['filter'=>'auth']);
$routes->get('fetchWorldwideLeaderboard/(:alpha)', 'LeaderboardController::fetchWorldwideLeaderboard/$1',['filter'=>'auth']);
$routes->get('fetchGroupLeaderboard/(:alpha)/(:alpha)', 'LeaderboardController::fetchGroupLeaderboard/$1/$2',['filter'=>'auth']);

/*
 * Profile
 */
$routes->get('profile', 'profileController::profile',['filter'=>'auth']);
$routes->get('otheruserprofile/(:num)', 'profileController::otheruserprofile/$1',['filter'=>'auth']);
$routes->match(['get','post'],'account/(:num)', 'profileController::account/$1',['filter'=>'auth']);
$routes->get('edit_profile', 'profileController::edit_profile',['filter'=>'auth']);

$routes->match(['get','post'],'edit_profile', 'profileController::edit_profile',['filter' => 'auth']);

/*
 * Search
 */
$routes->get('search', 'SearchController::search');
$routes->get('searchGetObservations/(:alpha)', 'SearchController::searchGetObservations/$1');
$routes->get('searchGetGroups/(:alpha)', 'SearchController::searchGetGroups/$1');
$routes->get('searchGetUsers/(:alpha)', 'SearchController::searchGetUsers/$1');

/*
 * Friends
 */
$routes->get('friendList', 'FriendsController::friendList');
$routes->get('acceptFriendRequest/(:num)', 'FriendsController::acceptFriendRequest/$1');
$routes->get('declineFriendRequestOrDelete/(:num)', 'FriendsController::declineFriendRequestOrDelete/$1');
$routes->get('sendFriendRequest/(:num)', 'FriendsController::sendFriendRequest/$1');

/*
 * Other
 */
//$routes->get('/lang/{locale}', 'Language::index',['filter' => 'noauth']);
$routes->get('getUsername','profileController::getUsername',['filter'=>'auth']);


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
