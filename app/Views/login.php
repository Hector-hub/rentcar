
<?php
use App\Models\UserModel;
$inicio_u = new stdClass;
$inicio_u->nombre =""; 
$inicio_u->clave ="";
$urlbase=base_url();
$msg="";
if ($_POST){
  $inicio_u->nombre =$_POST['nombre'];
  $inicio_u->clave = base64_encode($_POST['clave']);
if (iniciarSesion($inicio_u)){
    if($_POST['nueva_clave']=="" && $_POST['nuevo_nombre']=="" ){
        echo "<script>window.location='{$urlbase}';</script>";
    }else{
        $session=session();
        $id=$session->get('id');
        $userModel=new UserModel($db);
        if($_POST['nuevo_nombre']!=""){
        $userModel->set('nombre',$_POST['nuevo_nombre']);
        }
        if($_POST['nueva_clave']!=""){
        $userModel->set('clave',$_POST['nueva_clave']);
        }
        $userModel->where('id',$id);
        $userModel->update();
        $session->destroy();
        $msg="<div class='alert alert-success'   role='alert'>
        Se actualizo con exito.
        </div>
        <script>
        setTimeout(function() {
            $('.alert').fadeOut();           
       },5000);
      
        Swal.fire(
  'Genial!',
  'Se actualizo con exito.',
  'success'
)
        </script>
        ";
    }
   
}else{
  $msg="<div class='alert alert-danger'   role='alert'>
  El nombre o la contraseña son invalidos.
  </div>
  <script>
  setTimeout(function() {
      $('.alert').fadeOut();           
 },5000);

  </script>
  ";
}
}
?>
<div style="min-height:650px; text-align:center" class="">

<div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="login-form form-control bg-light mt-4 p-4">
                    <form action="" method="POST" onsubmit="verificarPasswords(); return false;" class="row g-3">
                    <div class="text-center text-lg-start globalColor">
    <div class="container d-flex justify-content-center py-1">
        <h2 style="color:white">
        Iniciar sesión
        </h2>
    </div>

    <div class="text-center text-white p-1" style="background-color: rgba(0, 0, 0, 0.2);">


    </div>
    
</div>
<?php echo $msg; ?>
                        <div class="col-12">
                            <h6>Nombre</h6>
                            <input type="text" required name="nombre" value="admin" id="nombre" class="input form-control" placeholder="Nombre">
                        </div>
                        <div class="col-12">
                        <h6>Contraseña</h6>
                            <input type="password" required name="clave" id="clave" value="admin" class="input form-control" placeholder="Contraseña">
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" id="btn_entrar" class="btn btn-dark float-end">Entrar</button>
                        </div>
                        
                        <div style="display: none;" class="accordion  accordion-flush" id="accordionFlushExample">
                      
  <div class="accordion-item " >
    <h2 class="form-control" id="flush-headingOne">
      <button class="accordion-button collapsed"  id="btn-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
       <h6> Cambiar nombre o contraseña</h6>
      </button>
    </h2>
    <div id="flush-collapseOne" style="background-color: rgba(var(--bs-light-rgb),var(--bs-bg-opacity))!important;" class="accordion-collapse row collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
 <br>
    <div class="col-12">
        <br>
                            <h6>Nuevo nombre</h6>
                            <input type="text"  name="nuevo_nombre" class="form-control user-change" placeholder="Nuevo nombre">
                        </div>
                        <div class="col-12">
                            <br>
                        <h6>Nueva contraseña</h6>
                            <input type="password" id="pass1" name="nueva_clave" class="form-control user-change" placeholder="Nueva contraseña">
                        </div> 
                        <div class="col-12">
                            <br>
                        <h6>Confirmar contraseña nueva</h6>
                            <input type="password" id="pass2"  name="confirmar_clave" class="form-control user-change" placeholder="Nueva contraseña">
                        </div>   
                        
                        <div style="margin-top: 10px;" class="col-12">
                            <button type="submit" style="display: none;" id="btn_cambiar" class="btn btn-dark float-end">Cambiar</button>
                        </div>
                    
                    </div>
  </div>

  
</div>
                    </form>
                  

                    <div id="msg"></div>
 
<!-- Mensajes de Verificación -->
<div id="error" class="alert alert-danger ocultar" role="alert">
    Las contraseñas no coinciden, vuelve a intentar !
</div>
<div id="ok" class="" role="">
   
</div>
                 
                
                </div>
            </div>
        </div>
    </div>
 
 

</div>
<br>


<script>
    
function verificarPasswords() {
 
 // Ontenemos los valores de los campos de contraseñas 
 pass1 = document.getElementById('pass1');
 pass2 = document.getElementById('pass2');

 // Verificamos si las constraseñas no coinciden 
 if (pass1.value != pass2.value) {

     // Si las constraseñas no coinciden mostramos un mensaje 
     document.getElementById("error").classList.add("mostrar");

     return false;
 } else {

     // Si las contraseñas coinciden ocultamos el mensaje de error
     document.getElementById("error").classList.remove("mostrar");

     // Mostramos un mensaje mencionando que las Contraseñas coinciden 
     document.getElementById("ok").classList.remove("ocultar");

     // Desabilitamos el botón de login 
     document.getElementById("login").disabled = true;

     // Refrescamos la página (Simulación de envío del formulario) 
     setTimeout(function() {
         location.reload();
     }, 3000);

     return true;
 }

}

$('.user-change').keyup(function(){
    var userChange = document.getElementsByClassName('user-change');
    for (let i = 0; i < userChange.length; i++) {
     if(userChange[i].value!=""){
         
          
               $('#btn_entrar').fadeOut(); 
               $('#btn_cambiar').fadeIn();           
         break;
     }else{
       
        $('#btn_cambiar').fadeOut(); 
              $('#btn_entrar').fadeIn();      
        
     }   
    }
    
});
$('#btn-accordion').click(function(){
     if($('#btn-accordion').attr('data-bs-target')==''){
         $('#btn-accordion').attr('data-bs-target','#flush-collapseOne');
             $('#btn-accordion').attr('class','accordion-button collapsed');
                
    }else{
            $('#btn-accordion').attr('data-bs-target','');
    }
    $('#flush-collapseOne').attr('class','accordion-collapse row collapse');
    $('#btn-accordion').attr('aria-expanded','true');

   

    
    
});

$('.input').keyup(function(){

if($('#nombre').val()!="" && $('#clave').val()!=""){
   
        $('#accordionFlushExample').fadeIn();           


}else{
 
        $('#accordionFlushExample').fadeOut();           
 
}

});

</script>