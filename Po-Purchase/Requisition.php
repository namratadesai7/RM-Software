<?php
include('../includes/dbcon.php');
 include('../includes/header.php');  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisition</title>
    <link rel="stylesheet"  href="../includes/style.css"/>
</head>
<style>
    .r1{
     

    }
    .heading{
        display:flex;
    }
    .heading h3{
        max-width:200px;
        margin:auto;
    }
    .fl{
        margin-top:2rem;
    }
</style>
<body>
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
                    <tr>

                    </tr>
               </tbody>

            </table>
        </div>
    </div>
</body>
</html>

<script>
 $('#req').addClass('active');
    $('#popurMenu').addClass('showMenu');
 
</script>
<?php
include('../includes/footer.php');
?>