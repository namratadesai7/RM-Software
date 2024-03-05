<?php
include('../includes/dbcon.php');
 include('../includes/header.php');  
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
                        $sql="SELECT id,createdAt,indentor,indentor_dept,approved_by FROM Requisition_head ";
                        $run=sqlsrv_query($conn,$sql);
                        while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                            $sql1="select count(req_aprv) as cn from Requisition_details where head_id='".$row['id']."' and req_aprv=1 group  by head_id";
                            $run1=sqlsrv_query($conn,$sql1);
                            $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);
                            ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php ( $row['createdAt']==NULL) ?'': $row['createdAt']->format('d-m-Y') ?></td>
                                <td><?php echo $row['indentor'] ?></td>
                                <td><?php echo $row['indentor_dept'] ?></td>
                                <td><?php echo $row['approved_by'] ?></td>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['id'] ?></td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="Requisition_edit.php?edit=<?php echo $row['id']   ?>">Edit</a>
                                    <a class="btn btn-success btn-sm"  href="Requisition-mapdf.php?pdf=<?php echo $row['id']?>">MA-PDF</a>
                                    <!-- <button type="button" <?php if($row1['cn'] >1){ ?> class="btn btn-sm btn-success ma"  <?php   } else{  ?> class="btn btn-sm btn-danger ma"  <?php  } ?>  id="<?php echo $row['id'] ?>">MA</button>
                                0 -->
                                <button type="button" class="btn btn-sm  ma"   id="<?php echo $row['id'] ?>" data-name="<?php echo $row1['cn']  ?>" >MA</button>
                                    <button type="button" class="btn btn-sm btn-danger radd"  id="<?php echo $row['id']  ?>" >AddRate</button>
                                    <button class="btn btn-sm btn-danger">RA</button>
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
                        <button type="submit" class="btn btn-primary save"  form="addrateformm" name="addrateform">Save changes</button>
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
        </div>
    </div>


<script>
    $('#req').addClass('active');
    $('#popurMenu').addClass('showMenu');

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
            // Find the closest parent row of the clicked "drums" element
            var reqno=$(this).attr('id');
            
            $.ajax({
                url:'requisitionma_modal.php',
                type: 'post',
                data: {reqno1:reqno},  
                success:function(data){
                    $('#showaddrate').html(data);  
                    $('#addratemodel').modal('show');

                    //smaller model inside add rate add model
                    $('.addrate').off('click').on('click',function(){
                        var reqno2=$(this).attr('id');
                        $.ajax({
                            url:'requisitionma_modal.php',
                            type: 'post',
                            data: {reqno2:reqno2},  
                            success:function(data){
                                $('#showsmaddrate').html(data); 
                                $('#smaddratemodel').modal('show');


                                $('.addrow').on('click', function() {

                                    // Check if the partyname input field of the last row is filled
                                    var lastPartyName = $('.row:last .partyname').val();
                                    if (!lastPartyName) {
                                        // If the partyname input field is empty, alert the user and prevent adding a new row
                                        alert('Please fill in the Party Name before adding a new row.');
                                        return false; // Prevent the default behavior of the "add" button
                                    }

                                    const lastRow = $('.row:last');

                                    // Clone the last row
                                    const newRow = lastRow.clone();

                                    // Clear input values in the cloned row
                                    newRow.find('input').val('');

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


</script>
<?php
include('../includes/footer.php');
?>