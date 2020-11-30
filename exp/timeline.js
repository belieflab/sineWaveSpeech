/* create timeline */
let timeline = [];

/* define welcome message trial */
let welcome = {
    type: "html-keyboard-response",
    stimulus: '<h1 style="color:white;">Welcome to the experiment!</h1>' + 
    '<p style="color:white;">Press any key to continue.</p>', //by default, jsPysch is white background and black text
};

/* define instructions trial */
let instructions_1 = {
    type: "html-keyboard-response",
    stimulus: '<h2 style="color:white;">In this task you will listen to a series of audio clips.</h2>' +
    '<h2 style="color:white;">The task is split into two test blocks, with a listening block in-between.</h2>'+
    '<p style="color:white;">Press any key to continue.</p>',
};

let instructions_2 = {
    type: "html-keyboard-response",
    stimulus: '<h2 style="color:white;">In the test blocks you will listen to a series of audio clips, and will have to indicate whether you heard speech in each clip.</h2>'+
    '<p style="color:white;">Press any key to continue.</p>',
};

let instructions_3 = {
    type: "html-keyboard-response",
    stimulus: '<h2 style="color:white;">In the listening block you just have to listen to several audio recordings. No response is required.</h2>'+
    '<p style="color:white;">Press any key to continue.</p>',
};

let instructions_4 = {
    type: "html-keyboard-response",
    stimulus: '<h2 style="color:white;">We will now begin the first test block.</h2> ' +
        '<p style="color:white;">Press any key to begin.</p>',
};

let beginListeningBlock = { 
    type: 'html-keyboard-response',
    stimulus: '<h2 style="color:white;">You will now hear some short sentences.</h2>' +
    '<p style="color:white;">You do not need to respond, just listen.</p>',
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    trial_duration: 10000,
};

let beginSecondBlock = { 
    type: 'html-keyboard-response',
    stimulus: '<h2 style="color:white;">We will now begin the second test block.</h2',
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    trial_duration: 10000,
};

let fixation = { 
    type: 'html-keyboard-response',
    stimulus: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    trial_duration: 1000,
};

let block1Stim = { 
    type: 'audio-keyboard-response',
    prompt: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    stimulus: jsPsych.timelineVariable('stimulus'),
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    // data: jsPsych.timelineVariable('data'),
    // on_finish: function (data) {
    //     experimentIterator++;
    //     },
    trial_ends_after_audio: true
};

let listeningStim = {
    type: 'audio-keyboard-response',
    prompt: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    stimulus: jsPsych.timelineVariable('stimulus'),
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    data: jsPsych.timelineVariable('data'),
    on_finish: function (data) {
        data.subjectKey = GUID;
        data.src_subject_id = workerId;
        data.site = siteNumber;
        data.interview_date = today;
        data.interview_age = ageAtAssessment;
        data.sex = sexAtBirth;
        data.handedness = handedness;
        data.response_speech = '';
        data.trial = experimentIterator;
        experimentIterator++;
        },
    trial_ends_after_audio: true
};

let block2Stim = { 
    type: 'audio-keyboard-response',
    prompt: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    stimulus: jsPsych.timelineVariable('stimulus'),
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    // data: jsPsych.timelineVariable('data'),
    // on_finish: function (data) {
    //     experimentIterator++;
    //     },
    trial_ends_after_audio: true
};

let response = { 
    type: 'html-keyboard-response',
    // stimulus: '<p style="color:white;">Could you hear a complete sentence in the audio?</p>' +
    stimulus: '<h1 style="color:white;">Could you hear a complete setence in the audio?</h1>' +
    '<h3 style="color:white;">Press "1" for Yes &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Press "0" for No</h3>',
    choices: ['1', '0'],
    response_ends_trial: true,
    data: jsPsych.timelineVariable('data'),
    on_finish: function (data) {
        data.subjectKey = GUID;
        data.src_subject_id = workerId;
        data.site = siteNumber;
        data.interview_date = today;
        data.interview_age = ageAtAssessment;
        data.sex = sexAtBirth;
        data.handedness = handedness;
        data.trial = experimentIterator;
        experimentIterator++;
        data.response_speech = jsPsych.pluginAPI.convertKeyCodeToKeyCharacter(data.key_press);
    },
};

