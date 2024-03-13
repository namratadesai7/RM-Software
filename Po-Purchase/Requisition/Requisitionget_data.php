<?php 
include('../../includes/dbcon.php');

/*----------------------- code for get autocomplete item name dept plant-----------------------*/
if(isset($_POST['iname'])){

	$ii = $_POST['iname'];

	$query="SELECT a.item,a.i_code,b.category  FROM [RM_software].[dbo].[rm_item] as a join [RM_software].[dbo].[rm_category] as b ON a.c_code=b.c_code
	  WHERE a.item LIKE '$ii%' and a.c_code != 30 and a.c_code != 37";
	$result=sqlsrv_query($conn,$query);

	while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
		$response[]=array("label"=>$row['item'],"cat"=>$row['category'],"i_code"=>$row['i_code']);
	}
	echo json_encode($response);

}

/*----------------------- code for get autocomplete name and dept-----------------------*/
if (isset($_POST['name'])) {
	$ii = $_POST['name'];
	$query = "SELECT  name,department FROM [RM_software].[dbo].[online_portal_user] where name LIKE '$ii%'";
	$result = sqlsrv_query($conn,$query);
	while($row =sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
		$response[] = array("label"=>$row['name'],"dept"=>$row['department']);
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

/*----------------------- code for get autocomplete mcno dept plant-----------------------*/
if (isset($_POST['pname'])) {
	$ii=$_POST['pname'];
    $query = "SELECT pid,party_name   FROM [RM_software].[dbo].[rm_party_master] WHERE party_name LIKE '%$ii%' ";
    $result = sqlsrv_query($conn,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $response[] = array("label"=>$row['party_name'],"pid"=>$row['pid']);
    }

    echo json_encode($response);

  }


  /*----------------------- get item name for inumber in edit-----------------------*/
  if(isset($_POST['item'])){

	$ii = $_POST['item'];

	$query="SELECT a.item,a.i_code FROM [RM_software].[dbo].[rm_item] as a join [RM_software].[dbo].[rm_category] as b ON a.c_code=b.c_code
	  WHERE a.i_code =$ii ";
	$result=sqlsrv_query($conn,$query);
	

	$row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
	$a= $row['item'];
	echo $a;


  }
     //  <!-- for changing button colors       -->
	if(isset($_POST['id'])){
    	$id=$_POST['id'];
	
		$sql="SELECT count(*) as cn FROM Requisition_rate a inner join Requisition_details b on a.head_id=b.id
        inner  join Requisition_head c on c.id=b.head_id where c.id='$id'";
		$run=sqlsrv_query($conn,$sql);
		$row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);
		
		$cn=$row['cn'];    
   		echo $cn;
	}
	//  <!-- for changing button colors       -->
	if(isset($_POST['id1'])){
		$id=$_POST['id1'];

		$sql="SELECT count(*) as cn from Requisition_details a inner join Requisition_head b on a.head_id=b.id where a.head_id='$id' and a.rate_aprv='true' ";
		$run=sqlsrv_query($conn,$sql);
		$row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);
	
		$cn=$row['cn'];
	
		echo $cn;
	}
?>
