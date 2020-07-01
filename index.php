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
    <script src="jsPsych/plugins/jspsych-audio-keyboard-response.js"></script>
    <script src="jsPsych/plugins/jspsych-html-keyboard-response.js"></script> <!--script is for javascript -->
    <script src="jsPsych/plugins/jspsych-image-keyboard-response.js"></script>
    <script src="jsPsych/plugins/jspsych-html-button-response.js"></script>
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
    let j=0;
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


    var countdownTrial = []
      countdownTrial.push("<p style='text-align:center; color:white; font-size:30px'>" + 10 + "</p>'");
      countdownTrial.push("<p style='text-align:center; color:white; font-size:30px'>" + 9 + "</p>'");
      countdownTrial.push("<p style='text-align:center; color:white; font-size:30px'>" + 8 + "</p>'");
      countdownTrial.push("<p style='text-align:center; color:white; font-size:30px'>" + 7 + "</p>'");
      countdownTrial.push("<p style='text-align:center; color:white; font-size:30px'>" + 6 + "</p>'");
      countdownTrial.push("<p style='text-align:center; color:white; font-size:30px'>" + 5 + "</p>'");
      countdownTrial.push("<p style='text-align:center; color:white; font-size:30px'>" + 4 + "</p>'");
      countdownTrial.push("<p style='text-align:center; color:white; font-size:30px'>" + 3 + "</p>'");
      countdownTrial.push("<p style='text-align:center; color:white; font-size:30px'>" + 2 + "</p>'");
      countdownTrial.push("<p style='text-align:center; color:white; font-size:30px'>" + 1 + "</p>'");
      
    var countdown_stim=[{stimulus: countdownTrial[0], sound: audio},{stimulus: countdownTrial[1], sound: audio},{stimulus: countdownTrial[2], sound: audio},{stimulus: countdownTrial[3], sound: audio},{stimulus: countdownTrial[4], sound: audio}, {stimulus: countdownTrial[5], sound: audio}, {stimulus: countdownTrial[6], sound: audio}, {stimulus: countdownTrial[7], sound: audio}, {stimulus: countdownTrial[8], sound: audio}, {stimulus: countdownTrial[9], sound: audio}]


    let workerID = prompt( 'Subject ID' );
    var audio = ["Stimuli/50msec.wav"];

    /* START TRAINING TRIAL FOR PARTICIPANTS */

    let getReady = { 
      type: 'html-button-response',
      stimulus: '<p id="counter" style="text-align:center; color:white; font-size:30px">Get Ready To Tap!</p>',
      button_html: '<button id="countdownPrompt" style = "outline:none; border:none; background-color:black" onclick="countdown()" onkeypress="countdown()">START</button>',
      choices: jsPsych.NO_KEYS, //Spacebar
      trial_duration: 5000,
      on_load: function() {
        document.getElementByID("countdownPrompt").focus() // getElementByID is camel case variable naming
      }
    }

    let countDown = { 
      type: 'audio-keyboard-response', //html is the most versatile. Use html-keyboard-response and stuff as many things in it as possible
      // stimulus: function(){
      //           var html= jsPsych.timelineVariable('stimulus', true) +
      //           "<audio controls autoplay src='"+jsPsych.timelineVariable('sound', true)+"'>" 
      //           return html;
      // },
      stimulus: audio,
      prompt: function(){
          return countdownTrial[j];
      },
      choices: jsPsych.NO_KEYS,
      trial_duration: 500,
      on_finish: function(){
        j++
      }
    }

    let tapTone = { // I think this is the object for collecting responses //
      type: "audio-keyboard-response",
      choices: [32],
      response_ends_trial: false,
      trial_ends_after_audio: false,
      trial_duration: 250,
      stimulus: "Stimuli/50msec.wav",
      on_finish: function (data) {
          console.log(data.key_press)
          },
      // stimulus: function() { return "Stimuli/50msec.wav" },
      prompt: '<p style="text-align:center; color:white; font-size:30px">+</p>',
    }

    let toneITI = { 
      type: 'html-keyboard-response',
      stimulus: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
      choices: [32], //Spacebar
      response_ends_trial: false,
      on_finish: function (data) {
          console.log(data.key_press)
          },
      trial_duration: 250,
    }
    
    let procedureCountDown = { //This loops over the object
      timeline: [countDown], //if you put fixation in front and the feedback after, it will display those in that order
      //timeline_variables: stimuliTone,
      randomize_order: false,// This is the outer procedure, looping over the stimuli
      timeline_variables: countdown_stim
    }

    let procedureTone = { //This loops over the object
      timeline: [tapTone, toneITI], //if you put fixation in front and the feedback after, it will display those in that order
      //timeline_variables: stimuliTone,
      randomize_order: false,// This is the outer procedure, looping over the stimuli
      repetitions: 10,
    }
    
    timeline.push(getReady) //Object oriented.
    timeline.push(procedureCountDown) //Object oriented.
    timeline.push(procedureTone) //Object oriented.
    

    //timeline.push(promptTone, procedureTone) //1st block
    // timeline.push(promptRight, procedureRight, promptLeft, procedureLeft) //2nd block
    // timeline.push(promptRight, procedureRight, promptLeft, procedureLeft) //3rd block
    //timeline.push(tapTone)

    function saveData(name, data){
      let xhr = new XMLHttpRequest();
      // let sec = 30;
      xhr.open('POST', 'index_working.php'); // 'write_data.php' is the path to the php file described above.
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.send(JSON.stringify({filename: name, filedata: data}));
    }

   /* start the experiment */
   function startExperiment(){
      jsPsych.init({
        timeline: timeline,
        preload_audio: audio,
        show_progress_bar: true,
        //use_webaudio: false,
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
