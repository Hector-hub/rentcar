<?php 
    $session=session();
    $user=$session->get('nombre');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?=base_url('favicon.ico')?>">
  <link rel="stylesheet" href="<?=base_url('public/styles/own-styles.css')?>" type="text/css">
  <link rel="stylesheet" href="<?=base_url('public/styles/bootstrap/bootstrap.min.css')?>" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url('public/styles/datatable/datatables.min.css')?>" type="text/css">
  <link rel="stylesheet" href="<?=base_url('public/styles/select2.min.css')?>" type="text/css">
  <link rel="stylesheet" href="<?=base_url('public/styles/sweetalert2.min.css')?>" type="text/css">
  
  <!-- <link rel="stylesheet" href="<?//base_url('public/styles/bootstrap/bootstrap-table.min.css')?>" type="text/css"> -->
  <title>RentCar</title>
</head>

<body>

<script type="text/javascript" src="<?php echo base_url('public/js/jquery/jquery-3.6.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/jquery/jquery.mask.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/datatable/datatables.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/styles/bootstrap/bootstrap.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/styles/bootstrap/bootstrap.bundle.min.js')?>"></script>
<!-- <script type="text/javascript" src="<?php //echo base_url('public/js/input_range.js')?>"></script> -->
<script type="text/javascript" src="<?php echo base_url('public/js/select2.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/sweetalert2.min.js')?>"></script>
<!-- <script type="text/javascript" src="<?php //echo base_url('public/styles/bootstrap/bootstrap-table.min.js')?>"></script>
<script type="text/javascript" src="<?// echo base_url('public/styles/bootstrap/bootstrap-table-mobile.min.js')?>"></script> -->

<nav class="  navbar-dark bg-dark">
  <div class="container-fluid" style="text-align: center;">
  <?php if($user==NULL){}else{?>
  <div class="row">
  <div class="col-md-11">

  </div>
  <div class="col-md-1">
    <div style="position: fixed; margin-top: 10px; margin-right: 2px; z-index:4;">
   <button class="btn btn-danger btn-sm" onclick="cerrarSession()">Cerrar sesión</button>
    </div>
  </div>
</div>
  <?php } ?>
  <br>
        <a style="margin-top:10px"class="navbar-brand" href="<?=base_url('');?>"><h1>RentCar</h1></a>

    <!-- <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">Home</a>
        <a class="nav-link" href="#">Features</a>
        <a class="nav-link" href="#">Pricing</a>
        <a class="nav-link disabled">Disabled</a>
      </div>
    </div> -->
   
  </div>
</nav> 
<p class="globalColor"> <br>  </p>
<div class='alert alert-warning divice-rotation'  style='display:none; width:100%; z-index:3' role='alert'>
  Se recomienda girar tu dispositivo.
  </div>

