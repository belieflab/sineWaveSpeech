<div class="screening" style="background-color:gray; text-align:center; margin:35px; vertical-align:middle">
  <div id="intake">
  <br>
  <h1 style="text-align:center;">CAPR Participant Intake</h1>


    <p><b>Select your Research Site:</b></p>

    <select name="facility" id="siteid">
        <option value="">---</option>
        <option value="Yale">Yale</option>
        <option value="Georgia">Georgia</option>
        <option value="Northwestern">Northwestern</option>
        <option value="Temple">Temple</option>
        <option value="Maryland">Maryland</option>
        <option value="Maryland">Emory</option>
    </select>
    <label for="facility"></label>

    <!-- <form name="myForm" action="/action_page.php" onsubmit="return validateForm()" method="post">
    Name: <input type="text" name="fname">
    <input type="submit" value="Submit">
    </form> -->

    <!-- <form action="/action_page.php" method="post">
        <input type="text" name="fname" required>
        <input type="submit" value="Submit">
    </form> -->

    <form action="<?php echo SIGNUP_VIEW ?>/post/intakeadd.php" method="post">
    <p><b>Subject ID Number:</b></p>
    <input id="subjectid" type="number" required name="consent_id">
</form>
    <!-- <button onclick="submitIntake()">submit subjectid</button> -->

    <!-- <p><b>Participant DOB</b></p>
    <p><b>Enter as MM/DD/YYYY</b></p>
    <p style="color:red">*must provide value</p>
    <input type="date">
    <form> -->
   
  <!-- <form action="< ?php echo SIGNUP_VIEW ?>/post/intakeadd.php" method="post">

    <p><b>Which is your dominant hand?</b></p>
    
        <input id="rightHanded" type="radio" value="right" name="handedness">
        <label for="right">Right</label><br>
        <input id="leftHanded" type="radio" value="left" name="handedness">
        <label for="left">Left</label><br>
  </form> -->

    <!-- <input type="checkbox"><p>Left</p> -->

  <form>
    <p><b>Before proceeding to the task, please confirm that the following are true:</b></p>
    <label class="container">Screen brightness is up to 100% &nbsp&nbsp&nbsp&nbsp   
    <input type="checkbox">
  </label>

<!-- <label class="container">Headphones are plugged in
    <input type="checkbox">
</label>
<br> -->
    <!-- <label class="container">Volume is up to 100% &nbsp&nbsp&nbsp&nbsp
    <input type="checkbox">
</label> -->
</form>

<br>
<button class="loadMain" onclick="submitIntake();" type="button">submit</button>

</div>
<div id="validation">
    <br>
    <form>


</form>


</div>
<button id="nextButton" style="display: none" onclick="startExperiment()">CONSENT/NEXT</button>
<br>
</div>

<script type="text/javascript" src="js/jquery-git.js"></script>

<script>$("button.loadMain").click(function(){

    $.getScript("exp/var.js");
    $.getScript("exp/timeline.js");
    setTimeout(1000);
    $.getScript("exp/main.js");

    // $.load("include/consent.php");
  }); </script>


<script>

</script>


<!-- <label class="container">One
  <input type="checkbox" checked="checked">
  <span class="checkmark"></span>
</label>

<label class="container">Two
  <input type="checkbox">
  <span class="checkmark"></span>
</label>

<label class="container">Three
  <input type="checkbox">
  <span class="checkmark"></span>
</label>

<label class="container">Four
  <input type="checkbox">
  <span class="checkmark"></span>
</label> -->