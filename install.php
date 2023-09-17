<!DOCTYPE html>
<html>
  <head>
    <link  href="public/styles/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link  href="public/styles/own-styles.css" rel="stylesheet">

  </script>
  <meta charset="utf-8">
    <title>Configuracion</title>
  </head>
  <body background="public/fondos/fondoconf31.jpg">
      
  <div style="padding-top:10px; padding-left:33%">

  
  <br><br>


<div style="height:70%; width:470px; background-color:#ffffff; padding:10px; border-radius:10px; ">
  
  <div class="text-center text-lg-start globalColor" >
  <div class="container d-flex justify-content-center py-4">
  <h2 style="color:white">
  Configuaracion BD
  </h2>
  </div>
  <div class="text-center text-white p-2" style="background-color: rgba(0, 0, 0, 0.2);">

  </div>
</div>
<br>
  <div >
    <form method="POST">
  <input required type="text" name="hostname" placeholder="Hostname" class="form-control col-3"/>
  <br>
  <input required type="text" name="usuario" placeholder="Usuario" class="form-control col-7"/>
  <br>
  <input type="password" name="clave"class="form-control col-7" placeholder="Contraseña"/>
<br>
  <input required type="text" name="namedb" placeholder="Nombre DB" class="form-control col-7"/>
  <br>
  <input required type="text" name="urlbase" placeholder="URL" class="form-control col-7"/>
  <br>
  <input required type="number" name="licencia"  placeholder="Tiempo de licencia (años)" class="form-control col-7"/>
  <br>
  <input type="submit" style="width: 100%;"  class="btn btn-dark" value="Guardar"/>

  </form>
</div>
</div>
</div>
<br>

  </body>

  </html>
  <?php
  include('vconfig.php');
  if(hostname!=""){
    echo "<script type='text/javascript'>window.location='/'</script>";
  }else{

  
if ($_POST){
  $licencia=($_POST['licencia']*365)+7;
  $contenido = array();
  foreach ($_POST as $campo => $valor) {
      if($campo=='licencia'){
        $date = date("Y-m-d");
        $mod_date = strtotime($date."+ {$licencia} days");
        $valor=date("Y-m-d",$mod_date);
 
  }
  $contenido[]="define('{$campo}','{$valor}');\n";
}
  $link = mysqli_connect($_POST['hostname'],$_POST['usuario'],$_POST['clave']);
  if ($link){
  $sql="create database {$_POST['namedb']}";
  $result=mysqli_query($link,$sql);
  $sql="use {$_POST['namedb']}";
  $result=mysqli_query($link,$sql);
  $sql="
  CREATE TABLE `cars` (
    `id` int(11) NOT NULL,
    `marca` varchar(40) NOT NULL,
    `modelo` varchar(40) NOT NULL,
    `color` varchar(12) NOT NULL,
    `anio` year(4) NOT NULL,
    `placa` varchar(10) NOT NULL,
    `comentario` varchar(255) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
  $result=mysqli_query($link,$sql);
  
  $sql="
  CREATE TABLE `clients` (
    `id` int(11) NOT NULL,
    `cedula` varchar(15) NOT NULL,
    `nombre` varchar(100) NOT NULL,
    `telefono` varchar(15) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
  $result=mysqli_query($link,$sql);
  
  $sql="
  CREATE TABLE `expenses` (
    `id` int(11) NOT NULL,
    `placa_vehiculo` varchar(255) NOT NULL,
    `motivo` varchar(100) NOT NULL,
    `descripcion` varchar(1024) NOT NULL,
    `fecha` date NOT NULL,
    `total` decimal(12,2) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
  
  $result=mysqli_query($link,$sql);
  $sql="
  CREATE TABLE `rents` (
    `id` int(11) NOT NULL,
    `cedula_cliente` varchar(20) NOT NULL,
    `nombre_cliente` varchar(100) NOT NULL,
    `numero_telefono` varchar(20) NOT NULL,
    `placa_vehiculo` varchar(255) NOT NULL,
    `combustible_disponible` varchar(30) NOT NULL,
    `comentario` varchar(255) NOT NULL,
    `fecha_entrega` date NOT NULL,
    `fecha_devolucion` date NOT NULL,
    `precio_por_dia` decimal(12,2) NOT NULL,
    `monto_pagado` decimal(12,2) NOT NULL,
    `deuda` decimal(12,2) NOT NULL,
    `precio_total` decimal(12,2) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
  
  $result=mysqli_query($link,$sql);
  $sql="
  CREATE TABLE `users` (
    `id` int(11) NOT NULL,
    `nombre` varchar(255) NOT NULL,
    `clave` varchar(255) NOT NULL,
    `expiracion` date DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
  $result=mysqli_query($link,$sql);
  $sql="
  ALTER TABLE `cars`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `placa` (`placa`);";
    $result=mysqli_query($link,$sql);
  
    $sql="
  ALTER TABLE `clients`
    ADD PRIMARY KEY (`id`);";
    $result=mysqli_query($link,$sql);
  
    $sql="
  ALTER TABLE `expenses`
    ADD PRIMARY KEY (`id`);";
    $result=mysqli_query($link,$sql);
  
    $sql="
  ALTER TABLE `rents`
    ADD PRIMARY KEY (`id`);";
    $result=mysqli_query($link,$sql);
  
    $sql="
  ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `nombre` (`nombre`);";
    $result=mysqli_query($link,$sql);
  
  
  
    $sql="
  ALTER TABLE `cars`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
    $result=mysqli_query($link,$sql);
  
    $sql="
  ALTER TABLE `clients`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
    $result=mysqli_query($link,$sql);
  
    $sql="
  ALTER TABLE `expenses`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
    $result=mysqli_query($link,$sql);
  
    $sql="
  ALTER TABLE `rents`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
    $result=mysqli_query($link,$sql);

    $sql="
    ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
    $result=mysqli_query($link,$sql);
  
    $sql="
  INSERT INTO `users` (`id`, `nombre`, `clave`, `expiracion`) VALUES
  (1, 'admin'," .base64_encode('admin').",DATE_ADD(CURDATE(), INTERVAL {$licencia} DAY));";
    $result=mysqli_query($link,$sql);

  mysqli_select_db($link,$_POST['namedb']);}
  $campos=implode("\n",$contenido);
  $txt = "<?php $campos ?>";
  file_put_contents('vconfig.php',$txt);
 echo "<script type='text/javascript'>window.location='index.php'</script>";
}
}
   ?>