<?php

namespace App\Models;

use CodeIgniter\Model;

class CountryModel extends Model
{
    // Nombre de la tabla
    protected $table      = 'countries'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'country'; // Establecer 'country' como la clave primaria

    // Columnas de la tabla que pueden ser asignadas masivamente
    protected $allowedFields = [
        'country', 'name', '_iso3', 'codigo', 'status', 'date', 'time', 'author', 
        'created_at', 'updated_at', 'deleted_at'
    ];


    // Mensajes de error para las validaciones
    protected $validationMessages = [
        'country' => [
            'required' => 'El campo país es obligatorio.',
            'is_unique' => 'El país ya existe en la base de datos.'
        ],
        'name' => [
            'required' => 'El campo nombre es obligatorio.',
        ],
        // Agrega aquí los mensajes de validación para los otros campos según sea necesario
    ];

    // Configuración de fechas automáticas para la creación y actualización
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Métodos adicionales según sea necesario (por ejemplo, para búsquedas personalizadas)
}
