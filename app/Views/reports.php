<div style="background-color:#ffffff" class="">
    <hr>
    <div class="" style="min-height:1000px">
        <div id="form" style="float:left; width:25%" class="panel-right form-control">
            <div class="mb-3">
                <div class="text-center text-lg-start globalColor">
                    <div class="container d-flex justify-content-center py-1">
                        <h2 style="color:white">
                            Reportes
                        </h2>
                    </div>

                    <div class="text-center text-white p-1" style="background-color: rgba(0, 0, 0, 0.2);">


                    </div>
                </div>

                <form method="POST">
                    <h6>Reporte:</h6>
                    <select name="select_reporte" onchange="mostrarOcultar()" id="select_reporte" class=" form-control">
                        <option value="">Seleccionar...</option>
                        <option  value="expenses">Gastos</option>
                        <option value="clients">Clientes</option>
                        <option value="cars">Vehiculos</option>
                    </select>
                    <div style="display: none;" id="fecha_section">
                    <h6>Fecha</h6>
                    <input type="month" name="fecha" id="fecha" min="2021-01" value="<?=date('Y-m')?>"
                        placeholder="Fecha" class="form-control" />
                        </div>
                    <br>
                    <div class="d-grid gap-2">
                    <button type="submit" id="submit" class="btn btn-info">Solicitar</button>
                        <button type="button" onclick="imprimir()" class="btn btn-warning">Imprimir</button>
                        
                    </div>

            </div>

            </form>

        </div>
        <div style="float:left; width:75%;  padding-left:10px" class="panel-left">
        <?php if($_POST){?>
            <div  id="reporte" class="form-control" >

                <div class="text-center text-lg-start globalColor">
                    <div class="container d-flex justify-content-center py-1">
                        <h2 id="" style="color:white">
                             <?php if($_POST){
                                    switch ($_POST['select_reporte']) {
                                        case 'expenses':
                                            $fecha= new DateTime($_POST['fecha']);
                                            $fecha=date_format($fecha, 'M Y');
                                            echo 'Gastos '.$fecha;
                                            break;
                                        case 'clients':
                                            echo 'Clientes';
                                            break;
                                        case 'cars':
                                            echo 'Vehículos ';
                                            break;
                                        default:
                                            # code...
                                            break;
                                    } 
                                 
                            }else {
                                echo 'Tabla de reporte';
                            }?>
                        </h2>
                    </div>

                    <div class="text-center text-white p-1" style="background-color: rgba(0, 0, 0, 0.2);">


                    </div>
                </div>
                
                <div >
                    <br>
                    <table id="table_reportes"
                        class="table table-striped  responsive-table-800px table-bordered dt-responsive  ">
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
                            </tr>
                            </thead>
                        <tbody>
                            <?php
      
      
      	
     
 $tr="<tr>";
      foreach($data as $value){
       if(count($data)>0){
                foreach($data[0] as $key => $dato){
                    if (date('Y-m-d', strtotime($value[$key])) == $value[$key]) {
                        $value[$key] = new DateTime($value[$key]);
                        $value[$key]=date_format($value[$key], 'd/m/Y');
                      } 
                    $td=" <td>{$value[$key]}</td>";
                    $tr.=$td;
                        }                     
          
        $tr.='</tr>';
        }
    }

  echo $tr;

       ?>
                        </tbody>
                        <tfoot>
            <tr>
          <?php if($_POST){if($_POST['select_reporte']=='expenses'){
              if(count($data)>0){?>  
            <th colspan="<?php if(count($data)>0){echo count($data[0])-1;}?>">
                Sub total:<br>
                Total:
            </th>
            <th></th>
            <?php }} if(count($data)<1){?>
<h2>No hay datos disponibles</h2>
   <?php }} ?>
           
            
            </tr>
        </tfoot>
        
                    </table>
                </div>
            </div>
            
        </div>
        <?php }?>
        
    </div>
</div>

<script type="text/javascript">
function imprimir() {
    var contenido = document.getElementById("reporte").innerHTML;
    var contenidoOriginal = document.body.innerHTML;

    document.body.innerHTML = contenido;

    window.print();

    setTimeout(function() { 
      

      document.body.innerHTML = contenidoOriginal;
          }, 1500); 

}


function mostrarOcultar() {
    if($('#select_reporte').val()=='expenses'){
        $("#fecha_section").attr("style", "display:block");
    }else{
        $("#fecha_section").attr("style", "display:none");
    }
  
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
</script>