<?php
/**
 * Created by PhpStorm.
 * User: kaylee
 * Date: 4/22/17
 * Time: 3:44 PM
 */

namespace App\Http\Controllers\Artist;


use App\Models\Artist;

trait ArtistCRUD
{
    public function isExists($channel_id){
        return
            Artist::where('artist_id',$channel_id)
            ->limit(1)->count() > 0;
    }

    public function getArtist($artist){

        return
            Artist::where('artist_id',$artist)
                ->first();
    }

    public function deleteArtist($artist){

    }

    public function channels($artist_id){

    }

    public function videos($artist_id){

    }
    public function artistCreate($description, $name, $nickname, $reputation,$channels,$featured){
        $artist = new Artist();
        $artist->description = $description;
        $artist->name  = $name;
        $artist->nickname = $nickname;
        //$artist->reputation = $reputation;
        //$artist->channel_id = $channels;
        //$artist->featured = $featured;
        $artist->save();
        //THE ABOVE CREATE METHOD TO BE REMOVED TO MAKE IT POSSIBLE TO GET THE INSERT ID
        //METHOD 2
        return $artist->getKey();
    }

    public function artistUpdate($id,$description, $name, $nickname, $reputation,$featured){
        Artist::where('artist_id',$id)->update([
            'description'   =>  $description,
            'name'          =>  $name,
            'nickname'      =>  $nickname,
            'reputation'    =>  $reputation,
            'featured'      =>  $featured
        ]);
    }


}