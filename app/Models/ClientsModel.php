<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientsModel extends Model
{
    protected $table      = 'clients';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['cedula',
    	                        'nombre',
                                'telefono'];

    protected $useTimestamps = false;
  
    protected $validationRules    = [
     
    ];
    protected $validationMessages = [
           
    ];
    protected $skipValidation     = false;
}