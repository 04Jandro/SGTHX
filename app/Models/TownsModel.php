<?php

namespace App\Models;

use CodeIgniter\Model;

class TownsModel extends Model
{
    // Nombre de la tabla
    protected $table      = 'towns'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'city'; // Clave primaria: 'city'

    // Columnas de la tabla que pueden ser asignadas masivamente
    protected $allowedFields = [
        'city', 'region', 'country', 'name', 'date', 'time', 'author', 'created_at', 'updated_at', 'deleted_at'
    ];


    // Mensajes de error para las validaciones
    protected $validationMessages = [
        'city' => [
            'required' => 'El campo ciudad es obligatorio.',
        ],
        'region' => [
            'required' => 'El campo región es obligatorio.',
        ],
        'country' => [
            'required' => 'El campo país es obligatorio.',
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
        public function getCity($city)
    {
        return $this->where('city', $city)->first(); // Devuelve el primer registro que coincida con la ciudad
    }

}
