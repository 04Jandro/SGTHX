<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentUploadModel extends Model
{
    protected $table = 'document_uploads';
    protected $primaryKey = 'id'; // ID es la clave primaria
    protected $allowedFields = ['cedula', 'document_type', 'file_path', 'updated_at', 'created_at'];
    protected $useTimestamps = true;
}
