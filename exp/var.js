let workerID = prompt( 'Subject ID' );

const intel = ['102'];
const unintel = ['102'];
const unaltered = ['0102'];

let intel_45 = [];
    for (let i = 0; i < intel.length ; i++){
        intel_45.push("sounds/intel_45/I_BKBQ0"+intel[i]+".wav");
    }

let unintel_45 = [];
    for (let i = 0; i < unintel.length ; i++){
        unintel_45.push("sounds/unintel_45/U_BKBQ0"+unintel[i]+".WAV");
    }

let unaltered_90 = [];
    for (let i = 0; i < unaltered.length ; i++){
        unaltered_90.push("sounds/unaltered_45/BKBQ"+unaltered[i]+".WAV");
    }

let intel_stim=[];
    for (let i = 0; i < intel.length ; i++){
        intel_stim.push({stimulus: intel_45[i], data: {test_part: 'intel'}});
    }

let unintel_stim=[];
    for (let i = 0; i < unintel.length ; i++){
        unintel_stim.push({stimulus: unintel_45[i], data: {test_part: 'intel'}});
    }

let unaltered_stim=[];
    for (let i = 0; i < unaltered.length ; i++){
        unaltered_stim.push({stimulus: unaltered_90[i], data: {test_part: 'intel'}});
    }

let full_stim = intel_stim.concat(unintel_stim);

let full_stim_shuffle = jsPsych.randomization.repeat(full_stim, 1); //shuffled array no repeats

let unaltered_stim_shuffle = jsPsych.randomization.repeat(unaltered_stim.shuffle, 1);