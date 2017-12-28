<?php

namespace App;

Class StableMariage
{

    private static $size;

    private static $men;
    private static $women;

    private static $menOriginal;
    private static $womenOriginal;

    private static $menEngagement = [];
    private static $womenEngagement = [];

    public static function start($menInput, $womenInput, $size)
    {
        // set inputs
        static::$size  = $size;
        static::$men   = static::$menOriginal = $menInput;
        static::$women = static::$womenOriginal = $womenInput;

        // run the algorithm
        self::run();
    }

    private static function run()
    {

        // keep running unless all matched
        while (static::someSingleMenExists()) {

            // do proposal for each men
            foreach (static::$men as $man => $prefs) {

                // skip this suitor if he is engaged
                if (self::manIsEngaged($man))
                    continue;

                // do proposal for current suitor
                foreach ($prefs as $currentPref) {
                    $proposal = self::doProposal($man, $currentPref);

                    if ($proposal)
                        break;
                }

            }

        }

        // print out the result table
        self::printOutTheMatchings();

    }

    private static function someSingleMenExists()
    {
        foreach (static::$men as $man => $prefs) {

            if (!static::manIsEngaged($man))
                return true;

        }

        return false;
    }

    private static function doProposal($suitor, $woman)
    {

        // check if proposed woman is engaged
        if (self::womanIsEngaged($woman)) {
            $womanPrefs   = static::$women[$woman];
            $fiancee      = static::getFiancee($woman);
            $fianceeOrder = self::getPrefOrder($fiancee, $womanPrefs);
            $suitorOrder  = self::getPrefOrder($suitor, $womanPrefs);

            // decline proposal if propsers's fiancee is has better index then suitor
            if ($suitorOrder > $fianceeOrder) {
                static::removeFromPrefs($suitor, $woman);
                return false; // stop progress and continue to next proposal
            }

            // break the engagement
            static::breakEngagement($fiancee, $woman);
            static::removeFromPrefs($fiancee, $woman);
        }

        // do engagement
        static::doEngagement($suitor, $woman);

        return true;

    }

    private static function manIsEngaged($man)
    {
        return isset(static::$menEngagement[$man]);
    }

    private static function womanIsEngaged($woman)
    {
        return isset(static::$womenEngagement[$woman]);
    }

    private static function getFiancee($woman)
    {
        return static::$womenEngagement[$woman];
    }

    private static function getPrefOrder($search, $prefs)
    {
        return array_search($search, $prefs);
    }

    private static function breakEngagement($man, $woman)
    {

        static::$womenEngagement = array_filter(static::$womenEngagement, function ($item) use ($woman) {
            return $item == $woman;
        });

        static::$menEngagement = array_filter(static::$menEngagement, function ($item) use ($man) {
            return $item == $man;
        });

    }

    private static function doEngagement($man, $woman)
    {
        static::$menEngagement[$man]     = $woman;
        static::$womenEngagement[$woman] = $man;
    }

    private static function removeFromPrefs($man, $woman)
    {

        static::$men[$man] = array_filter(static::$men[$man], function ($pref) use ($woman) {
            return $pref != $woman;
        });

    }

    private static function printOutTheMatchings()
    {
        $totalRank = $menRank = $womenRank = 0;
        printf("\nPref index %15s \t got engaged with %15s \t Pref index \t Rank \n", "Man", "Woman");
        foreach (static::$menEngagement as $man => $woman) {
            $manPrefOrder   = static::getPrefOrder($woman, static::$menOriginal[$man]) + 1;
            $womanPrefOrder = static::getPrefOrder($man, static::$womenOriginal[$woman]) + 1;
            $menRank        += $manPrefOrder;
            $womenRank      += $womanPrefOrder;
            $rank           = $manPrefOrder + $womanPrefOrder;
            $totalRank      += $rank;
            printf("%10s %15s \t got engaged with %15s \t %10s \t %4s \n", $manPrefOrder, $man, $woman, $womanPrefOrder, $rank);
        }

        echo "\nMen Total Rank: " . ($menRank / static::$size);
        echo "\nWomen Total Rank: " . ($womenRank / static::$size);
        echo "\nGrand Total Rank: " . ($totalRank / static::$size);
    }
}
