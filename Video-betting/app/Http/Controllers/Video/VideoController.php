<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\JSONResponse;
use App\Models\Artist;
use App\Video;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Youtube;
use Validator;

class VideoController extends Controller
{
    use YoutubeInterface;
    use Channels;
    use VideoTrait;
    use JSONResponse;

    /*
     * Home page to show all videos
     */
    public function index(){
        $videos = Video::where('active', 1)->get();
        return view('video.videos', [
            'videos' => $videos
        ]);
    }

    public function home($index){
        if(!$index){
            Redirect::route('index');
        }

        $id = Crypt::decrypt($index);

        $video = Video::where('video_id', $id)->first();

        $artist = $video->artist()->first();

        return view('video.video', ['video' => $video, 'artist' => $artist]);
    }
    public function getVideo(Request $request){
        $index = $request->get('id');
        try {
            $id = Crypt::decrypt($index);
        }catch (\Exception $x){
            return response()->json([
                'status' =>  false,
                'message'   =>  'This video was not found or might have ben deleted.'
            ]);
        }
        $video = Video::where('video_id', $id)->first();

        $artist = $video->artist()->first();
        if(count($artist) == 0){
            return response()->json([
               'status' =>  false,
                'message'   =>  'This video was not found or might have ben deleted.'
            ]);
        }
        return response()->json([
            'status'    =>  true,
            'message'   =>  [
                'video_name'    =>  $video->title,
                'video_image'    =>  $video->image,
                'description'   =>  $video->description,
                'number_of_views'   =>$video->views,
                'artist'    =>  $artist->name,
                'artist_description'    =>  $artist->description
            ]
        ]);
    }

    public function video(){
//        $video = Youtube::getVideoInfo('rie-hPVJ7Sw');
//        $video = Youtube::getChannelById('UCk1SpWNzOs4MYmr0uICEntg');
//        dd($video);
    }
    public function addChannel(Request $request){
        $channel = $this->getChannelDetails($request->get('channel_id'));
        if(!$channel)
            return $this->jsonRedirectResponse(route('admin.channel.add.post'), false,  'This channel does not exist or might have been deleted');
        if($this->artistChannelExist($channel->id))
            return $this->jsonRedirectResponse(route('admin.channel.add.post'), false,  'This channel is already assigned to another artist');
        $this->createChannel($channel);

//        dd($channel);
        return $this->jsonRedirectResponse(route('admin.channel.add.post'), true, 'Channel has been successfully added',[
            'youtube_id'    =>  $channel
        ]);
    }


    public function crawlVideos($channel_id){

        //this crawls all the videos of a given channel
        if(!$this->artistChannelExist(null,['channel_id' => $channel_id]))
            return $this->jsonResponse(false,  'This channel does not exist');

        $crawl_feed = $this->crawlVideosFromChannels($channel_id);

        return $this->jsonResponse(true,  'The all videos added',$crawl_feed);

    }

    public function active_inactiveVideo(){
        $video_id = $_GET['id'];
        $active = $_GET['option'];
        return Video::where('video_id', $video_id)->update(['active' => $active]);
    }

    public function feature_unfeatureVideo(){
        $video_id = $_GET['id'];
        $feature = $_GET['option'];
        return Video::where('video_id', $video_id)->update(['featured' => $feature]);
    }

}
