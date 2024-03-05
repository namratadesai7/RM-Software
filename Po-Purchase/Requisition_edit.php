<?php
include('../includes/dbcon.php');
include('../includes/header.php'); 

if(isset($_GET['edit'])){
  $id=$_GET['edit'];  
  //$sql="SELECT a.id ,a.required_date,a.indentor,a.approved_by,a.remarks,a.username,a.indentor_dept,a.createdAt,a.createdBy,a.updatedAt,a.updatedBy FROM Requisition_head a inner join Requisition_details b on a.id= b.head_id where id='$id'";
  $sql="SELECT * FROM Requisition_head where id='$id' ";  
  $run=sqlsrv_query($conn,$sql);
  $row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);
?>

<style>

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

    .fl{
        margin-top:2rem;
    }
    #reqentryTable input{
        border:none;
        background:none;
    }
 
    #reqentryTable td{
      padding:4px 2px 4px 2px;
    }
    #reqentryTable input:focus{
   
        outline:none !important;
    }
    #reqentryTable thead th{
        padding: 8px 6px;
        white-space: nowrap !important;
    }
    #opstat option.hide{
        display:none;
    }
    .ui-autocomplete {
    max-height: 200px; /* Set the maximum height for the dropdown */
    overflow-y: auto; /* Enable vertical scrolling */
    overflow-x: hidden; /* Hide horizontal scrollbar */
    }

