<?php
include('../includes/dbcon.php');
 include('../includes/header.php');  
?>
<style>
    .fl{
        margin-top:2rem;
    }
    #reqentryTable input{
        border:none;
        background:none;
    }
    #reqentryTable input:focus{
   
        outline:none !important;
    }
</style>
<div class="container-fluid fl">
    <div class="divCss">
        <div class="row">
            
                <label class="col-lg-3 form-label m-0" for="date">Date
                    <input type="date" class="form-control" id="date" placeholder="">
                </label>
            
                <label class="col-lg-3 form-label" for="prepby">Prepared By
                    <input type="text" class="form-control" id="prepby" placeholder="" onFocus=Searchindentor(this)>
                </label>
            
                <label class="col-lg-3 form-label" for="appby">Approved By
                    <input type="text" class="form-control" id="appby" placeholder="">
                </label>
            
                <label class="col-lg-3 form-label" for="rem">Review
                    <input type="text" class="form-control" id="rem" placeholder="">
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
                <tr class="bg-secondary text-light">
                    <th>Sr.</th>
                    <th>Item Description</th>
                    <th>Qnty</th>
                    <th>Unit</th>
                    <th>Approx Cost</th>
                    <th>M/C No.</th>
                    <th>Department</th>
                    <th>Plant</th>
                    <th>Category</th>
                    <th>State</th>
                    <th>Type</th>
                    <th>Old_Part_Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Sr</td>
                    <td><input type="text" class="form-control" id="idesc" > </td>
                    <td><input type="number" class="form-control" id="qty"></td>
                    <td><input type="number" class="form-control" id="unit"></td>
                    <td><input type="number" class="form-control" id="appcost"></td>
                    <td><input type="number" class="form-control" id="mcno"></td>
                    <td><input type="text" class="form-control" id="dept" onFocus=Searchindentor(this) ></td>
                    <td><input type="text" class="form-control" id="plant" ></td>
                    <td><input type="text" class="form-control" id="cat" ></td>
                    <td><input type="text" class="form-control" id="state" ></td>
                    <td><input type="text" class="form-control" id="type" ></td>
                    <td><input type="text" class="form-control" id="opstat" ></td>
                </tr>
            </tbody>
        </table>
        
    </div>
    <div class="row mt-2">
            <div class="col"></div>
            <div class="col-auto">
                <a href="requisitio/php" class="btn btn-sm btn-danger">Back</a>         
                <button type="submit" class="btn btn-sm btn-success">Save</button>
            </div>
        </div>
</div>

<script>
    $('#req').addClass('active');
    $('#popurMenu').addClass('showMenu');

    $(document).ready(function() {
            // Event listener for "Add" button
            $('#addRowBtn').on('click', function() {
                // Get a reference to the tbody of the table
                const tbody = $('#reqentryTable tbody');

                // Create a new row and append it to the tbody
                const newRow = $('<tr>');
                newRow.html(' <td><input  type="text" class="type" name="type[]" value="Other"></td> <td> <select class="name" name="name[]" required><option  disabled selected value="">--Select--</option><option value="other">Other</option></option><option value="Bare Cu">Bare Cu</option><option value="Tin Cu">Tin Cu</option><option value="Alu">Alu</option><option value="PVC">PVC</option><option value="XLPE">XLPE</option><option value="GI">GI</option><option value="Tape">Tape</option><option value="PVC-D(RE-OUT)">PVC-D(RE-OUT)</option></select></td> <td><input type="text" class="rem" name="rem[]"></td> <td><input class="qty" step="0.01" type="number" name="qty[]"></td> <td><input step="0.01" class="rate" type="number" name="rate[]" value="0"></td> <td><input class="amt" type="number" name="amt[]" readonly></td>,<td><button class="btn-sm btn-danger remove-row" >X</button></td>');

                // Append the new row to the table
                tbody.append(newRow);

            });
        });
    

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
                //$('#prepby').val(ui.item.label);

                $(this).closest('div').find('#prepby').val(ui.item.label);
                $(this).closest('div').find('#dept').val(ui.item.dpnt);
          
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
</script>
<?php
include('../includes/footer.php');
?>