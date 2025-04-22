<?php

namespace App\Controllers;

use App\Models\PersonalInfoModel;
use App\Models\AcademicInfoModel;
use App\Models\WorkExperienceModel;
use App\Models\AdditionalStudyModel;
use App\Models\UserModel;
use App\Models\TeachingWorkExperienceModel;

class UserInfoController extends BaseController {

public function index() {
    // Obtener la cédula desde la sesión
    $cedula = session()->get('cedula');

    if (!$cedula) {
        return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
    }

    $userModel = new UserModel();

    // Obtiene los datos del usuario por ID
    $data['user'] = $userModel->find($cedula);

    if (!$data['user']) {
        return redirect()->to('/')->with('error', 'Usuario no encontrado.');
    }

    // Obtener la cédula directamente desde el usuario obtenido por ID
    $cedula = $data['user']['cedula'];  
    $user = $userModel->where('cedula', $cedula)->first();

    if (!$user) {
        return redirect()->to('/')->with('error', 'Usuario no encontrado.');
    }

    // Obtener la foto de perfil
    $profilePhoto = $user['profile_photo'] ?? null;
    $data['profilePhoto'] = $profilePhoto;

    // Asignar datos del usuario
    $data['user_name'] = $user['name'] ?? 'N/A';
    $data['user_last_name'] = $user['last_name'] ?? 'N/A';
    $data['user_status'] = $user['status'] ?? 'No definido';
    $data['user_cedula'] = $user['cedula'];
    $data['user_profile_photo'] = $profilePhoto;

    // Obtener datos de las tablas relacionadas
    $personalInfoModel = new PersonalInfoModel();
    $academicInfoModel = new AcademicInfoModel();
    $workExperienceModel = new WorkExperienceModel();
    $additionalStudyModel = new AdditionalStudyModel();
    $teachingExperienceModel = new TeachingWorkExperienceModel();

    // Obtener la información relacionada asegurando que devuelve arrays
    $personalInfo = $personalInfoModel->asArray()->where('cedula', $cedula)->first() ?? [];
    $academicInfo = $academicInfoModel->asArray()->where('cedula', $cedula)->findAll();
    $workExperience = $workExperienceModel->asArray()->where('cedula', $cedula)->findAll();
    $additionalStudies = $additionalStudyModel->asArray()->where('cedula', $cedula)->findAll();
    $teachingExperience = $teachingExperienceModel->asArray()->where('cedula', $cedula)->findAll();

    // Pasar la información a la vista, evitando errores si no hay información
    $data['teachingExperience'] = !empty($teachingExperience) ? $teachingExperience : [];
    $data['personalInfo'] = !empty($personalInfo) ? $personalInfo : null;
    $data['academicInfo'] = $academicInfo ?? [];
    $data['workExperience'] = $workExperience ?? [];
    $data['additionalStudies'] = $additionalStudies ?? [];

    // Recopilar archivos
    $files = [];

    // Para cada tipo de información, obtenemos los archivos correspondientes si existen
    if (!empty($academicInfo)) {
        $files['academicInfo'] = $academicInfo;
    }
    if (!empty($workExperience)) {
        $files['workExperience'] = $workExperience;
    }
    if (!empty($additionalStudies)) {
        $files['additionalStudies'] = $additionalStudies;
    }
    if (!empty($personalInfo) && isset($personalInfo['cedula_file'])) {
        $files['personalInfo'][] = [
            'cedula_file' => $personalInfo['cedula_file'],
            'cedula' => $personalInfo['cedula'] ?? 'No disponible'
        ];
    }

    // Pasar los archivos a la vista
    $data['files'] = $files;

    // Depuración opcional para verificar datos antes de la vista
    // echo '<pre>'; print_r($data); exit();

    // Cargar la vista con los datos
    return view('my_information', $data);
}


