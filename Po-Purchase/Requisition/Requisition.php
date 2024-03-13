<?php
include('../../includes/dbcon.php');
 include('../../includes/header.php');  
?>

<style>
 
    /* .heading{
        display:flex;
    }
    .heading h3{
        max-width:200px;
        margin:auto;
    } */
    .fl{
        margin-top:2rem;
    }
    #rateaprvmodel .modal-dialog {
    width: 100vw !important; 
    min-width: 100vw !important; 
    max-width: none !important; 
    }

    #rateaprvmodel .modal-content {
       max-width: 100% !important; 
        max-height: 100% !important; 
    }
    #rateaprvmodel .modal-body{padding:0 !important;}
   
</style>

    <div class="container-fluid fl">
        <!-- <div class="row r1   rounded">
                <div class="col heading">
                    <button type="button" class="btn btn-sm btn-primary  ">New +</button>
                    <h3 >Requisition</h3>
                    <button type="button" class="btn btn-sm btn-danger">Back</button>
                </div>
        </div>
       <div class="divCss mt-2">
           
            <div class="row r2">

            </div>
       </div> -->
       
        <div class="row mb-3">
            <div class="col">
                <h4 class="pt-2 mb-0">Request</h4>
            </div>
            <div class="col-auto">
                <a href="Requisition_new.php"  class="btn  btn-danger" name="reset">New +</a>
            </div>  
        </div>
        <?php
               if (isset($_SESSION['req_id'])) {
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo ('Requisition No:'.  $_SESSION['req_id'].' Created Successfully')  ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="insert"></button>
                </div>
                <?php
                unset($_SESSION['req_id']);
                }


        ?>  
        <div class="divCss">
            <table class="table table-bordered text-center table-striped table-hover" id="reqtable">
               <thead>
                    <tr class="bg-secondary  text-light">
                        <th>mrsNo</th>
                        <th>Date</th>
                        <th>Indentor</th>
                        <th>Department</th>
                        <th>Req Date</th>
                        <th>Approver</th>
                        <th>Parties</th>
                        <th>Control</th>
                     </tr>
               </thead>
               <tbody>
                    <?php
                        $sql="SELECT a.id,
                        a.createdAt,a.indentor,a.indentor_dept,a.approved_by 
                        FROM Requisition_head a 
                        inner join Requisition_details b on a.id=b.head_id  
                         group by a.id, a.createdAt, a.indentor, a.indentor_dept, a.approved_by
                        ";
                        $run=sqlsrv_query($conn,$sql);
                        while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                            $sql1="select count(req_aprv) as cn from Requisition_details where head_id='".$row['id']."' and req_aprv=1 group  by head_id";
                            $run1=sqlsrv_query($conn,$sql1);
                            $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);
                            
                            $sql3="SELECT d.party_name from  Requisition_rate c 
                               inner join [RM_software].[dbo].[rm_party_master] d on d.pid=c.party_id   where c.head_id in(SELECT id from Requisition_details where head_id='".$row['id']."')
                                                  ";
                            $run3=sqlsrv_query($conn,$sql3);
                            $run4=sqlsrv_query($conn,$sql3);
                            $row4=sqlsrv_fetch_array($run4,SQLSRV_FETCH_ASSOC);
                            
                            // $sql2="select count(head_id) as cn from Requisition_rate where head_id='".$row['bid']."'  group  by head_id";
                            // $run2=sqlsrv_query($conn,$sql2);
                            // $row2=sqlsrv_fetch_array($run2,SQLSRV_FETCH_ASSOC);
                            ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php ( $row['createdAt']==NULL) ?'': $row['createdAt']->format('d-m-Y') ?></td>
                                <td><?php echo $row['indentor'] ?></td>
                                <td><?php echo $row['indentor_dept'] ?></td>
                                <td><?php echo $row['approved_by'] ?></td>
                                <td><?php echo $row['id'] ?></td>                              
                                <td class="showlist"  style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?php
                                while($row3=sqlsrv_fetch_array($run3,SQLSRV_FETCH_ASSOC)){
                                    ?>
                                 <?php echo $row3['party_name'] ?>
                            <?php
                                }
                                ?>
                               </td> 
                                <td>
                                    <a class="btn btn-sm btn-success" <?php if($row['id']==($_SESSION['ma'])){
                                        ?> onclick="disableedit(this)"   <?php 
                                    }else{ ?>  href="Requisition_edit.php?edit=<?php echo $row['id']?>"   <?php  } ?>   >Edit</a>
                                    <a class="btn btn-success btn-sm"  href="Requisition-mapdf.php?pdf=<?php echo $row['id']?>">MA-PDF</a>
                                    <!-- <button type="button" <?php if($row1['cn'] >1){ ?> class="btn btn-sm btn-success ma"  <?php   } else{  ?> class="btn btn-sm btn-danger ma"  <?php  } ?>  id="<?php echo $row['id'] ?>">MA</button>
                                0 -->
                                    <button type="button" class="btn btn-sm  ma"   id="<?php echo $row['id'] ?>" data-name="<?php echo $row1['cn']  ?>" >MA</button>
                                    <button type="button" class="btn btn-sm  radd"  id="<?php echo $row['id']  ?>" >AddRate</button>
                                    <button class="btn btn-sm  rateaprv" id="<?php echo $row['id'] ?>">RA</button>
                                  
                                    <button class="btn btn-sm btn-success">RA-PDF</button>
                                </td>

                            </tr>
                    <?php
                        }
                    ?>                
               </tbody>
            </table>
            <!-- Modal for MA -->
            <!-- Button trigger modal -->
          

            <!-- Modal for Item Approval -->
            <div class="modal fade" id="mamodel" tabindex="-1" aria-labelledby="maModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="maModalLabel">Material Approval</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body  ">
                        <form action="Requisition_db.php" method="POST"  id="maformm" >
                            <div id="showma">
                                
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary save"  form="maformm" name="maform">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Add Rate  -->
            <div class="modal fade" id="addratemodel" tabindex="-1" aria-labelledby="addrateModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addrateModalLabel">Material Approval</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body  ">
                        <form action="Requisition_db.php" method="POST"  id="addrateformm" >
                            <div id="showaddrate">
                                
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn btn-primary save"  form="addrateformm" name="addrateform">Save changes</button> -->
                    </div>
                    </div>
                </div>
            </div>

            <!-- Smaller inside 
            Modal for Add Rate  -->
            <div class="modal fade" id="smaddratemodel" tabindex="-1" aria-labelledby="smaddrateModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-m">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button class="btn btn-sm btn-danger addrow">Add Row</button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body  ">
                        <form action="Requisition_db.php" method="POST"  id="smaddrateformm" >
                            <div id="showsmaddrate">
                                
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary saverate"  form="smaddrateformm" name="smaddrateform">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Rate Approval  -->
            <div class="modal fade" id="rateaprvmodel" tabindex="-1" aria-labelledby="rateaprvModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rateaprvModalLabel">Rate Approval</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0 ">
                        <form action="Requisition_db.php" method="POST"  id="rateaprvformm" >
                            <div id="showrateaprv">
                                
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary save"  form="rateaprvformm" name="rateaprvform">Save changes</button> 
                    </div>
                    </div>
                </div>
            </div>

             <!-- Modal for Item History  -->
            <div class="modal fade" id="ihistorymodel" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Rate Approval</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0 ">
                        <!-- <form action="Requisition_db.php" method="POST"  id="ihistoryformm" > -->
                            <div id="showihistory">
                                
                            </div>
                        <!-- </form> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Modal for show list -->
            <div class="modal fade" id="showlistymodel" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Show List</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0 ">
                    <table class="table">
                        <thead>
                            <tr>
                            <th>Sr</th>
                            <th>Item</th>
                            </tr>
                        </thead>
                        <tbody id="listTableBody">
                            <!-- Table rows will be inserted here -->
                        </tbody>
                    </table>
                    </div>
                    
                    </div>
                </div>
            </div>


        </div>
    </div>


