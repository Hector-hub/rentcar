<div>

<div id="rentas_realizadas" style="display: block;" class="form-control">


<br>
<div class="row">
<div class="col">
    
    <form action=""   class="col-100 form-control "style="width:33%" >
    <div class="text-center text-lg-start globalColor">
    <div class="container d-flex justify-content-center py-1">
        <h2 style="color:white">
            Filtrar por fecha
        </h2>
    </div>

    <div class="text-center text-white p-1" style="background-color: rgba(0, 0, 0, 0.2);">


    </div>
</div>
    <h6>Fecha de entrega:</h6>
<input type="text" class="form-control"  name="" placeholder="Entrega" title="Puede escribir cualquier dato de la fecha, dia, mes o año. Para dia 00/, para mes /00/ y para año /0000" id="filter_entrega">
<h6>Fecha de devolución:</h6>
<input type="text" name="" class="form-control" placeholder="Devolución"  title="Puede escribir cualquier dato de la fecha, dia, mes o año. Para dia 00/, para mes /00/ y para año /0000">
<br>

<div class="d-grid gap-2">
<button type="button"  id="buscar_por_fecha"class="btn btn-success">Buscar</button>
</div>
     
    </form>
<br>
<div class="text-center text-lg-start globalColor">
    <div class="container d-flex justify-content-center py-1">
        <h2 style="color:white">
            Rentas realizadas
        </h2>
    </div>

    <div class="text-center text-white p-1" style="background-color: rgba(0, 0, 0, 0.2);">


    </div>
</div>
</div>
</div>
<div class="form-control">
<table id="all_rents" style="display:block;  overflow-x: auto; width: 100% !important;" class="table  responsive-table-1350px table-bordered dt-responsive nowrap ">
    <thead>
        <tr>
            <th>N.Factura</th>
            <th>Cliente</th>
            <th>Telefono</th>
            <th>Vehiculo</th>
            <th>Entrega</th>
            <th>Devolución</th>
            <th>Combustible</th>
            <th>Precio por dia</th>
            <th>Monto Pagado</th>
            <th >Deuda</th>
            <th >Total</th>
            <th>Estado</th>
        </tr>
        <tr style="display:none" class="filters">
        <th ></th>
            <th></th>
            <th></th>
            <th></th>
        <th><input type="text" id="filter_entrega_oculto" placeholder="Entrega"></th>
        <th ><input type="text" id="filter_devolucion_oculto" placeholder="Devolución"></th>
        <th></th>
            <th></th>
            <th></th>
            <th ></th>
            <th ></th>
            <th></th>
    </tr>
    </thead>
    <tbody>

        <?php


$rentas="";

foreach ($rents as $index=>$rent) {
    $nfactura=sprintf("%'.08d\n", $rent['id']);
    $fecha_entrega = new DateTime($rent['fecha_entrega']);
    $fecha_entrega=date_format($fecha_entrega, 'd/m/Y');
    $fecha_devolucion = new DateTime($rent['fecha_devolucion']);
    $fecha_devolucion=date_format($fecha_devolucion, 'd/m/Y');
    if($rent['deuda']>0){
        $celda_color="danger";
        $button_saldar="
        <div class='d-grid gap-2'>
        <span class='badge bg-warning text-dark'>Pendiente</span>
        <button type='button' onclick='saldarCuenta({$rent['id']},{$rent['precio_total']})' class='btn btn-danger' name='button'>Saldar</button>
        </div>
        ";
    }else{
        $celda_color="success";
        $button_saldar="
        <div class='d-grid gap-2'>
        <button type='button'  disabled='disabled'  class='btn btn-success' name='button'>Pagada</button>
        </div>
        ";
  
    }
$rentas.="
<tr class='table-{$celda_color}'>
<td>F-{$nfactura}</td>
<td>{$rent['nombre_cliente']}<br>402-137227-0</td>
<td>{$rent['numero_telefono']}</td>
<td>{$rent['placa_vehiculo']}</td>
<td>{$fecha_entrega}</td>
<td>{$fecha_devolucion}</td>
<td >{$rent['combustible_disponible']}</td>
<td >{$rent['precio_por_dia']}</td>
<td >{$rent['monto_pagado']}</td>
<td >{$rent['deuda']}</td>
<td >{$rent['precio_total']}</td>

<td>{$button_saldar}</td>

</tr>
";
}


echo $rentas;
?>
    </tbody>
 <tfoot>
            <tr>
            
            <th colspan="8">
                Sub total:<br>
                Total:
            </th>
            <th></th>
            <th ></th>
                <th ></th>
            </tr>
        </tfoot>
</table>
</div>
</div>
</div>

<script >
     $(document).ready(function() {
//     var table = $('#all_rents').DataTable({
//     responsive: true,
//     "language": {
//       "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
//     }

//   });


$('#all_rents').DataTable( {
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

            // total en vista monto pagado
            total_en_vista_monto_pagado = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total monto pagado
            total_monto_pagado = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer monto pagado
            $( api.column( 8 ).footer() ).html(
                'RD$'+total_monto_pagado +'<br> RD$'+ total_en_vista_monto_pagado
            );


           // total en vista deuda
            total_en_vista_deuda = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total deuda
            total_deuda = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer deuda
            $( api.column( 9 ).footer() ).html(
                'RD$'+total_deuda +'<br> RD$'+ total_en_vista_deuda
            );

            // Total en vita precio total
            total_en_vista_precio = api
                .column( 10 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total precio total
            total_precio_total = api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer precio total
            $( api.column( 10 ).footer() ).html(
                'RD$'+total_precio_total +'<br> RD$'+ total_en_vista_precio
            );
        },
        //filtro por columna
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                
                 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
 
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },
    } );
 
});
$("#buscar_por_fecha").click(function(){
    console.log('hola');
    $("#filter_entrega_oculto").val($("#filter_entrega").val());
    $("#filter_entrega_oculto").change();
});
$("#buscar_por_fecha").click(function(){
    $("#filter_devolucion_oculto").val($("#filter_devolucion").val());
    $("#filter_devolucion_oculto").change();
});

function saldarCuenta(id,precio_total) {
        let saldar_cuenta_url = <?=json_encode($saldar_cuenta_url=base_url('rentcar/saldar_cuenta/'))?>;

        Swal.fire({
            title: 'Estas seguro?',
            text: "No se podra reverir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, saldar cuenta!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Eliminado!',
                    'Este registro ha sido eliminado.',
                    'success'
                );
              
                window.location = saldar_cuenta_url + "/" + id+"/"+precio_total;
            }
        })
    }
  
 
</script>