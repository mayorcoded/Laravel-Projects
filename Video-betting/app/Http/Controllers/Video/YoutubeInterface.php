<?php

namespace App\Http\Controllers\Video;

use App\Models\Artist;
use App\Models\ArtistChannel;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;
use Youtube;
trait YoutubeInterface
{
    //
    public $limit = 10;

    public function test(){

    }

    public function search($sttring, $channel_id=null){

    }
    public function searchChannel($string, $channel_idi=null){

    }
    public function searchAll($string){

    }
    public function generateOdd($d){
//        odd
    }
    public function crawlVideosFromChannels($channel_id,array $extras = []){
        //get all videos from channel
        $artist_channel = ArtistChannel::where('channel_id', $channel_id)->first();
        $channel = $this->getArtistChannel($channel_id);
        $videos_ = $this->getChannelVideos($channel->youtube_id);
        //now insert videos
        //this method of inserting into the DB to be changed later for optimisation
        $videos = [];
        $videos_detail = $this->getVideoDetail(array_map(function($video){
            return $video->id->videoId;
        },$videos_));
//        print_r($videos_);
        foreach ($videos_ as $key=> $video){
//            dd($videos_detail[$key]->statistics->viewCount);
            $videos[] = $video->snippet->title;
            $created_date = $video->snippet->publishedAt;
            $created_date = str_replace('T',' ',$created_date);
            $created_date = preg_replace('!\..*!','',$created_date);
//            dd($created_date);
//            if(!$this->videoExists($video->id->videoId))
                $this->createVideos($video->id->videoId, 0.23, $video->snippet->title, $video->snippet->description, $video->snippet->thumbnails->high->url, $videos_detail[$key]->statistics->viewCount, true, 0, $artist_channel->artist_id,$created_date);
//            else
//                $this->updateVideo($video->id->videoId,0.23,$video->snippet->title,$video->snippet->description,$video->snippet->thumbnails->high->url);
        }
        if($extras == []){

        }

        return [
          'no_videos'  =>  count($videos_),
          'videos'  =>  ($videos_),
        ];

    }
    public function getVideoDetail($videos){
        return Youtube::getVideoInfo($videos);
    }
    public function getChannelVideos($channel_id_youtube){
        return Youtube::listChannelVideos($channel_id_youtube,$this->limit);
    }


    public function getChannelDetails($channel_id){
        return Youtube::getChannelById($channel_id);
    }

    public function getChannelDetailsByName($channel_name){

    }

    /**
     * @param $channel Object Expecting an object frm the youtube Facade
     */
    public function createChannel($channel){
        return
            $this->createArtistChannel($channel->snippet->title,$channel->id,$channel->snippet->description,$channel->snippet->thumbnails->high->url);
    }

}
