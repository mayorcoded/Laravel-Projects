<?php

namespace App\Http\Controllers;

use App\Bet;
use App\BetItem;
use Illuminate\Http\Request;
use App\Video;
use App\Models\Artist;
use App\Models\ArtistChannel;
use App\Models\Channel;
use Illuminate\Support\Facades\Input;

class LandingController extends Controller
{
    //
    public function index(){
        $featuredArtist = array();
        $trendingArtists = array();
        $recentBets = [];

        $trendingBetItems = BetItem::orderBy('created_at', 'desc')->take(10)->get();
        $uniqueArtists = [];

        foreach($trendingBetItems as $tBet){
            $unique = true;
            $artist = $tBet->video()->first()->artist()->first();

            foreach($uniqueArtists as $uA) {
                if ($uA->artist_id == $artist->artist_id)
                    $unique = false;
            }

            if(!$unique)
                continue;
            else
                $uniqueArtists[] = $artist;

            $trendingArtists[] = [
                "bet" => $tBet,
                "artist" => $artist,
                "channel" => $artist->channels()->first()->channel()->first()
            ];
        }

        $featuredVideos = Video::where('active', 1)->where('featured', 1)->get();
        $newVideos = Video::where('active', 1)->orderBy('updated_at', 'desc')->take(4)->get();
        $hotVideos = Video::where('active', 1)->orderBy('created_at', 'desc')->take(9)->get();
        $recentBetItems = BetItem::orderBy('created_at', 'desc')->take(4)->get();

        foreach($recentBetItems as $recentBet){
            $recentBets[] = ["bet" => $recentBet, "video" => $recentBet->video()->first()];
        }

        foreach (Artist::where('featured', 1)->get() as $value){
            array_push($featuredArtist, [
                    "artist" => $value,
                    "channel" => Channel::where( 'channel_id', ArtistChannel::where('artist_id',$value->artist_id)->first()->channel_id)->first()
                ]);
        }

        if(sizeof($featuredArtist) == 0)
            $featuredArtist = [];
        else if(sizeof($featuredArtist) == 1)
            $featuredArtist = [$featuredArtist[0], $featuredArtist[0]];
        else if(sizeof($featuredArtist) == 2)
            $featuredArtist = [$featuredArtist[0], $featuredArtist[1], $featuredArtist[0], $featuredArtist[1]];
        else if(sizeof($featuredArtist) == 3)
            $featuredArtist = [$featuredArtist[0], $featuredArtist[1], $featuredArtist[2], $featuredArtist[0]];
        else if(sizeof($featuredArtist) == 4)
            $featuredArtist = [$featuredArtist[0], $featuredArtist[1], $featuredArtist[2], $featuredArtist[3]];
        else if(sizeof($featuredArtist) > 4)
            $featuredArtist = [$featuredArtist[mt_rand(0,sizeof($featuredArtist)-1)], $featuredArtist[mt_rand(0,sizeof($featuredArtist)-1)],
                $featuredArtist[mt_rand(0,sizeof($featuredArtist)-1)], $featuredArtist[mt_rand(0,sizeof($featuredArtist)-1)]];

        if(sizeof($recentBets) == 0)
            $recentBets = [];
        else if(sizeof($recentBets) == 1)
            $recentBets = [$recentBets[0], $recentBets[0]];
        else if(sizeof($recentBets) == 2)
            $recentBets = [$recentBets[0], $recentBets[1], $recentBets[0], $recentBets[1]];
        else if(sizeof($recentBets) == 3)
            $recentBets = [$recentBets[0], $recentBets[1], $recentBets[2], $recentBets[0]];
        else if(sizeof($recentBets) == 4)
            $recentBets = [$recentBets[0], $recentBets[1], $recentBets[2], $recentBets[3]];
        else if(sizeof($recentBets) > 4)
            $recentBets = [$recentBets[mt_rand(0,sizeof($recentBets)-1)], $recentBets[mt_rand(0,sizeof($recentBets)-1)],
                $recentBets[mt_rand(0,sizeof($recentBets)-1)], $recentBets[mt_rand(0,sizeof($recentBets)-1)]];

        if($featuredVideos->count() == 0)
            $randomValues = [];
        else if($featuredVideos->count() == 1)
            $randomValues = [0, 0, 0, 0];
        else if($featuredVideos->count() == 2)
            $randomValues = [0, 1, 0, 1];
        else if($featuredVideos->count() == 3)
            $randomValues = [0, 1, 2, 0];
        else if($featuredVideos->count() == 4)
            $randomValues = [0, 1, 2, 3];
        else if($featuredVideos->count() > 4)
            $randomValues = [mt_rand(0, sizeof($featuredVideos)-1),mt_rand(0, sizeof($featuredVideos)-1),mt_rand(0, sizeof($featuredVideos)-1),mt_rand(0, sizeof($featuredVideos)-1)];

//        dd($trendingArtists);

        return view('index', compact('featuredVideos', 'randomValues', 'newVideos', 'hotVideos', 'featuredArtist', 'recentBets', 'trendingArtists'));
    }

    public function contact(){
        return view('contact');
    }

    public function regError(){
        print_r(session('error'));
    }

    public function account(){
        echo 'welcome';
        print_r(Auth::user());
    }

    public function search(){
        $keyword = Input::get('search');//$_GET['search'];
        $videos = Video::where('title', "LIKE","%$keyword%" )->get();
        $artists = Artist::where("name", "LIKE","%$keyword%")
            ->orWhere("nickname", "LIKE", "%$keyword%")->get();
        //$result = array_merge($artists, $videos);
        //var_dump($videos[0]);
        return view('search', compact('videos', 'artists')); //gettype($videos);
    }
}
