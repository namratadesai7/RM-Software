<?php 
include('../includes/dbcon.php');
/*----------------------- code for get autocomplete mcno-----------------------*/
if (isset($_POST['name'])) {
	$ii = $_POST['name'];
	$query = "SELECT * FROM [RM_software].[dbo].[online_portal_user] where name LIKE '%$ii%'";
$result = sqlsrv_query($conn,$query);
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
	$response[] = array("label"=>$row['name']);
}
echo json_encode($response);
}



?>
