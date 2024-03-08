<?php
include('../includes/dbcon.php');

if(isset($_POST['reqno'])){
    $reqno=$_POST['reqno'];
    $sql="SELECT a.id,a.item,a.qnty,a.apx_cost,a.mc,a.department,a.plant,a.category,a.plant,a.category,a.state,a.type,a.old_part_stat,a.req_aprv FROM Requisition_details a left join  [RM_software].[dbo].[rm_item]  b on a.item=b.i_code
    left join [RM_software].[dbo].[rm_category] c on c.c_code = b.c_code where a.head_id='$reqno' ";
    $run=sqlsrv_query($conn,$sql);
      
    ?>
    <style>
        #matable input{
            border:none;
        }
    </style>
   
        <table class="table table-bordered text-center table-striped table-hover" id="matable">
            <thead>
                    <tr class="bg-secondary text-light">
                        <th >Sr.</th>
                        <th>Item Description</th>
                        <th>Qnty</th>
                        <th>Approx Cost</th>
                        <th>M/C No.</th>
                        <th>Department</th>
                        <th>Plant</th>
                        <th>Category</th>
                        <th>State</th>
                        <th>Type</th>
                        <th>Old_part_status</th>
                        <th>
                            <input  id="checkall" type="checkbox" class="approves" >
                        </th>
                    </tr>  
            </thead>
            <tbody>
                    <?php
                    while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                    ?>
                    <tr>
                        <td><input style="width:50px;" type="number" name="id[]" value="<?php echo $row['id']  ?>" ></td>
                        <td><?php echo $row['item']  ?></td>
                        <td><?php echo $row['qnty']  ?></td>
                        <td><?php echo $row['apx_cost']  ?></td>
                        <td><?php echo $row['mc']  ?></td>
                        <td><?php echo $row['department']  ?></td>
                        <td><?php echo $row['plant']  ?></td>
                        <td><?php echo $row['category']  ?></td>
                        <td><?php echo $row['state']  ?></td>
                        <td><?php echo $row['type']  ?></td>
                        <td><?php echo $row['old_part_stat']  ?></td>
                        <td>
                            <!-- <input class="check" type="checkbox"  value="1" name="check[]"></td> -->
                            <input type="checkbox" class="remove"  <?php echo ($row['req_aprv'] == 1) ? 'checked' : ''; ?>>
                            <input type="hidden" class="checkbox-state" name="checkbox_state[]" value="<?php echo $row['req_aprv'] ?>" >
                    </tr>
                    <?php
                    }
                    ?>
            </tbody>
        </table>
       
<?php
}
if(isset($_POST['reqno1'])){
    $reqno=$_POST['reqno1'];

    $sql="SELECT a.id,a.item,a.qnty,a.apx_cost,a.mc,a.department,a.plant,a.category,a.plant,a.category,a.state,a.type,a.old_part_stat,a.req_aprv FROM Requisition_details a left join  [RM_software].[dbo].[rm_item]  b on a.item=b.i_code
    left join [RM_software].[dbo].[rm_category] c on c.c_code = b.c_code where a.head_id='$reqno' ";
    $run=sqlsrv_query($conn,$sql);

    ?>
    <style>
        #matable input{
            border:none;
        }
    </style>
        <table class="table table-bordered text-center table-striped table-hover" id="addratetable">
            <thead>
                    <tr class="bg-secondary text-light">
                        <th >Sr.</th>
                        <th>Item Description</th>
                        <th>Qnty</th>
                        <th>Approx Cost</th>
                        <th>M/C No.</th>
                        <th>Department</th>
                        <th>Plant</th>
                        <th>Category</th>
                        <th>State</th>
                        <th>Type</th>
                        <th>Old_part_status</th>
                        <th>Price</th>
                    </tr>  
            </thead>
            <tbody>
                    <?php
                    while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                    ?>
                    <tr>
                        <td><input style="width:50px;" type="number" name="id[]" value="<?php echo $row['id']  ?>" ></td>
                        <td><?php echo $row['item']  ?></td>
                        <td><?php echo $row['qnty']  ?></td>
                        <td><?php echo $row['apx_cost']  ?></td>
                        <td><?php echo $row['mc']  ?></td>
                        <td><?php echo $row['department']  ?></td>
                        <td><?php echo $row['plant']  ?></td>
                        <td><?php echo $row['category']  ?></td>
                        <td><?php echo $row['state']  ?></td>
                        <td><?php echo $row['type']  ?></td>
                        <td><?php echo $row['old_part_stat']  ?></td>
                        <td><input type="button" class="btn btn-sm btn-warning addrate"  id="<?php echo $row['id']  ?>" value="Add Price"></td>
                    </tr>
                    <?php
                    }
                    ?>
            </tbody>
        </table>
       
  <?php
}

