<?php 
include('../includes/dbcon.php');

/*----------------------- code for get autocomplete item name dept plant-----------------------*/
if(isset($_POST['iname'])){

	$ii = $_POST['iname'];

	$query="SELECT a.item,a.i_code,b.category  FROM [RM_software].[dbo].[rm_item] as a join [RM_software].[dbo].[rm_category] as b ON a.c_code=b.c_code
	  WHERE a.item LIKE '%$ii%' and a.c_code != 30 and a.c_code != 37";
	$result=sqlsrv_query($conn,$query);

	while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
		$response[]=array("label"=>$row['item'],"cat"=>$row['category'],"i_code"=>$row['i_code']);
	}
	echo json_encode($response);

}

/*----------------------- code for get autocomplete name-----------------------*/
if (isset($_POST['name'])) {
	$ii = $_POST['name'];
	$query = "SELECT * FROM [RM_software].[dbo].[online_portal_user] where name LIKE '%$ii%'";
$result = sqlsrv_query($conn,$query);
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
	$response[] = array("label"=>$row['name']);
}
echo json_encode($response);
}

/*----------------------- code for get autocomplete mcno dept plant-----------------------*/
if(isset($_POST['mc'])){

	$ii = $_POST['mc'];

	$query="SELECT mc ,dpnt, plant   FROM [RM_software].[dbo].[mc_master] WHERE mc LIKE '%$ii%' and plant is not null";
	$result=sqlsrv_query($conn,$query);

	while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
		$response[]=array("label"=>$row['mc'],"dname"=>$row['dpnt'],"plant"=>$row['plant']);
	}
	echo json_encode($response);

}
?>
