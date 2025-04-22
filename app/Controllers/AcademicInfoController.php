<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AcademicInfoModel;
use CodeIgniter\Controller;

class AcademicInfoController extends BaseController {

    public function __construct() {
        parent::__construct(); // Asegura que se ejecute el constructor de BaseController
    }

public function index() {
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

    // Obtener los datos académicos del usuario
    $academicInfoModel = new AcademicInfoModel();
    $academicInfo = $academicInfoModel->where('cedula', $cedula)->first();  // Asegúrate de que la cédula esté en la tabla 'academic_info'

    // Asignar los datos del usuario, foto de perfil y datos académicos a la vista
    $data = [
        'user_cedula' => $userData['cedula'],
        'user_name' => $userData['name'],
        'user_last_name' => $userData['last_name'],
        'user_status' => $userData['status'],
        'profilePhoto' => $profilePhoto,
        'academicInfo' => $academicInfo,  // Agregar los datos académicos a los datos
    ];

    return view('academic_info_form', $data);  // Pasar los datos a la vista
}


    public function save() {
        $cedula = $this->request->getPost('cedula');
        $academicLevel = $this->request->getPost('academic_level');
        $levelEducation = $this->request->getPost('level_education');
        $areaKnowledge = $this->request->getPost('area_knowledge');
        $institution = $this->request->getPost('institution');
        $titleObtained = $this->request->getPost('title_obtained');
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $semestersPassed = $this->request->getPost('semesters_passed');
        $graduated = $this->request->getPost('graduated');
        $professionalCardNumber = $this->request->getPost('professional_card_number');

        // Manejo del archivo subido
        $academicFile = $this->request->getFile('academic_file');
        $filePath = null;

        if ($academicFile && $academicFile->isValid() && !$academicFile->hasMoved()) {
            // Generar un nombre aleatorio para el archivo
            $newName = $academicFile->getRandomName();
            // Mover el archivo a la carpeta de destino
            $academicFile->move(FCPATH . 'uploads/academic_files', $newName);
            // Establecer la ruta del archivo
            $filePath = 'uploads/academic_files/' . $newName;
        }

        // Definir la variable $data con todos los campos
        $data = [
            'cedula' => $cedula,
            'academic_level' => $academicLevel,
            'level_education' => $levelEducation,
            'area_knowledge' => $areaKnowledge,
            'institution' => $institution,
            'title_obtained' => $titleObtained,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'academic_file' => $filePath,
            'semesters_passed' => $semestersPassed,
            'graduated' => $graduated,
            'professional_card_number' => $professionalCardNumber,
        ];

        // Intentar guardar la información
        $academicInfoModel = new AcademicInfoModel();
        if ($academicInfoModel->save($data)) {
            return redirect()->to('user/academic-info')->with('success', 'Información Académica guardada con éxito.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al guardar la información académica.');
        }
    }

