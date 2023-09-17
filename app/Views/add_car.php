<?php
$fecha=date('Y-m-d');
$date = new DateTime($fecha);
$fecha= date_format($date, 'd/m/Y');
//variable para mantener los datos escritos por el usuario en caso de error
$datos=['marca'=>'', 
'modelo'=>'', 
'anio'=>'',
'placa'=>'',
'comentario'=>''
];
//fin de los datos escritos por el usuario
//motrar la alerta de error 
if(count($errors)>0){
    echo "
    <div class='alert alert-warning' id='alert_error' style='position: fixed; width:100%; z-index:3' role='alert'>
  {$errors["placa"]}
</div>
<script>
    $('#alert_error').fadeIn();     
  setTimeout(function() {
       $('#alert_error').fadeOut();           
  },5000);
  
</script>
    ";
    $datos=['marca'=>$_POST['marca'], 
    'modelo'=>$_POST['modelo'], 
    'anio'=>$_POST['anio'],
    'placa'=>'',
    'comentario'=>$_POST['comentario']];
}else{
  if($_POST){
    if($_POST['car_id']==="null"){
      
      echo "
      <div class='alert alert-success' id='alert_guardar' style='position: fixed; width:100%; z-index:3' role='alert'>
    El registro ha sido insertado con exito.
    </div>
    <script>
      $('#alert_guardar').fadeIn();     
    setTimeout(function() {
         $('#alert_guardar').fadeOut();           
    },5000);
    Swal.fire(
        'Genial!',
        'Se insertó con exito.',
        'success'
        )
    </script>
      ";
    }else{
     
      echo "
      <div class='alert alert-info' id='alert_actualizar' style='position: fixed; width:100%; z-index:3' role='alert'>
    El registro ha sido actualizado con exito.
    </div>
    <script>
      $('#alert_actualizar').fadeIn();     
    setTimeout(function() {
         $('#alert_actualizar').fadeOut();           
    },5000);
    </script>
      ";
    }
    }
}
//fin motrar la alerta de error 

?>

<div style="background-color:#ffffff" class="">
    <hr>
    <div class="" style="min-height:1000px">
        <div id="form" style="float:left; width:25%" class="panel-right form-control">
            <div class="mb-3">
                <div class="text-center text-lg-start globalColor">
                    <div class="container d-flex justify-content-center py-1">
                        <h2 style="color:white">
                            Agregar vehiculo
                        </h2>
                    </div>

                    <div class="text-center text-white p-1" style="background-color: rgba(0, 0, 0, 0.2);">


                    </div>
                </div>

                <form method="POST">
                    <h6>Marca:</h6>
                    <input required type="text" name="marca" id="marca" maxlength="40" value="<?=$datos['marca']?>"
                        placeholder="Marca" class="form-control" />
                    <h6>Modelo</h6>
                    <input required type="text" name="modelo" id="modelo" maxlength="40" value="<?=$datos['modelo']?>"
                        placeholder="Modelo" class="form-control" />
                    <h6>Año</h6>
                    <input required type="number" name="anio" id="anio" maxlength="4" value="<?=$datos['anio']?>"
                        placeholder="Año" class="form-control" />
                    <h6>Placa</h6>
                    <input required type="text" name="placa" id="placa" maxlength="10" value="<?=$datos['placa']?>"
                        placeholder="Placa" class="form-control" />
                    <h6>Comentario:</h6>
                    <textarea name="comentario" id="comentario" maxlength="255" class="form-control" rows="6"
                        cols="10"><?=$datos['comentario']?></textarea>
                    <br>


         

            <!-- input para saber si se editara o agregara un nuevo registro -->
            <input type="hidden" name="car_id" value="null" id="car_id">
            <!-- fin input para saber si se editara o agregara un nuevo registro -->
            <div class="d-grid gap-2">
            <a class="btn btn-warning" href="<?=base_url('')?>">Cancelar</a>
            <button type="submit" id="submit" class="btn btn-success">Guardar</button>
</div>
     
            

            </form>
            </div>
        </div>
        <div style="float:left; width:75%;  padding-left:10px" class="panel-left">
            <div class="form-control">

                <div class="text-center text-lg-start globalColor">
                    <div class="container d-flex justify-content-center py-1">
                        <h2 style="color:white">
                            Todos los vehiculos
                        </h2>
                    </div>

                    <div class="text-center text-white p-1" style="background-color: rgba(0, 0, 0, 0.2);">


                    </div>
                </div>

                <table id="data_table"  class="table table-striped  responsive-table-800px table-bordered dt-responsive nowrap ">
                    <thead>
                        <tr>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
                            <th>Placa</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    <tbody>
                        <?php
      
      $vehiculos="";
      	
      foreach($cars as $index=>$car ) {
          $vehiculos.="
          <tr>
          <td>{$car['marca']}</td>
          <td>{$car['modelo']}</td>
            <td>{$car['anio']}</td>
            <td>{$car['placa']}</td>
            <td><button type='button' onclick='editarCar({$index},{$car['id']})' class='btn btn-warning' name='button'>Editar</button>
            <td><button type='button' onclick='eliminarCar({$car['id']})' class='btn btn-danger' name='button'>Eliminar</button></a></td>
         </tr>
          ";
        }


  echo $vehiculos;
       ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</div>
<script>
let datos = <?=json_encode($cars)?>;
console.log(datos);

function editarCar(index, car_id) {
    $('#marca').val(datos[index]['marca']);
    $('#modelo').val(datos[index]['modelo']);
    $('#anio').val(datos[index]['anio']);
    $('#placa').val(datos[index]['placa']);
    $('#comentario').val(datos[index]['comentario']);
    $('#submit').html('Actualizar');
    $('#car_id').val(car_id); 
}

function eliminarCar(id) {
    let eliminar_car_url = <?=json_encode($eliminar_car_url=base_url('rentcar/eliminar_vehiculo/'))?>;

    Swal.fire({
        title: 'Estas seguro?',
        text: "No se podra reverir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrarlo!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Eliminado!',
                'Este registro ha sido eliminado.',
                'success'
            );

            window.location = eliminar_car_url + "/" + id;
        }
    })
}
</script>