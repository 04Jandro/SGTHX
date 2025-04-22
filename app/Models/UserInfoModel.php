<?php

namespace App\Models;

use CodeIgniter\Model;

class UserInfoModel extends Model
{
    protected $table = 'personal_info';  // Tabla por defecto para este modelo
    protected $primaryKey = 'cedula';   // Clave primaria
    protected $useTimestamps = true;    // Si usas los campos `created_at` y `updated_at`
    
    // Definir qué campos pueden ser actualizados masivamente
    protected $allowedFields = [
        'cedula', 'document_type', 'place_of_issue', 'date_of_issue',
        'gender', 'nationality', 'first_name', 'middle_name', 'last_name',
        'second_last_name', 'birth_country', 'birth_department', 'birth_city',
        'birth_date', 'age', 'address', 'phone', 'mobile', 'email',
        'military_card_type', 'military_card_number', 'military_district',
        'marital_status', 'spouse_document_type', 'spouse_id_number',
        'spouse_first_name', 'spouse_last_name', 'cedula_file', 'max_level_academic',
        'mailing_country', 'mailing_state', 'mailing_city', 'obtained_title',
        'graduation_date', 'title_date'
    ];

    public function getPersonalInfo($userId)
    {
        return $this->where('cedula', $userId)->first();
    }

    public function getAcademicInfo($userId)
    {
        // Modifica según la estructura de tu base de datos
        return $this->db->table('academic_info') // Usa el DB de CI en lugar de conectarte directamente
            ->where('id', $userId)
            ->get()
            ->getResultArray();
    }

    public function getAdditionalInfo($userId)
    {
        return $this->db->table('additional_info')
            ->where('id', $userId)
            ->get()
            ->getResultArray();
    }

    // Métodos adicionales según sea necesario
}
