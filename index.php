<?php
include "stable_marriage.php";
include "input_generator.php";

use App\InputGenerator;
use App\StableMariage;

function read($prompt)
{
    if (PHP_OS == 'WINNT') { // for windows
        echo $prompt;
        return (int)stream_get_line(STDIN, 1024, PHP_EOL);
    } else {
        return (int)readline($prompt);
    }
}

;

// get input size from user
$inputSize = (int)read("How many couples do you want to match?\nMin: 1, Max: ".InputGenerator::MAX_SIZE."\nInput: ");

// prepare inputs
InputGenerator::setInputSize($inputSize);

$start = microtime();

// start algoritm
StableMariage::start(InputGenerator::getInputForMen(), InputGenerator::getInputForWomen(), $inputSize);

echo "\n\nCompleted in " . ((microtime() - $start) / 60) . " seconds";
