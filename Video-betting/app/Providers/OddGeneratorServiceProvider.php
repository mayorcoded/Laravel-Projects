<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 4/22/2017
 * Time: 11:53 AM
 */

namespace App\Providers;


class OddGeneratorServiceProvider
{
    private function __construct()
    {
    }

    public static function getOdds($days, $artist_rank, $user_guess){

        return self::computeOdds($days, $artist_rank, $user_guess);
    }
    public static function getRank($views){
        return $views < 1000000 ? 3
                : $views >= 1000000 && $views < 1300000 ? 2
                : 1;
    }
    private static function computeOdds($days, $artist_rank, $user_guess){

        $constant = 0;
        $artist_rank = self::getRank($artist_rank);

        switch ($artist_rank){
            case 1:
                $constant = 10.03; //Top views
                break;
            case 2:
                $constant = 8.8490; //Mid level views
                break;
            case 3:
                $constant = 8.06; //Low views
                break;
            default :
                $constant = 1;
        }

        $average = self::calculateAverage($constant, $days);
        $probability = self::calculateProbability($average, $user_guess);
        $odds = self::calculateOdds($probability);

        $result = ['rank' => $artist_rank, 'constant' => $constant,
                    'average' => $average, 'prob' => $probability, 'odds' => $odds];
        return json_encode($result);
    }

    private static function calculateAverage($constant, $days){
        return (pow(M_E, $constant) * pow(M_E, (-0.0009 * $days)));
    }

    private static function calculateProbability($average, $guess){
        return (1 / (sqrt(2 * M_PI * $average))) * pow(M_E, -1 * ((pow(($guess - $average), 2)) / (2 * $average)));
    }

    private static function calculateOdds($probability){
        return $probability / (1 - $probability);
    }
}