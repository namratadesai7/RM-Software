<?php
include('../../includes/dbcon.php');
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
    $run1=sqlsrv_query($conn,$sql1);

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

//edit
if(isset($_POST["edit"])){
    $date=$_POST['date'];
    $prepby=$_POST['prepby'];
    $udept=$_POST['udpt'];
    $appby=$_POST['appby'];
    $rem=$_POST['rem'];
    $req=$_POST['reqno'];

    $reqdetid=$_POST['reqdetid'];
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

    
    $sql1="UPDATE  Requisition_head SET required_date='$date',indentor='$prepby',approved_by='$appby',remarks='$rem',username='$prepby',indentor_dept='$udept',
    createdBy='".$_SESSION['uname']."' WHERE id='$req'";
    $run1 = sqlsrv_query($conn,$sql1);

    if($run1){
        foreach($icode as $key => $value){
      
            $sql3="SELECT count(*) as cn
               from Requisition_details where id='".$reqdetid[$key]."' and head_id='$req'  ";
             
            $run3=sqlsrv_query($conn,$sql3);
            $row3=sqlsrv_fetch_array($run3,SQLSRV_FETCH_ASSOC);

            if($row3['cn']===0){
                $sql2="INSERT INTO Requisition_details(item,qnty,unit,apx_cost,mc,department,plant,category,state,type,old_part_stat,head_id,createdBy) 
                VALUES('".$value."','".$qty[$key]."','".$unit[$key]."','".$appcost[$key]."','".$mcno[$key]."','".$dept[$key]."','".$plant[$key]."','".$cat[$key]."',
                '".$state[$key]."','".$type[$key]."','".$opstat[$key]."','$req','".$_SESSION['uname']."')";
                $run2=sqlsrv_query($conn,$sql2);
               
            }else{
                $sql2="UPDATE Requisition_details SET item='".$value."',qnty='".$qty[$key]."',unit='".$unit[$key]."',apx_cost='".$appcost[$key]."',
                mc='".$mcno[$key]."',department='".$dept[$key]."',plant='".$plant[$key]."',category='".$cat[$key]."',state= '".$state[$key]."',
                type='".$type[$key]."',old_part_stat='".$opstat[$key]."',updatedAt='".date('Y-m-d')."',updatedBy='".$_SESSION['uname']."' where id='".$reqdetid[$key]."' ";
                $run2=sqlsrv_query($conn,$sql2);
                
            }
        }
        if($run2){
            $_SESSION['req_id']=$req;
            //header("location:Requisition.php");
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
    $reqno=$_POST['reqno'];

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
    $_SESSION['ma']=$reqno;
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

  
  //rate aprv form 
  if(isset($_POST['rateaprvform'])){
    $pname=$_POST['pname'];
    $rateid=$_POST['rateid'];
    $ratelist=$_POST['ratelist'];
    $itemid=$_POST['itemid'];
    $radio_state=$_POST['radio_state'];
     //line 128
    
  
    foreach($itemid as $key=>$value){

        if($radio_state[$key]==='1'){
            $sql="UPDATE Requisition_details SET rate_aprv=1,rate_list='".$ratelist[$key]."',rate_head_id='".$rateid[$key]."',
            rateaprvBy='".$_SESSION['uname']."',rateaprvAt='".date('Y-m-d')."'where id='".$value."' " ;
            $run=sqlsrv_query($conn,$sql);
            echo $sql;
            if(!$run){
                print_r(sqlsrv_errors());
            }
        }  
    }
 
    ?>
    <script>
     window.open('requisition.php','_self');
    </script>
    <?php

}





?>
