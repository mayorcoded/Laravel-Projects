<?php

namespace App\Http\Controllers;

use App\State;
use App\Lg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Validator;
use App\Forum;
use App\Http\Requests;

class ForumController extends Controller
{
    //this will controll all the activity going on in the forum
    public $topic_title,
        $topic_content,
        $topic_active,
        $topic_age,
        $topic_lg;

    public function getAllTopics(){
        $topics = Forum::paginate(10);
        return $topics;
    }
    public function getTopic($id){
        $topic = Forum::where('id',$id);
        return $topic;
    }
    public function getTopicLg($lg){
        $topic = Forum::where('local_government', $lg);
        return $topic->get();
    }
    public function getTopicLg2($lg){
        $topic = Forum::where('local_government', $lg);
        return $topic;
    }
    public function getTopicState($state_id){
        //first of all get all the available lg of the state
        $stateC = new GeoController();
        $lgs = $stateC->getStateLg($state_id);
        $decodeLg = json_decode($lgs, true);
        $forumFor = Forum::where('active','<=','1');
        foreach($decodeLg as $lg){
            $forumFor->orWhere('local_government', $lg['id']);
        }
        return $forumFor->get();
    }
    
    public function editTopic($id){
        //['created_by', 'title', 'active', 'content', 'local_government']
        $topic = Forum::find($id);
        if($topic->count() > 0){
            if(isset($this->topic_title) && strlen($this->topic_title))
                $topic->title = $this->topic_title;
            if(isset($this->topic_title) && strlen($this->topic_title))
                $topic->active = $this->topic_active;
            if(isset($this->topic_title) && strlen($this->topic_title))
                $topic->content = $this->topic_content;
            if(isset($this->topic_title) && strlen($this->topic_title))
                $topic->local_government = $this->topic_lg;

            if(isset($this->topic_title) && strlen($this->topic_title))
                $topic->save();
            return true;
        }else{
            return false;
        }

    }

    public function addTopic(){
        //this expect that all the public methods declared are all not null

        $topic = new Forum();
        $topic->title = $this->topic_title;
        $topic->active = $this->topic_active;
        $topic->content = $this->topic_content;
        $topic->local_government = $this->topic_lg;
        $topic->created_by = Auth::user()->username;
        $topic->age_group = $this->topic_age;
        $topic->save();
    }

    public function deleteTopic($id){
        $topic = Forum::find($id);
        $topic->delete();
    }

    public function getComments($topic_id){
        $comment = ForumController::where('topic_id', $topic_id);
        return $comment->get();
    }

    public function getAllTopicsByUser($user_id){
        $topics = Forum::where('created_by',$user_id);
        return $topics->get();
    }
    public function postAddTopic(Request $request){
        $validate = Validator::make($request->all(),[
           'topic'  =>  'required|string|min:4|max:40|unique:forum_topics,title',
            'content' => 'required|string|min:4|max:1300|unique:forum_topics,content',
            'lg'    => 'required|exists:forum_geo_local_government,lg',
            'age'   => 'required'
        ]);
        $ar = array();

        if($validate->fails()){
            if(strlen($validate->errors()->first('topic')) > 0)
                $ar['topic'] = $validate->errors()->first('topic');
            if(strlen($validate->errors()->first('content')) > 0)
                $ar['content'] = $validate->errors()->first('content');
            if(strlen($validate->errors()->first('lg')) > 0)
                $ar['lg'] = 'invalid';
            if(strlen($validate->errors()->first('age')) > 0)
                $ar['age'] = 'Select a valid age';
        }else{
            //validate the age
            $age = $request->get('age');
            if($age != Auth::user()->age && $age != 'all'){
                $ar['age'] = 'Please select a valid age';
            }else {
                $my_acc = Auth::user()->local_government;
                $lg = $request->get('lg');
                $checkLg = new GeoController();
                $lg_id = $checkLg->getLgId($lg)[0]->id;
                $getal = $checkLg->getLG($lg_id);
                if ($my_acc == $getal)
                    $ar['lg'] = "You can't add topic to this community";
                else {
                    $this->topic_title = $request->get('topic');
                    $this->topic_content = $request->get('content');
                    $this->topic_lg = $request->get('lg');
                    $this->topic_active = 1;
                    $this->topic_age = $request->get('age');
                    $this->addTopic();
                    $data = array('status' => true, 'message' => 'Topic has successfully been created');
                }
            }
        }
        if(count($ar) > 0)
            $data = array('status'=>false, 'message'=>$ar);
        return json_encode($data);
    }

    public function isExist($id){
        //this checks if the topic exist
        $result = $this->getTopic($id);
        if($result != NULL && $result->count()>0){
            return true;
        }else{
            return false;
        }
    }
    public function getTotalTopics(){
        //his returns an int of the total number of topics in the database
        $no = Forum::get()->count();
        return $no;
    }
}
