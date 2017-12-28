<?php

namespace App;

class InputGenerator
{
    private static $size = 0;
    const MAX_SIZE = 100;

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

    private static $slicedMen;
    private static $slicedWomen;

    public static function setInputSize($size)
    {
        static::$size = $size > 50 ? 50 : $size; // check in case of given input is gt 50

        static::$slicedMen   = static::$size == 50 ? static::$men : array_slice(static::$men, 0, static::$size);
        static::$slicedWomen = static::$size == 50 ? static::$women : array_slice(static::$women, 0, static::$size);
    }

    public static function getInputForMen()
    {
        $inputList = [];

        foreach (static::$slicedMen as $man) {
            shuffle(static::$slicedWomen);
            $inputList[$man] = static::$slicedWomen;
        }

        return $inputList;
    }

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
