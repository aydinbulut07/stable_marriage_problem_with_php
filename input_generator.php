<?php

namespace App;

/**
 * Thids class is used to generate input
 *
 * Class InputGenerator
 * @package App
 */
class InputGenerator
{
    /**
     * This property
     *
     * @var int
     */
    private static $size = 0; // runtime couple's size to match given by user
    const MAX_SIZE = 100; // number of couples saved in below properties

    private static $men = [
        "Oliver","George","Harry","Jack","Jacob","Noah","Charlie","Muhammad","Thomas","Oscar","William","James","Henry",
        "Leo","Alfie","Joshua","Freddie","Archie","Ethan","Isaac","Alexander","Joseph","Edward","Samuel","Max","Daniel",
        "Arthur","Lucas","Mohammed","Logan","Theo","Harrison","Benjamin","Mason","Sebastian","Finley","Adam","Dylan",
        "Zachary","Riley","Teddy","Theodore","David","Toby","Jake","Louie","Elijah","Reuben","Arlo","Hugo","Luca",
        "Jaxon","Matthew","Harvey","Reggie","Michael","Harley","Jude","Albert","Tommy","Luke","Stanley","Jenson",
        "Frankie","Jayden","Gabriel","Elliot","Mohammad","Ronnie","Charles","Louis","Elliott","Frederick","Nathan",
        "Lewis","Blake","Rory","Ollie","Ryan","Tyler","Jackson","Dexter","Alex","Austin","Kai","Albie","Caleb","Carter",
        "Bobby","Ezra","Ellis","Leon","Roman","Ibrahim","Aaron","Liam","Jesse","Jasper","Felix","Jamie",
    ];

    private static $women = [
        "Amelia","Olivia","Emily","Isla","Ava","Jessica","Ella","Isabella","Poppy","Mia","Sophie","Sophia","Lily",
        "Grace","Evie","Scarlett","Ruby","Chloe","Daisy","Isabelle","Phoebe","Florence","Freya","Alice","Charlotte",
        "Sienna","Matilda","Evelyn","Eva","Millie","Sofia","Lucy","Elsie","Imogen","Layla","Rosie","Maya","Elizabeth",
        "Esme","Willow","Lola","Ivy","Holly","Emilia","Molly","Erin","Jasmine","Eliza","Ellie","Abigail","Lilly",
        "Eleanor","Georgia","Hannah","Harriet","Maisie","Amber","Emma","Annabelle","Bella","Amelie","Thea","Harper",
        "Rose","Gracie","Summer","Violet","Martha","Penelope","Anna","Zara","Nancy","Maria","Maryam","Darcie","Darcey",
        "Heidi","Lottie","Megan","Francesca","Mila","Lexi","Bethany","Julia","Lacey","Robyn","Aisha","Victoria","Zoe",
        "Clara","Sara","Beatrice","Darcy","Leah","Arabella","Hollie","Sarah","Maddison","Katie","Eloise",
    ];

    /**
     * This property will hold number of men given by userat runtime
     *
     * @var array
     */
    private static $slicedMen;

    /**
     * This property will hold number of women given by userat runtime
     *
     * @var array
     */
    private static $slicedWomen;

    /**
     * This method sets size of cuoples that user wants to match at runtime
     *
     * @param int $size
     * @return void
     */
    public static function setInputSize($size)
    {
        static::$size = $size > static::MAX_SIZE ? static::MAX_SIZE : $size; // check in case of given input is gt MAX_SIZE

        static::$slicedMen   = static::$size == static::MAX_SIZE ? static::$men : array_slice(static::$men, 0, static::$size);
        static::$slicedWomen = static::$size == static::MAX_SIZE ? static::$women : array_slice(static::$women, 0, static::$size);
    }

    /**
     * This method will return men list number of given by user
     *
     * @return array
     */
    public static function getInputForMen()
    {
        $inputList = [];

        foreach (static::$slicedMen as $man) {
            shuffle(static::$slicedWomen);
            $inputList[$man] = static::$slicedWomen;
        }

        return $inputList;
    }

    /**
     * This method will return women list number of given by user
     *
     * @return array
     */
    public static function getInputForWomen()
    {
        $inputList = [];

        foreach (static::$slicedWomen as $woman) {
            shuffle(static::$slicedMen);
            $inputList[$woman] = static::$slicedMen;
        }

        return $inputList;
    }

}
