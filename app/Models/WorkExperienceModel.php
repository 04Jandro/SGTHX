<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkExperienceModel extends Model
{
    protected $table = 'work_experience'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Columna de la clave primaria
    protected $returnType = 'array'; // Tipo de retorno de la consulta
    protected $useSoftDeletes = true; // Habilitar soft deletes
    protected $allowedFields = [
        'cedula',
        'current_employer',
        'is_current_job',
        'country_employ',
        'department',
        'municipality',
        'phones',
        'emails',
        'start_date',
        'end_date',
        'position',
        'dependency',
        'address_employ',
        'verified',
        'workexperience_file',
        'company_type'
    ]; // Campos permitidos para ser insertados o actualizados en la base de datos
    protected $useTimestamps = true; // Habilitar timestamps (created_at, updated_at)
    protected $createdField = 'created_at'; // Nombre del campo para la fecha de creación
    protected $updatedField = 'updated_at'; // Nombre del campo para la fecha de actualización
    protected $deletedField = 'deleted_at'; // Nombre del campo para la fecha de eliminación
    protected $validationRules = [
        'cedula' => 'required',
        'current_employer' => 'permit_empty|max_length[255]',
        'is_current_job' => 'permit_empty|max_length[10]',
        'country_employ' => 'permit_empty|max_length[100]',
        'department' => 'permit_empty|max_length[255]',
        'municipality' => 'permit_empty|max_length[255]',
        'phones' => 'permit_empty|max_length[255]',
        'emails' => 'permit_empty|max_length[255]|valid_email',
        'start_date' => 'permit_empty',
        'end_date' => 'permit_empty',
        'position' => 'permit_empty|max_length[255]',
        'dependency' => 'permit_empty|max_length[255]',
        'address_employ' => 'permit_empty|max_length[255]',
        'verified' => 'permit_empty',
        'workexperience_file' => 'permit_empty|max_length[255]',
        'company_type' => 'permit_empty|max_length[50]'
    ]; // Reglas de validación para los campos


    // Relación de trabajo con las tablas (recuperación de experiencias laborales)
    public function getExperienceByCedula($cedula)
    {
        return $this->where('cedula', $cedula)->findAll();
    }


    public function insertExperience($workExperienceData)
    {
        // Insertar en la tabla de experiencia laboral
        return $this->insert($workExperienceData);
    }
}
