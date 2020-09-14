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
    on_finish: function (data) {
        experimentIterator++; 
        },
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
        data.subjectKey = 'GUID';
        data.src_subject_id = workerID;
        data.site = siteNumber;
        data.interview_date = 'must be formatted exactly thusly: MM/DD/YYYY';
        data.session = '??';
        data.sex = '??';
        data.sample_group = '?? maybe 1=Clinical; 2=Healthy control';
        data.interview_age = 'integer number of months';
        data.response = null;
        data.index = experimentIterator;
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
    on_finish: function (data) {
        experimentIterator++; 
        },
    trial_ends_after_audio: true
};

let response = { 
    type: 'html-keyboard-response',
    // stimulus: '<p style="color:white;">Could you hear a complete sentence in the audio?</p>' +
    stimulus: '<h1 style="color:white;">Could you hear speech in the audio?</h1>' +
    '<h3 style="color:white;">Press "1" for YES &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Press "0" for NO</h3>',
    choices: ['1', '0'],
    response_ends_trial: true,
    data: jsPsych.timelineVariable('data'),
    on_finish: function (data) {
        data.subjectKey = 'GUID';
        data.src_subject_id = workerID;
        data.site = siteNumber;
        data.interview_date = 'must be formatted exactly thusly: MM/DD/YYYY';
        data.session = '??';
        data.sex = '??';
        data.sample_group = '?? maybe 1=Clinical; 2=Healthy control';
        data.interview_age = 'integer number of months';
        data.index = experimentIterator;
        data.response = jsPsych.pluginAPI.convertKeyCodeToKeyCharacter(data.key_press);
    },
};

let pause = { 
    type: 'html-keyboard-response',
    stimulus: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    trial_duration: 500,
};


let end = { 
    type: 'html-keyboard-response',
    stimulus: '<p id="counter" style="text-align:center; color:white; font-size:30px">This is the end of the experiment.</p>',
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    trial_duration: 5000,
};