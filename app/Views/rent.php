<?php
$fechaOriginal=date('Y-m-d');
$fechaSumanda=date("Y-m-d",strtotime($fechaOriginal."+ 3 days"));
$date = new DateTime($fechaOriginal);
$fecha= date_format($date, 'd/m/Y');
//css bootstrap cargado en un variable
$css=base_url('public/styles/bootstrap/bootstrap.min.css');
//fin css bootstrap cargado en un variable
if($_POST){    
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
  }
?>
<!-- <link rel="stylesheet" href="<?//=base_url('public/styles/input_range.css')?>" type="text/css"> -->

<div style="background-color:#ffffff" class="">
    <hr>
    <div class="" style="min-height:1200px">
        <div id="form" style="float:left; width:25%" class="panel-right  form-control">
            <div class="mb-3">
                <div class="text-center text-lg-start globalColor">
                    <div class="container d-flex justify-content-center py-1">
                        <h2 style="color:white">
                            Rentar vehiculo
                        </h2>
                    </div>

                    <div class="text-center text-white p-1" style="background-color: rgba(0, 0, 0, 0.2);">


                    </div>
                </div>

                <form method="POST">

                    <h6>Fecha de entrega:</h6>
                    <input required type="date"
                        onchange="comprobarDisponibilidad(), sumarTresDias(this.value),calcularTotalPago(),calcularDeuda()"
                        min="<?= $fechaOriginal ?>" name="fecha_entrega" id="fecha_entrega" class="form-control" />
                    <h6>Fecha de devolución</h6>
                    <input required type="date" onchange="comprobarDisponibilidad(),calcularTotalPago(),calcularDeuda()"
                        min="<?=$fechaSumanda?>" name="fecha_devolucion" id="fecha_devolucion" value=""
                        class="form-control" />
                    <h6>Cedula del cliente:</h6>
                    <input required type="text" name="cedula_cliente" id="cedula_cliente" maxlength="20" value=""
                        placeholder="Cedula" class="form-control" />
                    <h6>Nombre del cliente:</h6>
                    <input required type="text" name="nombre_cliente" id="nombre_cliente"maxlength="100" value="" placeholder="Nombre"
                        class="form-control" />
                    <h6>Numero de telefono:</h6>
                    <input required type="tel" id="numero_telefono" name="numero_telefono" maxlength="10" value=""
                        placeholder="Telefono" class="form-control" />
                    <h6>Vehiculo:</h6>
                    <select required name="placa_vehiculo" id="vehiculo" class=" mi-selector form-control">
                        <option value="">Seleccionar...</option>
                    </select>
                    <h6>Combustible disponible:</h6>
                    <!-- <div class ="inputDiv i1"></div> -->
                    <input required type="text" name="combustible_disponible" maxlength="10" value=""
                        placeholder="Combustible" class="form-control" />
                    <h6>Precio por dia:</h6>
                    <input required type="number" onkeyup="calcularTotalPago(),calcularDeuda()" min="0"
                        id="precio_por_dia" name="precio_por_dia" value="" placeholder="Precio" class="form-control" />
                    <h6>Monto pagado:</h6>
                    <input required type="number" onkeyup="calcularDeuda()" id="monto_pagado" min="0"
                        name="monto_pagado" value="" placeholder="Monto pagado" class="form-control" />
                    <h6>Deuda:</h6>
                    <input readonly required style="background-color: white !important;" type="number" id="deuda"
                        name="deuda" value="" placeholder="Deuda" class="form-control" />
                    <h6>Precio total:</h6>
                    <input readonly required style="background-color: white !important;" type="number" id="precio_total"
                        name="precio_total" value="" placeholder="Total" class="form-control" />
                    <h6>Comentario:</h6>
                    <textarea name="comentario" maxlength="255" class="form-control" rows="6" cols="10"></textarea>
                    <br>


            </div>



            <div class="d-grid gap-2">
            <a class="btn btn-warning" href="<?=base_url('')?>">Cancelar</a>
            <button type="submit" id="submit" class="btn btn-success">Guardar</button>
