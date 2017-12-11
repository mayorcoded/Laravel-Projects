<?php

namespace App\Http\Controllers;

use App\Forum;
use App\ForumComment;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use View;
use Auth;
class AdminController extends Controller
{
    //this controls all the activities on the admin dashboard
    public function getDeleteComment($id){
        $comEx = new ForumCommentController();
        if(!$comEx->commentExist($id)){
            $data = array('status' => false, 'title' => 'Invalid Comment', 'message' => 'This comment does not exist or might have been deleted');
            $data = json_encode($data, true);

            return view('status')->withData($data);
        }
        $comment = ForumComment::where('id', $id);
        $comment->delete();
        $data = array('status' => true, 'title' => 'Successfully deleted', 'message' => 'This comment has successfully been deleted');
        $data = json_encode($data, true);

        return view('status')->withData($data);
    }
    public function getDeletePost($id){
        //this will delete the post having the sent ID
        $postEx = new  ForumController();
        if(!$postEx->isExist($id)){
            $data = array('status' => false, 'title' => 'Invalid Topic', 'message' => 'This post does not exist or might have been deleted');
            $data = json_encode($data, true);

            return view('status')->withData($data);
        }
        $forum = Forum::where('id', $id);
        $forum->delete();
        $data = array('status' => true, 'title' => 'Successfully deleted', 'message' => 'This topic has successfully been deleted');
        $data = json_encode($data, true);

        return view('status')->withData($data);
    }

    public function getEditComment($id){
        $comEx = new ForumCommentController();
        if(!$comEx->commentExist($id)){
            $data = array('status' => false, 'title' => 'Invalid Comment', 'message' => 'This comment does not exist or might have been deleted');
            $data = json_encode($data, true);

            return view('status')->withData($data);
        }

        $commetn = new ForumCommentController();
        $comment = $commetn->getComment($id);
        return View('admin_comment', ['comment'=>$comment]);
    }
    public function getEditPost($id){
        //this will recieve the edit post request
        //validate the existence of the post
        $postEx = new  ForumController();
        if(!$postEx->isExist($id)){
            $data = array('status' => false, 'title' => 'Invalid Topic', 'message' => 'This post does not exist or might have been deleted');
            $data = json_encode($data, true);

            return view('status')->withData($data);
        }
        $topiCx = new ForumController();
        $topic = $topiCx->getTopic($id);
        $comments ='';
        return View('admin', ['topic'=>$topic]);
    }
    public function postEditPost($id, Request $request){
        $postEx = new  ForumController();
        if(!$postEx->isExist($id)){
            $data = array('status' => false, 'title' => 'Invalid Topic', 'message' => 'This post does not exist or might have been deleted');
            $data = json_encode($data, true);

            return view('status')->withData($data);
        }
        //validate the user input
        $validate = Validator::make($request->all(),[
            'topic'  =>  'required|string|min:4|max:40',
            'content' => 'required|string|min:4|max:3300',
        ]);
        $ar = array();

        if($validate->fails()) {
            if (strlen($validate->errors()->first('topic')) > 0)
                $ar['topic'] = $validate->errors()->first('topic');
            if (strlen($validate->errors()->first('content')) > 0)
                $ar['content'] = $validate->errors()->first('content');
        }else{

        }
        $cm = array();
        if(count($ar) > 0) {
            $data = array('status' => false, 'message' => $ar);
            $cm['data'] = $data;
        }else{
            //now update the topic
            $forum = Forum::where('id', $id);
            $forum->update(['title'=>$request->get('topic'), 'content'=>$request->get('content')]);

            $data = array('status' => true, 'message' => 'Topic successfully updated');
            $cm['data'] = $data;
        }
        $topiCx = new ForumController();
        $topic = $topiCx->getTopic($id);
        $cm['topic'] = $topic;
        return View('admin', $cm);
    }

    public function postEditComment($id, Request $request){
        $commment_ = new ForumCommentController();
        if(!$commment_->commentExist($id)){
            $data = array('status' => false, 'title' => 'Invalid Comment', 'message' => 'This user comment does not exist or might have been deleted');
            $data = json_encode($data, true);

            return view('status')->withData($data);
        }
        $validate = Validator::make($request->all(),[
            'comment' => 'required|string|min:1|max:3300',
        ]);
        $cm = array();
        if($validate->fails()) {
            $ar = $validate->errors()->first('comment');

            $data = array('status' => false, 'message' => $ar);
            $cm['data'] = $data;
        }else{
            $comment = $request->get('comment');
            $commentC = ForumComment::where('id', $id);
            $commentC->update(['comment'=>$comment]);
            $data = array('status' => true, 'message' => 'Comment Successfully updated');
            $cm['data'] = $data;
        }
        $commetn = new ForumCommentController();
        $commentV = $commetn->getComment($id);
        $cm['comment'] = $commentV;
        return view('admin_comment', $cm);
    }

    public function getAddAdmin($data = NULL){
        if($data == NULL)
            return view('add_admin');
        else
            return view('add_admin', ['data'=>$data]);
    }
    public function postAddAdmin(Request $request){
        $acc = new AccountController();
        $admin_level = $acc->adminLevel();
        $validate = Validator::make($request->all(), [
           'username' => 'required|exists:users,username',
            'level' => 'required|integer|min:1|max:'.$admin_level.'',
        ]);
        $error = array();
        if($validate->fails()){
            if(strlen($validate->errors()->first('username')))
                $error['username'] = $validate->errors()->first('username');

            if(strlen($validate->errors()->first('level')))
                $error['level'] = $validate->errors()->first('level');


        }
        else{
            $username = $request->get('username');
            $level = $request->get('level');

            if($acc->adminLevel() <= (int)$acc->adminLevel($username)){
                $error['level'] = 'Sorry you are not permitted to rank this user';
            }else if(Auth::user()->username == $username) {
                $error['username'] = 'Sorry you are not permitted to rank yourself';
            }else
            {
                $user = User::where('username', $request->get('username'));
                $user->update(['user_level'=>$level]);
            }
        }
        if(count($error)>0)
            $data = array('status' => false, 'title' => 'Successfully deleted', 'message' => $error);
        else
            $data = array('status' => true, 'title' => 'Successfully deleted', 'message' => 'User level has been updated');

        $data['username'] = $request->get('username');
        $data['level']= $request->get('level');
        return $this->getAddAdmin($data);
    }
}
