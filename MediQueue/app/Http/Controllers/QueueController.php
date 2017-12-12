<?php

namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use Validator;
use App\Http\Requests;

class QueueController extends Controller
{
    public $max =3;

    public $startHour = '8';
    public $stopHour = '18';
    public $interval  = '30';/*minutes*/
    //
    public function getQueuefortoday(){
        $admin_id = Auth::user()->id;
        $year = date('Y');
        $month = date('i');
        $day = date('d');
        $complaints = Complaint::select("SELECT DATEPART(yyyy,date_created) as queueYear,
         DATEPART(mm,date_created) as queueMonth,
         DATEPART(dd,date_created) as queueDate, * WHERE queueYear='$year' AND queueMonth='$month' AND queueDate='$day' AND admin_id='$admin_id'")->get();


    }
    public function getAllQueue($admin_id = null){
//        echo $admin_id;
       if($admin_id != null)
            $complaints = Complaint::where("admin_id", $admin_id)->get();
        else
             $complaints = Complaint::where("admin_id",'!=',0)->get();

        return $complaints;

    }
    public function createQueue(Request $request){
        $validate = Validator::make($request->all(), [
            'message'    =>  'required|min:2|max:200',
            'admin_id'  =>  'required|exists:users,user_id,level,1'
        ]);
        if($validate->fails()){
            $msg = $validate->errors()->has('message') ? $validate->errors()->get('message'): 'Select a valid admin'.$request->get('admin_id');
            return json_encode([
                'status'    =>  false,
                'message'   =>  $msg
            ]);
        }else{
            $admin = User::where('user_id',$request->get('admin_id'))->first();

            if($this->isCurrentQueue($request->get('admin_id'))){
                $queueDetail = $this->getCurrentQueue($request->get('admin_id'));

                return json_encode([
                    'status'    =>  false,
                    'message'   =>  'You already have a meeting with '.$admin->name.' on '.strftime('%Y-%m-%d ',$queueDetail[0]->attend_to)
                ]);
            }


//            /now schedule time
            $attend_to = $this->checkIfAdminIsAvailableDate($request->get('admin_id'));


//
//            echo strftime('%Y-%m-%d %H:%M:%S', $attend_to).' ';
//            echo strftime('%Y-%m-%d %H:%M:%S', time()).' ';
//            echo time().' ';
//            echo $attend_to.' ';
//
//            echo $attend_to-time();
//            echo time().' ';
            //lets insert
            $insert = new Complaint();
            $insert->complaint =  $request->get('message');
            $insert->status =  0;
            $insert->attend_to =  (int) $attend_to;
            $insert->added_by =  Auth::user()->user_id;
            $insert->admin_id =  $request->get('admin_id');
            $insert->save();
            
            return json_encode([
                'status'    => true,
                'message'   => 'You have successfully scheduled a meeting time with '.$admin->name,
                'time'      =>  strftime('%Y-%m-%d %H:%M:%S',$attend_to),
                'admin'     =>  $admin->name,
                'complain'  =>  $request->get('message')
            ]);

        }
    }

    public function checkIfAdminIsAvailableDate($admin_id = null){
        $hour = @date('H');
        if($admin_id != null)
            $allQueue = $this->getAllQueue();
        else
            $allQueue = $this->getAllQueue();
        $numQueue = $allQueue->count();
        if($numQueue == 0){
            //then just check if current time is within range and if it is within range add it

            $day_min = strtotime(strftime('%Y-%m-%d',time()).' '.$this->startHour.':00:00');
            $day_max = strtotime(strftime('%Y-%m-%d',time()).' '.$this->stopHour.':00:00');
            $current = strtotime(strftime('%Y-%m-%d %H:%M:%S',time()).' + '.$this->interval.' minutes');

            if($current > $day_min && $current < $day_max){
                return $current;
            }
            //else return tomorror
            return $day_min = strtotime(strftime('%Y-%m-%d',time()).' '.$this->startHour.':00:00 + 24 hours');

        }
        if($numQueue != 0) {
            $lastQueue = $allQueue[$numQueue-1];
            $date = $lastQueue->attend_to;
//            echo strftime('%Y-%m-%d %H:%M:%S',$date);

            $day_min = strtotime(strftime('%Y-%m-%d',time()).' '.$this->startHour.':00:00');
            $day_max = strtotime(strftime('%Y-%m-%d',time()).' '.$this->stopHour.':00:00');
//            echo 'now =>'.time().' prev => '.$date;
            //new login for next time
            //first of all get the last time and compare with now
            if($date > time() && strftime('%d', $lastQueue->attend_to) >= strftime('%d', time())){
                //then use a reference to the last date
                $day_min_ = strtotime(strftime('%Y-%m-%d',$lastQueue->attend_to).' '.$this->startHour.':00:00');
                $day_max_ = strtotime(strftime('%Y-%m-%d',$lastQueue->attend_to).' '.$this->stopHour.':00:00');

                $current_complaints = Complaint::where('attend_to','>=',$day_min_)
                    ->where('attend_to','<=',$day_max_)
                    ->get();
                if($current_complaints->count() == $this->max){

                    //then go to the next day
                    $next_day = strtotime(strftime('%Y-%m-%d',$lastQueue->attend_to).' + 24 hours');
                    return $next_day = strtotime(strftime('%Y-%m-%d',$next_day).' '.$this->startHour.':00:00');
                }else{

                    //add interval to this day and if the interval is larger than limit move to the next day of the interval
                    $next = strtotime(strftime('%Y-%m-%d %H:%M:%S',$lastQueue->attend_to).' + '.$this->interval.' minutes');
                    $end_time_for_the_day = strtotime(strftime('%Y-%m-%d',$lastQueue->attend_to).' '.$this->stopHour.':00:00');
                    if($next > $end_time_for_the_day){
                        //then move to the next day

                        $next_day = strtotime(strftime('%Y-%m-%d',$lastQueue->attend_to).' + 24 hours');
                        return $next_day = strtotime(strftime('%Y-%m-%d',$next_day).' '.$this->startHour.':00:00');
                    }else{

                        //return the gotten time
                        return $next;
                    }
                }
            }else{
                //then use the current time
                //get the number of meetings for the day and compare them with the current time/date

                echo 'ssss';
                $day_min_ = strtotime(strftime('%Y-%m-%d',time()).' '.$this->startHour.':00:00');
                $day_max_ = strtotime(strftime('%Y-%m-%d',time()).' '.$this->stopHour.':00:00');

                $current_complaints = Complaint::where('attend_to','>=',$day_min_)
                    ->where('attend_to','<=',$day_max_)
                    ->get();


                if($current_complaints->count() == $this->max){
                    //then move to the next day
                    return strtotime(strftime('%Y-%m-%d',time()).' '.$this->startHour.':00:00 + 24 hours');
                }else{
                    //add the interval and check if it is within range and if otherwise move to the next day

                    $next = strtotime(strftime('%Y-%m-%d %H:%M:%S',time()).' + '.$this->interval.' minutes');
                    $end_time_for_the_day = strtotime(strftime('%Y-%m-%d',time()).' '.$this->stopHour.':00:00');
                    if($next > $end_time_for_the_day){
                        //then move to the next day

                        $next_day = strtotime(strftime('%Y-%m-%d',time()).' + 24 hours');
                        return $next_day = strtotime(strftime('%Y-%m-%d',$next_day).' '.$this->startHour.':00:00');
                    }else{

                        //return the gotten time
                        return $next;
                    }
                }
            }

        }

    }

    public function isCurrentQueue($admin_id = null){
        //checks if an unattended queue exists for a user
        $user_id = Auth::user()->user_id;

        $year = date('Y');
        $month = date('i');
        $day = date('d');

//        $complaints = Complaint::select("SELECT DATEPART(yyyy,date_created) as queueYear,
//         DATEPART(mm,date_created) as queueMonth,
//         DATEPART(dd,date_created) as queueDate, * WHERE queueYear='$year' AND queueMonth='$month' AND queueDate >= '$day' AND added_by='$user_id'")->get();
        $now = (int) time();

        if($admin_id != null)
            $complaints = Complaint::where('attend_to','>=',$now)->where('added_by',$user_id)->where('admin_id', $admin_id)->get();
        else
            $complaints = Complaint::where('attend_to','>=',$now)->where('added_by',$user_id)->get();

        return ($complaints->count() >= 1);
    }
    public function getCurrentQueue($admin_id = null){
        //checks if an unattended queue exists for a user
        $user_id = Auth::user()->user_id;

        $now = (int) time();

        if($admin_id != null)
            $complaints = Complaint::where('attend_to','>=',$now)/*->where('added_by',$user_id)*/->where('admin_id', $admin_id)->get();
        else
            $complaints = Complaint::where('attend_to','>=',$now)->where('added_by',$user_id)->get();

//        print_r($complaints);
        return ($complaints);
    }
    public function getPreviousQueue($admin_id = null){
        //checks if an unattended queue exists for a user
        $user_id = Auth::user()->user_id;
        $extra = '';
        $now = time();

        if($admin_id != null)
            $complaints = Complaint::where('attend_to','<',$now)->where('added_by',$user_id)->where('admin_id', $admin_id)->get();
        else
            $complaints = Complaint::where('attend_to','<',$now)->where('added_by',$user_id)->get();


        return ($complaints);
    }
    public function getPreviousQueueAdmin($admin_id = null){
        //checks if an unattended queue exists for a user
        $user_id = Auth::user()->user_id;
        $extra = '';
        $now = time();

            $complaints = Complaint::where('attend_to','<',$now)->where('admin_id',$user_id)->get();


        return ($complaints);
    }
    public function getMyQueue($admin_id = null){

        //checks if an unattended queue exists for a user
        $user_id = Auth::user()->id;

        $year = date('Y');
        $month = date('i');
         $day = date('d');
        $extra = '';
        if($admin_id != null)
            $extra = "AND admin_id='$admin_id'";
        $complaints = Complaint::query("SELECT * FROM complaints WHERE attend_to < NOW() AND added_by='$user_id' $extra")->get();


        return $complaints;
    }
}
