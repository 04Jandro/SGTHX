<?php

namespace App\Controllers;

use App\Models\UserModel;  // Agregar esta línea
use App\Models\WorkExperienceModel;
use App\Models\TeachingWorkExperienceModel;
use App\Models\PersonalInfoModel;
use App\Models\AcademicInfoModel;
use CodeIgniter\Controller;

class ExperienceController extends BaseController {

    public function index() {
        // Obtener el ID del usuario desde la sesión
        $cedula = session()->get('cedula');
        // Verificar si el usuario está autenticado
        if (!$cedula) {
            return redirect()->to('/');
        }

        // Obtener los modelos
        $userModel = new UserModel();
        $personalInfoModel = new PersonalInfoModel();
        $academicInfoModel = new AcademicInfoModel();
        $workExperienceModel = new WorkExperienceModel();  // Instancia el modelo WorkExperienceModel
        // Consultar los datos del usuario
        $user = $userModel->find($cedula);
        $ProfilePhoto = $user['profile_photo'] ?? null;
        if (!$user) {
            return redirect()->to('/error')->with('message', 'Usuario no encontrado.');
        }

        // Consultar la experiencia laboral (o el tipo de datos que necesites)
        $workExperienceData = $workExperienceModel->where('cedula', $cedula)->findAll(); // Ejemplo de consulta
        // Pasar los datos a la vista
        $data = [
            'user_cedula' => $user['cedula'],
            'user_name' => $user['name'],
            'user_last_name' => $user['last_name'],
            'user_status' => $user['status'],
            'user_count' => $userModel->countAll(),
            'formulario_count' => $personalInfoModel->countAll(),
            'academic_count' => $academicInfoModel->countAll(),
            'profilePhoto' => $ProfilePhoto,
            'workExperienceData' => $workExperienceData // Pasar la experiencia laboral a la vista
        ];

        return view('experience_form', $data);
    }

public function save() {
    // Validar que el usuario esté autenticado
    $cedula = session()->get('cedula');
    if (!$cedula) {
        return redirect()->to('/')->with('error', 'Sesión no iniciada');
    }

    // Configuración de carga de archivos
    $workExperienceFile = $this->request->getFile('workexperience_file');
    $teachingExperienceFile = $this->request->getFile('teachingexperience_file');

    // Recoger todos los datos del formulario
    $workExperienceData = [
        'cedula' => $cedula,
        'current_employer' => $this->request->getPost('current_employer'),
        'is_current_job' => $this->request->getPost('is_current_job'),
        'country_employ' => $this->request->getPost('country_employ'),
        'department' => $this->request->getPost('department'),
        'municipality' => $this->request->getPost('municipality'),
        'phones' => $this->request->getPost('phones'),
        'emails' => $this->request->getPost('emails'),
        'start_date' => $this->request->getPost('start_date'),
        'end_date' => $this->request->getPost('end_date'),
        'position' => $this->request->getPost('position'),
        'dependency' => $this->request->getPost('dependency'),
        'address_employ' => $this->request->getPost('address_employ'),
        'verified' => $this->request->getPost('verified') ? 1 : 0,
        'workexperience_file' => $this->request->getFile('workexperience_file') ? $this->request->getFile('workexperience_file')->getName() : null,
        'company_type' => $this->request->getPost('company_type')
    ];

    $teachingExperienceData = [
        'cedula' => $cedula,
        'educational_institution' => $this->request->getPost('educational_institution'),
        'teaching_academic_level' => $this->request->getPost('teaching_academic_level'),
        'teaching_area_of_knowledge' => $this->request->getPost('teaching_area_of_knowledge'),
        'country' => $this->request->getPost('country'),
        'teaching_start_date' => $this->request->getPost('start_date'),
        'teaching_end_date' => $this->request->getPost('end_date'),
        'teaching_verified' => $this->request->getPost('verified') ? 1 : 0
    ];

    // Inicializar los modelos
    $workExperienceModel = new WorkExperienceModel();
    $teachingExperienceModel = new TeachingWorkExperienceModel();

    // Manejar archivos
    $workExperienceFilePath = null;
    $teachingExperienceFilePath = null;

    // Configurar ruta de almacenamiento de archivos
    $uploadPath = FCPATH . 'uploads/experience_files/' . $cedula . '/';

    // Crear directorio si no existe
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    // Procesar archivo de experiencia laboral
    if ($workExperienceFile && $workExperienceFile->isValid() && !$workExperienceFile->hasMoved() && !empty($workExperienceData['current_employer'])) {
        $newWorkFileName = $workExperienceFile->getRandomName();
        // Guardar la ruta completa con 'uploads/experience_files/'
        $workExperienceFilePath = 'uploads/experience_files/' . $cedula . '/' . $newWorkFileName;

        try {
            $workExperienceFile->move($uploadPath, $newWorkFileName);
        } catch (\Exception $e) {
            log_message('error', 'Error subiendo archivo de experiencia laboral: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'No se pudo subir el archivo de experiencia laboral');
        }

        // Agregar ruta de archivo a los datos
        $workExperienceData['workexperience_file'] = $workExperienceFilePath;
    }

    // Procesar archivo de experiencia docente
    if ($teachingExperienceFile && $teachingExperienceFile->isValid() && !$teachingExperienceFile->hasMoved()) {
        $newTeachingFileName = $teachingExperienceFile->getRandomName();
        // Guardar la ruta completa con 'uploads/experience_files/'
        $teachingExperienceFilePath = 'uploads/experience_files/' . $cedula . '/' . $newTeachingFileName;

        try {
            $teachingExperienceFile->move($uploadPath, $newTeachingFileName);
        } catch (\Exception $e) {
            log_message('error', 'Error subiendo archivo de experiencia docente: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'No se pudo subir el archivo de experiencia docente');
        }

        // Agregar ruta de archivo a los datos
        $teachingExperienceData['teachingexperience_file'] = $teachingExperienceFilePath;
    }

    // Iniciar transacción para asegurar consistencia
    $db = \Config\Database::connect();
    $db->transStart();

    try {
        // Verificar si el campo 'current_employer' tiene valor
        if (!empty($workExperienceData['current_employer'])) {
            // Guardar experiencia laboral solo si el campo 'current_employer' no está vacío
            $workExperienceModel->insertExperience($workExperienceData);
        }

        // Guardar experiencia docente (si aplica)
        if (!empty($teachingExperienceData['educational_institution'])) {
            $teachingExperienceModel->insertTeachingExperience($teachingExperienceData);
        }

        // Completar transacción
        $db->transComplete();

        // Verificar si la transacción fue exitosa
        if ($db->transStatus() === FALSE) {
            throw new \Exception('Error al guardar la información');
        }

        // Redirigir con mensaje de éxito
        return redirect()->to('user/experience-info')
                         ->with('success', 'Experiencia guardada exitosamente');
    } catch (\Exception $e) {
        // Revertir transacción en caso de error
        $db->transRollback();

        // Eliminar archivos subidos en caso de error
        if ($workExperienceFilePath) {
            @unlink(FCPATH . 'uploads/' . $workExperienceFilePath);
        }
        if ($teachingExperienceFilePath) {
            @unlink(FCPATH . 'uploads/' . $teachingExperienceFilePath);
        }

        // Registrar error para depuración
        log_message('error', 'Error guardando experiencia: ' . $e->getMessage());

        // Redirigir con mensaje de error
        return redirect()->back()
                         ->withInput()
                         ->with('error', 'No se pudo guardar la experiencia: ' . $e->getMessage());
    }
}

    // Método de validación para experiencia laboral
    private function validateWorkExperience($data) {
        $errors = [];

        // Validaciones personalizadas
        if (empty($data['entity_name'])) {
            $errors[] = 'El nombre de la entidad es obligatorio';
        }

        if (empty($data['position'])) {
            $errors[] = 'El cargo es obligatorio';
        }

        if (empty($data['start_date'])) {
            $errors[] = 'La fecha de inicio es obligatoria';
        }

        return [
            'success' => empty($errors),
            'errors' => $errors
        ];
    }

    // Método de validación para experiencia docente
    private function validateTeachingExperience($data) {
        $errors = [];

        // Solo validar si se proporciona información de institución educativa
        if (!empty($data['educational_institution'])) {
            if (empty($data['academic_level'])) {
                $errors[] = 'El nivel académico es obligatorio para experiencia docente';
            }

            if (empty($data['area_of_knowledge'])) {
                $errors[] = 'El área de conocimiento es obligatoria para experiencia docente';
            }
        }

        return [
            'success' => empty($errors),
            'errors' => $errors
        ];
    }
}
