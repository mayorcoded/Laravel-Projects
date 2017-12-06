<?php
/**
 * Created by PhpStorm.
 * User: kaylee
 * Date: 4/22/17
 * Time: 12:56 PM
 */

namespace App\Http\Controllers\Video;


use App\Video;

trait VideoTrait
{
    public function createVideos($youtube_link, $odd, $title, $description, $image, $views=0, $updatable = true, $bets=0, $artist_id, $created_at=null){

        if($this->videoExists($youtube_link,'youtube_id'))
            if($updatable)
                return $this->updateVideo($youtube_link,$odd,$title,$description,$image,$views, $artist_id);
            else
                return;
        $video_ = new Video();
        $video_->youtube_id = $youtube_link;
        $video_->odd = $odd;
        $video_->artist_id = $artist_id;
        $video_->title = $title;
        $video_->description = $description;
        $video_->bets = $bets;
        $video_->image = $image;
        $video_->views = $views;
        if($created_at != null)
            $video_->created_at = $created_at;
        $video_->save();
    }

    public function updateVideo($youtube_link,$odd,$title,$description,$image,$views = 0, $artist_id = 0){
        
        if(!$this->videoExists($youtube_link,'youtube_id'))
            return;
        $video_ = Video::where('youtube_id',$youtube_link)->update([
            'youtube_id'    =>  $youtube_link,
            'odd'    =>  $odd,
            'artist_id'    =>  $artist_id,
            'title'    =>  $title,
            'description'    =>  $description,
            'image'    =>  $image,
            'views'    =>  $views,
        ]);
    }

    public function videoExists($video_id,$extra=null){

        if($extra != null){

            return Video::where($extra,$video_id)->count() > 0;
        }
        return Video::where('video_id',$video_id)->count() > 0;

    }
}