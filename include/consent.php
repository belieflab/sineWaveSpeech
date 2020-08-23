<script>
// show consent page when loaded 
window.onload = function() {
  $(".loading").css({display: "none"});
  $(".consent").css({display: "block"});
  $(".buttonHolder").css({display: "block"});
};
</script>

<!-- Standard Consent Form Template -->

<div class="loading centeredDiv">
<h1 class="loading">Loading...</h1>
</div>
<div id="consentHolder" class="consent centeredDiv">
<h3 id="consentPreamble" class="consent" style="color:white;">In order for us to conduct this test online, we need to include the standard consent form below. <br /> <br /> </h3>
<div id="consentForm" class="consent consent-box"> 
<h2 id="consentHeading" class="consent">
    CONSENT FOR PARTICIPATION IN RESEARCH STUDY
    <br>
    Yale University Department of Psychiatry
</h2> 

<h2>
    
</h2>
<p id="consentInstructions" class="consent">
    <b>Study Title:</b> CAPR<!-- Text in between the <b> <b> bolds the text -->
    <br><br> <!-- This is for adding line breaks, you can add them at the end of a line or on their own -->
    <b>Principal Investigator:</b> Philip R. Corlett, PhD
    <br><br>
    <b>Funding Source:</b> department funds
    <br><br>
    <u><b>Invitation to Participate and Description of Project</b></u>
    <br>
    You are invited to participate in a research study that concerns psychological processes related to beliefs, perceptions, and decisions. Due to the nature of psychology experiments, we cannot explain the precise purpose of the experiment until after the session is over. Afterwards, the experimenter will be happy to answer any questions you might have about the purpose of the study.
    <br><br>
    <u><b>Description of Procedures</b></u>
    <br>
    If you agree to participate in this study, this task will require you to (1) press (tap) the spacebar as quickly as you can for 10 seconds and (2) press (tap) the spacebar in time with the sound you hear and the without it. You will never be asked for personally identifiable information such as your name, address, or date of birth. 
    <br><br>
    The experiment is designed to take approximately 20 minutes. 
    <br><br>
    <u><b>Risks and Inconveniences</b></u>
    <br>
    There are little to no risks associated with this study. Some individuals may experience mild boredom. 
    <br><br>
    <u><b>Economic Considerations</b></u>
    <br>
    You will receive the payment specified in broader consent form completed when you first started the study.  
    <br><br>
    <u><b>Confidentiality</b></u>
    <br>
    We will never ask for your name, birth date, email or any other identifying piece of information. Your data will be pooled with those of others, and your responses will be completely anonymous. We will keep this data indefinitely for possible use in scientific publications and presentations. 
    <br><br>
    <u><b>Voluntary Participation</b></u>
    <br>
    Your participation in this study is completely voluntary. You are free to decline to participate or to end participation at any time by simply closing your browser window. However, please note that if you stop your participation in the study, you will only be compensated for the duration of your participation. 
    <br><br>
    <u><b>Questions or Concerns</b></u>
    <br>
    If you have any questions or concerns regarding the experiment, you may contact us here at the lab by emailing adapt@northwestern.edu If you have general questions about your rights as a research participant, you may contact the Yale University Human Investigation Committee at 203-785-4688 or human.subjects@yale.edu (HSC# 2000026290).

</p>
</div>


</div> <!-- This is testing our settings to the computer being used and if it doesn't fit, then it knows it a mobile device -->
<div id="attritionHolder" class="attrition centeredDiv"> 
<p id="attritionInstructions" class="attrition"></p>
<input required type="text" id="attritionAns" class="attrition" size="60" style="width:inherit; height:17px; font-size:15px; margin: 0 auto;" />
</div>
<div id="errorMessageHolder" class="error centeredDiv">
<p id="mobileBrowserErrorMessage">You cannot access this test from a mobile browser. Please use a desktop computer to complete the task.</p>
<p id="workerIDErrorMessage">You are ineligible for this task, since your worker ID has been recorded as participating in this task already. 
Please return the HIT.</p>
</div>



<div id="nextButtonHolder" class="buttonHolder">
<button id="nextButton" onclick="startExperiment()">CONSENT/NEXT</button>
</div>

