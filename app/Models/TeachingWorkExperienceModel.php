<?php

namespace App\Models;

use CodeIgniter\Model;

class TeachingWorkExperienceModel extends Model {

    protected $table = 'teaching_work_experience'; // Tabla para experiencia docente
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'cedula',
        'educational_institution',
        'teaching_academic_level',
        'teaching_area_of_knowledge',
        'country',
        'start_date',
        'end_date',
        'verified',
        'teachingexperience_file'
    ];

    // Relación de trabajo docente con las tablas (recuperación de experiencias laborales docentes)
    public function getTeachingExperience($cedula = null) {
        if ($cedula) {
            $experience = $this->where('cedula', $cedula)->findAll(); // Recupera todas las experiencias por cédula
            return $experience ? $experience : [];  // Devuelve un array vacío si no hay resultados
        }

        return $this->findAll();  // Recupera todas las experiencias
    }

    public function insertTeachingExperience($teachingExperienceData) {
        // Insertar en la tabla de experiencia docente
        return $this->insert($teachingExperienceData);
    }
}
