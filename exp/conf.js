//***********************************//
//   EXPERIMENT CONFIGURATION FILE   //
//***********************************//

"use strict";

// Debug Mode
// Options: true, false
let debug = true; // Default debug mode setting for the experiment

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

// Global variables for sites and phenotypes
const sites = ["WashU", "UChicago", "MPRC", "UMinnesota", "UCI"];
const phenotypes = ["sz"];
