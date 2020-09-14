const intel = ['102', '103', '106', '109', '110', '112', '114', '115', '201', '202', '203', '205', '206', '209', '214', '215', '304', '306', '307', '308', '309', '311', '312', '315', '316', '401', '406', '407', '409', '411', '412', '413', '416', '501', '505', '511', '512', '513', '514', '603', '607', '608', '609', '612', '613'];
const unintel = ['102', '103', '106', '109', '110', '112', '114', '115', '201', '202', '203', '205', '206', '209', '214', '215', '304', '306', '307', '308', '309', '311', '312', '315', '316', '401', '406', '407', '409', '411', '412', '413', '416', '501', '505', '511', '512', '513', '514', '603', '607', '608', '609', '612', '613'];
const unaltered = ['0102', '0103', '0106', '0109', '0110', '0112', '0114', '0115', '0201', '0202', '0203', '0205', '0206', '0209', '0214', '0215', '0304', '0306', '0307', '0308', '0309', '0311', '0312', '0315', '0316', '0401', '0406', '0407', '0409', '0411', '0412', '0413', '0416', '0501', '0505', '0511', '0512', '0513', '0514', '0603', '0607', '0608', '0609', '0612', '0613', '1702', '1704', '1706', '1707', '1710', '1711', '1714', '1715', '1801', '1803', '1807', '1808', '1814', '1815', '1816', '1902', '1904', '1905', '1910', '1912', '1913', '1914', '1915', '1916', '2001', '2002', '2004', '2008', '2010', '2011', '2012', '2013', '2014', '2016', '2102', '2103', '2105', '2106', '2107', '2108', '2109', '2111', '2112', '2114', '2116'];
let experimentIterator = 1;

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
        intel_stim.push({stimulus: intel_45[i], data: {test_part: 'intel', stim: intel[i]+'.wav'}});
    }

let unintel_stim=[];
    for (let i = 0; i < unintel.length ; i++){
        unintel_stim.push({stimulus: unintel_45[i], data: {test_part: 'unintel', stim: intel[i]+'.wav'}});
    }

let unaltered_stim=[];
    for (let i = 0; i < unaltered.length ; i++){
        unaltered_stim.push({stimulus: unaltered_90[i], data: {test_part: 'unaltered', stim: intel[i]+'.wav'}});
    }

let full_stim = intel_stim.concat(unintel_stim);

let full_stim_shuffle = jsPsych.randomization.repeat(full_stim, 1); //shuffled array no repeats

let unaltered_stim_shuffle = jsPsych.randomization.repeat(unaltered_stim, 1); //shuffled array no repeats