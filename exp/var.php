<!-- Purpose of var.js: To include all global variables and server-side logic -->

<?php
/**
 * Stimulus discovery for sineWaveSpeech.
 *
 * Layout produced by stim/split_pre_post.php:
 *   stim/intel/{pre,post}/       41 / 41 sine-wave-speech stimuli
 *   stim/unintel/{pre,post}/     42 / 41 sine-wave-speech stimuli
 *   stim/unaltered/{pre,post}/   83 / 82 clear originals of the above targets
 *
 * The pre and post pools are disjoint, so a participant tested at both visits
 * never meets the same utterance twice. intel and unintel are built from
 * DISJOINT target sets, so the folders are NOT index-matched -- exp/main.js
 * pairs a degraded stimulus with its clear original by the BKBQ target id
 * parsed below, never by array position.
 *
 * BOTH pools are emitted to JavaScript rather than one being chosen here.
 * `visit` is only on the URL for the start.php / nda.php entry paths; on the
 * intake.php path it is chosen in the form and set client-side
 * (wrap/lib/validate.js), long after this PHP has run. Selecting server-side
 * would silently serve the pre pool to every intake-form participant, so
 * exp/main.js makes the choice once the value is known.
 */

/** BKBQ id of the target sentence, from a degraded or a clear filename. */
function parseTargetId($filename) {
    if (preg_match('/_T_(BKBQ\d+)\.wav_D_/i', $filename, $matches)) {
        return strtoupper($matches[1]);   // I_..._T_BKBQ0102.WAV_D_BKBQ0204.WAV
    }
    if (preg_match('/^(BKBQ\d+)\.wav$/i', $filename, $matches)) {
        return strtoupper($matches[1]);   // BKBQ0102.WAV
    }
    return null;
}

/** BKBQ id of the competing talker mixed into a degraded stimulus, else null. */
function parseDistractorId($filename) {
    if (preg_match('/_D_(BKBQ\d+)\.wav$/i', $filename, $matches)) {
        return strtoupper($matches[1]);
    }
    return null;
}

/**
 * Scan a stimulus directory and return one entry per audio file.
 *
 * Only regular .wav files are returned: scandir also reports subdirectories,
 * and handing one to jsPsychPreload as an audio path fails the preload.
 */
function getStimulusFiles($dirPath) {
    if (!is_dir($dirPath)) {
        return [];
    }
    $stimuli = [];
    foreach (scandir($dirPath) as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $fullPath = $dirPath . $entry;
        if (!is_file($fullPath)) {
            continue;
        }
        if (strtolower(pathinfo($entry, PATHINFO_EXTENSION)) !== 'wav') {
            continue;
        }
        $stimuli[] = [
            'file' => $fullPath,
            'target' => parseTargetId($entry),
            'distractor' => parseDistractorId($entry),
        ];
    }
    // Do not rely on scandir's ordering; sampling is random anyway, but a stable
    // order keeps runs reproducible when debugging.
    usort($stimuli, function ($a, $b) {
        return strcmp($a['file'], $b['file']);
    });
    return $stimuli;
}

$stimulusPools = [];
foreach (['pre', 'post'] as $pool) {
    $stimulusPools[$pool] = [
        'intel' => getStimulusFiles('./stim/intel/' . $pool . '/'),
        'unintel' => getStimulusFiles('./stim/unintel/' . $pool . '/'),
        'unaltered' => getStimulusFiles('./stim/unaltered/' . $pool . '/'),
    ];
}
$stimulusPoolsJSON = json_encode($stimulusPools);
?>

<script>
"use strict";

// Global variables for tracking trial and score
let trialIterator = 0;
let score = null;

// Both visit pools. Each entry is { file, target, distractor }; distractor is
// null for the clear originals. exp/main.js selects a pool from `visit`.
const stimulusPools = <?php echo $stimulusPoolsJSON; ?>;

/**
 * Determine which stimulus set to serve, from the participant's visit or week.
 *
 * Same convention as prl/exp/var.js and kaminBlocking/exp/var.js: the set is
 * chosen by the POSITION of the visit value in intake.visits (exp/conf.js), not
 * by the value itself. With intake.visits = [1, 3] that gives
 * visit 1 -> index 0 -> "pre" and visit 3 -> index 1 -> "post". Supporting a
 * third repeat assessment is then one entry in intake.visits plus one more
 * stimulus folder. Values are compared as strings, so ["Pre", "Post"] or
 * ["T1", "T2"] work just as well as numbers.
 *
 * IMPORTANT: this is defined here but CALLED FROM exp/main.js, which is the one
 * difference from prl and kamin. Those tasks call it at the top level of
 * exp/var.js, which is safe because wrap/lib/validate.js loads var.js only after
 * the intake form is submitted. sineWaveSpeech has no var.js -- this file is
 * rendered inline by index.php at page load, before the intake form sets `visit`
 * client-side (wrap/lib/validate.js). Calling it at top level here would read an
 * empty visit and hand every intake-form participant the "pre" set.
 *
 * @returns {string} the stimulus set name; throws and renders an error page if
 *                   the visit/week cannot be resolved to an available set.
 */
