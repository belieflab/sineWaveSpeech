<!-- Purpose of var.js: To include all global variables and server-side logic -->

<?php
// Directory paths for different stimulus types
$intelPath = './stim/intel_45/';
$unintelPath = './stim/unintel_45/';
$unalteredPath = './stim/unaltered_45/';

// Function to scan directory and return array of file paths, excluding . and ..
function getFilePaths($dirPath) {
    $files = scandir($dirPath);
    $fileArray = [];
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $fileArray[] = $dirPath . $file;
        }
    }
    return $fileArray;
}

// Arrays of file paths for each stimulus type
$intelArray = getFilePaths($intelPath);
$unintelArray = getFilePaths($unintelPath);
$unalteredArray = getFilePaths($unalteredPath);

// JSON-encoded strings for use in JavaScript
$intelArrayJSON = json_encode($intelArray);
$unintelArrayJSON = json_encode($unintelArray);
$unalteredArrayJSON = json_encode($unalteredArray);
?>

<script>
"use strict";

// Global variables for tracking trial and score
let trialIterator = 0;
let score = 0;

// Arrays of stimuli, parsed from JSON provided by PHP
const intelligible = <?php echo $intelArrayJSON; ?>;
const unintelligible = <?php echo $unintelArrayJSON; ?>;
const unaltered = <?php echo $unalteredArrayJSON; ?>;

// Function to create stimulus objects for an array of file paths
function createStimuli(array, part) {
    return array.map(stimulus => ({
        stimulus,
        data: { test_part: part, stim: stimulus },
    }));
}

// Stimulus objects for each category
const intel_stim = createStimuli(intelligible, "intel");
const unintel_stim = createStimuli(unintelligible, "unintel");
const unaltered_stim = createStimuli(unaltered, "unaltered");

// Combined and shuffled arrays of stimuli
const full_stim = intel_stim.concat(unintel_stim); // Combined array of intel and unintel stimuli
const full_stim_shuffle = shuffleArray(full_stim); // Shuffled array with no repeats
const unaltered_stim_shuffle = shuffleArray(unaltered_stim); // Shuffled array with no repeats

</script>
