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

const version = "standard"; // Current version of the experiment
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
const urlConfig = {
    // redirect only
    standard:
        "https://yalesurvey.ca1.qualtrics.com/jfe/form/SV_bErtyAFIwnwDhWu",
};
