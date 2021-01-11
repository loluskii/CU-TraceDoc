<?php

require_once "session.php";
$id = $_SESSION["id"];


$sql = "SELECT form_request_type as Form_Name,  receiver_name as sent_to, request_status as status,  date_sent as Date_Uploaded  FROM requests WHERE sender_id ='$id' ";
$res = mysqli_query($con, $sql) or die("database error:". mysqli_error($con));
$data = array();
while( $rows = mysqli_fetch_assoc($res) ) {
	$data[] = $rows;
}

$result = array(
	"sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData"=>$data
);

echo json_encode($result);
exit;

?>\