<?php

namespace App;

/**
 * Class StableMariage
 * @package App
 */
Class StableMariage
{

    /**
     * This property will hold number of couples that user wants to match
     *
     * @var
     */
    private static $size;

    /**
     * This property will hold sliced men and their prefs on runtime
     *
     * @var
     */
    private static $men;

    /**
     * This property will hold sliced women and their prefs on runtime
     *
     * @var
     */
    private static $women;

    /**
     * This property will hold sliced men and their prefs on runtime
     * unless $men property this will hold the sliced men without any change
     *
     * @var
     */
    private static $menOriginal;

    /**
     * This property will hold sliced women and their prefs on runtime
     * unless $men property this will hold the sliced men without any change
     *
     * @var
     */
    private static $womenOriginal;

    /**
     * @var array
     */
    private static $engagedMen = [];
    /**
     * @var array
     */
    private static $engagedWomen = [];

    /**
     * @param array $menInput
     * @param array $womenInput
     * @param int $size
     */
    public static function start($menInput, $womenInput, $size)
    {
        // set properties
        static::$size  = $size;
        static::$men   = static::$menOriginal = $menInput;
        static::$women = static::$womenOriginal = $womenInput;

        // run the algorithm
        self::run();
    }

    /**
     * This method is proccess the Gale & Shapley Algorithm
     *
     */
    private static function run()
    {

        // keep running unless all matched
        while (static::anySingleMenExists()) {

            // do proposal for each men
            foreach (static::$men as $man => $prefs) {

                // skip this suitor if he is engaged
                if (self::manIsEngaged($man))
                    continue;

                // do proposal for current suitor
                foreach ($prefs as $currentPref) {

                    // end proposal slot for current suitor if he got an accept
                    if (self::doProposal($man, $currentPref))
                        break;
                }

            }

        }

        // print out the result table
        self::printOutTheMatchings();

    }

    /**
     * This method will indicate wether there are any single men or not
     *
     * @return bool
     */
    private static function anySingleMenExists()
    {

        // check for all men in $men list
        foreach (static::$men as $man => $prefs) {

            // return true if got a single man
            if (!static::manIsEngaged($man))
                return true;

        }

        return false;
    }

    /**
     * This method runs a proposal
     *
     * @param string $suitor
     * @param string $woman
     * @return bool
     */
    private static function doProposal($suitor, $woman)
    {

        // check if proposed woman is engaged
        if (self::womanIsEngaged($woman)) {
            $womanPrefs   = static::$women[$woman]; // get woman's pref list
            $fiancee      = static::getFiancee($woman); // get current woman's fiancee
            $fianceeOrder = self::getPrefOrder($fiancee, $womanPrefs); // get current woman's fiancee's pref order in her pref list
            $suitorOrder  = self::getPrefOrder($suitor, $womanPrefs); // get current woman's suitor's pref order in her pref list

            // decline proposal if propsers's fiancee is has better index then suitor
            if ($suitorOrder > $fianceeOrder) {

                // remove current woman from suitor's pref list since she declined him
                static::removeFromPrefs($suitor, $woman);

                // stop progress and continue to next proposal
                return false;
            }

            // break the engagement since suitor has a better index then current woman's fiancee
            static::breakEngagement($fiancee, $woman);

            // remove current woman from ex fiancee's pref list since she jilt
            static::removeFromPrefs($fiancee, $woman);
        }

        // do engagement since proposer is single
        static::doEngagement($suitor, $woman);

        // indicate that proposal is accepted
        return true;

    }

    /**
     * This method indicates whether given man is engaged or not
     *
     * @param $man
     * @return bool
     */
    private static function manIsEngaged($man)
    {
        return isset(static::$engagedMen[$man]);
    }

    /**
     * This method indicates whether given man is engaged or not
     *
     * @param $woman
     * @return bool
     */
    private static function womanIsEngaged($woman)
    {
        return isset(static::$engagedWomen[$woman]);
    }

    /**
     * This method returns given woman's fiancee
     *
     * @param string $woman
     * @return string man
     */
    private static function getFiancee($woman)
    {
        return static::$engagedWomen[$woman];
    }

    /**
     * This method return index of a man or woman in given pref list of opposite sex
     *
     * @param string $search
     * @param array $prefs
     * @return false|int|string
     */
    private static function getPrefOrder($search, $prefs)
    {
        return array_search($search, $prefs);
    }

    /**
     * This methot breaks engagement
     *
     * @param string $man
     * @param string $woman
     */
    private static function breakEngagement($man, $woman)
    {

        static::$engagedWomen = array_filter(static::$engagedWomen, function ($item) use ($woman) {
            return $item == $woman;
        });

        static::$engagedMen = array_filter(static::$engagedMen, function ($item) use ($man) {
            return $item == $man;
        });

    }

    /**
     * This method engages a man and a woman
     *
     * @param string $man
     * @param string $woman
     */
    private static function doEngagement($man, $woman)
    {
        static::$engagedMen[$man]     = $woman;
        static::$engagedWomen[$woman] = $man;
    }

    /**
     * This method removes given woman from given man's pref list
     *
     * @param $man
     * @param $woman
     */
    private static function removeFromPrefs($man, $woman)
    {

        static::$men[$man] = array_filter(static::$men[$man], function ($pref) use ($woman) {
            return $pref != $woman;
        });

    }

    /**
     * This method prints out the result of algorithm
     */
    private static function printOutTheMatchings()
    {
        $totalRank = $menRank = $womenRank = 0;
        printf("\nPref index %15s \t got engaged with %15s \t Pref index \t Rank \n", "Man", "Woman");
        foreach (static::$engagedMen as $man => $woman) {
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
