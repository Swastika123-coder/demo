<?php
function insertActivity($activity_details,$con,$session_user_code){
	$activity_code = "ACT_".uniqid().time();
	mysqli_query($con,"insert into user_activity (id, activity_code, user_code, activity_details) values(null,'".$activity_code."','".$session_user_code."','".$activity_details."')");
}
?>