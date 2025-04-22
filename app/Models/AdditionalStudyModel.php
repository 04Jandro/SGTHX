<?php

namespace App\Models;

use CodeIgniter\Model;

class AdditionalStudyModel extends Model
{
    protected $table = 'additional_studies'; // Nombre de la tabla
    protected $primaryKey = 'id'; // Clave primaria
    protected $allowedFields = [
        'cedula', 'study_type', 'institution_name', 'study_name', 'start_date', 
        'end_date', 'duration_hours', 'modality', 'study_file', 'status', 'created_at', 
        'updated_at', 'deleted_at'
    ];

    // Método para obtener los estudios adicionales por cédula
    public function getAdditionalStudies($cedula = null)
    {
        if ($cedula) {
            return $this->where('cedula', $cedula)->findAll(); // Obtener los estudios adicionales de un usuario
        }

        return $this->findAll(); // Obtener todos los estudios adicionales
    }
}
