//***********************************//
//   EXPERIMENT CONFIGURATION FILE   //
//***********************************//

"use strict";

// Debug Mode
// Options: true, false
let debug = false; // Default debug mode setting for the experiment

// hard coding a phase will override the randomization
let phase = undefined;

// Experiment Name
const experimentName = "Sine Wave Speech"; // Name displayed in the browser title bar
const experimentAlias = "sws"; // Unique identifier for the experiment, used in data saving

// Experiment Language
const language = "english"; // Language setting for the experiment

// User Interface Theme
// Options: "light", "dark"
const theme = "dark"; // Default theme setting for the user interface

// "correct-stim" marks data collected with the corrected stimulus set:
// disjoint intel/unintel target sets, matched to their clear originals by
// BKBQ target id, and disjoint pre/post pools. Written to every row as
// data.version by wrap/lib/ids.php.
const version = "correct-stim"; // Current version of the experiment
// Add additional global configuration constants here

// Note: Uncomment the desired options. Ensure only one option per setting is active at a time.
const adminEmail = "joshua.kenney@yale.edu";
const feedbackLink = undefined;

// Repetitions
const repetitions = {
    production: undefined,
    debug: undefined,
};

// Intake Settings
const intake = {
    subject: {
        minLength: 7,
        maxLength: 7,
        prefix: "VIP",
    },
    sites: ["Vanderbilt"], // Add your sites here
    phenotypes: ["sz"], // Add your phenotypes here
    visits: [1, 3], // Define which visits are allowed (maps to stimulus sets 0, 1)
    weeks: [], // Define which weeks are allowed if using weeks instead of visits
    nih: false,
};

// Redirect Configuration (Daisy Chaining)
// Keys are looked up by `version` in getRedirectLink (wrap/lib/redirect.js:32),
// which falls back to urlConfig.default when the version has no entry. Both the
// current and previous version names are mapped, and `default` is set so a
// future version rename cannot produce an undefined redirect URL.
const urlConfig = {
    // redirect only
    "correct-stim":
        "https://yalesurvey.ca1.qualtrics.com/jfe/form/SV_bErtyAFIwnwDhWu",
    standard:
        "https://yalesurvey.ca1.qualtrics.com/jfe/form/SV_bErtyAFIwnwDhWu",
    default:
        "https://yalesurvey.ca1.qualtrics.com/jfe/form/SV_bErtyAFIwnwDhWu",
};

// Number of utterances sampled PER CONDITION. intel and unintel are disjoint
// target sets, so each is sampled independently and all three blocks present
// 2 x numberTestTrials trials: the test blocks the degraded stimuli, the
// listening block their clear originals. 90 audio trials at the current value.
// Pool per visit: visit 1 (pre) 41 intel / 42 unintel, visit 3 (post) 41 / 41,
// so the max is 41. Exceeding it aborts with a setup error in exp/main.js.
const numberTestTrials = 15;
