"use strict";

const procedureInstructions = {
    //This loops over the object
    timeline: [instructions_1, instructions_2, instructions_3, instructions_4], //if you put fixation in front and the feedback after, it will display those in that order
    randomize_order: false, // This is the outer procedure, looping over the stimuli
};

const procedureTestBlock1 = {
    timeline: [fixation, stim, response],
    //timeline_variables: full_stim_shuffle.slice(0, 45), // incorrect assignment (only half played in capr)
    timeline_variables: shuffleTimelineVariables(intel_and_unintel_stim),
};

const procedureListeningBlock = {
    //This loops over the object
    timeline: [listeningStim, pause],
    timeline_variables: shuffleTimelineVariables(unaltered_stim), //This is the outer procedure, looping over the stimuli
};

const procedureTestBlock2 = {
    timeline: [fixation, stim, response],
    // timeline_variables: full_stim_shuffle.slice(45, 90), // incorrect assignment (only half played in capr)
    timeline_variables: shuffleTimelineVariables(intel_and_unintel_stim),
};

timeline.push(preload);
timeline.push(welcome);
timeline.push(procedureInstructions);
timeline.push(procedureTestBlock1); //Object oriented.
timeline.push(beginListeningBlock);
timeline.push(procedureListeningBlock); //Object oriented.
timeline.push(beginSecondBlock);
timeline.push(procedureTestBlock2); //Object oriented.
timeline.push(dataSave);

// don't allow experiment to start unless subjectId is set
if (subjectId) {
    // New jsPsych 7.x syntax
    jsPsych.run(timeline);
}
