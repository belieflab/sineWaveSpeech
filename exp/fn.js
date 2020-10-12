function saveData(name, data){
    let xhr = new XMLHttpRequest();
    // let sec = 30;
    xhr.open('POST', 'index.php'); // 'write_data.php' is the path to the php file described above.
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({filename: name, filedata: data}));
}

function startExperiment(){
    jsPsych.init({
    timeline: timeline,
    preload_audio: [intel_45, unintel_45, unaltered_90],
    show_progress_bar: true,
    });
}