</div>
     
            </form>

        </div>
        <div style="float:left; width:75%;  padding-left:10px" class="panel-left">
            <!-- rentas realizadas -->
            <div id="rentas_realizadas" style="display: block;" class="form-control">

                <div class="text-center text-lg-start globalColor">
                    <div class="container d-flex justify-content-center py-1">
                        <h2 style="color:white">
                            Rentas realizadas
                        </h2>
                    </div>

                    <div class="text-center text-white p-1" style="background-color: rgba(0, 0, 0, 0.2);">


                    </div>
                </div>
                <br>
                <table id="data_table" class="table table-striped responsive-table-1350px table-bordered dt-responsive nowrap ">
                    <thead>
                        <tr>
                        <th>N.Factura</th>
                            <th>Cliente</th>
                            <th>Telefono</th>
                            <th>Vehiculo</th>
                            <th>Entrega</th>
                            <th>Devolución</th>
                            <th>Detalles</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
      
     
      $rentas="";
    
      foreach ($rents as $index=>$rent) {
        $nfactura=sprintf("%'.08d\n", $rent['id']);
        $rents[$index]['id']=$nfactura;
        $fecha_entrega = new DateTime($rent['fecha_entrega']);
        $fecha_entrega=date_format($fecha_entrega, 'd/m/Y');
   
        $fecha_devolucion = new DateTime($rent['fecha_devolucion']);
        $fecha_devolucion=date_format($fecha_devolucion, 'd/m/Y');
        
          $rentas.="
          <tr>
          <td>F-{$nfactura}</td>
          <td>{$rent['nombre_cliente']}<br>{$rent['cedula_cliente']}</td>
          <td>{$rent['numero_telefono']}</td>
          <td>{$rent['placa_vehiculo']}</td>
            <td>{$fecha_entrega}</td>
            <td>{$fecha_devolucion}</td>
            <td><button type='button' onclick='detallesRenta({$index})' class='btn btn-info' name='button'>Detalles</button></td>
            <td><button type='button' onclick='eliminarRenta({$rent['id']})' class='btn btn-danger' name='button'>Eliminar</button></td>
  
            </tr>
          ";
        }


  echo $rentas;
       ?>
                    </tbody>

                </table>
            </div>
            <!-- fin rentas realizadas -->
            <!-- factura -->
            <div id="detalles" style="display: none;" class="form-control">

                <div class=" text-lg-start globalColor">
                    <div class="container py-1">
                        <div class="row">
                            <div class="col-4">

                                <button type='button' style="float: left; margin-top:5px;" onclick='atras()'
                                    class='btn btn-light' name='button'>
                                    < Atras</button>

                            </div>
                            <div class="col-4" style="text-align: center;">

                                <h2 id="detalles_vehiculo" style="color:white">
                                    Detalles
                                </h2>
                            </div>
                            <div class="col-4">
                                <button type='button' style="float: right; margin-top:5px;" onclick='imprimir_factura()'
                                    class='btn btn-warning' name='button'>Imprimir</button>
                            </div>
                        </div>

                    </div>

                    <div class="text-center text-white p-1" style="background-color: rgba(0, 0, 0, 0.2);">


                    </div>
                </div>
                <br>
                <div id="factura">


                    <div class="col-md-4 form-control ">
                        <div class="form-control">
                          <div class="row">
<div class="col">
<img width="50%" src="<?=base_url('public/img/logo.png')?>" alt=""><br><br>
                       
</div>
<div class="col">
<div id="nfactura" style="float: right;"></div>
                       