</style>
<div class="container-fluid fl">
    <form action="Requisition_db.php" method="POST" >
        <div class="divCss">
        
            <div class="row">
                
                    <label class="col-lg-3 form-label m-0" for="date">Date
                        <input type="date" class="form-control" id="date" name="date" placeholder="" value="<?php echo $row['required_date']->format('Y-m-d') ?>" required>
                    </label>
                
                    <label class="col-lg-3 form-label" for="prepby">Prepared By
                        <input type="text" class="form-control prepby" id="prepby" value="<?php echo $row['indentor'] ?>" name="prepby" onFocus=Searchindentor(this) required>
                        <input type="hidden" class="form-control udpt" id="udpt" name="udpt" value="<?php echo $_SESSION['dept'] ?>" required>
                    </label>
                
                    <label class="col-lg-3 form-label" for="appby">Approved By
                        <input type="text" class="form-control" id="appby" name="appby" value="<?php echo $row['approved_by'] ?>" required>
                    </label>
                
                    <label class="col-lg-3 form-label" for="rem">Remarks
                        <input type="text" class="form-control" id="rem"  name="rem" value="<?php echo $row['remarks'] ?>" required>
                    </label>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <button type="button" id="addRowBtn" class="btn btn-sm btn-danger">Add</button>
                </div>
                <div class="col-auto">
                
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover text-center mt-4" id="reqentryTable">
                <thead>
                    <tr class="bg-secondary text-light heading">
                        <th>Sr.</th>
                        <th  >Item Description</th>
                        <th style="width:70px;">Qnty</th>
                        <th>Unit</th>
                        <th style="width:120px;">Approx Cost</th>
                        <th >M/C No.</th>
                        <th style="width:160px;">Department</th>
                        <th>Plant</th>
                        <th>Category</th>
                        <th>State</th>
                        <th>Type</th>
                        <th>Old_Part_Status</th>
                    </tr>
                </thead>
                <tbody>

                        <?php
                        $sql1="SELECT * FROM Requisition_details where head_id='$id'";
                        $sr=1;
                        $run1=sqlsrv_query($conn,$sql1);
              
                        while($row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC)){
                        
?>                                 
                            <tr>
                            <td><?php echo $sr++  ?></td>
                        <td> <input type="text" class="form-control item"  name="item[]" onFocus=SearchItem(this) value="<?php echo $row1['item'] ?>" required  > </td>
                        <td><input type="number" class="form-control" name="qty[]"  value="<?php echo $row1['qnty'] ?>"  required></td>
                        <td>
                            <select class="form-select" name="unit[]" id="unit" required>
                                <!-- <option value="" selected disabled>--Select--</option> -->
                                <option <?php if($row1['unit']=='Box'){ ?> selected  <?php }   ?>>Box</option>
                                <option <?php if($row1['unit']=='Mtr'){ ?> selected  <?php }   ?>>Mtr</option>
                                <option <?php if($row1['unit']=='cylnr'){ ?> selected  <?php }   ?>>cylnr</option>
                                <option <?php if($row1['unit']=='Feet'){ ?> selected  <?php }   ?>>Feet</option>
                                <option <?php if($row1['unit']=='Gram'){ ?> selected  <?php }   ?>>Gram</option>
                                <option <?php if($row1['unit']=='Kg'){ ?> selected  <?php }   ?> >Kg</option>
                                <option <?php if($row1['unit']=='Liter'){ ?> selected  <?php }   ?>>Liter</option>
                                <option <?php if($row1['unit']=='Nos'){ ?> selected  <?php }   ?>>Nos</option>
                                <option <?php if($row1['unit']=='Pair'){ ?> selected  <?php }   ?>>Pair</option>
                                <option <?php if($row1['unit']=='Pkt'){ ?> selected  <?php }   ?>>Pkt</option>
                                <option <?php if($row1['unit']=='Roll'){ ?> selected  <?php }   ?>>Roll</option>
                                <option <?php if($row1['unit']=='Set'){ ?> selected  <?php }   ?>>Set</option>
                                <option <?php if($row1['unit']=='Sq.Ft'){ ?> selected  <?php }   ?>>Sq.Ft</option>
                                <option <?php if($row1['unit']=='Sqmm'){ ?> selected  <?php }   ?>>Sqmm</option>
                                <option <?php if($row1['unit']=='Ton'){ ?> selected  <?php }   ?>>Ton</option>
                                <option <?php if($row1['unit']=='Uom'){ ?> selected  <?php }   ?>>Uom</option>
                                <option <?php if($row1['unit']=='Bag'){ ?> selected  <?php }   ?>>Bag</option>
                                <option <?php if($row1['unit']=='Book'){ ?> selected  <?php }   ?>>Book</option>
                                <option <?php if($row1['unit']=='R.ft'){ ?> selected  <?php }   ?>>R.ft</option>
                                <option <?php if($row1['unit']=='Sq.Mtr'){ ?> selected  <?php }   ?>>Sq.Mtr</option>
                            </select>
                        <!-- <input type="number" class="form-control" id="unit"> -->
                        </td>
                        <td><input type="number" class="form-control" name="appcost[]" value="<?php echo $row1['apx_cost'] ?>" required></td>
                        <td><input type="text" class="form-control mcno" name="mcno[]" onFocus=Searchmc(this) value="<?php echo $row1['mc'] ?>" required></td>
                        <td><input type="text" class="form-control dept" name="dept[]" value="<?php echo $row1['department'] ?>"  required></td>
                        <td>
                            <select class="form-select" name="plant[]"  required>
                                <option <?php if($row1['plant']=='All'){  ?> selected  <?php } ?> >All</option>
                                <option  <?php if($row1['plant']=='1701'){  ?> selected  <?php } ?> >1701</option>
                                <option  <?php if($row1['plant']=='2205'){  ?> selected  <?php } ?> >2205</option>
                                <option  <?php if($row1['plant']=='696'){  ?> selected  <?php } ?> >696</option>
                                <option  <?php if($row1['plant']=='jarod'){  ?> selected  <?php } ?> >jarod</option>
                                <option  <?php if($row1['plant']=='baroda'){  ?> selected  <?php } ?> >baroda</option>
                            </select>
                            <!-- <input type="text" class="form-control plant" id="plant" > -->
                        </td>
                    <td><input type="text" class="form-control cat"  name="cat[]" value="<?php echo $row1['category'] ?>" required></td>
                        <td>
                            <select class="form-select" name="state[]" id="state" required>
                                <option  <?php if($row1['state']=='Capital'){  ?> selected  <?php } ?>  >Capital</option>
                                <option  <?php if($row1['state']=='Consumable'){  ?> selected  <?php } ?>  >Consumable</option> 
                                <option   <?php if($row1['state']=='Raw Material'){  ?> selected  <?php } ?> >Raw Material</option>
                            </select>
                        </td>

                        <td>
                            <select class="form-select" name="type[]" id="type" required>
                                <option  <?php if($row1['type']=='New'){  ?> selected  <?php } ?>   >New</option>
                                <option  <?php if($row1['type']=='Replace'){  ?> selected  <?php } ?>   >Replace</option>
                            </select>
                    
                        </td>
                        <td>
                            <select class="form-select" name="opstat[]" id="opstat" >
                                <option value="">--select--</option>
                                <option  <?php if($row1['old_part_stat']=='Capital'){  ?> selected  <?php } ?> class="hide" >Repair</option>
                                <option <?php if($row1['old_part_stat']=='Stock'){  ?> selected  <?php } ?>  class="hide" >Stock</option>
                                <option <?php if($row1['old_part_stat']=='Scrap'){  ?> selected  <?php } ?>  class="hide">Scrap</option>
                            </select>
                        </td>
                    </tr>
                <?php
                        }
                ?>
                       
                </tbody>
            </table>
        
        </div>
        <div class="row mt-2">
                <div class="col"></div>
                <div class="col-auto">
                    <a href="requisition.php" class="btn btn-sm btn-danger">Back</a>         
                    <button type="submit" class="btn btn-sm btn-success" name="save">Save</button>
                </div>
        </div>  
    </form>    
</div>