    public function update($cedula) {
// Obtener los datos desde el formulario
        $academicLevel = $this->request->getPost('academic_level');
        $levelEducation = $this->request->getPost('level_education');
        $areaKnowledge = $this->request->getPost('area_knowledge');
        $institution = $this->request->getPost('institution');
        $titleObtained = $this->request->getPost('title_obtained');
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $semestersPassed = $this->request->getPost('semesters_passed'); // Nuevo campo
        $graduated = $this->request->getPost('graduated'); // Nuevo campo
        $professionalCardNumber = $this->request->getPost('professional_card_number'); // Nuevo campo
        // Manejo del archivo subido
        $academicFile = $this->request->getFile('academic_file');
        $filePath = null;

        if ($academicFile && $academicFile->isValid() && !$academicFile->hasMoved()) {
            // Generar un nombre aleatorio para el archivo
            $newName = $academicFile->getRandomName();
            // Mover el archivo a la carpeta de destino
            $academicFile->move(FCPATH . 'uploads/academic_files', $newName);
            // Establecer la ruta del archivo
            $filePath = 'uploads/' . $newName;
        }

        // Buscar la información académica actual por cédula
        $academicInfoModel = new AcademicInfoModel();
        $currentData = $academicInfoModel->where('cedula', $cedula)->first();

        // Verificar si se encontró el registro
        if (!$currentData) {
            return redirect()->to('academic-info/success')->with('error', 'Información académica no encontrada.');
        }

        // Preparar los datos para la actualización
        $updateData = [
            'cedula' => $cedula,
            'academic_level' => $academicLevel,
            'level_education' => $levelEducation,
            'area_knowledge' => $areaKnowledge,
            'institution' => $institution,
            'title_obtained' => $titleObtained,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'semesters_passed' => $semestersPassed, // Nuevo campo
            'graduated' => $graduated, // Nuevo campo
            'professional_card_number' => $professionalCardNumber, // Nuevo campo
        ];

        // Solo actualizar el archivo si se subió uno nuevo
        if ($filePath) {
            // Eliminar el archivo anterior si existe
            if (!empty($currentData['academic_file']) && file_exists(FCPATH . $currentData['academic_file'])) {
                unlink(FCPATH . $currentData['academic_file']);
            }
            // Incluir la nueva ruta del archivo
            $updateData['academic_file'] = $filePath;
        }

        // Intentar actualizar los datos
        if ($academicInfoModel->update($cedula, $updateData)) {
            return redirect()->to('user/academic-info/edit/' . $cedula)->with('success', 'Información académica actualizada con éxito.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar la información académica.');
        }
    }

    public function edit($cedula) {
        $academicInfoModel = new AcademicInfoModel();
        $user = new UserModel();
        $academicInfo = $academicInfoModel->where('cedula', $cedula)->first();
        $user = $user->where('cedula', $cedula)->first();
        $profilePhoto = $userData['profile_photo'] ?? null;
        if (!$academicInfo) {
            return redirect()->to('academic-info/success')->with('error', 'Usuario no encontrado');
        }

        // Aquí puedes obtener todos los campos directamente
        $data = [
            'user_cedula' => $academicInfo['cedula'] ?? null,
            'user_name' => $user['name'] ?? 'Desconocido',
            'user_last_name' => $user['last_name'] ?? 'Desconocido',
            'user_status' => $academicInfo['status'] ?? 'Desconocido',
            'institution' => $academicInfo['institution'] ?? 'Desconocida',
            'profilePhoto' => $profilePhoto, // Agregar la foto de perfil a los datos
            'academic_level' => $academicInfo['academic_level'] ?? null,
            'level_education' => $academicInfo['level_education'] ?? null,
            'pregrado_formation' => $academicInfo['pregrado_formation'] ?? null,
            'area_knowledge' => $academicInfo['area_knowledge'] ?? null,
            'title_obtained' => $academicInfo['title_obtained'] ?? null,
            'start_date' => $academicInfo['start_date'] ?? null,
            'end_date' => $academicInfo['end_date'] ?? null,
            'semesters_passed' => $academicInfo['semesters_passed'] ?? null, // Nuevo campo
            'graduated' => $academicInfo['graduated'] ?? null, // Nuevo campo
            'professional_card_number' => $academicInfo['professional_card_number'] ?? null, // Nuevo campo
        ];

        return view('academic_info_edit', $data);
    }

    public function downloadFile($filename) {
        $path = WRITEPATH . 'uploads/' . $filename;  // Ruta completa del archivo

        if (file_exists($path)) {
            return $this->response->download($path, null);  // Descargar el archivo
        } else {
            return redirect()->back()->with('error', 'Archivo no encontrado');  // Si no existe el archivo
        }
    }

    public function viewPdf($filename) {
        $file_path = FCPATH . 'uploads/' . $filename; // Usa fcpath en lugar de WRITEPATH
        // Verifica si el archivo existe
        if (file_exists($file_path)) {
            // Si el archivo existe, lo devuelve con el tipo de contenido adecuado para mostrar en el navegador
            return $this->response->setHeader('Content-Type', 'application/pdf')
                            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
                            ->setBody(file_get_contents($file_path));
        } else {
            // Si el archivo no existe, redirige a una página de error
            return redirect()->to('error')->with('error', 'El archivo no fue encontrado.');
        }
    }
}
