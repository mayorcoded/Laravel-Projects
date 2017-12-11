<?php

namespace App\Http\Controllers;
use App\Forum;
use App\ForumComment;
use App\Lg;
use Illuminate\Support\Facades\Gate;
use View;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use Hash;
use App\Http\Requests;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class AccountController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/dashboard';
    protected $username = 'username';
    //
    public function store(Request $request){
        if(Auth::user()) {
            $data = array('status' => false, 'message' => 'You are already logged into an account please log out of the account before you can register');
            return json_encode($data);
        }
        $validate = Validator::make($request->all(), [
            'username'=>'required|min:2|max:30|string|alpha|unique:users,username',
            'age'=>'required|',
            'address'=>'required|string|min:5|max:50',
            'area'=>'required|string|min:2|max:20',
            'state'=>'required|',
            'local_government'=>'required|',
            'email'=>'email|required|unique:users,email',
            'password'=>'required|min:7|max:40|string|confirmed',
            //'username'=>'required|min:5|max:40|string|alpha_dash|unique:users,username',
        ]);
        $ar = array();
        if($validate->fails()){
            if(strlen($validate->errors()->first('username')))
                $ar['username'] = $validate->errors()->first('username');
            if(strlen($validate->errors()->first('age')))
                $ar['age'] = $validate->errors()->first('age');
            if(strlen($validate->errors()->first('email')))
                $ar['email'] = $validate->errors()->first('email');
            if(strlen($validate->errors()->first('state')))
                $ar['state'] = $validate->errors()->first('state');
            if(strlen($validate->errors()->first('local_government')))
                $ar['local_government'] = $validate->errors()->first('local_government');
            if(strlen($validate->errors()->first('password')))
                $ar['password'] = $validate->errors()->first('password');
            if(strlen($validate->errors()->first('address')))
                $ar['address'] = $validate->errors()->first('address');
            if(strlen($validate->errors()->first('area')))
                $ar['area'] = $validate->errors()->first('area');
        }else {
            //if validat1ion is true
            //now validate the local government and state
            $lg = $request->get('local_government');
            $state = $request->get('state');
            $geo = new GeoController();
            $get = $geo->getState($state);
            $getlg = $geo->getLgId($lg);
            $lgs = json_decode($getlg, true);
            if(!$get)
                $ar['state'] = 'Invalid state/province';
            else if(!$getlg){
                $ar['local_government'] = 'Invalid local government';
            }else{
                //check both
                $check = Lg::where('id',$getlg[0]->id)->where('state_id',$state);
                if($check->count() < 1){
                    $ar['local_government'] = 'Invalid local government'.$getlg[0]->id;
                    $ar['state'] = 'Invalid state/province';
                }
            }
            //validate age group
            $valid_age  = array('below 18','18-24','25-30','31-38','39-45','46-50','51-60','above 60');
            if(!in_array(strtolower($request->get('age')), $valid_age))
                $ar['age'] = 'Invalid age';
            if(count($ar) == 0) {
                $conf = $this->random(5);
                $newUser = new User();
                $newUser->username = $request->get('username');
                $newUser->password = Hash::make($request->get('password'));
                $newUser->age = $request->get('age');
                $newUser->email = $request->get('email');
                $newUser->address = $request->get('address');
                $newUser->area = $request->get('area');
                $newUser->local_government = $request->get('local_government');
                $newUser->user_level = 0;
                $newUser->state = $request->get('state');
                $newUser->conf_code = $conf;
                $newUser->save();

                $header = 'Successful Registration';
                $body = 'Your account has been successfully created. A confirmatory link has been sent to ' . $request->get('email') . ', please click on the link to activate
        For testing purpose confirmatory link is <a href="account/activate/'.$request->get('email').'/' . $conf . '">click here</a>
        ';
                $Emaildata = array('header' => $header, 'body' => $body, 'success' => true);
                $html = '<div align="center">

                    <h2 class="text-success">'.$header.'</h2>
                    <p class="text-warning">'.$body.'</p>
                </div>';
                $data= array('status'=> true, 'body'=>$html);
            }
        }
        if(count($ar) > 0)
            $data = array('status'=>false, 'message'=>$ar);
        return json_encode($data);
    }

    public function userId(){
        return Auth::user()->id;
    }
    public function getUserByUname($user_name){
        $user = User::where('username',$user_name);
        return $user->get();
    }

    public function doLogin(Request $request){
        $error2 = '';
        $validator = Validator::make($request->all(), [
            'username'=>'required',
            'password'=>'required',
        ]);
        ///some manual configurations
        if($validator->fails()){
            if($validator->errors()->first('username'))
                $er = $validator->errors()->first('username');
            else
                $er = $validator->errors()->first('password');
            $data = array('status'=>false, 'message'=>$er);
        }else {
            $email = $request->get('username');
            $error2 = '';
            $user = user::where('username', $email);
            if ($user->where('activate', 0)->count() > 0 && $user->count() > 0) {
                $error2 = 'This account has not yet been activated';#))
                $data = array('status' =>false, 'message'=>$error2);
            } else {
                /////////////////////////////
                $this->login($request);
                if (Auth::check())
                    $data = array('status' =>true, 'message'=>'Successfully logged in');
                else
                    $data = array('status' =>false, 'message'=>'Username and Password do not match');
            }
        }
        return json_encode($data, true);
    }

    public function updateUser(Request $request){
        $this->validate($request, [
            'firstname'=>'min:2|max:30|string|alpha',
            'lastname'=>'min:2|max:30|string|alpha',
            'middlename'=>'min:2|max:30|string|alpha',
            'email'=>'email|unique:users,email',

        ]);
        $newUser = User::find($this->userId());
        if($request->has('firstname'))
            $newUser->firstname=$request->get('firstname');
        if($request->has('lastname'))
            $newUser->lastname=$request->get('lastname');
        if($request->has('middlename'))
            $newUser->middlename=$request->get('middlename');
        if($request->has('email'))
            $newUser->email=$request->get('email');

        $newUser->save();
    }

    public function activateUser($email, $code){
            $token = $code;
            $error = array();
            $user = User::where('email',$email);

            if($user->count() == 0)
                $error[] = 'THe account does not exist or might have been deleted';
            if(count($error) == 0 && $user->where('activate',0)->count() == 0)
                $error[] = 'This account has already been activated';
            if(count($error) == 0 && $user->where('conf_code',$token)->count() == 0)
                $error[] = 'Invalid activation key';
            if(count($error) == 0){
                //then update

                $user->update(['activate'=>'1']);
                $data = array('status'=>true, 'title'=> 'Account Activation', 'message'=>'Account has successfully been activated');
            }else{
                $data = array('status'=>false, 'title'=> 'Account Activation', 'message'=>$error[0]);
            }

        return json_encode($data, true);
    }

    public function postPasswordChange(Request $request){
        $this->validate($request, [
            'new_password'=>'required|min:5|max:40|string|confirmed',
            'old_password'=>'required|min:5|max:40',
        ]);
    }
    public function changePassword($newPass, $user_id=NULL){
        $newUser = User::find(($user_id == NULL) ? $this->userId() : $user_id);#
        $newUser->password =  Hash::make($newPass);
        $newUser->save();
    }

    public function doReset($user_id){
        //this will reset the password
        $password = $this->random(7);
        $this->changePassword($password, $user_id);
        return $password;
    }

    public function validateReset(Request $request){
        $this->validate($request,[
            'email'=>'email|required|exists:users,email',
            'code'=>'required',
        ]);
        $email = $request->get('email');
        $code = $request->get('code');
        $user = User::where('email', $email)->where('activate','1');
        $error = array();
        $exp = $user->get()[0]->pwd_time + 6000;
        if($user->count() == 0)
            $error[] = 'This account has not yet been activated';
        else
            $user_id = $user->get()[0]->id;
        if(count($error) == 0 && $user->where('pwd_val',1)->count() == 0)
            $error[] = 'There is currently no request for password reset for this account';
        if(count($error) == 0 && $user->where('pwd_val',1)->where('pwd_recovery',$code)->count() == 0)
            $error[] = 'This is an invalid request code';
        if(time() > $exp){
            $error[] = 'This code for the account is expired please request for another by clicking <a href="password/reset">here</a>';
        }
        //now update
        if(count($error) == 0) {
            $user->update(['pwd_recovery' => '', 'pwd_val' => '0']);
            $password = $this->doReset($user_id);
            $success = 'Password recovery successful';
            $msg = 'Your password has been successfully changed to '.$password;
//            $sendMail = new MailController();
//            $sendMail->email = $email;
//            $sendMail->subject = 'Password reset';
//            $sendMail->content = $msg;
//            $sendMail->send();
        }

        if(count($error) > 0){
            $data = array('status' => false, 'title' => 'Password Recovery', 'message' => $error[0]);
        }else
            $data = array('status' => true, 'title' => 'Password Recovery', 'message' => $msg.'<br>Password to this account has been successfully reset please check your mail for the new password"');
        $data = json_encode($data, true);

        return view('status')->withData($data);
        //->where('activate','1')->where('code',$code)->update(['pwd_recovery'=>$code, 'code_val'=>'0'])
    }

    public function random($length){
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }

        return $str;
    }
    public function isLogged(){
        //this will return a boolean on the user login status
        if(Auth::user())
            return true;
        else
            return false;
    }

    public function postUpdate(Request $request){
        $validate = Validator::make($request->all(), [
            'username'=>'min:2|max:30|string|alpha|unique:users,username',
            'address'=>'string|min:5|max:50',
            'area'=>'string|min:2|max:20',
            'email'=>'email|unique:users,email',
            'password'=>'min:7|max:40|string|confirmed',
        ]);
        $ar = array();
        if($validate->fails()){
            if(strlen($validate->errors()->first('username')))
                $ar['message'] = $validate->errors()->first('username');
            if(strlen($validate->errors()->first('age')))
                $ar['message'] = $validate->errors()->first('age');
            if(strlen($validate->errors()->first('email')))
                $ar['message'] = $validate->errors()->first('email');
            if(strlen($validate->errors()->first('password')))
                $ar['message'] = $validate->errors()->first('password');
            if(strlen($validate->errors()->first('address')))
                $ar['message'] = $validate->errors()->first('address');
            if(strlen($validate->errors()->first('area')))
                $ar['message'] = $validate->errors()->first('area');
        }else {
            //if validat1ion is truee group
            $valid_age = array('below 18', '18-24', '25-30', '31-38', '39-45', '46-50', '51-60', 'above 60');
            if ($request->has('age') && !in_array(strtolower($request->get('age')), $valid_age))
                $ar['message'] = 'Invalid age';

            if(count($ar) == 0){
                $user = User::find(Auth::user()->id);
            }

            //validate the password change
        }
        if(count($ar) > 0){
            $status = array('status'=>false, $ar);
        }else{
            if($request->has('username')){
                //also updates all comments and post with th username
                $comment = ForumComment::where('comment_by', Auth::user()->username);
                $comment->update(['comment_by'=>$request->get('username')]);
                //also update all topics
                $topic = Forum::where('created_by', Auth::user()->username);
                $topic->update(['created_by'=>$request->get('username')]);
                $user = User::where('username', Auth::user()->username);
                $user->update(['username'=>$request->get('username')]);
            }
            if($request->has('email')){
                $user = User::where('username', Auth::user()->username);
                $user->update(['email'=>$request->get('email')]);
            }
            if($request->has('age')){
                $user = User::where('username', Auth::user()->username);
                $user->update(['age'=>$request->get('age')]);
            }
            if($request->has('area')){
                $user = User::where('username', Auth::user()->username);
                $user->update(['area'=>$request->get('area')]);
            }
            if($request->has('address')){
                $user = User::where('username', Auth::user()->username);
                $user->update(['address'=>$request->get('address')]);
            }
            if($request->has('password')){
                $this->changePassword($request->get('password'));
            }
            $ar['message'] ='Profile info successfully updated';
            $status = array('status'=>true, $ar);
        }

        return redirect('profile/update/true')->withErrors(json_encode($status));
    }

    public function profilePicUpdate(Request $request){
        $validate = Validator::make($request->all(), [
            'profile_pic' => 'required|min:2|max:3000|mimes:jpeg,bmp,png'
        ]);
        if($validate->fails()){
            return redirect('profile/update/true')->withErrors($validate->errors()->first('profile_pic'));
        }
        $rnd = abs(time());
        $rnd = $rnd % 39;
        $ext= $request->file('profile_pic')->getClientOriginalExtension();
        $filename = $this->random(10).$rnd.'.'.$ext;
        $request->file('profile_pic')->move('images',$filename);
        //update user
        $user = User::where('username', Auth::user()->username);
        $profile_pic = 'images/'.$filename;
        $user->update(['profile_pic'=>$profile_pic]);

        return redirect('profile/update/true');
    }

    public function postReset(Request $request){
        $validate = Validator::make($request->all(),[
            'email'=>'email|required|exists:users,email',
        ]);
        if($validate->fails()){
            return redirect('password/reset')->withErrors($validate->errors()->first('email'));
        }
                //if the validations is true now send a mail to the user
        $email = $request->get('email');
        $code = $this->random(5);
        //now send the confirmatory message to the user
        $msg = 'We received a request from to reset the the password of your account ('.$email.'). please <a href="password/reset/confirm?email='.$email.'&code='.$code.'"';
        $user = User::where('email', $email)->where('activate','1')->update(['pwd_recovery'=>$code, 'pwd_val'=>'1', 'pwd_time'=>time()]);
//        $sendMail = new MailController();
//        $sendMail->email = $email;
//        $sendMail->subject = 'Password reset';
//        $sendMail->content = $msg;
//        $sendMail->send();
            $data = array('status' => true, 'title' => 'Password Recovery', 'message' => 'A password recovery request has been sent to the server but we need to you to confirm this action by clicking on the confirmatory link sent to your box <a href="password/reset/'.$email.'/'.$code.'"');
        $data = json_encode($data, true);

        return view('status')->withData($data);
    }

    public function isAdmin(){
        if(!Auth::user())
            return false;
        $admin_level = Auth::user()->user_level;
        if($admin_level > 0)
            return true;
        else
            return false;
    }
    public function adminLevel($user_id = NULL){
        if($user_id == NULL)
            $admin_level = Auth::user()->user_level;
        else
            $admin_level = User::where('username',$user_id)->get()[0]->user_level;

        return $admin_level;
    }
    public function getAllUsers(){
        //this returns int
        $users = User::where('activate', 1)->get()->count();
        return $users;
    }
}