function getStimulusSet() {
    let setIndex = null;
    let visitOrWeekValue = null;

    // Default to set index 0 if no visit or week is specified
    if (
        (visit === null && week === null) ||
        (typeof visit === "undefined" && typeof week === "undefined")
    ) {
        setIndex = 0;
    }

    // Check if visit is defined and valid
    if (typeof visit !== "undefined" && visit !== null) {
        visitOrWeekValue = visit; // Keep as-is, don't convert to int

        if (
            typeof intake !== "undefined" &&
            intake.visits &&
            intake.visits.length > 0
        ) {
            // Convert everything to strings for comparison to be flexible
            const stringVisits = intake.visits.map((v) => String(v));
            const visitString = String(visitOrWeekValue);
            const visitIndex = stringVisits.indexOf(visitString);

            if (visitIndex !== -1) {
                setIndex = visitIndex;
                console.log(
                    `Visit ${visit} found at index ${visitIndex} in intake.visits`,
                );
            } else {
                console.error(
                    `Visit ${visit} not found in allowed visits: ${stringVisits.join(", ")}`,
                );
                setIndex = null; // Explicitly set to null to indicate error
            }
        }
    }

    // Check if week is defined and valid (only if visit wasn't valid)
    if (setIndex === null && typeof week !== "undefined" && week !== null) {
        visitOrWeekValue = week; // Keep as-is

        if (
            typeof intake !== "undefined" &&
            intake.weeks &&
            intake.weeks.length > 0
        ) {
            const stringWeeks = intake.weeks.map((v) => String(v));
            const weekString = String(visitOrWeekValue);
            const weekIndex = stringWeeks.indexOf(weekString);

            if (weekIndex !== -1) {
                setIndex = weekIndex;
                console.log(
                    `Week ${week} found at index ${weekIndex} in intake.weeks`,
                );
            } else {
                console.error(
                    `Week ${week} not found in allowed weeks: ${stringWeeks.join(", ")}`,
                );
                setIndex = null;
            }
        }
    }

    // Available stimulus sets. These are the pre/post folder names under
    // stim/{intel,unintel,unaltered}/ and must stay aligned with intake.visits.
    const availableSets = ["pre", "post"];

    // If no valid visit/week was found, or if the index is out of bounds
    if (setIndex === null || setIndex >= availableSets.length) {
        let errorMessage = "";

        if (setIndex === null) {
            if (typeof visit !== "undefined" && visit !== null) {
                const allowedVisitsStr = intake.visits
                    ? intake.visits.map((v) => String(v)).join(", ")
                    : "None";
                errorMessage = `Error: Visit "${visit}" is not in the allowed visits: [${allowedVisitsStr}]`;
            } else if (typeof week !== "undefined" && week !== null) {
                const allowedWeeksStr = intake.weeks
                    ? intake.weeks.map((v) => String(v)).join(", ")
                    : "None";
                errorMessage = `Error: Week "${week}" is not in the allowed weeks: [${allowedWeeksStr}]`;
            } else {
                errorMessage = "Error: No valid visit or week specified";
            }
        } else {
            errorMessage = `Error: No stimulus set available for ${
                visit ? "visit " + visit : ""
            }${week ? "week " + week : ""} (index: ${setIndex}). Only ${
                availableSets.length
            } sets available.`;
        }

        console.error(errorMessage);

        document.body.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                        background: white; z-index: 9999; display: flex;
                        align-items: center; justify-content: center;
                        font-family: Arial, sans-serif;">
                <div style="text-align: center; max-width: 600px; padding: 40px;
                            border: 2px solid #ff0000; border-radius: 10px;
                            background: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <h2 style="color: #ff0000; margin-top: 0;">Stimulus Set Not Found</h2>
                    <p style="font-size: 16px; margin: 20px 0;">${errorMessage}</p>
                    <p style="margin: 15px 0;">Only ${availableSets.length} sets are available for this experiment: ${availableSets.join(", ")}.</p>
                    <p style="margin: 15px 0;"><strong>Available visits:</strong> ${
                        intake.visits && intake.visits.length ? intake.visits.join(", ") : "None"
                    }</p>
                    <p style="margin: 15px 0;"><strong>Available weeks:</strong> ${
                        intake.weeks && intake.weeks.length ? intake.weeks.join(", ") : "None"
                    }</p>
                    <p style="margin: 20px 0;">Please contact the administrator at: <a href="mailto:${adminEmail}" style="color: #0066cc;">${adminEmail}</a></p>
                </div>
            </div>
        `;

        throw new Error("Required stimulus set not available");
    }

    const stimulusSet = availableSets[setIndex];
    console.log("Using stimulus set:", stimulusSet, "(index:", setIndex, ")");
    return stimulusSet;
}

// Function to create stimulus objects for an array of stimulus records
function createStimuli(array, part, stimVisit) {
    return array.map((record) => ({
        stimulus: record.file,
        data: {
            test_part: part,
            stim: record.file,
            target: record.target,
            distractor: record.distractor,
            stim_visit: stimVisit,
        },
    }));
}

</script>