if(isset($_POST['reqno2'])){
    $reqno=$_POST['reqno2'];
    $sql="SELECT a.party_id,a.rate,b.party_name FROM Requisition_rate a inner join [RM_software].[dbo].[rm_party_master] b 
    on a.party_id=b.pid where a.head_id='$reqno'";
    $run=sqlsrv_query($conn,$sql);
  
    ?>
    <style>
        .a{
            display:flex;
            justify-content:space-around;
        }
        .b{
            max-width:200px;
        }
        .ui-autocomplete {
            max-height: 200px; /* Set the maximum height for the dropdown */
            overflow-y: auto; /* Enable vertical scrolling */
            overflow-x: hidden; /* Hide horizontal scrollbar */
        }
        /* Width and height of the scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        /* Track (background) */
        ::-webkit-scrollbar-track {
            background: #f1f1f1; /* Change this to your desired background color */
        }

        /* Handle (thumb) */
        ::-webkit-scrollbar-thumb {
             background: #888; /* Change this to your desired scrollbar color */
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555; /* Change this to your desired scrollbar color on hover */
        }
        </style>
    <input type="hidden" name="reqid" value="<?php echo $reqno  ?>">
   
    <?php
    if(sqlsrv_has_rows($run)){

        while( $row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
            ?>
             <div class="row a"  >
                <input type="text" class="col form-control partyname b" placeholder="Enter Party Name" name="pname[]" value="<?php echo $row['party_name']  ?>" onFocus=SearchParty(this)  >
                <input type="hidden" class="col form-control pid b" name="pid[]" value="<?php echo $row['party_id']  ?>" >
                <input type="text" class="col form-control b" placeholder="Enter Rate" name="rate[]" value="<?php echo $row['rate']  ?>" >
            </div>
            <?php
                }
       
        }else{
            ?>
            <div class="row a"  >
            <input type="text" class="col form-control partyname b" placeholder="Enter Party Name" name="pname[]"  onFocus=SearchParty(this)  >
            <input type="hidden" class="col form-control pid b" name="pid[]"  >
            <input type="text" class="col form-control b" placeholder="Enter Rate" name="rate[]"  >
        </div>
<?php
        }
}

if(isset($_POST['reqno3'])){
    $reqno=$_POST['reqno3'];
    $sql="SELECT a.id,a.createdBy,a.createdAt,a.required_date,b.qnty,b.department,b.mc,b.type,b.old_part_stat,c.rate,d.party_name,d.pid,e.item,e.i_code,f.category
    from Requisition_head a inner join Requisition_details b ON a.id=b.head_id
    inner join Requisition_rate c   on b.id=c.head_id 
    inner join [RM_software].[dbo].[rm_party_master] d  on c.party_id=d.pid 
    left join [RM_software].[dbo].[rm_item] e on b.item=e.i_code
    join [RM_software].[dbo].[rm_category] f ON e.c_code=f.c_code";
    $run=sqlsrv_query($conn,$sql);
    $row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);    

    ?>
    <style>
        .row{
            background-color:#bfe2f2;  
            padding-top:0px;
            top:0 !important;
        }

    </style>
   
            <div class="out">
                <div class="row">
                    <div class="col">
                        INDENTOR:<?php echo $row['createdBy'] ?>
                    </div>
                    <div class="col-auto">
                        MRS.NO:<?php echo $row['id'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        DATE:<?php echo $row['createdAt']-> format('d-M-Y') ?>
                    </div>
                    <div class="col-auto">
                        REQUIRED DATE:<?php echo $row['required_date']-> format('d-M-Y') ?>
                    </div>
           
            </div>
           

            <table class="table table-bordered table-hover  text-center">
                <thead>
                    <tr class="bg-secondary">
                        <th>Sr.No</th>
                        <th>Item Description</th>
                        <th>category</th>
                        <th>Qnty</th>
                        <th>Rate</th>
                        <th>Basic Value</th>
                        <th>Dept(MC)</th>
                        <th>Type</th>
                        <th>OldPartStatus</th>
                        <th>Control</th>
                        <th>LP_Date</th>
                        <th>LP_Rate</th>
                        <th>LP_Qnty</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sr=1;
            
                $icode=0;
                $run1=sqlsrv_query($conn,$sql);
                while($row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)) {
                    if($icode!=$row1['i_code'] ){
                        $s=1;
                        ?>
                        <tr style="background:#d9dbdb;" >

                        <td><?php echo $sr.$row['i_code'] ?></td>
                        <td><?php echo $row1['item'] ?></td>
                        <td><?php echo $row1['category'] ?></td>
                        <td><?php echo $row1['qnty'] ?></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $row1['department'] ?>(<?php echo $row1['mc'] ?>)</td>
                        <td><?php echo $row1['type'] ?></td>
                        <td><?php echo $row1['old_part_stat'] ?></td>
                        <td>
                            <button  type="button" class="btn btn-sm btn-warning ihistory" id="<?php echo $row['i_code']  ?>" > Item History</button>
                            <button class="btn btn-sm btn-warning">Reject</button>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tr>
                        <?php
                        $sr++;
                        $pname=$row1['item'];
                    }
                ?>          
                    <tr>
                        <td></td>
                        <td><?php echo $row1['party_name'] ?></td>
                        <td></td>
                        <td><?php echo $row1['rate'] ?></td>
                        <td><?php echo $row1['qnty']* $row1['rate'] ?></td>
                        <td>L<?php echo $s ?></td>
                        <td>
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1<?php echo $pname  ?>">
                        </td>
                        <td></td>
                    </tr>
                       
                <?php
                    $icode=$row1['i_code'];
                    $s++;
                 }
                ?>
                  
                </tbody>

            </table>
        </div>
  
    <?php
}

