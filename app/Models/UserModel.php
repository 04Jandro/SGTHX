<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {

    protected $table = 'users';       // Nombre de la tabla en la base de datos
    protected $primaryKey = 'cedula';      // Clave primaria, en este caso, 'cedula'
    protected $returnType = 'array';    // El tipo de datos que se devuelve es un array
    protected $useSoftDeletes = false;      // No estamos utilizando eliminación en suave (soft delete)
// Los campos que se pueden insertar y actualizar
    protected $allowedFields = [
        'cedula', 'name', 'last_name', 'email', 'document_type', 'password', 'role', 'created_at', 'updated_at', 'phone', 'status', 'profile_photo'
    ];
// Las reglas de validación para los campos
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'last_name' => 'required|min_length[3]|max_length[255]',
        'password' => 'permit_empty|min_length[6]',
        'phone' => 'required|min_length[10]',
        'document_type' => 'required',
        'profile_photo' => 'permit_empty'
    ];
// Las fechas para las columnas created_at y updated_at
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

// UserModel.php
    public function getFilesByCedula($cedula) {
// Inicializamos un array para almacenar los resultados
        $files = [];

// Consultamos cada tabla por separado
// Consulta para academic_info
        $query_academic = $this->db->table('academic_info')
                        ->select('academic_file')
                        ->where('cedula', $cedula)
                        ->get()->getResultArray();

        if (!empty($query_academic)) {
            $files[] = ['tipo' => 'Información Académica', 'archivo' => $query_academic[0]['academic_file']];
        }

// Consulta para additional_studies
        $query_studies = $this->db->table('additional_studies')
                        ->select('study_file')
                        ->where('cedula', $cedula)
                        ->get()->getResultArray();

        if (!empty($query_studies)) {
            $files[] = ['tipo' => 'Estudios Adicionales', 'archivo' => $query_studies[0]['study_file']];
        }

// Consulta para personal_info
        $query_personal = $this->db->table('personal_info')
                        ->select('cedula_file')
                        ->where('cedula', $cedula)
                        ->get()->getResultArray();

        if (!empty($query_personal)) {
            $files[] = ['tipo' => 'Información Personal', 'archivo' => $query_personal[0]['cedula_file']];
        }

// Consulta para teaching_work_experience
        $query_teaching = $this->db->table('teaching_work_experience')
                        ->select('teachingexperience_file')
                        ->where('cedula', $cedula)
                        ->get()->getResultArray();

        if (!empty($query_teaching)) {
            $files[] = ['tipo' => 'Experiencia Docente', 'archivo' => $query_teaching[0]['teachingexperience_file']];
        }

// Consulta para work_experience
        $query_work = $this->db->table('work_experience')
                        ->select('workexperience_file')
                        ->where('cedula', $cedula)
                        ->get()->getResultArray();

        if (!empty($query_work)) {
            $files[] = ['tipo' => 'Experiencia Laboral', 'archivo' => $query_work[0]['workexperience_file']];
        }

        return $files;
    }
    
    
    public function getTotalUsers()
    {
        return $this->countAll();
    }

}
