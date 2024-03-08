<?php
include('../includes/dbcon.php');
session_start();

if(isset($_POST["save"])){
    $date=$_POST['date'];
    $prepby=$_POST['prepby'];
    $udept=$_POST['udpt'];
    $appby=$_POST['appby'];
    $rem=$_POST['rem'];

    $idesc=$_POST['item'];
    $icode=$_POST['i_code'];
    $qty=$_POST['qty'];
    $unit=$_POST['unit'];
    $appcost=$_POST['appcost'];
    $mcno=$_POST['mcno'];
    $dept=$_POST['dept'];
    $plant=$_POST['plant'];
    $cat=$_POST['cat'];
    $state=$_POST['state'];
    $type=$_POST['type'];
    $opstat=$_POST['opstat'];


    $sql="SELECT MAX(id) as requisitionno from Requisition_head";
    $run=sqlsrv_query($conn,$sql);
    $row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);
    $reqno=$row['requisitionno']+1;


    $sql1="INSERT INTO Requisition_head(id,required_date,indentor,approved_by,remarks,username,indentor_dept,createdBy)
            VALUES('$reqno','$date',' $prepby',' $appby','$rem','$prepby','$udept','".$_SESSION['uname']."')";
    $run1 = sqlsrv_query($conn,$sql1);

    if($run1){
        foreach($icode as $key => $value){
            $sql2="INSERT INTO Requisition_details(item,qnty,unit,apx_cost,mc,department,plant,category,state,type,old_part_stat,head_id,createdBy) 
                    VALUES('".$value."','".$qty[$key]."','".$unit[$key]."','".$appcost[$key]."','".$mcno[$key]."','".$dept[$key]."','".$plant[$key]."','".$cat[$key]."',
                    '".$state[$key]."','".$type[$key]."','".$opstat[$key]."','$reqno','".$_SESSION['uname']."')";
            $run2=sqlsrv_query($conn,$sql2);

        }
        if($run2){
            $_SESSION['req_id']=$reqno;
            header("location:Requisition.php");
        }else{
            print_r(sqlsrv_errors());
        }
    }else{
        print_r(sqlsrv_errors());
    }
}


// MA form
if(isset($_POST['maform'])){
    $id=$_POST['id'];
    $check=$_POST['checkbox_state'];

    foreach($id as $key => $value){
        $sql1="SELECT req_aprv from requisition_details where id='".$value."' ";
        $run1=sqlsrv_query($conn,$sql1);
        $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);
    
        if( $row1['req_aprv']==='1'){
            continue;
        }

            if(  $check[$key]==='1'){
                $sql="UPDATE Requisition_details SET req_aprv='1' ,aprvBy='".$_SESSION['uname']."',  aprvAt='".date('Y-m-d')."' where id='".$value."'";
                $run=sqlsrv_query($conn,$sql);
                echo $sql;
           
            if (!$run) {
                print_r(sqlsrv_errors());
            }
        }
    }
    header('location:Requisition.php');
    
}

//rate add in requisition

if(isset($_POST['smaddrateform'])){
    $reqno=$_POST['reqid'];
    $pid=$_POST['pid'];
    $rate=$_POST['rate'];
    
  

    foreach($pid as $key=> $value){

        $sql1="SELECT COUNT(*) AS cn from Requisition_rate where party_id='".$value."'";
        $run1=sqlsrv_query($conn,$sql1);
        $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);

        if($row1['cn']>0){
            $run=true;
            continue;
        }else{
            $sql="INSERT INTO Requisition_rate(party_id,rate,head_id,createdBy) VALUES('".$value."','".$rate[$key]."','".$reqno."','".$_SESSION['uname']."')";
            $run=sqlsrv_query($conn,$sql);
        }
      
    }
    if($run){
        ?>

        <script>
        //alert("saved");
             window.open('requisition.php','_self');
        </script>
    <?php
      
    }else{
        print_r(sqlsrv_errors());
    }
}


  
  

    

?>
