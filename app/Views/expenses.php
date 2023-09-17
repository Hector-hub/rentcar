<?php
if($_POST){
    if($_POST['gasto_id']==="null"){
      
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
?>
<div style="background-color:#ffffff" class="">
    <hr>
    <div class="" style="min-height:1000px">
        <div id="form" style="float:left; width:25%" class="panel-right form-control">
            <div class="mb-3">
                <div class="text-center text-lg-start globalColor">
                    <div class="container d-flex justify-content-center py-1">
                        <h2 style="color:white">
                            Agregar gasto
                        </h2>
                    </div>

                    <div class="text-center text-white p-1" style="background-color: rgba(0, 0, 0, 0.2);">


                    </div>
                </div>
           
                <form method="POST">
                <h6>Fecha:</h6>
                    <input readonly required type="date" name="fecha" id="fecha" maxlength="10" value="<?=date('Y-m-d')?>"
                        placeholder="Fecha" class="form-control" />
                    <h6>Vehiculo:</h6>
                        <select required name="placa_vehiculo" id="placa_vehiculo" class=" mi-selector form-control">
                        <option value="">Seleccionar...</option>
                        <?php
                        foreach ($cars as  $car) {
                            echo  "<option value='{$car['marca']} {$car['anio']} [{$car['placa']}]'>{$car['marca']} {$car['anio']} [{$car['placa']}]</option>";
                        }
                        ?>
                    </select>
                    
                    <h6>Motivo</h6>
                    <input required type="text" name="motivo" id="motivo" maxlength="100" value=""
                        placeholder="Motivo" class="form-control" />
                    <h6>Descripción</h6>
                    <textarea name="descripcion" id="descripcion" maxlength="1024" class="form-control" rows="6"
                        cols="10"></textarea>
                        <h6>Total</h6>
                    <input required type="number" name="total" id="total" min="0"maxlength="15" value=""
                        placeholder="Total" class="form-control" />
                    <br>

 <!-- input para saber si se editara o agregara un nuevo registro -->
 <input type="hidden" name="gasto_id" value="null" id="gasto_id">
            <!-- fin input para saber si se editara o agregara un nuevo registro -->
            
            <div class="d-grid gap-2">
            <a class="btn btn-warning" href="<?=base_url('')?>">Cancelar</a>
            <button type="submit" id="submit" class="btn btn-success">Guardar</button>
</div>
     
            

            </form>
            </div>

        </div>
        <div style="float:left; width:75%;  padding-left:10px" class="panel-left">
        <?php if(count($data)>0){?>
            <div class="form-control">

                <div class="text-center text-lg-start globalColor">
                    <div class="container d-flex justify-content-center py-1">
                        <h2 id="" style="color:white">
                            Gastos
                        </h2>
                    </div>

                    <div class="text-center text-white p-1" style="background-color: rgba(0, 0, 0, 0.2);">


                    </div>
                </div>
                <div id="reporte">
                    <br>
                    <table id="table_reportes"
                        class="table table-striped  responsive-table-800px table-bordered dt-responsive ">
                        <thead>
                            <tr>
                                <?php
                                
                                if(count($data)>0){
                            foreach($data[0] as $key => $value)
                            {
                                if($key=="placa_vehiculo"){
                                    $key="Vehiculo";
                                }
                              echo '<th>'. ucfirst($key).'</th>' ;
                            }
                        }
                            ?>
                            <th>Editar</th>
                            <th>Eliminar</th>
                            </tr>
                            </thead>
                        <tbody>
                            <?php
      
      
      	
     
 $tr="<tr>";
      foreach($data as $index=>$value){
       if(count($data)>0){
                foreach($data[0] as $key => $dato){
                   
                    if (date('Y-m-d', strtotime($value[$key])) == $value[$key]) {
                        $value[$key] = new DateTime($value[$key]);
                        $value[$key]=date_format($value[$key], 'd/m/Y');
                      } 

                    $td=" <td>{$value[$key]}</td>";
                    $tr.=$td;
                        }                     
          
        $tr.="<td><button type='button' onclick='editarGasto({$index},{$value['id']})' class='btn btn-warning' name='button'>Editar</button>
        <td><button type='button' onclick='eliminarGasto({$value['id']})' class='btn btn-danger' name='button'>Eliminar</button></a></td>
 </tr>";
        }
    }

  echo $tr;

       ?>
                        </tbody>
                       
                        <tfoot>
            <tr>
            
            <th colspan="<?php if(count($data)>0){echo count($data[0])-1;}?>">
                Sub total:<br>
                Total:
            </th>
            <th></th>
            
            </tr>
        </tfoot>
                    </table>
                </div>
            </div>
            <?php }?>
         
        </div>

    </div>
</div>

<script type="text/javascript">
function imprimir() {
    var contenido = document.getElementById("reporte").innerHTML;
    var contenidoOriginal = document.body.innerHTML;

    document.body.innerHTML = contenido;

    window.print();

    document.body.innerHTML = contenidoOriginal;

}

function ocultar() {
    $("#mes").css("display", "none");
    $("#f").css("display", "none");
}

function mostrar() {
    $("#mes").css("display", "block");
    $("#f").css("display", "block");
}
$(document).ready(function() {
let cantidad_campos = <?=json_encode($data)?>; 

cantidad_campos=Object.keys(cantidad_campos[0]).length-1;
console.log(cantidad_campos);
$('#table_reportes').DataTable( {
    responsive: true,
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
        "footerCallback": function ( row, data, start, end, display ) {

            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };


            // Total en vita precio total
            total_en_vista_precio = api
                .column(cantidad_campos )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total precio total
            total_precio_total = api
                .column( cantidad_campos, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer precio total
            $( api.column( cantidad_campos ).footer() ).html(
                'RD$'+total_precio_total +'<br> RD$'+ total_en_vista_precio
            );
        }
    } );
});


let datos = <?=json_encode($data)?>;
function editarGasto(index, gasto_id) {
    $('#fecha').val(datos[index]['fecha']);
    $('#placa_vehiculo').val(datos[index]['placa_vehiculo']);
    $('#motivo').val(datos[index]['motivo']);
    $('#descripcion').val(datos[index]['descripcion']);
    $('#total').val(datos[index]['total']);
    $('#submit').html('Actualizar');
    $('#gasto_id').val(gasto_id);
}

function eliminarGasto(id) {
    let eliminar_gasto_url = <?=json_encode($eliminar_gasto_url=base_url('rentcar/eliminar_gasto/'))?>;

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

            window.location = eliminar_gasto_url + "/" + id;
        }
    })
}
</script>