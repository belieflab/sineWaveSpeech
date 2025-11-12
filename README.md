# 🃏 Sine Wave Speech (sws)

Welcome to the Sine Wave Speech task! In this task participants will hear audio clips and are asked to decide if they heard a complete sentence in the audio. They are instructed to press ‘1’ if they hear a complete sentence and ‘0’ if they did not. Following that portion, they are instructed to listen to some sentences and not respond. Then they will complete the first part of the task again.

**Total run time: 15 minutes**

See our recent preprint:
```
https://osf.io/preprints/psyarxiv/g75tc_v1
``` 

## 🚀 Getting Started

### Clone the Repository

```bash
git clone --recurse-submodules -j4 git@github.com:belieflab/sineWaveSpeech.git && cd sineWaveSpeech &&
git submodule foreach --recursive 'git checkout $(git config -f $toplevel/.gitmodules submodule.$name.branch || echo main)'
```

> 💡 This will initialize the `wrap` submodule

### Stay Updated

When pulling changes, run:

```bash
./sync.sh
```

> 🔄 This ensures the `wrap` submodule is up-to-date

### ⚙️ Configuration

Modify `exp/conf.js` to customize your experiment. Key options include:

```javascript
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
```

### 🌐 Online Administration

For platforms like PROLIFIC, CloudResearch, MTurk, or Connect, use:

```
https://web-url-of-your-website.com/study-name/sineWaveSpeech
```

## 🧠 Task Versions

### CNTRACS 2024
cntracs: 90 pre( intel/unintel), 90 unaltered, 90 post (intel/unintel) = 270
participants heard all stimuli, randomized at each timepoint
This is considered the "correct" administration

### CAPR 2021
capr: 45 pre (intel/unintel), 90 unaltered, 45 post (intel/unintel) = 180
this means participants did not hear all combinations of intel/unintel pre-post but rather an asymmetrical set
both the pre- and post- sets were randomized from the same initial pool of 90 intel/unintel SORRY :) Josh
maybe allows for more "interesting" modeling on a subject-by-subject basis as we can see what happens when subjects did or did not hear pre- post- :D

## Task Info
- 180 or 270 trials (see above)

## 🛠 Development Guide

### Dependencies
- PHP version 8.x
- jsPsych version 7.x

### XAMPP Setup
1. [Download XAMPP](https://www.apachefriends.org/download.html)
2. Start XAMPP and services
3. Clone the repository into htdocs
4. Modify permissions
5. Launch the experiment

## 📊 Output Variables

We're working on including:
- start_time, end_time
- browser details
- response or response_speech (people heard or not the speech)
- test_part (3 levels: unintel, intel, and unaltered)

## 🚧 To-Do
- Implement image preloading in version 7

---

🃏 Ready to dive in? Let's explore how auditory priors are formed! 🧠🔍
