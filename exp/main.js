// procedure

let procedureInstructions = { //This loops over the object
    timeline: [instructions_1, instructions_2], //if you put fixation in front and the feedback after, it will display those in that order
    randomize_order: false,// This is the outer procedure, looping over the stimuli
}

let procedureTestBlock1 = { //This loops over the object
    timeline: [fixation, block1Stim, response], //if you put fixation in front and the feedback after, it will display those in that order
    randomize_order: false,// This is the outer procedure, looping over the stimuli
    timeline_variables: full_stim_shuffle.slice(0,45),
}

let procedureListeningBlock = { //This loops over the object
    timeline: [listeningStim, pause], //if you put fixation in front and the feedback after, it will display those in that order
    randomize_order: false,// This is the outer procedure, looping over the stimuli
    timeline_variables: unaltered_stim_shuffle,
}

let procedureTestBlock2 = { //This loops over the object
    timeline: [fixation, block1Stim, response], //if you put fixation in front and the feedback after, it will display those in that order
    randomize_order: false,// This is the outer procedure, looping over the stimuli
    timeline_variables: full_stim_shuffle.slice(45,90),
}

timeline.push(welcome)
timeline.push(procedureInstructions)
timeline.push(procedureTestBlock1) //Object oriented.
timeline.push(beginListeningBlock)
timeline.push(procedureListeningBlock) //Object oriented.
timeline.push(beginSecondBlock)
timeline.push(procedureTestBlock2) //Object oriented.
timeline.push(end)
