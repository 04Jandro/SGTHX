<?php

namespace App\Models;

use CodeIgniter\Model;

class AcademicInfoModel extends Model {

    protected $table = 'academic_info';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'cedula', 'academic_level', 'level_education', 'area_knowledge',
        'institution', 'title_obtained', 'start_date', 'end_date', 'academic_file', 'semesters_passed', 'graduated', 'professional_card_number'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    // Reglas de validación
    protected $validationRules = [
        'cedula' => 'permit_empty',
        'academic_level' => 'permit_empty',
        'level_education' => 'permit_empty',
        'area_knowledge' => 'permit_empty',
        'institution' => 'permit_empty',
        'title_obtained' => 'permit_empty',
        'start_date' => 'permit_empty',
        'end_date' => 'permit_empty',
        'academic_file' => 'permit_empty',
        'semesters_passed' => 'permit_empty',
        'graduated' => 'permit_empty',
        'professional_card_number' => 'permit_empty',
    ];

    public function getFormulariosCount() {
        return $this->countAllResults();
    }

    public function getAcademicInfo($cedula) {
        return $this->where('cedula', $cedula)->findAll();
    }
}
