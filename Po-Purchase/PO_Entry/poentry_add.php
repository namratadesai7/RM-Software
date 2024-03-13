<?php
    include('../../includes/dbcon.php');
    include('../../includes/header.php');  
?>
<style>
    .fl{
        margin-top:2rem;
    }
    .divCss{
        display:flex;
        flex-direction:row;
    }
    .first{
        background-color:pink;
        width:40%;
       margin-right:2rem
       
    }
    .sec{
        background-color:blue;
        width:60%;
       
    }

</style>
<div class="container-fluid fl">
    <div class="row mb-3">
        <div class="col">
            <h4 class="pt-2 mb-0">Purchase Order</h4>
        </div>
        <div class="col-auto">
            <a class="btn btn-sm btn-success" href="">Save</a>
        </div>
    </div>

<div class="divCss">
    <div class="first">
        <div class="row">
            <h4>Is Form Requisition</h4>
            <label class="switch">
                <input type="checkbox">
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <div class="sec">
    <h1>srfdf</h1>
    </div>
  
</div>
</div>








<script>
    $('#poentry').addClass('active');
    $('#popurMenu').addClass('showMenu');
</script>

<?php
    include('../../includes/footer.php');
?>