<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonalInfoModel extends Model {

    // Tabla en la base de datos
    protected $table = 'personal_info';
    protected $primaryKey = 'cedula'; // Clave primaria es cedula
    protected $useAutoIncrement = false; // No auto incremento porque estamos usando cedula como PK
    protected $returnType = 'array'; // Tipo de retorno
    protected $useSoftDeletes = true; // Permite el uso de soft deletes
    // Campos que se pueden insertar o actualizar
    protected $allowedFields = [
        'document_type', 'cedula', 'place_of_issue', 'date_of_issue', 'gender',
        'nationality', 'first_name', 'middle_name', 'last_name', 'second_last_name',
        'birth_country', 'birth_department', 'birth_city', 'birth_date', 'age',
        'address', 'phone', 'mobile', 'email', 'military_card_type', 'military_card_number',
        'military_district', 'marital_status', 'spouse_document_type', 'spouse_id_number',
        'spouse_first_name', 'spouse_last_name', 'cedula_file', 'mailing_country', 'mailing_state', 'mailing_city', 'max_level_academic', 'obtained_title', 'graduation_date', 'title_date'
    ];
    // Reglas de validación
    protected $validationRules = [
        'cedula' => 'permit_empty',
        'document_type' => 'permit_empty',
        'place_of_issue' => 'permit_empty',
        'date_of_issue' => 'permit_empty',
        'gender' => 'permit_empty',
        'nationality' => 'permit_empty',
        'first_name' => 'permit_empty',
        'middle_name' => 'permit_empty',
        'last_name' => 'permit_empty',
        'second_last_name' => 'permit_empty',
        'birth_country' => 'permit_empty',
        'birth_department' => 'permit_empty',
        'birth_city' => 'permit_empty',
        'birth_date' => 'permit_empty',
        'age' => 'permit_empty',
        'address' => 'permit_empty',
        'phone' => 'permit_empty',
        'mobile' => 'permit_empty',
        'email' => 'permit_empty',
        'military_card_type' => 'permit_empty',
        'military_card_number' => 'permit_empty',
        'military_district' => 'permit_empty',
        'marital_status' => 'permit_empty',
        'spouse_document_type' => 'permit_empty',
        'spouse_id_number' => 'permit_empty',
        'spouse_first_name' => 'permit_empty',
        'spouse_last_name' => 'permit_empty',
        'cedula_file' => 'permit_empty',
        'mailing_country' => 'permit_empty',
        'mailing_state' => 'permit_empty',
        'mailing_city' => 'permit_empty',
        'max_level_academic' => 'permit_empty',
        'obtained_title' => 'permit_empty',
        'graduation_date' => 'permit_empty',
        'title_date' => 'permit_empty'
    ];
    // Configuración de fechas (timestamps)
    protected $useTimestamps = true;
    protected $createdField = 'created_at';  // Campo de creación
    protected $updatedField = 'updated_at';  // Campo de actualización
    protected $deletedField = 'deleted_at';  // Campo de eliminación lógica (soft delete)

    // Método para contar los registros de la tabla
    public function getFormulariosCount() {
        return $this->countAllResults();
    }
public function verificarInformacionCompleta($cedula) {
    $builder = $this->db->table($this->table);
    $info = $builder->where('cedula', $cedula)->get()->getRowArray();
    
    return !empty($info);
}

}