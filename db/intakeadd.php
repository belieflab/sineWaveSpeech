<?php
//======================================================================
// INTAKE ADD
//======================================================================
include_once (realpath(dirname(__FILE__).'/path.php'));
include_once (ROOT_PATH . '/php/config.php');
/* Check Role */
include_once (ROOT_SRC_PATH .'/check_admin.php');
$consent_id = $_POST['consent_id'];
$handedness = $_POST['handedness'];

$insert_subject = $db_connection->prepare(
	"INSERT INTO subject (
		consent_id,
        handedness) VALUES(?,?);");
$insert_subject->bind_param("is", 
  $consent_id,
  $handedness);
$insert_subject->execute();
$insert_subject->close();
header("Location: ". BASE_URL ."/include/intake_confirmation.php");
?>