    public function updateData($cedula) {
        // Obtener los modelos
        $personalInfoModel = new PersonalInfoModel();
        $academicInfoModel = new AcademicInfoModel();
        $workExperienceModel = new WorkExperienceModel();
        $teachingExperienceModel = new TeachingWorkExperienceModel();
        $additionalStudyModel = new AdditionalStudyModel();

        try {
            // Obtener todos los datos del formulario
            $allPostData = $this->request->getPost();
            $personalData = $this->request->getPost();
            // 1. Actualizar información personal
            $personalInfoModel->where('cedula', $cedula)->set($personalData)->update();


            // 2. Actualizar información académica
            $academicData = $this->request->getPost('academic');
            if (!empty($academicData) && is_array($academicData)) {
                foreach ($academicData as $academicId => $data) {
                    if (is_array($data)) {
                        $existingRecord = $academicInfoModel->where([
                                    'id' => $academicId,
                                    'cedula' => $cedula
                                ])->first();

                        if ($existingRecord) {
                            $data['cedula'] = $cedula;
                            $academicInfoModel->update($academicId, $data);
                        }
                    }
                }
            }

            // 3. Actualizar experiencia laboral
            $workExperienceData = $this->request->getPost('work_experience');
            if (!empty($workExperienceData) && is_array($workExperienceData)) {
                foreach ($workExperienceData as $experienceId => $data) {
                    if (is_array($data)) {
                        $existingRecord = $workExperienceModel->where([
                                    'id' => $experienceId,
                                    'cedula' => $cedula
                                ])->first();

                        if ($existingRecord) {
                            $data['cedula'] = $cedula;
                            $workExperienceModel->update($experienceId, $data);
                        }
                    }
                }
            }

            // 4. Actualizar experiencia docente
            $teachingData = $this->request->getPost('teaching_experience');
            if (!empty($teachingData) && is_array($teachingData)) {
                foreach ($teachingData as $teachingId => $data) {
                    if (is_array($data)) {
                        $existingRecord = $teachingExperienceModel->where([
                                    'id' => $teachingId,
                                    'cedula' => $cedula
                                ])->first();

                        if ($existingRecord) {
                            $data['cedula'] = $cedula;
                            $teachingExperienceModel->update($teachingId, $data);
                        }
                    }
                }
            }

            // 5. Actualizar estudios adicionales
            $additionalStudyData = $this->request->getPost('additional_study');
            if (!empty($additionalStudyData) && is_array($additionalStudyData)) {
                foreach ($additionalStudyData as $studyId => $data) {
                    if (is_array($data)) {
                        $existingRecord = $additionalStudyModel->where([
                                    'id' => $studyId,
                                    'cedula' => $cedula
                                ])->first();

                        if ($existingRecord) {
                            $data['cedula'] = $cedula;
                            $additionalStudyModel->update($studyId, $data);
                        }
                    }
                }
            }

            return redirect()->to("user/my-information")
                            ->with('success', 'Información actualizada correctamente.');
        } catch (\Exception $e) {
            log_message('error', 'Error en actualización: ' . $e->getMessage());
            return redirect()->back()
                            ->with('error', 'Error al actualizar los datos: ' . $e->getMessage());
        }
    }

    public function view($userId) {
        // Cargar los modelos
        $personalInfoModel = new PersonalInfoModel();  // Instancia del modelo de Información Personal
        $academicInfoModel = new AcademicInfoModel();  // Instancia del modelo de Información Académica
        $workExperienceModel = new WorkExperienceModel();  // Instancia del modelo de Experiencia Laboral
        $additionalStudyModel = new AdditionalStudyModel();  // Instancia del modelo de Estudios Adicionales
        // Traer la información del usuario desde las diferentes tablas
        $personalInfo = $personalInfoModel->where('user_id', $userId)->first();  // Información personal usando el userId
        $academicInfo = $academicInfoModel->where('user_id', $userId)->first();  // Información académica usando el userId
        $workExperience = $workExperienceModel->where('user_id', $userId)->findAll();  // Experiencia laboral usando el userId
        $additionalStudies = $additionalStudyModel->where('user_id', $userId)->findAll();  // Estudios adicionales usando el userId
        // Si no se encuentra la información básica
        if (!$personalInfo) {
            return redirect()->to('/user/personal-info')->with('error', 'Información no encontrada.');  // Si no se encuentra la información personal, redirige a la página de ingreso de información
        }

        // Pasar los datos a la vista
        return view('user_info/view', [
            'personalInfo' => $personalInfo, // Pasa la información personal a la vista
            'academicInfo' => $academicInfo, // Pasa <la información académica a la vista
            'workExperience' => $workExperience, // Pasa la experiencia laboral a la vista
            'additionalStudies' => $additionalStudies  // Pasa los estudios adicionales a la vista
        ]);
    }
}