let pause = {
    type: 'html-keyboard-response',
    stimulus: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    trial_duration: 500,
};

let save_data = {
    type: "html-keyboard-response",
    stimulus: "<p>Data saving...</p>"+
    '<div class="sk-cube-grid">'+
  '<div class="sk-cube sk-cube1"></div>'+
  '<div class="sk-cube sk-cube2"></div>'+
  '<div class="sk-cube sk-cube3"></div>'+
  '<div class="sk-cube sk-cube4"></div>'+
  '<div class="sk-cube sk-cube5"></div>'+
  '<div class="sk-cube sk-cube6"></div>'+
  '<div class="sk-cube sk-cube7"></div>'+
  '<div class="sk-cube sk-cube8"></div>'+
  '<div class="sk-cube sk-cube9"></div>'+
  '</div>'+
    "<p>Do not close this window until the text dissapears.</p>",
  
    choices: jsPsych.NO_KEYS,
    trial_duration: 5000,
    on_finish: function(){
      saveData("sws_" + workerId, jsPsych.data.get().csv());
      document.getElementById("unload").onbeforeunload='';
      $(document).ready(function(){
      $("body").addClass("showCursor"); // returns cursor functionality
  });
    }
  };
  
  let end = {
    type: "html-keyboard-response",
    stimulus:   "<p>Thank you!</p>"+
    "<p>You have successfully completed the experiment and your data has been saved.</p>"+
    "<p>To leave feedback on this task, please click the following link:</p>"+
    "<p style='color:white;'><a href="+feedbackLink+">Leave Task Feedback!</a></p>"+
    // "<p>Please wait for the experimenter to continue.</p>"+
    "<p><i>You may now close the expriment window at anytime.</i></p>",
    choices: jsPsych.NO_KEYS,
    // trial_duration: 60000,
  };
  
  // procedure

let procedureInstructions = { //This loops over the object
    timeline: [instructions_1, instructions_2, instructions_3, instructions_4], //if you put fixation in front and the feedback after, it will display those in that order
    randomize_order: false,// This is the outer procedure, looping over the stimuli
}

let procedureTestBlock1 = { //This loops over the object
    timeline: [fixation, block1Stim, response], //if you put fixation in front and the feedback after, it will display those in that order
    randomize_order: false,// This is the outer procedure, looping over the stimuli
   timeline_variables: full_stim_shuffle.slice(0,45),
    //  timeline_variables: full_stim_shuffle.slice(0,1),
}

let procedureListeningBlock = { //This loops over the object
    timeline: [listeningStim, pause], //if you put fixation in front and the feedback after, it will display those in that order
    randomize_order: false,// This is the outer procedure, looping over the stimuli
    timeline_variables: unaltered_stim_shuffle,
    //  timeline_variables: unaltered_stim_shuffle.slice(0,1),

}

let procedureTestBlock2 = { //This loops over the object
    timeline: [fixation, block1Stim, response], //if you put fixation in front and the feedback after, it will display those in that order
    randomize_order: false,// This is the outer procedure, looping over the stimuli
    timeline_variables: full_stim_shuffle.slice(45,90),
    //  timeline_variables: full_stim_shuffle.slice(1,2),
}

timeline.push(welcome)
timeline.push(procedureInstructions)
timeline.push(procedureTestBlock1) //Object oriented.
timeline.push(beginListeningBlock)
timeline.push(procedureListeningBlock) //Object oriented.
timeline.push(beginSecondBlock)
timeline.push(procedureTestBlock2) //Object oriented.
timeline.push(save_data)
timeline.push(end)