let workerID = prompt( 'Subject ID' );

/* create timeline */
let timeline = [];

// timeline.push({stimulus: '<p style="text-align:center; color:green; font-size:100px">Go!</p>', data: {test_part: 'tap', correct_response: ' '}})

/* define welcome message trial */
let welcome = {
    type: "html-keyboard-response",
    stimulus: '<p style="color:white;">Welcome to the experiment!</p>' + 
    '<p style="color:white;">Press any key to continue.</p>', //by default, jsPysch is white background and black text
    // on_load: countdown(1),
    // // prompt: '<div id = "counter" style="color:white; font-size:60px;">timer</div>',
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
}

let beginSecondBlock = { 
    type: 'html-keyboard-response',
    stimulus: '<p style="color:white;">We will now begin the second test block.</p>',
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    on_finish: function (data) {
        console.log(data.key_press)
        },
    trial_duration: 5000,
}



const intel = ['102', '103', '106', '109', '110', '112', '114', '115', '201', '202', '203', '205', '206', '209', '214', '215', '304', '306', '307', '308', '309', '311', '312', '315', '316', '401', '406', '407', '409', '411', '412', '413', '416', '501', '505', '511', '512', '513', '514', '603', '607', '608', '609', '612', '613'];
const unintel = ['102', '103', '106', '109', '110', '112', '114', '115', '201', '202', '203', '205', '206', '209', '214', '215', '304', '306', '307', '308', '309', '311', '312', '315', '316', '401', '406', '407', '409', '411', '412', '413', '416', '501', '505', '511', '512', '513', '514', '603', '607', '608', '609', '612', '613'];
const unaltered = ['0102', '0103', '0106', '0109', '0110', '0112', '0114', '0115', '0201', '0202', '0203', '0205', '0206', '0209', '0214', '0215', '0304', '0306', '0307', '0308', '0309', '0311', '0312', '0315', '0316', '0401', '0406', '0407', '0409', '0411', '0412', '0413', '0416', '0501', '0505', '0511', '0512', '0513', '0514', '0603', '0607', '0608', '0609', '0612', '0613', '1702', '1704', '1706', '1707', '1710', '1711', '1714', '1715', '1801', '1803', '1807', '1808', '1814', '1815', '1816', '1902', '1904', '1905', '1910', '1912', '1913', '1914', '1915', '1916', '2001', '2002', '2004', '2008', '2010', '2011', '2012', '2013', '2014', '2016', '2102', '2103', '2105', '2106', '2107', '2108', '2109', '2111', '2112', '2114', '2116'];


let intel_45 = [];
for (let i = 0; i < intel.length ; i++){
    intel_45.push("sounds/intel_45/I_BKBQ0"+intel[i]+".wav")
}

let unintel_45 = [];
for (let i = 0; i < unintel.length ; i++){
    unintel_45.push("sounds/unintel_45/U_BKBQ0"+unintel[i]+".WAV")
}

let unaltered_90 = [];
for (let i = 0; i < unaltered.length ; i++){
    unaltered_90.push("sounds/unaltered_45/BKBQ"+unaltered[i]+".WAV")
}

let intel_stim=[];
    for (let i = 0; i < intel.length ; i++){
        intel_stim.push({stimulus: intel_45[i], data: {test_part: 'intel', correct_response: '1'}},)
    }

let unintel_stim=[];
    for (let i = 0; i < unintel.length ; i++){
        unintel_stim.push({stimulus: unintel_45[i], data: {test_part: 'intel', correct_response: '1'}},)
    }

let unaltered_stim=[];
    for (let i = 0; i < unaltered.length ; i++){
        unaltered_stim.push({stimulus: unaltered_90[i], data: {test_part: 'intel', correct_response: '1'}},)
    }

let full_stim = []
for (let i = 0; i < intel.length ; i++){
    full_stim.push({stimulus: intel_45[i], data: {test_part: 'intel', correct_response: '1'}},)
}
for (let i = 0; i < unintel.length ; i++){
    full_stim.push({stimulus: unintel_45[i], data: {test_part: 'intel', correct_response: '1'}},)
}
let full_stim_shuffle = jsPsych.randomization.repeat(full_stim, 1); //shuffled array no repeats
// let full_stim_shuffle = full_stim;



