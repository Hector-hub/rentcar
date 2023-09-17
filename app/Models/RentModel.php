<?php

namespace App\Models;

use CodeIgniter\Model;

class RentModel extends Model
{
    protected $table      = 'rents';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['cedula_cliente', 
                                'nombre_cliente', 
                                'numero_telefono',
                                'placa_vehiculo',
                                'combustible_disponible',
                                'comentario',
                                'fecha_entrega',
                                'fecha_devolucion',
                                'precio_por_dia',
                                'monto_pagado',
                                'deuda',
                                'precio_total'

                            ];

    protected $useTimestamps = false;
  
    protected $validationRules    = [
            
    ];
    protected $validationMessages = [
            
    ];
    protected $skipValidation     = false;
}