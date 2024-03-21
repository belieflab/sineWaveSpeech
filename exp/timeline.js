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
    on_load: () => toggleDebugMode(),
    stimulus: instructions[0],
};

/* define instructions trial */
const instructions_1 = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus: instructions[1],
};

const instructions_2 = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus: instructions[2],
};

const instructions_3 = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus: instructions[3],
};

const instructions_4 = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus: instructions[4],
};

const beginListeningBlock = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus: instructions[5],
    choices: "NO_KEYS",
    response_ends_trial: false,
    trial_duration: 10000,
};

const beginSecondBlock = {
    type: jsPsychHtmlKeyboardResponse,
    stimulus: instructions[6],
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
    stimulus: instructions[7],
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
        const thankYou = instructions[9](updatedScore);

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
