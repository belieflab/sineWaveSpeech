"use strict";

const jsPsych = initJsPsych({
    show_progress_bar: true,
});

const timeline = [];

const preload = {
    type: jsPsychPreload,
    images: [],
    audio: [intelligible, unintelligible, unaltered],
    show_detailed_errors: true,
};

/* define welcome message trial */
const welcome = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus:
        '<h1 style="color:white;">Welcome to the experiment!</h1>' +
        '<p style="color:white;">Press any key to continue.</p>', //by default, jsPysch is white background and black text
};

/* define instructions trial */
const instructions_1 = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus:
        '<h2 style="color:white;">In this task you will listen to a series of audio clips.</h2>' +
        '<h2 style="color:white;">The task is split into two test blocks, with a listening block in-between.</h2>' +
        '<p style="color:white;">Press any key to continue.</p>',
};

const instructions_2 = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus:
        '<h2 style="color:white;">In the test blocks you will listen to a series of audio clips, and will have to indicate whether you heard speech in each clip.</h2>' +
        '<p style="color:white;">Press any key to continue.</p>',
};

const instructions_3 = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus:
        '<h2 style="color:white;">In the listening block you just have to listen to several audio recordings. No response is required.</h2>' +
        '<p style="color:white;">Press any key to continue.</p>',
};

const instructions_4 = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus:
        '<h2 style="color:white;">We will now begin the first test block.</h2> ' +
        '<p style="color:white;">Press any key to begin.</p>',
};

const beginListeningBlock = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus:
        '<h2 style="color:white;">You will now hear some short sentences.</h2>' +
        '<p style="color:white;">You do not need to respond, just listen.</p>',
    choices: "NO_KEYS",
    response_ends_trial: false,
    trial_duration: 10000,
};

const beginSecondBlock = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus:
        '<h2 style="color:white;">We will now begin the second test block.</h2',
    choices: "NO_KEYS",
    response_ends_trial: false,
    trial_duration: 10000,
};

const fixation = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus:
        '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    choices: "NO_KEYS",
    response_ends_trial: false,
    trial_duration: 1000,
};

const stim = {
    type: jsPsychAudioKeyboardResponse,
    prompt: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    stimulus: jsPsych.timelineVariable("stimulus"),
    choices: "NO_KEYS",
    response_ends_trial: false,
    trial_ends_after_audio: true,
};

const listeningStim = {
    type: jsPsychAudioKeyboardResponse,
    prompt: '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    stimulus: jsPsych.timelineVariable("stimulus"),
    choices: "NO_KEYS",
    response_ends_trial: false,
    data: jsPsych.timelineVariable("data"),
    on_finish: function (data) {
        writeCandidateKeys(data);
        data.response_speech = "";
        data.index = trialIterator;
        trialIterator++;
    },
    trial_ends_after_audio: true,
};

const response = {
    type: jsPsychHtmlKeyboardResponse,
    // stimulus: '<p style="color:white;">Could you hear a complete sentence in the audio?</p>' +
    stimulus:
        '<h1 style="color:white;">Could you hear a complete sentence in the audio?</h1>' +
        '<h3 style="color:white;">Press "1" for Yes &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Press "0" for No</h3>',
    choices: ["1", "0"],
    response_ends_trial: true,
    data: jsPsych.timelineVariable("data"),
    on_finish: function (data) {
        writeCandidateKeys(data);
        data.index = trialIterator;
        trialIterator++;
        data.response_speech = jsPsych.data.get().last(1).values()[0].response;
    },
};

const pause = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus:
        '<p id="counter" style="text-align:center; color:white; font-size:30px">+</p>',
    choices: "NO_KEYS",
    response_ends_trial: false,
    trial_duration: 500,
};

const dataSave = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus: dataSaveAnimation(),
    choices: "NO_KEYS",
    trial_duration: 5000,
    on_finish: () => {
        const updatedScore =
            typeof score !== "undefined"
                ? score
                : jsPsych.data.get().select("score").values.slice(-1)[0]; // Replace 'score' with actual data key if necessary

        // Now, generate the thank you message with the updated score
        const thankYou = instructions[3](updatedScore);

        saveDataPromise(
            `${experimentAlias}_${subjectId}`,
            jsPsych.data.get().csv()
        )
            .then((response) => {
                console.log("Data saved successfully.", response);
                // Update the stimulus content directly via DOM manipulation
                document.querySelector("#jspsych-content").innerHTML = thankYou;
            })
            .catch((error) => {
                console.log("Failed to save data.", error);
                // Check if the error object has 'error' property and use it, otherwise convert object to string
                let errorMessage = error.error || JSON.stringify(error);
                switch (errorMessage) {
                    case '{"success":false}':
                        errorMessage =
                            "The ./data directory does not exit on this server.";
                        break;
                    case "Not Found":
                        errorMessage =
                            "There was an error saving the file to disk.";
                        break;
                    default:
                        errorMessage = "Unknown error.";
                }
                // Update the stimulus content directly via DOM manipulation
                const dataFailure = `
                <div class="error-page">
                    <p>Oh no!</p>
                    <p>An error has occured and your data has not been saved:</p>
                    <p>${errorMessage}</p>
                    <p>Please wait for the experimenter to continue.</p>
                </div>`;
                document.querySelector("#jspsych-content").innerHTML =
                    dataFailure;
            })
            .finally(() => {
                document.getElementById("unload").onbeforeunload = ""; // Removes popup
                $("body").addClass("showCursor"); // Returns cursor functionality
                closeFullscreen(); // Kill fullscreen
            });
    },
};

// Load and execute "exp/main.js" using jQuery's $.getScript method.
$.getScript("exp/main.js");
