function saveData(name, data){
    let xhr = new XMLHttpRequest();
    // let sec = 30;
    xhr.open('POST', 'index_working.php'); // 'write_data.php' is the path to the php file described above.
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({filename: name, filedata: data}));
}