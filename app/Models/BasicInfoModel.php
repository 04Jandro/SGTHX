<?php

namespace App\Models;

use CodeIgniter\Model;

class BasicInfoModel extends Model {

    // Define el nombre de la tabla
    protected $table = 'languages'; // La tabla de idiomas (en tu caso parece llamarse 'languages')
    // Define la clave primaria de la tabla
    protected $primaryKey = 'id'; // Suponiendo que 'id' es la clave primaria
    // Define los campos que pueden ser actualizados en la base de datos
    protected $allowedFields = [
        'cedula',
        'language_name',
        'speaks',
        'reads',
        'writes'
    ];
    // Evita el uso de timestamps
    protected $useTimestamps = false;

    // Método para obtener la información de idiomas por cédula
    public function getLanguageInfoByCedula($cedula, $limit = 2) {
        return $this->where('cedula', $cedula)->limit($limit)->findAll();
    }

    // Método para actualizar la información de idioma
    public function updateLanguageInfo($cedula, $data) {
        // Actualiza los datos de la tabla languages para la cédula proporcionada
        return $this->update($cedula, [
                    'language_name' => $data['language_name'],
                    'speaks' => $data['speaks'],
                    'reads' => $data['reads'],
                    'writes' => $data['writes']
        ]);
    }
}
