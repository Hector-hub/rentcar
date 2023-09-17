


<!-- Remove the container if you want to extend the Footer to full width. -->
<div class=" footer">

  <footer class="text-center text-lg-start globalColor" >
    <div class="container d-flex justify-content-center py-5">
    
    </div>

    <!-- Copyright -->
    <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2021 TODOS LOS DERECHOS RESERVADOS
      
    </div>
    <!-- Copyright -->
  </footer>
  
</div>
<!-- End of .container -->


</body>

<script type="text/javascript">
   $(document).ready(function() {
  $("#data_table").DataTable({
    responsive: false,
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
  });
});
// $(function() {
//     $('#data_table').bootstrapTable()
//   });
  
jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});


function cerrarSession() {
        let cerrar_sesion_url = <?=json_encode($saldar_cuenta_url=base_url('rentcar/cerrar_session/'))?>;

        Swal.fire({
            title: 'Estas seguro?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, cerrar sesión!'
        }).then((result) => {
            if (result.isConfirmed) {
               
              
                window.location = cerrar_sesion_url;
            }
        })
    }
   </script>
</html>
