<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\JSONResponse;
use App\Http\Controllers\Video\Channels;
use App\Http\Controllers\Video\VideoController;
use App\Models\Artist;
use App\Models\ArtistChannel;
use App\Models\Channel;
use App\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Validator;

class ArtistController extends Controller
{
    use ArtistCRUD;
    use Channels;
    use JSONResponse;
    //

    public function index(){
        $artists = Artist::all()->toArray();

        for($i = 0; $i < sizeof($artists); $i++){
            $artists[$i]['video'] = Video::where('artist_id', $artists[$i]['artist_id'])->first();
        }

        return view('artist.artists', compact('artists'));
    }

    public function home($id){
        $id = Crypt::decrypt($id);

        $artist = Artist::find($id);

        $videos = $artist->videos()->where("active", 1)->get();

        return view('artist.artist', compact('artist', 'videos'));
    }

    public function create(Request $request){
        $validate = Validator::make($request->all(),[
            'description' =>    'required|string|min:1|max:500',
            'name'  =>  'required|string|min:3|max:200|unique:artists,name',
            'nickname'  =>  'required|string|min:1|max:200|unique:artists,nickname',
//            'reputation'  =>  'required|int|min:0|max:5',
            'channels'   =>  'required'
        ]);

        $channels = $request->get('channels');


        if(!is_array($channels))
            $channels = [$channels];
        $error = [];
        $failed = false;
        foreach ($channels as $channel){
            $result  = (new VideoController())->getChannelDetails($channel);
            if(!$result) {
                $error[] = 'This channel does not exists';
                $failed = true;
            }
            else
                $error[] = '';
        }

        if($validate->fails() || $failed){
            return $this->jsonRedirectResponse(route('setup'),false,[
                'description'   =>  $validate->errors()->first('description'),
                'name'   =>  $validate->errors()->first('name'),
                'nickname'   =>  $validate->errors()->first('nickname'),
                'reputation'   =>  $validate->errors()->first('reputation'),
                'featured'   =>  $validate->errors()->first('featured'),
                'channels'   =>  $validate->errors()->first('channels'),
            ],
                ['channels' => $channels, 'errors'  =>  $error,'name',
                    'description'   =>  $request->get('description'),
                    'name'  =>  $request->get('name'),
                    'nickname'  =>  $request->get('nickname'),
                    'reputation'    =>  $request->get('reputation')]);
        }



        $artist_id = $this->artistCreate(
            $request->get('description'),
            $request->get('name'),
            $request->get('nickname'), $request->get('reputation'),
            $channels[0],
            $request->get('featured') == 'on' ? 1 : 0

        );

        //now create channels and artist_channels
        $video = new VideoController();
        foreach ($channels as $channel){
            $details = $video->getChannelDetails($channel);
            $channel_id = $video->createChannel($details);

            $this->createChannelArtist($artist_id,$channel_id);
            
            //now crawl videos for this channels

            $video->crawlVideos($channel_id);
        }




        return $this->jsonRedirectResponse(route('setup'),true, 'Artist has been created!');

    }

    public function update($artist_id, Request $request){
        $validate = Validator::make(array_merge(
            $request->all(),
            ['artist'   =>  $artist_id]
        ),[
            'description' =>    'required|string|min:1|max:500',
            'name'  =>  'required|string|min:3|max:200',
            'nickname'  =>  'required|string|min:1|max:200|unique:artists,nickname,null,null,nickname,'.$artist_id,
//            'reputation'  =>  'required|int|min:0|max:5',
            'artist'  =>  'required|exists:artists,artist_id',
            'channels'   =>  'required'
        ]);

        $channels = $request->get('channels');

//        dd($channels);
        if(!is_array($channels))
            $channels = [$channels];
        $error = [];
        $failed = false;
        foreach ($channels as $channel){
            $result  = (new VideoController())->getChannelDetails($channel);
            if(!$result) {
                $error[] = 'This channel does not exists';
                $failed = true;
            }
            else
                $error[] = '';
        }

        if($validate->fails() || $failed){
            return $this->jsonRedirectResponse(route('setup'),false,[
                'description_'.$artist_id   =>  $validate->errors()->first('description'),
                'name_'.$artist_id   =>  $validate->errors()->first('name'),
                'nickname_'.$artist_id   =>  $validate->errors()->first('nickname'),
                'reputation_'.$artist_id   =>  $validate->errors()->first('reputation'),
                'featured_'.$artist_id   =>  $validate->errors()->first('featured'),
                'channels_'.$artist_id   =>  $validate->errors()->first('channels'),
                'error_'.$artist_id   =>  'Artist not updated, please check form fields for errors',
            ],
                ['channels_'.$artist_id => $channels, 'errors'  =>  $error,'name',
                    'description_'.$artist_id   =>  $request->get('description'),
                    'name_'.$artist_id  =>  $request->get('name'),
                    'nickname_'.$artist_id  =>  $request->get('nickname'),
                    'error_'.$artist_id   =>  'Artist not updated, please check form fields for errors',
                    'reputation_'.$artist_id    =>  $request->get('reputation')]);
        }



        $this->artistUpdate(
            $artist_id,
            $request->get('description'),
            $request->get('name'),
            $request->get('nickname'),
            $request->get('reputation'),
            $request->get('featured') == 'on' ? 1 : 0
        );

        //now create channels and artist_channels
        $video = new VideoController();
        foreach ($channels as $channel){
            $details = $video->getChannelDetails($channel);
            $channel_ = $this->getArtistChannel(['youtube_id',$details->id]);
            if(count($channel_) == 0)
                $channel_id = $video->createChannel($details);
            else
                $channel_id = $channel_->channel_id;
            if(!$this->checkArtistChannelExist($artist_id, $channel_id))
                $this->createChannelArtist($artist_id,$channel_id);

            //now crawl videos for this channels

            $video->crawlVideos($channel_id);
        }




        return $this->jsonRedirectResponse(route('setup'),true, ' ', [
            'artist_update_'.$artist_id =>  'Artist successfully updated!'
        ]);

    }
    public function createChannelArtist($artist_id, $channel_id){
        $chanel = new ArtistChannel();
        $chanel->artist_id = $artist_id;
        $chanel->channel_id = $channel_id;
        $chanel->save();
        return $chanel->getKey();
    }
    public function checkArtistChannelExist($artist_id, $channel_id){

        return ArtistChannel::where('artist_id',$artist_id)
        ->where('channel_id',$channel_id)
        ->count() > 0;
    }

    public function delete(){

    }
}
