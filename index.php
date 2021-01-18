<?php
  require_once 'db/data.php';
  require_once 'db/config.php';
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Sine Wave Speech</title>  <!-- This is for changing the title -->
    <script src="db/validate.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="jsPsych/jspsych.js"></script>
      <script src="jsPsych/plugins/jspsych-audio-keyboard-response.js"></script>
      <script src="jsPsych/plugins/jspsych-html-keyboard-response.js"></script> 
      <link  href="jsPsych/css/jspsych.css" rel="stylesheet" type="text/css"></link> <!--link is for any other text file; href is for local directory, either a url or path -->
      <link  href="css/style.css" rel="stylesheet" type="text/css" > <!--the interpreter will take care of ordering, rel, type, href do not have to be in a specific order -->
  </head>
  <body id='unload' onbeforeunload="return areYouSure()" style="background-color:light-grey;">  <!--any time you see style = all properties that follow are inline css -->
    <?php
      if ($db_connection_status == true) {
        include_once "include/nda.php";
        // echo'<br>';
        // echo'connected';
      } else if ($db_connection_status == false) {
        include_once "include/intake.php";
        // echo'<br>';
        // echo'not connected';
      }
    ?>
  </body>
  <footer>
    <script src="exp/conf.js"></script>
    <script src="exp/fn.js"></script>
    <script src="exp/var.js"></script>
    <!-- <script src="exp/timeline.js"></script> -->
    <script type="text/javascript">
    let feedbackLink = "https://belieflab.yale.edu/omnibus/eCRFs/feedback/tasks/sws.php?candidateId=<?php echo $candidateId?>&studyId=<?php echo $studyId?>";
    let GUID = "<?php echo $subjectKey?>";
    let subjectID = "<?php echo $consortId?>";
    let sexAtBirth = "<?php echo $sexAtBirth?>";
    let siteNumber = "<?php echo $institutionAlias?>";
    let ageAtAssessment = "<?php echo $ageInMonths?>";
    </script>
  </footer>
</html>
