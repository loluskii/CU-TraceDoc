<?php

require_once "session.php";
$id = $_SESSION["id"];


$sql = "SELECT form_name as Form_Name,  form_description as Form_Key,  date_uploaded as Date_Uploaded  FROM uploaded_forms WHERE uploader_id ='$id' ";
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

?>