<script>
    $('#req').addClass('active');
    $('#popurMenu').addClass('showMenu');

    //to get item name
    
    function  SearchItem(textBoxRef){

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
                        iname:request.term
                    },
                    success:function(data){
                        response(data);
                    //  console.log(data);
                    }
                });
            },
            select:function(event,ui){
                $(this).closest('tr').find('.item').val(ui.item.label);
                $(this).closest('tr').find('.cat').val(ui.item.cat);
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
    //get dept acc to machine number
   function  Searchmc(textBoxRef){

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
                    mc:request.term
                },
                success:function(data){
                    response(data);
                  //  console.log(data);
                }
            });
        },
        select:function(event,ui){
            console.log()
            // $('#mcno').val(ui.item.label);

            $(this).closest('tr').find('.mcno').val(ui.item.label);
            $(this).closest('tr').find('.dept').val(ui.item.dname);
            $(this).closest('tr').find('.plant').val(ui.item.plant);
            return false;
        },
        change:function(event,ui){
            if(f){
            if(ui.item == null){
                $(this).val('');
                $(this).focus();
            }else{
                $(this).closest('tr').find('.dept').prop('readonly',true);
            }
        }
        },
        open: function () {
          // Set a higher z-index for the Autocomplete dropdown
          $('.ui-autocomplete').css('z-index',1500);
          $('.ui-autocomplete').css('width','190px');
         }
    })
   }


    //Serach indentor name
    function Searchindentor(txtBoxRef) {
      
        var f = true; //check if enter is detected
        $(txtBoxRef).keypress(function (e) {
            if (e.keyCode == '13' || e.which == '13'){
                f = false;
            }
        });
        $(txtBoxRef).autocomplete({      
            source: function( request, response ){
                $.ajax({
                    url: "Requisitionget_data.php",
                    type: 'post',
                    dataType: "json",
                    data: {name: request.term },
                    success: function( data ) {
                        console.log(data)
                        response( data );
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
            },
        select: function (event, ui) {
               // $('#prepby').val(ui.item.label);

                $(this).closest('div').find('.prepby').val(ui.item.label);
                $(this).closest('div').find('.dept').val(ui.item.dpnt);
          
              return false;
        },
        change: function (event, ui) {
              if(f){
                  if (ui.item == null){
                      $(this).val('');
                      $(this).focus();
                  }
              }
        },
          open: function () {
          
          // Set a higher z-index for the Autocomplete dropdown
          $('.ui-autocomplete').css('z-index',1500);
       
         }
        });
    } 

      //For adding row in table for new item
    $(document).ready(function() {
        var srValue = <?php echo $sr; ?>;
              
            // Event listener for "Add" button
            $('#addRowBtn').on('click', function() {
          
                // Get a reference to the tbody of the table
                const tbody = $('#reqentryTable tbody');

                // Create a new row and append it to the tbody
                const newRow = $('<tr>');
                newRow.html('<td>'+ srValue +'</td> <td>  <input type="text" class="form-control item" id="item" name="item[]" onFocus=SearchItem(this) ></td> <td><input type="number" class="form-control" id="qty" name="qty[]"> </td><td><select class="form-select" name="unit[]" id="unit"> <!-- <option value="" selected disabled>--Select--</option> -->     <option>Box</option> <option>Mtr</option> <option>cylnr</option> <option>Feet</option> <option>Gram</option><option>Kg</option> <option>Liter</option><option>Nos</option> <option>Pair</option><option>Pkt</option><option>Roll</option> <option>Set</option><option>Sq.Ft</option><option>Sqmm</option> <option>Ton</option> <option>Uom</option><option>Bag</option><option>Book</option><option>R.ft</option><option>Sq.Mtr</option></select></td><td><input type="number" class="form-control" id="appcost" name="appcost[]"></td><td><input type="text" class="form-control mcno" id="mcno" name="mcno[]" onFocus=Searchmc(this) ></td> <td><input type="text" class="form-control dept" id="dept" name="dept[]"  ></td><td><select class="form-select" name="plant[]" id="plant"> <option value="All">All</option><option value="1701">1701</option> <option value="2205">2205</option> <option value="696">696</option><option value="jarod">jarod</option><option value="baroda">baroda</option> </select></td><td><input type="text" class="form-control cat" id="cat" name="cat[]" ></td>  <td> <select class="form-select" name="state[]" id="state"> <option >Capital</option> <option >Consumable</option><option >Raw Material</option></select>   </td> <td>  <select class="form-select" name="type[]" id="type"> <option value="New"  >New</option> <option value="Replace"  >Replace</option> </select> </td> <td><select class="form-select" name="opstat[]" id="opstat"> <option value="">--select--</option> <option class="hide" >Repair</option> <option class="hide" >Stock</option> <option class="hide">Scrap</option></select> </td>');
              
                // Append the new row to the table
                tbody.append(newRow);
               srValue++;
            });
        });
        $(document).on('change', '#type', function () {
        var val = $(this).val();
        console.log(val)
        if (val == "Replace") {
            $('#opstat option.hide').show(); // Hide options with class .hide
        }else if (val == "New") {
            $('#opstat option.hide').hide(); // Hide options with class .hide
        }
        });

</script>





<?php


}
include('../includes/footer.php');

?>