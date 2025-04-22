<?php

namespace App\Models;

use CodeIgniter\Model;

class ExperienceModel extends Model
{
    // Define el nombre de la tabla
    protected $table = 'experience';
    
    // Define la clave primaria de la tabla
    protected $primaryKey = 'id';
    
    // Define las columnas que pueden ser insertadas o actualizadas (sin los campos 'id', 'created_at', 'updated_at', 'deleted_at')
    protected $allowedFields = [
        'cedula', 
        'public_servant_years',
        'public_servant_months',
        'private_sector_years',
        'private_sector_months',
        'independent_worker_years',
        'independent_worker_months',
        'total_years',
        'total_months'
    ];

    // Indica que los timestamps serán gestionados automáticamente
    protected $useTimestamps = true;

    // Especifica los nombres de los campos de los timestamps
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    // Si deseas manejar el borrado lógico (soft delete)
    protected $useSoftDeletes = true;
    
    // Relación con la tabla 'users', puedes definir un método si necesitas obtener el usuario relacionado
    public function getUserExperience($cedula)
    {
        // Devuelve los datos de experiencia de un usuario basado en la cedula
        return $this->where('cedula', $cedula)->first();
    }
    
    // Método para calcular los años y meses totales de experiencia
    public function calculateTotalExperience($public_servant_years, $public_servant_months, $private_sector_years, $private_sector_months, $independent_worker_years, $independent_worker_months)
    {
        // Calcula los años totales y los meses totales
        $total_months = ($public_servant_years * 12 + $public_servant_months) 
                        + ($private_sector_years * 12 + $private_sector_months) 
                        + ($independent_worker_years * 12 + $independent_worker_months);

        $total_years = intdiv($total_months, 12); // Número de años
        $remaining_months = $total_months % 12; // Número de meses restantes

        return ['total_years' => $total_years, 'total_months' => $remaining_months];
    }
}
