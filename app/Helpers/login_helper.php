<?php
use App\Models\UserModel;
function iniciarSesion($inicio_u){
$userModel=new UserModel($db);
$userModel->where('nombre',$inicio_u->nombre);
$userModel->where('clave',$inicio_u->clave);
$result=$userModel->find();

  if(count($result)>0){
    $session=session();
    $session->set($result[0]);
    

    return true;
  }else{
    return false;
  }
}
 ?>