if(isset($_POST['reqno4'])){
    $icode=$_POST['reqno4'];
    $sql="SELECT top 10 b.receive_date,a.rec_qnty,a.pur_rate,c.party_name FROM [RM_software].[dbo].[inward_ind] a
              LEFT OUTER JOIN  [RM_software].[dbo].[inward_com] b on a.sr_no = b.sr_no AND a.receive_at = b.receive_at
              LEFT OUTER JOIN [RM_software].[dbo].[rm_party_master] c on c.pid= b.mat_from_party WHERE a.p_item ='$icode' ORDER BY receive_date desc";
   $run=sqlsrv_query($conn,$sql);
//    $count=sqlsrv_num_rows($run);
   ?>
   <table class="table table-bordered table-hover text-center">
        <thead>
            <tr class="bg-secondary">
                <th>Sr no.</th>
                <th>Rec. Date</th>
                <th>Party Name</th>
                <th>Qnty</th>
                <th>Rate</th>
            </tr>
        </thead>
        <tbody>
           <?php
                $sr=1;
                while($row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)){
                    ?>
                    <tr>
                        <td><?php echo $sr; ?></td>
                        <td><?php echo $row['receive_date']-> format('Y-m-d') ?></td>
                        <td><?php echo $row['party_name'] ?></td>
                        <td><?php echo $row['rec_qnty'] ?></td>
                        <td><?php echo $row['pur_rate'] ?></td>
                    </tr>
                    <?php
                }
                ?>
          
        </tbody>
   </table>	
   <?php

}
?>

       
<script>
  
    $(document).ready(function(){
        $('#checkall').change(function(){
            var isChecked = $(this).prop('checked');

            $('.remove').each(function() {
                var checkboxStateInput = $(this).siblings('.checkbox-state');
                var defaultValue = checkboxStateInput.val();

                // If "Check All" is checked, or if the checkbox value in the database is 1, check the checkbox
                if (isChecked || defaultValue == 1) {
                    $(this).prop('checked', true);
                } else {
                    // If "Check All" is unchecked and the checkbox value in the database is not 1, uncheck the checkbox
                    if (defaultValue != 1) {
                        $(this).prop('checked', false);
                    }
                }
            });
        });

        $('.remove').change(function () {
            var isChecked = $(this).prop('checked');
            var checkboxStateInput = $(this).siblings('.checkbox-state');

            // Update the hidden input to '1' when the checkbox is checked, '0' when unchecked
            checkboxStateInput.val(isChecked ? '1' : '0');
        });
    });

    //add rate second modal
    function  SearchParty(textBoxRef){
        
        var f= true;
        $(textBoxRef).keypress(function(e){
            if(e.keyCode== '13' || e.which =='13'){
                f=false;
            }
        });
        $(textBoxRef).autocomplete({
            source:function(request,response){
                $.ajax({
                    url:"Requisitionget_data.php",
                    type:'post',
                    dataType:'json',
                    data:{
                        pname:request.term
                    },
                    success:function(data){
                        response(data);
                    //  console.log(data);
                    }
                });
            },
            select:function(event,ui){
                $(this).closest('div').find('.partyname').val(ui.item.label);
                $(this).closest('div').find('.pid').val(ui.item.pid);

                return false;
            },
            change:function(event,ui){
            if(f){
                if(ui.item == null){
                    $(this).val('');
                    $(this).focus();
                }
            }
            },
            open: function () {
                // Set a higher z-index for the Autocomplete dropdown
                $('.ui-autocomplete').css('z-index',1500);
                $('.ui-autocomplete').css('width','210px');
            }
        })
    }

</script>