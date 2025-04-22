<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\DocumentUploadModel;
use App\Models\UserModel;

class DocumentsController extends Controller {
    
public function index()
{
    // Obtener la cédula del usuario desde la sesión
    $cedula = session()->get('cedula');

    // Obtener los datos del usuario desde la base de datos
    $userModel = new UserModel();
    $userData = $userModel->where('cedula', $cedula)->first();

    if (!$userData) {
        // Si no se encuentra el usuario, redirigir o mostrar un error
        return redirect()->to('/error')->with('error', 'Usuario no encontrado');
    }

    // Obtener la foto de perfil desde el usuario
    $profilePhoto = $userData['profile_photo'] ?? null;

    // Obtener los documentos del usuario desde la tabla personal_info (cedula_file)
    $db = \Config\Database::connect();
    $builder = $db->table('personal_info');
    $builder->select('cedula, document_type, cedula_file AS file_path, created_at');
    $builder->where('cedula', $cedula);  // Filtramos por la cédula del usuario
    $query = $builder->get();
    $personalDocuments = $query->getResultArray();

    // Obtener los documentos adicionales del usuario desde la tabla documents (file_path)
    $builder = $db->table('document_uploads');
    $builder->select('cedula, document_type, file_path, created_at');
    $builder->where('cedula', $cedula);  // Filtramos por la cédula del usuario
    $query = $builder->get();
    $documents = $query->getResultArray();

    // Combinar los documentos de ambas tablas
    $allDocuments = array_merge($personalDocuments, $documents);

    // Asignar los datos del usuario, documentos y la foto de perfil a la vista
    $data = [
        'user_cedula' => $userData['cedula'],
        'user_name' => $userData['name'],
        'user_last_name' => $userData['last_name'],
        'user_status' => $userData['status'],
        'profilePhoto' => $profilePhoto,
        'documents' => $allDocuments,  // Pasar todos los documentos combinados
    ];

    return view('documents', $data);  // Pasar los datos a la vista
}

public function upload()
{
    // Definir los nombres de los campos de los archivos para document_uploads
    $fileFields = [
        'cv'                    => 'Hoja de Vida',
        'rut'                   => 'RUT (DIAN)',
        'bank_cert'             => 'Certificación Bancaria',
        'fiscal'                => 'Antecedentes Fiscales',
        'disciplinary'          => 'Antecedentes Disciplinarios',
        'criminal'              => 'Antecedentes Penales',
        'profession_validation' => 'Validación Profesional',
        'redam'                 => 'REDAM'
    ];

    // Cargar el modelo de documentos (para los que van en document_uploads)
    $documentUploadModel = new \App\Models\DocumentUploadModel();
    // Cargar el modelo de personal_info (para la cédula)
    $personalInfoModel   = new \App\Models\PersonalInfoModel();

    // Obtener la cédula del usuario (clave para ambas tablas)
    $cedula = session()->get('cedula');
    $errors = [];

    // 1) MANEJO ESPECIAL PARA CÉDULA
    // ---------------------------------------------------------
    $uploadedCedulaFile = $this->request->getFile('cedula');
    if ($uploadedCedulaFile && $uploadedCedulaFile->isValid() && !$uploadedCedulaFile->hasMoved()) {
        
        // Construir un nombre único para el archivo
        $timestamp   = date('YmdHis');
        $newName     = 'cedula_' . $cedula . '_' . $timestamp . '.' . $uploadedCedulaFile->getExtension();
        
        // Mover el archivo al directorio de destino
        if ($uploadedCedulaFile->move(FCPATH . 'uploads/cedulas', $newName)) {
            // Crear la ruta final
            $filePath = 'uploads/cedulas/' . $newName;

            // Primero, opcionalmente, podrías buscar el registro en personal_info
            $existingPersonal = $personalInfoModel->where('cedula', $cedula)->first();
            if ($existingPersonal) {
                // Eliminar archivo anterior si existe
                if (!empty($existingPersonal['cedula_file'])) {
                    $oldCedulaPath = FCPATH . $existingPersonal['cedula_file'];
                    if (is_file($oldCedulaPath)) {
                        unlink($oldCedulaPath);
                    }
                }

                // Actualizar solo la columna cedula_file
                $personalInfoModel
                    ->where('cedula', $cedula)
                    ->set(['cedula_file' => $filePath])
                    ->update();
            } else {
                // Si no existe la fila en personal_info, podrías insertarla (opcional)
                // Ajusta los campos necesarios. Ejemplo:
                $personalInfoModel->insert([
                    'cedula'       => $cedula,
                    'cedula_file'  => $filePath,
                    // otros campos que sean obligatorios en personal_info...
                ]);
            }
        } else {
            $errors[] = 'No se pudo mover el archivo de la cédula';
            log_message('error', 'No se pudo mover el archivo de la cédula');
        }
    }

    // 2) MANEJO GENERAL PARA LOS OTROS DOCUMENTOS
    // ---------------------------------------------------------
    foreach ($fileFields as $fieldName => $docType) {
        $uploadedFile = $this->request->getFile($fieldName);

        if ($uploadedFile && $uploadedFile->isValid() && !$uploadedFile->hasMoved()) {
            // Primero buscamos si ya existe un registro para este tipo de documento
            $existingRecord = $documentUploadModel
                ->where('cedula', $cedula)
                ->where('document_type', $docType)
                ->first();

            // Construir un nombre único para el nuevo archivo
            $sanitizedDocType = str_replace(' ', '_', strtolower($docType));
            $timestamp        = date('YmdHis');
            $newName = $sanitizedDocType . '_' . $cedula . '_' . $timestamp . '.' . $uploadedFile->getExtension();

            // Mover el archivo al directorio de destino
            if ($uploadedFile->move(FCPATH . 'uploads/documentos', $newName)) {
                // Preparar datos para guardar/actualizar en la BD (document_uploads)
                $documentData = [
                    'cedula'        => $cedula,
                    'document_type' => $docType,
                    'file_path'     => 'uploads/documentos/' . $newName
                ];

                // Si ya existe un registro, lo actualizamos
                if ($existingRecord) {
                    // Borrar el archivo anterior si existe
                    $oldFilePath = FCPATH . $existingRecord['file_path'];
                    if (is_file($oldFilePath)) {
                        unlink($oldFilePath);
                    }

                    // Asignar el 'id' para forzar el UPDATE en lugar de un INSERT
                    $documentData['id'] = $existingRecord['id'];
                }

                if (!$documentUploadModel->save($documentData)) {
                    log_message('error', 'No se pudo guardar/actualizar en la BD para ' . $docType);
                }
            } else {
                $errors[] = 'No se pudo mover el archivo para: ' . $docType;
                log_message('error', 'No se pudo mover el archivo: ' . $newName);
            }
        } 
        // Podrías omitir este else si no quieres notificar archivos vacíos
        else {
            $errors[] = 'Archivo no válido o ya movido para: ' . $docType;
        }
    }

    // 3) RETORNO DE LA FUNCIÓN
    // ---------------------------------------------------------
    if (!empty($errors)) {
        return redirect()->back()->with('errors', $errors);
    }

    return redirect()->to('user/documents')->with('message', 'Archivos subidos (o reemplazados) exitosamente');
}



public function list()
{
    // 1) Obtener la cédula desde la sesión
    $cedula = session()->get('cedula');

    // 2) Obtener los datos del usuario
    $userModel = new UserModel();
    $userData = $userModel->where('cedula', $cedula)->first();

    if (!$userData) {
        return redirect()->to('/error')->with('error', 'Usuario no encontrado');
    }

    // 3) Obtener la foto de perfil
    $profilePhoto = $userData['profile_photo'] ?? null;

    // 4) Conectar a la base de datos
    $db = \Config\Database::connect();

    // 5) Obtener documentos de personal_info
    //    Devolviendo 'id' como NULL, para unificar estructura
    $builderPersonal = $db->table('personal_info');
    $builderPersonal->select('
        NULL AS id,
        cedula,
        document_type,
        cedula_file AS file_path,
        created_at
    ', false);  
    // El false al final evita que CodeIgniter escape la palabra NULL
    $builderPersonal->where('cedula', $cedula);
    $personalDocuments = $builderPersonal->get()->getResultArray();

    // 6) Obtener documentos de document_uploads
    //    Asumiendo que la tabla tiene una columna primaria 'id'
    $builderUploads = $db->table('document_uploads');
    $builderUploads->select('
        id,
        cedula,
        document_type,
        file_path,
        created_at
    ');
    $builderUploads->where('cedula', $cedula);
    $uploadsDocs = $builderUploads->get()->getResultArray();

    // 7) Combinar resultados en un solo arreglo
    $allDocuments = array_merge($personalDocuments, $uploadsDocs);

    // 8) Preparar datos para la vista
    $data = [
        'user_cedula'    => $userData['cedula'],
        'user_name'      => $userData['name'],
        'user_last_name' => $userData['last_name'],
        'user_status'    => $userData['status'],
        'profilePhoto'   => $profilePhoto,
        'documents'      => $allDocuments,
    ];

    // 9) Retornar la vista
    return view('document_list', $data);
}

    public function delete($id)
    {
        // Instanciar el modelo
        $documentModel = new DocumentUploadModel();

        // Buscar el registro por su ID
        $document = $documentModel->find($id);

        // Validar si existe
        if (!$document) {
            // Retornar con mensaje de error si no existe
            return redirect()->to('user/document/list')
                             ->with('error', 'Documento no encontrado.');
        }

        // Eliminar el archivo físico si existe
        $filePath = FCPATH . $document['file_path'];
        if (!empty($document['file_path']) && file_exists($filePath)) {
            unlink($filePath);
        }

        // Verificar si el tipo de documento es "Cédula de Ciudadanía"
        if ($document['document_type'] === 'Cédula de Ciudadanía') {
            // Si es una cédula, eliminamos solo el archivo (ponemos file_path en NULL)
            $documentModel->update($id, ['file_path' => null]);

            return redirect()->to('user/document/list')
                             ->with('success', 'Archivo de la cédula eliminado correctamente (registro conservado).');
        } else {
            // Si es cualquier otro tipo de documento, eliminamos el registro completo
            $documentModel->delete($id);

            return redirect()->to('user/document/list')
                             ->with('success', 'Documento eliminado exitosamente.');
        }
    }

}