/* START TRAINING TRIAL FOR PARTICIPANTS */

// let getReady = { 
//     type: 'html-button-response',
//     stimulus: '<p id="counter" style="text-align:center; color:white; font-size:30px">Get Ready To Tap!</p>',
//     button_html: '<button id="countdownPrompt" style = "outline:none; border:none; background-color:black" onclick="countdown()" onkeypress="countdown()">START</button>',
//     choices: jsPsych.NO_KEYS, //Spacebar
//     trial_duration: 5000,
//     on_load: function() {
//     document.getElementByID("countdownPrompt").focus() // getElementByID is camel case variable naming
//     }
// }

// let countDown = { 
//     type: 'audio-keyboard-response', //html is the most versatile. Use html-keyboard-response and stuff as many things in it as possible
//     // stimulus: function(){
//     //           var html= jsPsych.timelineVariable('stimulus', true) +
//     //           "<audio controls autoplay src='"+jsPsych.timelineVariable('sound', true)+"'>" 
//     //           return html;
//     // },
//     stimulus: audio,
//     prompt: function(){
//         return countdownTrial[j];
//     },
//     choices: jsPsych.NO_KEYS,
//     trial_duration: 500,
//     on_finish: function(){
//     j++
//     }
// }

// let tapTone = { // I think this is the object for collecting responses //
//     type: "audio-keyboard-response",
//     choices: [32],
//     response_ends_trial: false,
//     trial_ends_after_audio: false,
//     trial_duration: 250,
//     stimulus: audio,
//     on_finish: function (data) {
//         console.log(data.key_press)
//         },
//     // stimulus: function() { return "Stimuli/50msec.wav" },
//     prompt: '<p style="text-align:center; color:white; font-size:30px">+</p>',
// }

let fixation = { 
    type: 'html-keyboard-response',
    stimulus: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    on_finish: function (data) {
        console.log(data.key_press)
        },
    trial_duration: 1000,
}

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
}

let listeningStim = { 
    type: 'audio-keyboard-response',
    prompt: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    stimulus: jsPsych.timelineVariable('stimulus'),
    choices: jsPsych.NO_KEYS,
    response_ends_trial: false,
    on_finish: function (data) {
        console.log(data.key_press)
        },
    // trial_ends_after_audio: true
}

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
}

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
    // trial_duration: 1000,
}


let procedureInstructions = { //This loops over the object
    timeline: [instructions_1, instructions_2], //if you put fixation in front and the feedback after, it will display those in that order
    //timeline_variables: stimuliTone,
    randomize_order: false,// This is the outer procedure, looping over the stimuli
    // timeline_variables: unintel_stim
}

let procedureTestBlock1 = { //This loops over the object
    timeline: [fixation, block1Stim, response], //if you put fixation in front and the feedback after, it will display those in that order
    //timeline_variables: stimuliTone,
    randomize_order: false,// This is the outer procedure, looping over the stimuli
    timeline_variables: full_stim_shuffle.slice(0,45),
}

let procedureListeningBlock = { //This loops over the object
    timeline: [listeningStim], //if you put fixation in front and the feedback after, it will display those in that order
    //timeline_variables: stimuliTone,
    randomize_order: false,// This is the outer procedure, looping over the stimuli
    // repetitions: 10,
    timeline_variables: unaltered_stim,
}

let procedureTestBlock2 = { //This loops over the object
    timeline: [fixation, block1Stim, response], //if you put fixation in front and the feedback after, it will display those in that order
    //timeline_variables: stimuliTone,
    randomize_order: false,// This is the outer procedure, looping over the stimuli
    timeline_variables: full_stim_shuffle.slice(45,90),
}

timeline.push(welcome)
timeline.push(procedureInstructions)
timeline.push(procedureTestBlock1) //Object oriented.
timeline.push(beginListeningBlock)
timeline.push(procedureListeningBlock) //Object oriented.
timeline.push(beginSecondBlock)
timeline.push(procedureTestBlock2) //Object oriented.


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
    preload_audio: [intel_45, unintel_45, unaltered_90],
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
