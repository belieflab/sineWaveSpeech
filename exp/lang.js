"use strict";

// Translation
// This file contains the instructions for the experiment,
// which will be translated to the language specified in exp/conf.js

let instructions = [];

// Switch version to determine the instructions for the experiment and language
/**
 * Translates the text of instuctions, buttons, etc. based on the selected language.
 *
 * @param {string} version - The version of the task defined in exp/conf.js.
 *                           Default version is "standard".
 */
switch (version) {
    default:
        var english0 = `
        <p>Welcome to the experiment!</p>
        <p>Press any key to continue.</p>`;
        var english1 = `
        <p>In this task you will listen to a series of audio clips.</p>
        <p>There are three parts parts to this experiment:</p>
        <p>1. A <strong>test block</strong>, where you respond whether or not you can hear speech in the audio.</p>
        <p>2. A <strong>listening block</strong>, where you don't need to make any choices - just listen.</p>
        <p>3. Another <strong>test block</strong>, where you again respond whether or not you can hear speech in the audio.</p>
        <p>Press any key to continue.</p>`;

        var english2 = `
        <p>In the <strong>test blocks</strong>, you will listen to a series of audio clips and will indicate whether you heard speech in each clip.</p>
        <p>Speech can be anything from single words to whole sentences.</p>
        <p>Press any key to continue.</p>;`;

        var english3 = `
        <p>In the <strong>listening block</strong>, you just have to listen to the audio recordings.<p>
        <p>No response is required.</p>
        <p>Press any key to continue.</p>`;

        var english4 = `
        <p>We will now begin the first test block.</p>`;

        var english5 = `
        <p>You will now hear some more audio clips.</p>
        <p>You do not need to respond, just listen.</p>`;

        var english6 = `
        <p>We will now begin the second test block.</p>`;

        var english7 = `
        <p>Could you hear speech in the audio?</p>
        <p>Press "1" for Yes &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Press "0" for No</p>`;

        var english8 = (score) => {
            // Initialize the base HTML content.
            let htmlContent = `
                <div class="body-white-theme">
                    <p>Thank you!</p>
                    <p>You have successfully completed the experiment and your data has been saved.</p>`;

            // Append the score to the HTML content if it is not null.
            if (score !== null) {
                htmlContent += `<p>Your final score is ${score}.</p>`;
            }

            // Append the closing HTML content.
            htmlContent += `
                    <!-- <p>To leave feedback on this task, please click the following link:</p> -->
                    <!-- <p><a href="${feedbackLink}">Leave Task Feedback!</a></p> -->
                    <!-- <p>Please wait for the experimenter to continue.</p> -->
                    <p>You may now close the experiment window at any time.</p>
                </div>`;

            return htmlContent;
        };
}

// Aggregate the instructions of your language choice
// These will be bassed to the translate function
/**
 * Translates the text of instuctions, buttons, etc. based on the selected language.
 *
 * @param {language} version - The language of the task defined exp/conf.js.
 *                             Default language is English.
 */

switch (language) {
    default:
        instructions = [
            english0,
            english1,
            english2,
            english3,
            english4,
            english5,
            english6,
            english7,
            (score) => english8(score), // Store it as a function that accepts score
        ];
        break;
}

// Translate the instructions to the specified language
translate(language, ...instructions);
