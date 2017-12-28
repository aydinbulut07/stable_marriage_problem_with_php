# STABLE MARIAGE PROBLEM

This problem is used to match same size of 2 lists consist of different objects. In this implementation i used Gale & 
Shapley's "Deferred Acceptance Procedure" and developed in PHP language.

This implementation works in console, has a input generator up to 100 couples but you can add more same size of men and 
women easily into input_generator.php if you want.

## Increasing men and women number
Open input_generator.php and you will see men and woman array list and you can add same size of men and women to the 
two lists

## Requirements
In order to run this application, you must have installed PHP interpreter on your machine(for who wants to run locally). 

This application tested on PHP 5.6.25 and 7.0.10, the application may work with old versions of PHP but i don't know yet.

## How To Run

First open command shell and change your current directory to basepath of the application, it depends on where you store it.

For CMD use `cd` command to get into basepath of the application

For example: cd "E:\education\YZM 3207 Algorithm Analysis and Design\projects\stable_marriage_problem"

Then run `php index.php` command to start application

It will ask for enter integer between 1 and 100, when you hit appropriate 
number and then enter, the application will run the Gale & Shapley Algorithm to solve "Stable Marriage Problem"

Thanks.
Author: Aydın Bulut
https://www.linkedin.com/in/aydinbulut/
https://github.com/aydinbulut07
