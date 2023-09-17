<?php

namespace App\Controllers;
use App\Models\CarModel;
use App\Models\RentModel;
use App\Models\ExpensesModel;
use App\Models\ClientsModel;
class Rentcar extends BaseController
{
    public function __construct(){

          
        
        
        }
    public function index()
    {
        $session=session();
        $user=$session->get('nombre');
        if ($user==NULL && uri_string() != '/rentcar/login'){    
            return redirect()->to(base_url('/rentcar/login')); 
        }else{

        return(
             view('common/header')
            .view('home')
            .view('common/footer')
        );
    }
    }
    public function login()
    {
        $session=session();
        $user=$session->get('nombre');
        if (!$user==NULL && uri_string() != '/rentcar/login'){
            return redirect()->to(base_url('/rentcar')); 
        }else{
        return(
             view('common/header')
            .view('login')
            .view('common/footer')
        );
    }
       
    }
    

    public function rentar()
    {
        $session=session();
        $user=$session->get('nombre');
        if ($user==NULL){    
            return redirect()->to(base_url('/rentcar/login')); 
        }else{
        $clientsModel=new ClientsModel($db);
        $carModel=new CarModel($db);
        $rentModel=new RentModel($db);
        if($_POST){
            $fecha_entrega=date_create($_POST['fecha_entrega']);
            $fecha_devolucion=date_create($_POST['fecha_devolucion']);
            $dias_rentados=$fecha_entrega->diff($fecha_devolucion);
            $_POST['precio_total']=$dias_rentados->days*$_POST['precio_por_dia'];
            $rentModel->where('placa_vehiculo',$_POST['placa_vehiculo']);
            $rentModel->where('fecha_entrega',$_POST['fecha_entrega']);
            $rentModel->where('fecha_devolucion',$_POST['fecha_devolucion']);
            $resultRent=$rentModel->find();
            if(count($resultRent)>0){

            }else{
                $rentModel->insert($_POST);
            }
           
            //insertar cliente no existente
            $clientsModel->where('cedula',$_POST['cedula_cliente']);
            $result=$clientsModel->find();
            if(count($result)>0){
                //existe
            $clientsModel->where('nombre',$_POST['nombre_cliente']);
            $clientsModel->where('telefono',$_POST['numero_telefono']);
            $resultClient=$clientsModel->find();
            if(count($resultClient)>0){
             
            }else{
                $client=[
                    'nombre'=>$_POST['nombre_cliente'],
                    'telefono'=>$_POST['numero_telefono']];
                    $clientsModel->update($result[0]['id'],$client);
                
            }
            }else{
                $client=['cedula'=>$_POST['cedula_cliente'],
                         'nombre'=>$_POST['nombre_cliente'],
                         'telefono'=>$_POST['numero_telefono']
            ];
                $clientsModel->insert($client);
            }
            //fin insertar cliente no existente
            }
          
        $rents=$rentModel->where('fecha_devolucion >=',date('Y-m-d'))->findAll();
        $cars=$carModel->findAll();
        $clients=$clientsModel->findAll();
        $data=array('cars'=>$cars,'rents'=>$rents,'clients'=>$clients);
        return(
             view('common/header')
            .view('rent',$data)
            .view('common/footer')
        );
    }
    }
    public function agregar_vehiculo()
    {
        $session=session();
        $user=$session->get('nombre');
        if ($user==NULL){    
            return redirect()->to(base_url('/rentcar/login')); 
        }else{
        $carModel=new CarModel($db);
        $errors=[];
        if($_POST){
            if($_POST['car_id']==="null"){
                if($carModel->insert($_POST)===false){
                    $errors=$carModel->errors();
                } 
               
            }else{
                $car=$carModel->find($_POST['car_id']);
                if($_POST['placa']===$car['placa']){
                    unset($_POST['placa']);
                }else{
                    if($carModel->update($_POST['car_id'],$_POST)===false){
                        $errors=$carModel->errors();
                    } 
                   
                    
                }
               
               
            }
          
        }
        
        $cars=$carModel->findAll();
        $cars=array('cars'=>$cars,
                    'errors'=>$errors);
       
        return(
             view('common/header')
            .view('add_car',$cars)
            .view('common/footer')
        );
    }
    }
    public function rentas_realizadas()
    {
        $session=session();
        $user=$session->get('nombre');
        if ($user==NULL){    
            return redirect()->to(base_url('/rentcar/login')); 
        }else{
        $rentModel=new RentModel($db);
        $rents=$rentModel->findAll();
        $data=array('rents'=>$rents);
        return(
             view('common/header')
            .view('all_rents',$data)
            .view('common/footer')
        );
    }
    }
    public function gastos()
    {
    $session=session();
    $user=$session->get('nombre');
    if ($user==NULL){    
        return redirect()->to(base_url('/rentcar/login')); 
    }else{
            
            $data=array('data'=>$data=[]);
            $expensesModel=new ExpensesModel($db);
  
            if($_POST){
                if($_POST['gasto_id']==="null"){
                   $expensesModel->insert($_POST);
                   $_POST=NULL;
                }else{
                    $expensesModel->update($_POST['gasto_id'],$_POST);    
                    }
                   
                   
                }
                $carModel=new CarModel($db);
                $cars=$carModel->findAll();
        $data=array('data'=>$expensesModel->findAll(),'cars'=>$cars);
        return(
             view('common/header')
            .view('expenses',$data)
            .view('common/footer')
        );
    }
    }
    public function reportes()
    {
        $session=session();
        $user=$session->get('nombre');
        if ($user==NULL){    
            return redirect()->to(base_url('/rentcar/login')); 
        }else{
            
            $data=array('data'=>$data=[]);
        if($_POST){
            switch ($_POST['select_reporte']) {
                case 'expenses':
                    $expensesModel=new ExpensesModel($db);
                    $expensesModel->like('fecha', $_POST['fecha'], 'after'); 
                    $data=array('data'=>$expensesModel->findAll());
                    break;
                case 'clients':
                    $clientsModel=new ClientsModel($db); 
                    $data=array('data'=>$clientsModel->findAll());
                    break;
                case 'cars':
                    $carModel=new CarModel($db);
                    $data=array('data'=>$carModel->findAll());
                    break;
                default:
                    # code...
                    break;
            }     
           
        }
      
        return(
             view('common/header')
            .view('reports',$data)
            .view('common/footer')
        );
    }
    }
    public function eliminar_vehiculo($id)
    {
        $session=session();
        $user=$session->get('nombre');
        if ($user==NULL){    
            return redirect()->to(base_url('/rentcar/login')); 
        }else{
        
        $carModel=new CarModel($db);
        $carModel->delete($id);
        return redirect()->back();
        }
    }
    public function eliminar_gasto($id)
    {
        $session=session();
        $user=$session->get('nombre');
        if ($user==NULL){    
            return redirect()->to(base_url('/rentcar/login')); 
        }else{
        
        $expensesModel=new ExpensesModel($db);
        $expensesModel->delete($id);
        return redirect()->back();
        }
    }
    public function eliminar_renta($id)
    {
        $session=session();
        $user=$session->get('nombre');
        if ($user==NULL){    
            return redirect()->to(base_url('/rentcar/login')); 
        }else{
        $rentModel=new RentModel($db);
        $rentModel->delete($id);
        return redirect()->back();
        }
    }
    public function saldar_cuenta($id,$precio_total){

        $session=session();
        $user=$session->get('nombre');
        if ($user==NULL){    
            return redirect()->to(base_url('/rentcar/login')); 
        }else{
        $rentModel=new RentModel($db);
        $rentModel->set('monto_pagado',$precio_total);
        $rentModel->set('deuda',0);
        $rentModel->where('id',$id);
        $rentModel->update();
        return redirect()->to(base_url('/rentcar/rentas_realizadas'));
        }
    }

    public function cerrar_session(){
        $session=session();
        $session->destroy();
        return redirect()->to(base_url('/rentcar/login')); 
     
    }
}
