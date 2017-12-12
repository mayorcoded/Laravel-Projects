<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Validator;
use App\Http\Requests;

class LandingController extends Controller
{
    //
    public function logout(){
        Auth::logout();

        return redirect('/');
    }
    public function index(){

        if(Auth::check())
            return redirect(route('student.home'));
        return view('index');
    }
    public function adminIndex(){

        $quey = new QueueController();
        $admins = AccountController::getAllAdmins();
//        $meetings = $quey->getAllQueue(Auth::user()->user_id);
        $meetings = $quey->getCurrentQueue(Auth::user()->user_id);

        $omeetings = $quey->getPreviousQueueAdmin();
        return view('admin', [
            'admins'    =>  $admins,
            'meetings'    =>  $meetings,
            'omeetings'    =>  $omeetings
        ]);
    }
    //
    public function account(){
        $quey = new QueueController();
        $admins = AccountController::getAllAdmins();
        $meetings = $quey->getCurrentQueue();
        $omeetings = $quey->getPreviousQueue();
        return view('user_dashboard', [
            'admins'    =>  $admins,
            'meetings'    =>  $meetings,
            'omeetings'    =>  $omeetings
        ]);
    }

    public function registerStudent(Request $request){
        $valdate = Validator::make($request->all(),[
            'email'  =>  'required|min:3|max:20|unique:users,email',
            'password'  =>  'required|min:3|max:25|confirmed',
            'name'      =>  'required|min:3|max:40|regex:!^([a-zA-Z0-9]*){1}[ ]([a-zA-Z0-9]*){1}([ ]([a-zA-Z0-9])*)*$!'
        ],[

            'email.min'   =>  'Please input valid details',
            'email.max'   =>  'Please input valid details',
            'email.required'  =>  'Input your registration number',
            'email.unique'  =>  'A similar account already exists'

        ]);
        if($valdate->fails()){
            return json_encode([
                'status' =>  false,
                'errors'    =>  [
                    'email' =>  $valdate->errors()->first('email'),
                    'password' =>  $valdate->errors()->first('password'),
                    'name' =>  $valdate->errors()->first('name')
                ]
            ]);
        }

        $exploded_matric = explode('/', $request->get('email'));
        if(count($exploded_matric) != 3){
            return json_encode([
                'status' =>  false,
                'errors'    =>  [
                    'email' =>  'Invalid matric number',
                    'password' =>  '',
                    'name' =>  ''
                ]
            ]);
        }

        foreach($exploded_matric as $key => $matric){
            if($key == 0){
                if(strlen($matric) != 3 || !ctype_alpha($matric)){

                    return json_encode([
                        'status' =>  false,
                        'errors'    =>  [
                            'email' =>  'Invalid matric number',
                            'password' =>  '',
                            'name' =>  ''
                        ]
                    ]);
                }
            }elseif($key == 1){
                if(!is_numeric($matric) || $matric < 2000 || $matric > strftime('%Y',time())){

                    return json_encode([
                        'status' =>  false,
                        'errors'    =>  [
                            'email' =>  'Invalid matric number',
                            'password' =>  '',
                            'name' =>  ''
                        ]
                    ]);
                }
            }elseif ($key == 2){

            if(!is_numeric($matric) || $matric < 1 || $matric > 999  || strlen($matric) != 3){

                    return json_encode([
                        'status' =>  false,
                        'errors'    =>  [
                            'email' =>  'Invalid matric number',
                            'password' =>  '',
                            'name' =>  ''
                        ]
                    ]);
                }
            }
        }
        $student = new User();
        $student->email =  $request->get('email');
        $student->name =  $request->get('name');
        $student->password =  Hash::make($request->get('password'));
        $student->save();

        return json_encode([
            'status'    =>  true,
            'message'   =>  'Account has been successfully created please sign in to access'
        ]);
    }
}
