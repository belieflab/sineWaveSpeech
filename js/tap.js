function move() { // function definition
    var width = document.getElementById("goTap").style.width; // variable assignment of width property of keyBar
    width = parseInt(width.slice(0, -1)); // variable reassignment
      if (width >= 100) {
        width = document.getElementById("goTap").style.width="0%";
      } else {
        width++;
        width = document.getElementById("goTap").style.width=String(width)+"%";
      }
    }