</div>
                          </div>
                               <div class="row">
                                <div class="col">
                                    <h5><strong>Fecha de entrega: </strong><br><label id="fecha_entrega_factura">
                                            20-12-12</label></h5>
                                </div>
                                <div class="col">
                                    <h5><strong>Fecha de devolución: </strong><br><label id="fecha_devolucion_factura">
                                            20-12-12</label></h5>
                                </div>

                            </div>
                        </div>
                        <div class="container">

                            <br>
                            <div class="row">
                                <div class="col">
                                    <h5 class="col-12"><strong>Vehiculo: </strong><br><label id="vehiculo_factura">
                                            20-12-12</label></h5>
                                </div>
                                <div class="col">
                                    <h5 class="col-12"><strong>Cliente: </strong><br><label id="cliente_factura">
                                            20-12-12</label></h5>
                                </div>
                            </div>
                        </div>

                        <br>
                        <table class="table responsive-table-761px table-bordered">
                            <thead>
                                <tr>
                                    <th>Combustible disponible</th>
                                    <th>Precio por dia</th>
                                    <th>Monto pagado</th>
                                    <th>Deuda</th>
                                    <th>Precio Total</th>
                                </tr>
                            <tbody>
                                <tr>
                                    <td>
                                        <div id="combustible_disponible_factura"></div>
                                    </td>
                                    <td>
                                        <div id="precio_por_dia_factura">1</div>
                                    </td>
                                    <td>
                                        <div id="monto_pagado_factura">2</div>
                                    </td>
                                    <td>
                                        <div id="deuda_factura">2</div>
                                    </td>
                                    <td>
                                        <div id="precio_total_factura">3</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <textarea name="" readonly style=" resize: none;" id="comentario_factura" class="form-control"
                            rows="10" cols="30"></textarea>

                        <br><br><br>
                        <div class="" style="text-align:right">
                            ____________________________
                            <h5><strong>Firma del cliente</strong></h5>
                        </div>
                    </div>

                </div>
            </div>
            <!-- fin factura -->
        </div>
    </div>
  <?php
  
  ?>
    <script>
    //inputs con mascara
    $('#numero_telefono').mask('(000) 000-0000');
    $('#cedula_cliente').mask('000-0000000-0');
    //fin inputs con mascara


    function sumarTresDias(fecha) {
        let fecha_entrega = new Date(fecha);
        let anio = fecha_entrega.getFullYear();
        let mes = fecha_entrega.getMonth() + 1;
        fecha_entrega.setDate(fecha_entrega.getDate() + 4);
        let dia = fecha_entrega.getDate();


        if (mes < 10) {
            mes = "0" + mes;
        }
        if (dia < 10) {
            dia = "0" + dia;
        }
        fecha_entrega_string = anio + "-" + mes + "-" + dia;
        $('#fecha_devolucion').attr('min', fecha_entrega_string)

    }
    //saber si un vehiculo es ta disponible en la fecha seleccionada
    function comprobarDisponibilidad() {

        if ($('#fecha_devolucion').val() != '' && $('#fecha_entrega').val() != '') {
            document.getElementById("vehiculo").options.length = 0;
            $('#vehiculo').append($('<option>', {
                value: '',
                text: 'Seleccionar...'
            }));
            let rents = <?=json_encode($rents)?>;
            let cars = <?=json_encode($cars)?>;
            let fecha_entrega = new Date($('#fecha_entrega').val());
            let fecha_devolucion = new Date($('#fecha_devolucion').val());
            for (let i_cars = 0; i_cars < cars.length;) {
                let vehiculo_no_rents = cars[i_cars]['marca'] + " " + cars[i_cars]['anio'] + " [" + cars[i_cars][
                    'placa'] + "]";

                if (rents.length > 0) {

                    for (let i_rents = 0; i_rents < rents.length; i_rents++) {
                        if (i_cars < cars.length) {
                            let vehiculo = cars[i_cars]['marca'] + " " + cars[i_cars]['anio'] + " [" + cars[i_cars][
                                'placa'
                            ] + "]";
                            if (vehiculo == rents[i_rents]['placa_vehiculo']) {
                                let rent_fecha_entrega = new Date(rents[i_rents]['fecha_entrega']);
                                let rent_fecha_devolucion = new Date(rents[i_rents]['fecha_devolucion']);
                              console.log((fecha_entrega <= rent_fecha_devolucion) && (rent_fecha_entrega <=
                                    fecha_devolucion));
                                 console.log(fecha_entrega,' 2)',rents[i_rents]['fecha_devolucion'],' 3)',rents[i_rents]['fecha_entrega'],' 4)',fecha_devolucion);   
                                if ((fecha_entrega <= rent_fecha_devolucion) && (rent_fecha_entrega <=
                                    fecha_devolucion)) {
                                       
                                    $('#vehiculo').append($('<option>', {
                                        value: vehiculo,
                                        text: vehiculo +
                                            ' - No esta disponible durante la fecha seleccionada', //" Reservado del ("+fecha_entrega.toLocaleDateString()+"-"+fecha_devolucion.toLocaleDateString()+")",
                                        disabled: true,
                                    }));

                                    i_cars++; //para saltar al proximo vehiculo 

                                } else {
                                    $('#vehiculo').append($('<option>', {
                                        value: vehiculo,
                                        text: vehiculo,
                                        color: 'red'
                                    }));
                                    i_cars++;
                                  
                                }

                            } else {
                             
                                if(i_rents==rents.length-1){
                                    $('#vehiculo').append($('<option>', {
                                    value: vehiculo,
                                    text: vehiculo
                                    
                                }));
                                
                                i_cars++;
                                }else{
                                   
                            
                                }
                               
                            }

                        }
                      
                    }
                } else {
                    $('#vehiculo').append($('<option>', {
                        value: vehiculo_no_rents,
                        text: vehiculo_no_rents
                    }));
                    i_cars++;
                 

                }
            }
        }
    }
    //fin saber si un vehiculo es ta disponible en la fecha seleccionada

    //detalles de la renta
    function detallesRenta(index) {

        let rents = <?=json_encode($rents)?>;
        $('#nfactura').html('<h2>F-'+rents[index]['id']+'</h2>');
        $('#fecha_entrega_factura').html(rents[index]['fecha_entrega']);
        $('#fecha_devolucion_factura').html(rents[index]['fecha_devolucion']);
        $('#vehiculo_factura').html(rents[index]['placa_vehiculo']);
        $('#cliente_factura').html(rents[index]['nombre_cliente'] +" ["+rents[index]['cedula_cliente']+"]");
        $('#combustible_disponible_factura').html(rents[index]['combustible_disponible']);
        $('#comentario_factura').html(rents[index]['comentario']);
        $('#precio_por_dia_factura').html('RD$'+rents[index]['precio_por_dia']);
        $('#monto_pagado_factura').html('RD$'+rents[index]['monto_pagado']);
        $('#deuda_factura').html('RD$'+rents[index]['deuda']);
        $('#precio_total_factura').html('RD$'+rents[index]['precio_total']);


        $('#detalles').attr('style', 'display: block');
        $('#rentas_realizadas').attr('style', 'display: none');
    }
    //fin detalles de la renta  
    //imprimir factura
    function imprimir_factura() {
        var contenido= document.getElementById("factura").innerHTML;
var contenidoOriginal= document.body.innerHTML;

document.body.innerHTML = contenido;

window.print();
setTimeout(function() { 
      

      document.body.innerHTML = contenidoOriginal;
          }, 1500); 
// var estilo = json_encode($css)?>; 
//         var ficha = document.getElementById('factura'); 
//         var ventana_imp = window.open(' ', 'popimpr'); 
//         ventana_imp.document.write(ficha.innerHTML); 
//         var css = ventana_imp.document.createElement("link"); 
//         css.setAttribute("href", estilo); 
//         css.setAttribute("rel", "stylesheet"); 
//         css.setAttribute("type", "text/css"); 
//         ventana_imp.document.head.appendChild(css); 
 
//         setTimeout(function() { 
//             ventana_imp.print(); 
//             ventana_imp.close(); 
 
//         }, 100); 
    }
    //fin imprimir factura

    //volver atras
    function atras() {
        $('#detalles').attr('style', 'display: none');
        $('#rentas_realizadas').attr('style', 'display: block');
    }
    // fin volver atras
    function calcularTotalPago() {
        let fecha_entrega = new Date($('#fecha_entrega').val());
        let fecha_devolucion = new Date($('#fecha_devolucion').val());
        let precio_por_dia = $('#precio_por_dia').val();

        if (($('#fecha_entrega').val() != '') && ($('#fecha_devolucion').val() != '') && (precio_por_dia != '')) {
            let difference = Math.abs(fecha_entrega - fecha_devolucion);
            let days = difference / (1000 * 3600 * 24)
            precio_total = days * precio_por_dia;
            $('#precio_total').val(precio_total);
            $('#monto_pagado').attr('max', precio_total);
            console.log(precio_total)
        }

    }

    function calcularDeuda() {
        if (($('#fecha_entrega').val() != '') &&
            ($('#fecha_devolucion').val() != '') &&
            (precio_por_dia != '') &&
            ($('monto_pagado').val() != ''))

        {
            let deuda = $('#precio_total').val() - $('#monto_pagado').val();
            if (deuda < 0) {
                $('#deuda').val(0);
            } else {
                $('#deuda').val(deuda);
            }
        }
    }

    function eliminarRenta(id) {
        let eliminar_rent_url = <?=json_encode($eliminar_rent_url=base_url('rentcar/eliminar_renta/'))?>;

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
                console.log(eliminar_rent_url + id)
                window.location = eliminar_rent_url + "/" + id;
            }
        })
    }

    //comprobar clientes existente
    let clients = <?=json_encode($clients)?>;
    $('#cedula_cliente').keyup(function(){
        for (let i = 0; i < clients.length; i++) {
           if($('#cedula_cliente').val()==clients[i]['cedula']){
            $('#nombre_cliente').val(clients[i]['nombre']);
            $('#numero_telefono').val(clients[i]['telefono']);
            break;
           }else{
            $('#nombre_cliente').val('');
            $('#numero_telefono').val('');
           }
            
        }
       
    });
    //comprobar clientes existentes
    </script>