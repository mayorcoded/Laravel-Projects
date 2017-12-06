<?php
/**
 * Created by PhpStorm.
 * User: kaylee
 * Date: 4/22/17
 * Time: 10:23 AM
 */

namespace App\Http\Controllers\Video;


use App\Models\Artist;
use App\Models\Channel;

trait Channels
{
    /**
     * @param $title string
     * @param $youtube_id string
     * @param $description string
     * @param null $canvas string
     * @return bool
     * @internal This creates a channel with the provided info, Note: this method assumes that all necessary validation has been done
     */
    public function createArtistChannel($title,$youtube_id, $description, $canvas=null){

        $art = new Channel();
        $art->title = $title;
        $art->youtube_id = $youtube_id;
        $art->description = $description;
        $art->canvas = $canvas;
        $art->save();
        return $art->getKey();
    }

    /**
     * @param $artist_id int
     * @inheritdoc This geta all the the channels belonging to an artist
     */
    public function getArtistChannels($artist_id){
        $arr = [];
        foreach ((Artist::where('artist_id',$artist_id)->first()->channels()->get()) as $get)
            $arr[] = $get->channel()->first();
        return $arr;

    }
    public function deleteArtistChannel($channel_id){
        return
            Channel::where('channel_id',$channel_id)
                ->delete();
    }

    /**
     * @param $channel_id int channel id of channel in the table
     * @param $channel_info array an array containing the params to update as keys
     */
    public function updateArtistChannel($channel_id,array $channel_info){
        return
            Artist::where('channel_id',$channel_id)
                ->update($channel_info);

    }

    /**
     * @param $channel_id int id of the channel in the database
     * @return Artist;
     */
    public function getArtistChannel($channel_id){
        if(!is_array($channel_id))
            return
                Channel::where('channel_id', $channel_id)->first();
        return
            Channel::where($channel_id[0], $channel_id[1])->first();
    }


    public function artistChannelExist($youtube_id=null,array $channel_details=[]){
        //check if channel exists in the DB
        if($youtube_id !== null)
            return
                Channel::where('youtube_id', $youtube_id)->limit(1)->count() > 0;

        $column_names = array_keys($channel_details);

        $artist = Channel::where($column_names[0], $channel_details[$column_names[0]]);
        foreach ($column_names as $key => $column_name){
            if($key == 0)
                continue;
            $artist->where($column_name, $channel_details[$column_name]);

        }

        return
            $artist->limit(1)->count() > 0;
    }
}