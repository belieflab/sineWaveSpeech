/* create timeline */
let timeline = [];

/* define welcome message trial */
let welcome = {
    type: "html-keyboard-response",
    stimulus: '<p style="color:white;">Welcome to the experiment!</p>' + 
    '<p style="color:white;">Press any key to continue.</p>', //by default, jsPysch is white background and black text
};

/* define instructions trial */
let instructions_1 = {
    type: "html-keyboard-response",
    stimulus: '<p style="color:white;">In this task you will listen to a series of audio clips.</p>' +
    '<p style="color:white;">The task is split into two test blocks, with a listening block in-between.</p>'+
    '<p style="color:white;">In the test blocks you will listen to a series of audio clips, and will have to indicate whether you heard speech in each clip.</p>'+
    '<p style="color:white;">In the listening block you just have to listen to several audio recordings. No response is required.</p>'+
    '<p style="color:white;">Press any key to continue to the study.</p>',
};

let instructions_2 = {
    type: "html-keyboard-response",
    stimulus: '<p style="color:white;">We will now begin the first test block .</p> ' +
        '<p style="color:white;">Press any key to begin.</p>',
};

let beginListeningBlock = { 
    type: 'html-keyboard-response',
    stimulus: '<p style="color:white;">You will now hear some short sentences.</p>' +
    '<p style="color:white;">You do not need to respond, just listen </p>',
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    on_finish: function (data) {
        console.log(data.key_press)
        },
    trial_duration: 5000,
};

let beginSecondBlock = { 
    type: 'html-keyboard-response',
    stimulus: '<p style="color:white;">We will now begin the second test block.</p>',
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    on_finish: function (data) {
        console.log(data.key_press)
        },
    trial_duration: 5000,
};

let fixation = { 
    type: 'html-keyboard-response',
    stimulus: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    on_finish: function (data) {
        console.log(data.key_press)
        },
    trial_duration: 1000,
};

let block1Stim = { 
    type: 'audio-keyboard-response',
    prompt: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    stimulus: jsPsych.timelineVariable('stimulus'),
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    on_finish: function (data) {
        console.log(data.key_press)
        },
    trial_ends_after_audio: true
};

let listeningStim = { 
    type: 'audio-keyboard-response',
    prompt: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    stimulus: jsPsych.timelineVariable('stimulus'),
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    on_finish: function (data) {
        console.log(data.key_press)
        },
};

let block2Stim = { 
    type: 'audio-keyboard-response',
    prompt: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    stimulus: jsPsych.timelineVariable('stimulus'),
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    on_finish: function (data) {
        console.log(data.key_press)
        },
    trial_ends_after_audio: true
};

let response = { 
    type: 'html-keyboard-response',
    stimulus: '<p style="color:white;">Could you hear speech in the audio?</p>' +
    '<p style="color:white;">Press "1" for YES</p>' +
    '<p style="color:white;">Press "0" for NO</p>',
    choices: ['1', '0'],
    response_ends_trial: true,
    on_finish: function (data) {
        console.log(data.key_press)
    },
};