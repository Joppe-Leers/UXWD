<?php /** @noinspection PhpUnused */


namespace App\Controllers;

use Database_model;
use Group_model;
use Menu_model;

class AccountController extends BaseController
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

    public function login() {
        $this->data=[];
        $this->set_common_data('eco', null,'eco');

        if ($this->request->getMethod() === 'post' && $this->validate([
                'email'  => 'required|min_length[3]|max_length[40]|valid_email|is_not_unique[user.email]',
                'password'=>'required|min_length[6]|max_length[50]'
            ]))
        {
            //check the password
            $email= $this->request->getPost('email');
            $password=$this->request->getPost('password');
            $searchresult=$this->database_model->validateUser($email,$password);
            if ($searchresult==0){
                //password is correct
                // save the current user data
                //get the user row from the database by the email
                $user = $this->database_model->getUserByEmail($email);
                //save this
                $this->setUserSession($user);
                session()->setFlashdata('success','Successful Login!');
                //return hub page
                return redirect()->to('hub');

            }
            else if($searchresult==1){
                //password is wrong
                $this->data['error_message'] = 'Wrong password. Did you forgot your password?';
            }
            else if ($searchresult==2){
                //user doesn't exsit
                $this->data['error_message'] = 'There is no account with this email address.';

            }
            else if ($searchresult==3){
                //multiple accounts with the same user name,
                $this->data['error_message'] = 'Multiple accounts with the same email exist. Please consult our software developer!';
            }
        }
        else if($this->request->getMethod() === 'post' )
        {
            $this->data['validation']="errors";
        }
        $this->data['content'] = view('login',$this->data); //replace by your own view
        return view("extraTemplate", $this->data);
    }
    public function loginFromObservation() {

        $this->data['content'] = view('loginFromObservation'); //replace by your own view
        $this->data['title'] = lang('app.Login_From_Observation');

        return view("extraTemplate", $this->data);
    }

    public function register() {
        $this->data=[];
        helper(['form']);
        if ($this->request->getMethod() === 'post' && $this->validate([
                'username' => 'required|min_length[3]|max_length[255]|alpha_dash|is_unique[user.username]',
                'email'  => 'required|min_length[3]|max_length[40]|valid_email|is_unique[user.email]',
                'password'=>'required|min_length[6]|max_length[50]',
                'password_confirm'=>'matches[password]'
            ]))
        {
            $username= $this->request->getPost('username');
            $email= $this->request->getPost('email');
            $password=$this->request->getPost('password');
            $hashed_password=$this->passwordHash($password);
            $this->database_model-> insertUser($username,$hashed_password,$email,$password);
            $user = $this->database_model->getUserByEmail($email);
            $this->setUserSession($user);
            session()->setFlashdata('success','Successful Register!');
            return redirect()->to('hub');
        }
        else if($this->request->getMethod() === 'post')
        {
            $this->data['validation']="error";
        }
        $this->data['content'] = view('register',$this->data); //replace by your own view
        return view("extraTemplate", $this->data);
    }

    public function forgotPassword() {
        $this->data=[];
        helper(['form']);//to remain the user's typed value if the login fails
        if ($this->request->getMethod() === 'post' && $this->validate([
                'email'  => 'valid_email|is_not_unique[user.email]',
                'username' => 'required|min_length[3]|max_length[255]|alpha_dash'
            ]))
        {
            //check the password
            $email= $this->request->getPost('email');
            $userName=$this->request->getPost('username');
            $searchresult=$this->database_model->validateUserNameEmail($email,$userName);
            if ($searchresult==0){
                //userName and email are correct
                $userquery = $this->database_model->getUserByEmail($email);
                $this->setUserSession($userquery);
                session()->setFlashdata('success','Successfully Login!');
                return redirect()->to('resetPassword/'.$userquery->id);
            }
            else if($searchresult==1){
                //username is wrong
                $this->data['error_message'] = 'Wrong username.';
            }
            else if ($searchresult==2){
                //email doesn't exsit
                $this->data['error_message'] = 'This email address does not exists.';
            }
            else if ($searchresult==3){
                //multiple accounts with the same user name,
                $this->data['error_message'] = 'Multiple accounts with the same email address exist. Please consult our software developer!';
            }
        }
        elseif($this->request->getMethod() === 'post')
        {
            $this->data['error_message'] =' ';
        }
        $this->data['content'] = view('forgotPassword', $this->data); //replace by your own view
        $this->data['title'] = lang('app.Forgot_password?');
        return view("extraTemplate", $this->data);
    }

    public function resetPassword($userID) {
        if($userID != session()->get('id'))
        {
            //here should inform you don't have right to do that, you can only modify your own password
            return redirect()->to(base_url());
        }
        $this->data['userID'] = $userID;
        if ($this->request->getMethod() === 'post' && $this->validate([
                'newPassword'  => 'required|min_length[6]|max_length[50]',
                'password_confirm'=>'matches[newPassword]'
            ]))
        {
            $password= $this->request->getPost('newPassword');
            if($this->database_model->validateUser(session()->get('email'),$password)==0)
            {
                $this->data['error_message'] ='This password is the same as te old one!';
                $this->data['content'] = view('resetPassword', $this->data); //replace by your own view
                return view("extraTemplate", $this->data);
            }
            $hashed_password=$this->passwordHash($password);
            $this->database_model->resetPassword($hashed_password, $userID,$password);
            session()->destroy();
            return redirect()->to(base_url());
        }
        elseif ($this->request->getMethod() === 'post')
        {
            $this->data['validation'] = "error";
        }
        $this->data['content'] = view('resetPassword', $this->data); //replace by your own view
        $this->data['title'] = lang('app.Reset_Password');
        return view("extraTemplate", $this->data);
    }

    public function logout(){
        session()->destroy();
        return redirect()->to('login');
    }

    public function check_login(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->load->model('user_model');
        $row = $this->user_model->get_by_name_pwd($username,$password);
        if($row){
            $this->load->view('success');
        }
        else{
            $this->load->view('login');
        }
    }

    private function setUserSession($user){
        $data = [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'points' => $user->points,
            'monthlyPoints' => $user->monthlyPoints,
            'weeklyPoints' => $user->weeklyPoints,
            'isLoggedIn' => true,
            'lastMainPageLink' => 'null'
        ];
        session()->set($data);
        return true;
    }

}


