<?php
$post_data = json_decode(file_get_contents('php://input'), true); 
// the directory "data" must be writable by the server
$name = "data/".$post_data['filename'].".csv"; 
$data = $post_data['filedata'];
// write the file to disk
file_put_contents($name, $data);

include_once ("db/config.php");

$studyId = $_GET["studyId"];
$candidateId = $_GET["candidateId"];
if (isset($candidateId)) {
  $query = "SELECT GUID from candidate where sub_id = $candidateId";
  $prepare = $db_connection->prepare($query);
  $prepare->execute();
  $result = $prepare->get_result();
  $row = $result->fetch_assoc();
  $guid = $row["GUID"];
  $prepare->close();
  } else {
}
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Sine Wave Speech</title>  <!-- This is for changing the title -->
    <script src="db/submit.js"></script>
    <script src="jsPsych/jspsych.js"></script>
      <script src="jsPsych/plugins/jspsych-audio-keyboard-response.js"></script>
      <script src="jsPsych/plugins/jspsych-html-keyboard-response.js"></script> 
      <link  href="jsPsych/css/jspsych.css" rel="stylesheet" type="text/css"></link> <!--link is for any other text file; href is for local directory, either a url or path -->
      <link  href="css/style.css" rel="stylesheet" type="text/css" > <!--the interpreter will take care of ordering, rel, type, href do not have to be in a specific order -->
  </head>
  <body id='unload' onbeforeunload="return areYouSure()" style="background-color:light-grey;">  <!--any time you see style = all properties that follow are inline css -->
    <?php include_once 'include/intake.php';?>
  </body>
  <footer>
    <script src="js/jquery-git.js"></script>
    <script src="exp/conf.js"></script>
    <script src="exp/fn.js"></script>
    <script src="exp/var.js"></script>
    <!-- <script src="exp/timeline.js"></script> -->
    <script type="text/javascript">
    let feedbackLink = "https://omnibus.sh/eCRFs/feedback/tasks/sws.php?candidateId=<?php echo $candidateId?>&studyId=<?php echo $studyId?>";
    </script>
  </footer>
</html>