<script>
    $('#req').addClass('active');
    $('#popurMenu').addClass('showMenu');


    //show list of parties
    $(document).on('click','.showlist',function(){
        var items=$(this).text().trim();
        console.log(items)
        var itemList = items.split(/\s{2,}/); // Split the items by more than one space
        $('#listTableBody').empty(); // Clear previous content
        if (itemList.length > 0) {
            itemList.forEach(function(item, index) {
                if (item.trim() !== '') { // Skip empty items
                    var row = '<tr><td>' + (index + 1) + '</td><td>' + item.trim() + '</td></tr>';
                    $('#listTableBody').append(row);
                }
            });
            $('#showlistymodel').modal('show');
        } else {
            console.log("No items to display.");
        }
    });
        // console.log(a);
        // $('#showlist').html(a);  
        //       $('#showlistymodel').modal('show');
    
    //MA Summary Modal
    $(document).on('click','.ma',function(){
        // Find the closest parent row of the clicked "drums" element
        var reqno=$(this).attr('id');
        
        $.ajax({
            url:'requisitionma_modal.php',
            type: 'post',
            data: {reqno:reqno},  
            // dataType: 'json',
            success:function(data){
              $('#showma').html(data);  
              $('#mamodel').modal('show');
            }
        });
    });

    //Add Rate Modal
    $(document).on('click','.radd',function(){
       
        var reqno=$(this).attr('id');
        
        $.ajax({
            url:'requisitionma_modal.php',
            type: 'post',
            data: {reqno1:reqno},  
            success:function(data){
                $('#showaddrate').html(data);  
                $('#addratemodel').modal('show');

                    $('.addrate').each(function(){
                        var reqaprv=$(this).data('name');
                       
                        if(reqaprv=='0'){
                            $(this).val("X").css({"background": "#d64e2f", "border": "none"});

                        }
                    });
                //smaller model inside add rate add model
                $('.addrate').off('click').on('click',function(){
                    var reqno2=$(this).attr('id');
                    var reqaprv=$(this).data('name');
                    if(reqaprv=='0'){
                        alert('Requisition is not approved yet!!!');
                        return false;
                    }
                   
                    $.ajax({
                        url:'requisitionma_modal.php',
                        type: 'post',
                        data: {reqno2:reqno2},  
                        success:function(data){
                            $('#showsmaddrate').html(data); 
                            $('#smaddratemodel').modal('show');


                            $('.addrow').off('click').on('click', function() {

                                // Check if the partyname input field of the last row is filled
                                var lastPartyName = $('.row:last .partyname').attr('readonly');
                                console.log(lastPartyName);
                                if (lastPartyName!='readonly') {
                                    // If the partyname input field is empty, alert the user and prevent adding a new row
                                    alert('Please fill in the Party Name before adding a new row.');
                                    return false; // Prevent the default behavior of the "add" button
                                }

                                const lastRow = $('.row:last');

                                // Clone the last row
                               // const newRow = lastRow.clone();
                               const newRow = $('<div class="row a"  >');
                               newRow.html('<input type="text" class="col form-control partyname b" placeholder="Enter Party Name" name="pname[]"  onFocus=SearchParty(this)   ><input type="hidden" class="col form-control pid b" name="pid[]"   > <input type="text" class="col form-control b" placeholder="Enter Rate" name="rate[]"   > ')
                                // Clear input values in the cloned row
                                //newRow.find('input').val('');
                               //    newRow.find('input').removeAttr('readonly');

                                newRow.css("margin-top","4px");
                                // Append the new row after the last row
                                lastRow.after(newRow);
                                
        
                            });    
                        
                        }
                    });
                })
        
            }
        });
        
    });

     //RA Summary Modal
    $(document).on('click','.rateaprv',function(){
        // Find the closest parent row of the clicked "drums" element
        var reqno=$(this).attr('id');
        
        $.ajax({
            url:'requisitionma_modal.php',
            type: 'post',
            data: {reqno3:reqno},  
            // dataType: 'json',
            success:function(data){
                $('#showrateaprv').html(data);  
                $('#rateaprvmodel').modal('show');

                $('.ihistory').click(function(){
                    // Find the closest parent row of the clicked "drums" element
                    var reqno=$(this).attr('id');
                    console.log(reqno);
                  
                    $.ajax({
                        url:'requisitionma_modal.php',
                        type: 'post',
                        data: {reqno4:reqno},  
                        // dataType: 'json',
                        success:function(data){
                        $('#showihistory').html(data);  
                        $('#ihistorymodel').modal('show');
                        },
                        error:function(err){
                            console.log(err);
                        }
                    });
                });

              
            }
        });
    });
  

    //to change the colors of button 
    $(document).ready(function() {
        $('button.ma').each(function() {
            var id = $(this).attr('id');
            // Make AJAX call or perform PHP check to get the value of $row1['cn']
            var cn =$(this).data('name'); // Assuming $row1['cn'] is available here
            if (cn > 1) {
                $(this).addClass('btn-success');
            } else {
                $(this).addClass('btn-danger');
            }
        });
      
    });
    $(document).ready(function(){
        $('button.radd').each(function() {
            var id = $(this).attr('id');
            var $this= $(this);
            $.ajax({
            url:'Requisitionget_data.php',
            type: 'post',
            data: {id:id},  
            // dataType: 'json',
            success:function(data){
             var cn = data;
         
             if(cn>0){
                    $this.addClass('btn-success');
             }else{
                $this.addClass('btn-danger');
             }
            }
        });
        });

        $('button.rateaprv').each(function(){
            var id = $(this).attr('id');
            var $this= $(this);
            $.ajax({
            url:'Requisitionget_data.php',
            type: 'post',
            data: {id1:id},  
            // dataType: 'json',
            success:function(data){
             var cn = data;
       
             if(cn>0){
                    $this.addClass('btn-success');
             }else{
                $this.addClass('btn-danger');
             }
            }
        });





        })
    })
    //Disabble buttons
    function disableedit(){
        alert("You cannot edit after material is approved!!!");
    }
</script>
<?php
include('../../includes/footer.php');
?>