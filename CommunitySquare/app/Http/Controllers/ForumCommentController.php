<?php

namespace App\Http\Controllers;

use App\ForumComment;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class ForumCommentController extends Controller
{
    //this will output anything that has to do with comments
    //including the comment validations
    //and also magic replace of banned string
    //['topic_id', 'comment_by', 'active', 'comment']
    public $comment_content
    ,$comment_by
    ,$topic_id
    ,$active;
    public function addCommnet(){
        $commnet = new ForumComment();
        $commnet->topic_id = $this->topic_id;
        $commnet->comment_by = $this->comment_by;
        $commnet->active = 1;
        $commnet->comment = $this->comment_content;
        $commnet->save();
    }
    public function deleteComment($id){
        $comment = ForumComment::find($id)->delete();
    }
    public function editComment($id){
        $comment = ForumComment::find($id);
        if(isset($this->topic_id))
            $comment->topic_id = $this->topic_id;
        if(isset($this->comment_by))
            $comment->comment_by = $this->comment_by;
        if(isset($this->active))
            $comment->active = $this->active;
        if(isset($this->comment_content))
            $comment->comment = $this->comment_content;
        $comment->save();
    }
    public function getTopicComments($topic_id){
        $comment = ForumComment::where('topic_id', $topic_id);
        return $comment->get();
    }

    public function getAllCommentsFromUser($user_id){
        $comment = ForumComment::where('comment_by', $user_id);
        return $comment->get();
    }

    public function postComment($topic_id, Request $request){
        //chec if the topic exist
        $checkTopic = new ForumController();
        $ar = array();
        $validatror = Validator::make($request->all(), [
           'comment' => 'required|string|min:2|max:1000',
        ]);
        if($validatror->fails()){
            $ar['error'] = $validatror->errors()->first('comment');
        }
        if($checkTopic->getTopic($topic_id)->count() == 0){
            $ar['error'] = 'Does not exist';
        }

        //check if the topic belongs to his local government
        $userCo = new AccountController();
        $user_lg = Auth::user()->local_government;
        $topic = $checkTopic->getTopic($topic_id)->get()[0]->created_by;
        $created_lg = $userCo->getUserByUname($checkTopic->getTopic($topic_id)->get()[0]->created_by)[0]->local_government;
        if(count($ar) == 0 && $created_lg != $user_lg){
            $ar['error'] = 'This topic does not belong your community';
        }
        //now check the age group

        if(count($ar) == 0 && ($checkTopic->getTopic($topic_id)->get()[0]->age_group != Auth::user()->age) && $checkTopic->getTopic($topic_id)->get()[0]->age_group !='all'){
            $ar['error'] = 'This topic is not for your age group';
        }
        if(count($ar) > 0)
            $status = array('status'=>false, 'message'=>$ar['error']);
        if(count($ar) == 0){
            //then insert comment
            $this->comment_content = $request->comment;
            $this->comment_by = Auth::user()->username;
            $this->topic_id = $topic_id;
            $this->addCommnet();
            $status = array('status'=>true, 'message'=>'Comment has successfully been added');
        }
        $data = json_encode($status);
        return redirect('topics/'.$topic_id)->withErrors($data);
    }

    public function noOfComments($topic_id){
        $coments = $this->getTopicComments($topic_id);
        return $coments->count();
    }

    public function getComment($comment_id){
        $comment = ForumComment::where('id', $comment_id);
        return $comment;
    }
    public function commentExist($comment_id){
        $result = $this->getComment($comment_id);
        if($result != NULL && $result->count()>0){
            return true;
        }else{
            return false;
        }
    }
    public function getAllComments_num(){
        //this returns the total number of comments in the database
        $comment = ForumComment::get()->count();
        return $comment;
    }
}
