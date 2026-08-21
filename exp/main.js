"use strict";

/**
 * Renders a blocking setup-error screen instead of starting the experiment.
 *
 * Used for conditions that would produce unusable data if the run continued,
 * rather than letting the task render a blank page or run degraded.
 */
function abortWithSetupError(consoleMessage, participantMessage) {
    console.error("sineWaveSpeech aborted: " + consoleMessage);
    document.body.innerHTML =
        '<div style="margin:80px auto;max-width:600px;font-family:sans-serif;text-align:center;">' +
        "<h2>Setup error</h2>" +
        "<p>" +
        participantMessage +
        "</p>" +
        "<p>Please contact the experimenter and reopen the original study link.</p>" +
        "</div>";
}

// Resolve the visit (or week) to a stimulus pool. getStimulusSet is defined in
// exp/var.php and follows the same convention as prl and kaminBlocking: the set
// is chosen by the POSITION of the visit value in intake.visits (exp/conf.js),
// so intake.visits = [1, 3] maps visit 1 -> "pre" and visit 3 -> "post". The two
// pools are disjoint, so a participant is never re-tested at their second visit
// on an utterance they already heard at the first.
//
// It is called here rather than at the top of exp/var.php because `visit` is not
// populated until validation completes: wrap/lib/ids.php sets it at page load on
// the URL entry paths, but wrap/lib/validate.js sets it from the intake form,
// long after var.php has been rendered. wrap/lib/validate.js loads this file
// after both, so the value is always in place by now.
//
// An unresolvable visit renders an error page and throws from inside
// getStimulusSet; a missing visit AND week defaults to set index 0 ("pre"),
// matching prl and kaminBlocking.
const stimVisit = getStimulusSet();
const pool = stimulusPools[stimVisit];

const intel_stim = createStimuli(pool.intel, "intel", stimVisit);
const unintel_stim = createStimuli(pool.unintel, "unintel", stimVisit);
const unaltered_stim = createStimuli(pool.unaltered, "unaltered", stimVisit);

const poolSize = Math.min(intel_stim.length, unintel_stim.length);

// numberTestTrials larger than the pool would silently run fewer trials than
// configured, so treat it as a setup error rather than quietly diverging.
const poolTooSmall = numberTestTrials > poolSize;

// In debug, sample exactly one intel and one unintel target, so all three
// blocks run 2 trials on the same two utterances and debug mirrors production.
const sampleSize = debug ? 1 : numberTestTrials;

const intelSubset = shuffleArray(intel_stim).slice(0, sampleSize);
const unintelSubset = shuffleArray(unintel_stim).slice(0, sampleSize);

// Both test blocks present the same 2 x sampleSize stimuli, reshuffled per
// block. shuffleArray is used directly rather than shuffleTimelineVariables:
// the latter also truncates to one item in debug, which would leave the three
// blocks drawing unrelated stimuli. In production the two are equivalent.
const testBlockPool = intelSubset.concat(unintelSubset);

// Listening block: the clear original of every tested target, so each sampled
// utterance is exposed exactly once between the two test blocks. Matched by id.
const unalteredByTarget = new Map(
    unaltered_stim.map((stimulus) => [stimulus.data.target, stimulus]),
);

const listeningPool = testBlockPool.map((tested) => {
    const clear = unalteredByTarget.get(tested.data.target);
    if (clear === undefined) {
        return undefined;
    }
    // Record which condition the exposed utterance was tested in, so the CSV can
    // separate exposure of an intel target from exposure of an unintel target.
    return {
        ...clear,
        data: { ...clear.data, exposed_condition: tested.data.test_part },
    };
});

// A missing clear original means that utterance would be tested but never
// exposed, which breaks the priming manipulation for that item.
const unexposedTargets = testBlockPool
    .filter((tested, i) => listeningPool[i] === undefined)
    .map((tested) => tested.data.target);

const procedureInstructions = {
    //This loops over the object
    timeline: [instructions_1, instructions_2, instructions_3, instructions_4], //if you put fixation in front and the feedback after, it will display those in that order
    randomize_order: false, // This is the outer procedure, looping over the stimuli
};

const procedureTestBlock1 = {
    timeline: [fixation, stim, response],
    timeline_variables: shuffleArray(testBlockPool),
};

const procedureListeningBlock = {
    //This loops over the object
    timeline: [listeningStim, pause],
    timeline_variables: shuffleArray(listeningPool), //This is the outer procedure, looping over the stimuli
};

const procedureTestBlock2 = {
    timeline: [fixation, stim, response],
    timeline_variables: shuffleArray(testBlockPool),
};

// Preload only the files this run will actually play. A visit pool holds ~166
// stimuli while a run uses 2 x sampleSize of them plus their clear originals.
preload.audio = [
    ...new Set(
        testBlockPool
            .concat(listeningPool.filter(Boolean))
            .map((stimulus) => stimulus.stimulus),
    ),
];

timeline.push(preload);
timeline.push(welcome);
timeline.push(procedureInstructions);
timeline.push(procedureTestBlock1); //Object oriented.
timeline.push(beginListeningBlock);
timeline.push(procedureListeningBlock); //Object oriented.
timeline.push(beginSecondBlock);
timeline.push(procedureTestBlock2); //Object oriented.
timeline.push(dataSave);

// Only start once the participant id and the stimulus set check out. The visit
// itself was already resolved (or rejected) by getStimulusSet above.
if (!subjectId) {
    abortWithSetupError(
        "subjectId is missing.",
        "This task could not start because no participant ID was provided.",
    );
} else if (poolTooSmall) {
    abortWithSetupError(
        `numberTestTrials is ${numberTestTrials} but the ${stimVisit} pool holds only ${poolSize} per condition.`,
        "This task could not start because it is configured for more trials than there are stimuli.",
    );
} else if (unexposedTargets.length > 0) {
    abortWithSetupError(
        "no clear original found for target(s): " + unexposedTargets.join(", "),
        "This task could not start because the stimulus set is incomplete.",
    );
} else {
    // New jsPsych 7.x syntax
    jsPsych.run(timeline);
}
