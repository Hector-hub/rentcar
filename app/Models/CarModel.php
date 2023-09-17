<?php

namespace App\Models;

use CodeIgniter\Model;

class CarModel extends Model
{
    protected $table      = 'cars';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['marca', 
                                'modelo', 
                                'anio',
                                'placa',
                                'comentario'];

    protected $useTimestamps = false;
  
    protected $validationRules    = [
            'placa'=>'is_unique[cars.placa]'
    ];
    protected $validationMessages = [
            'placa'=>['is_unique'=>'Lo sentimos. Esta placa vehicular esta registrada']
    ];
    protected $skipValidation     = false;
}