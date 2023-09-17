<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpensesModel extends Model
{
    protected $table      = 'expenses';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id',
                                'placa_vehiculo',
                                'motivo',
                                'descripcion',
                                'fecha',
                                'total'	
                                ];

    protected $useTimestamps = false;
  
    protected $validationRules    = [
          
    ];
    protected $validationMessages = [

    ];
    protected $skipValidation     = false;
}