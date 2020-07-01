<?php
$post_data = json_decode(file_get_contents('php://input'), true); //json is a type of javascript variable that functions as a structure. json_decode makes it php. file_get_contents gets the raw input for php
// the directory "data" must be writable by the server
$name = "data/".$post_data['filename'].".csv"; 
$data = $post_data['filedata'];
// write the file to disk
file_put_contents($name, $data);
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Tapping Task</title>  <!-- This is for changing the title -->
    <script async src="js/timer.js"></script>
    <!--<script type="text/javascript" src="js/stimuli.js"></script>-->
    <script src="jsPsych/jspsych.js"></script>
    <link href="jsPsych/css/jspsych.css" rel="stylesheet" type="text/css"></link> <!--link is for any other text file; href is for local directory, either a url or path -->
    <link rel="stylesheet" type="text/css" href="css/style.css"> <!--the interpreter will take care of ordering, rel, type, href do not have to be in a specific order -->
  </head>
  <body  style="background-color:black;">  <!--any time you see style = all properties that follow are inline css -->
  
  <div class="loading centeredDiv">
    <h1 class="loading">Loading...</h1>
  </div>
  <div id="consentHolder" class="consent centeredDiv">
  <h3 id="consentPreamble" class="consent" style="color:white;">In order for us to conduct this test online, we need to include the standard consent form below. <br /> <br /> </h3>
  <div id="consentForm" class="consent consent-box"> 
    <h2 id="consentHeading" class="consent">
      CONSENT FOR PARTICIPATION IN RESEARCH STUDY
      <br>
      Northwestern University Department of Psychology
    </h2> 

    <h2>
      
    </h2>
    <p id="consentInstructions" class="consent">
      <b>Study Title:</b> Finger Tapping <!-- Text in between the <b> <b> bolds the text -->
      <br><br> <!-- This is for adding line breaks, you can add them at the end of a line or on their own -->
      <b>Principal Investigator:</b> Vijay A. Mittal, PhD
      <br><br>
      <b>Funding Source:</b> department funds
      <br><br>
      <u><b>Invitation to Participate and Description of Project</b></u>
      <br>
      You are invited to participate in a research study that concerns psychological processes related to beliefs, perceptions, and decisions. Due to the nature of psychology experiments, we cannot explain the precise purpose of the experiment until after the session is over. Afterwards, the experimenter will be happy to answer any questions you might have about the purpose of the study.
      <br><br>
      <u><b>Description of Procedures</b></u>
      <br>
      If you agree to participate in this study, this task will require you to (1) press (tap) the spacebar as quickly as you can for 10 seconds and (2) press (tap) the spacebar in time with the sound you hear and the without it. You will never be asked for personally identifiable information such as your name, address, or date of birth. 
      <br><br>
      The experiment is designed to take approximately 20 minutes. 
      <br><br>
      <u><b>Risks and Inconveniences</b></u>
      <br>
      There are little to no risks associated with this study. Some individuals may experience mild boredom. 
      <br><br>
      <u><b>Economic Considerations</b></u>
      <br>
      You will receive the payment specified in broader consent form completed when you first started the study.  
      <br><br>
      <u><b>Confidentiality</b></u>
      <br>
      We will never ask for your name, birth date, email or any other identifying piece of information. Your data will be pooled with those of others, and your responses will be completely anonymous. We will keep this data indefinitely for possible use in scientific publications and presentations. 
      <br><br>
      <u><b>Voluntary Participation</b></u>
      <br>
      Your participation in this study is completely voluntary. You are free to decline to participate or to end participation at any time by simply closing your browser window. However, please note that if you stop your participation in the study, you will only be compensated for the duration of your participation. 
      <br><br>
      <u><b>Questions or Concerns</b></u>
      <br>
      If you have any questions or concerns regarding the experiment, you may contact us here at the lab by emailing adapt@northwestern.edu If you have general questions about your rights as a research participant, you may contact the Yale University Human Investigation Committee at 203-785-4688 or human.subjects@yale.edu (HSC# 2000026290).

    </p>
  </div>


</div> <!-- This is testing our settings to the computer being used and if it doesn't fit, then it knows it a mobile device -->
<div id="attritionHolder" class="attrition centeredDiv"> 
  <p id="attritionInstructions" class="attrition"></p>
  <input required type="text" id="attritionAns" class="attrition" size="60" style="width:inherit; height:17px; font-size:15px; margin: 0 auto;" />
</div>
<div id="errorMessageHolder" class="error centeredDiv">
  <p id="mobileBrowserErrorMessage">You cannot access this test from a mobile browser. Please use a desktop computer to complete the task.</p>
  <p id="workerIDErrorMessage">You are ineligible for this task, since your worker ID has been recorded as participating in this task already. 
    Please return the HIT.</p>
</div>



  <div id="nextButtonHolder" class="buttonHolder">
  <button id="nextButton" onclick="startExperiment()">CONSENT/NEXT</button>
  <!-- <div id = "counter" style="color:white; font-size:60px;">timer</div> -->
</div>
</body>


  
  <script>

    let stimuli;
    // let countdownTimer = '<div id = "counter" style="color:white; font-size:60px;">timer</div>';

    /* create timeline */
    let timeline = [];

    // timeline.push({stimulus: '<p style="text-align:center; color:green; font-size:100px">Go!</p>', data: {test_part: 'tap', correct_response: ' '}})

    /* define welcome message trial */
    let welcome = {
      type: "html-keyboard-response",
      stimulus: '<p style="color:white;">Welcome to the experiment! Press any key to begin.</p>', //by default, jsPysch is white background and black text
      // on_load: countdown(1),
      // // prompt: '<div id = "counter" style="color:white; font-size:60px;">timer</div>',
    };
    timeline.push(welcome);

    /* define instructions trial */
    let instructions_1 = {
      type: "html-keyboard-response",
      stimulus: '<p style="color:white;">You will see a series of abstract figures. They are adaptations of signs in the Korean alphabet, but that is not important for this study. </p>' +
        '<p style="color:white;">Abstract figures sometimes have a more masculine or feminine shape. Here, each figure has already been assigned a gender '+
        'as <q>Male</q> or <q>Female</q> by a panel of respondents in a pilot study. The respondents were not given specific instructions on how to do this, '+
        'but were only told to use their intuition and to take into account the entire configuration of the stimulus. </p>'+
        '<p style="color:white;">Your task now is to guess the assigned gender of each figure. Please press the corresponding response keys to indicate your choice: </p>'+
        '<p style="color:white;"> Male &#8594 <q>,</q> (comma)</p>'+
        '<p style="color:white;"> Female &#8594 <q>.</q> (period)</p>'+
        '<p style="color:white;">Press either response keys to continue.</p>',
      choices: [',', '.'], //without this, it can be any keyboard response
    };
    timeline.push(instructions_1);

    let instructions_2 = {
      type: "html-keyboard-response",
      stimulus: '<p style="color:white;">Your choice is correct if it matches the gender assigned by the majority of respondents in the pilot study.</p> ' +
          '<p style="color:white;">For each correct choice you will receive 2 cents. There will be 200 trials divided into 4 blocks of 50 trials. You will be able to take a break after every 50 trials.</p> ' +
          '<p style="color:white;">Press the space bar to continue.</p>',
      choices: [32],
    };
    timeline.push(instructions_2);

    

    let instructions_3 = {
      type: "html-keyboard-response",
      stimulus: '<p style="color:white;">Here are some examples.</p> ' +
          '<p style="color:white;">For each, guess whether the assigned figure is male-like or female-like and indicate your choice by pressing either response keys.</p> ' +
          '<p style="color:white;">Press the space bar to continue.</p>',
      // prompt: '<p style="color:white;" id="safeTimerDisplay">00:30</p>',
      choices: [32],
      post_trial_gap: 2000, //After this is displayed, it waits 2 seconds before moving to next object
//       on_start: function () {document.getElementById('timer').innerHTML = 003 + ":" + 20;},
      };
    
      timeline.push(instructions_3);


    /* START TRAINING TRIAL FOR PARTICIPANTS */
    
    // let sec = 30; //set timer for 30 seconds

    

    let tapping_stimuli = []; /* I believe this creates an array that holds the trial information. Does this need to be done in a for loop? */
    for (let i = 0; i < 100; i++){
      tapping_stimuli.push('<p style="text-align:center; color:green; font-size:100px">Go!</p>'); //this is a thought of these in between the ps in an array
    }

    stimuliLeft = [ 
{stimulus: tapping_stimuli[ 0 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 1 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 2 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 3 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 4 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 5 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 6 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 7 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 8 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 9 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 10 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 11 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 12 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 13 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 14 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 15 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 16 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 17 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 18 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 19 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 20 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 21 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 22 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 23 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 24 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 25 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 26 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 27 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 28 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 29 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 30 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 31 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 32 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 33 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 34 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 35 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 36 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 37 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 38 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 39 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 40 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 41 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 42 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 43 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 44 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 45 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 46 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 47 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 48 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 49 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 50 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 51 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 52 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 53 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 54 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 55 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 56 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 57 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 58 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 59 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 60 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 61 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 62 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 63 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 64 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 65 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 66 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 67 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 68 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 69 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 70 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 71 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 72 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 73 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 74 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 75 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 76 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 77 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 78 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 79 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 80 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 81 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 82 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 83 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 84 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 85 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 86 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 87 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 88 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 89 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 90 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 91 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 92 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 93 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 94 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 95 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 96 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 97 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 98 ], data: {test_part: 'tapLeft', correct_response: ' '}},
{stimulus: tapping_stimuli[ 99 ], data: {test_part: 'tapLeft', correct_response: ' '}},
]  

stimuliRight = [ 
{stimulus: tapping_stimuli[ 0 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 1 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 2 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 3 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 4 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 5 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 6 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 7 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 8 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 9 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 10 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 11 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 12 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 13 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 14 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 15 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 16 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 17 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 18 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 19 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 20 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 21 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 22 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 23 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 24 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 25 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 26 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 27 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 28 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 29 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 30 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 31 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 32 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 33 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 34 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 35 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 36 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 37 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 38 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 39 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 40 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 41 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 42 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 43 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 44 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 45 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 46 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 47 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 48 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 49 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 50 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 51 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 52 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 53 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 54 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 55 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 56 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 57 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 58 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 59 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 60 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 61 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 62 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 63 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 64 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 65 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 66 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 67 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 68 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 69 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 70 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 71 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 72 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 73 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 74 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 75 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 76 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 77 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 78 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 79 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 80 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 81 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 82 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 83 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 84 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 85 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 86 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 87 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 88 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 89 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 90 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 91 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 92 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 93 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 94 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 95 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 96 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 97 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 98 ], data: {test_part: 'tapRight', correct_response: ' '}},
{stimulus: tapping_stimuli[ 99 ], data: {test_part: 'tapRight', correct_response: ' '}},
]

    let tapLeft = { // I think this is the object for collecting responses //
      type: "html-keyboard-response",
      choices: [9,' '],
      response_ends_trial: true,
      stimulus: jsPsych.timelineVariable('stimulus'), //This loads the array of your stimulus order
      data: jsPsych.timelineVariable('data'), //Data is a method (function), saves and knows to write it later
      prompt: '<p hidden id="counter" style="text-align:center; color:white; font-size:30px"></p>',
    }

    let tapRight = { // I think this is the object for collecting responses //
      type: "html-keyboard-response",
      choices: [9,' '],
      response_ends_trial: true,
      stimulus: jsPsych.timelineVariable('stimulus'), //This loads the array of your stimulus order
      data: jsPsych.timelineVariable('data'), //Data is a method (function), saves and knows to write it later
      prompt: '<p hidden id="counter" style="text-align:center; color:white; font-size:30px"></p>',
    }

    let promptLeft = { // I think this is the object for collecting responses //
      type: 'html-button-response',
      stimulus: '<p id="counter" style="text-align:center; color:white; font-size:30px">Get ready to tap with you LEFT hand.</p>',
      button_html: '<button id="nextButton" onclick="countdown(1)" onkeypress="coutndown(1)">START</button>',
      choices: [32], //Spacebar
      prompt: '<p hidden id="counter" style="text-align:center; color:white; font-size:30px"></p>', //this gets filled in with the countdown
    }
    

    let procedureLeft = { //This loops over the object
      timeline: [tapLeft], //if you put fixation in front and the feedback after, it will display those in that order
      timeline_variables: stimuliLeft,
      randomize_order: false,// This is the outer procedure, looping over the stimuli
    }


    let promptRight = { // 
      type: 'html-button-response',
      stimulus: '<p id="counter" style="text-align:center; color:white; font-size:30px">Get ready to tap with you RIGHT hand.</p>',
      button_html: '<button id="nextButton" onclick="countdown(1)" onkeypress="coutndown(1)">START</button>',
      choices: [32], //Spacebar
      prompt: '<p hidden id="counter" style="text-align:center; color:white; font-size:30px"></p>', //this gets filled in with the countdown
      response_ends_trial: true, //as soon as the click, it will advance to the next trial
    }

    //timeline.push(promptRight);


    let procedureRight = { //This loops over the object
      timeline: [tapRight], //if you put fixation in front and the feedback after, it will display those in that order
      timeline_variables: stimuliRight,
      randomize_order: false,// This is the outer procedure, looping over the stimuli
    }

    //timeline.push(procedureRight) //Object oriented.

    timeline.push(promptRight, procedureRight, promptLeft, procedureLeft) //1st block
    timeline.push(promptRight, procedureRight, promptLeft, procedureLeft) //2nd block
    timeline.push(promptRight, procedureRight, promptLeft, procedureLeft) //3rd block

    function saveData(name, data){
      let xhr = new XMLHttpRequest();
      // let sec = 30;
      xhr.open('POST', 'index.php'); // 'write_data.php' is the path to the php file described above.
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.send(JSON.stringify({filename: name, filedata: data}));
    }

    let workerID = prompt( 'Subject ID' );

   /* start the experiment */
   function startExperiment(){
      jsPsych.init({
        timeline: timeline,
        show_progress_bar: true,
        // on_finish: countdown(1),
        // prompt: '<div id = "counter" style="color:white; font-size:60px;">timer</div>',
        on_finish: function(){ saveData("tapping-task_" + workerID, jsPsych.data.get().csv()); }
        //on_finish: function(){
          //jsPsych.data.get().filter([{test_part: 'test'},{test_part: 'prediction'},{test_part: 'c2_test'}]).localSave("csv", `test-self-deception-data.csv`);
            //jsPsych.data.displayData(); 
        //}
      });
    }

</script>

<footer>
<script src="jsPsych/plugins/jspsych-html-keyboard-response.js"></script> <!--script is for javascript -->
<script src="jsPsych/plugins/jspsych-image-keyboard-response.js"></script>
<script src="jsPsych/plugins/jspsych-html-button-response.js"></script>

<script type="text/javascript" src="//code.jquery.com/jquery-git.js"></script>

<script>
// show consent page when loaded 
window.onload = function() {
  $(".loading").css({display: "none"});
  $(".consent").css({display: "block"});
  $(".buttonHolder").css({display: "block"});
};
</script>
</footer>
  </html>
