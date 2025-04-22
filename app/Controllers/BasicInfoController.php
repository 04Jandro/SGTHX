<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\PersonalInfoModel;
use App\Models\AcademicInfoModel;
use App\Models\WorkExperienceModel;
use App\Models\AdditionalStudyModel;
use App\Models\TeachingWorkExperienceModel;
use App\Models\UserInfoModel;  
use App\Models\BasicInfoModel;

class BasicInfoController extends Controller {

    protected $userInfoModel;  // Declarar la propiedad para el modelo

    public function __construct() {
       
        $this->userInfoModel = new UserInfoModel();
        $this->basicInfoModel = new BasicInfoModel();
    }

    public function index() {
        $userModel = new UserModel();

        // Obtener la cédula desde la sesión
        $cedula = session()->get('cedula');
        if (!$cedula) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
        }

        // Obtener los datos del usuario por cédula
        $data['user'] = $userModel->where('cedula', $cedula)->first();

        // Si no se encuentra el usuario por la cédula, redirigir con un mensaje de error
        if (!$data['user']) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }

        // Obtener la foto de perfil
        $profilePhoto = $data['user']['profile_photo'] ?? null;
        $data['profilePhoto'] = $profilePhoto;

        // Asignar datos del usuario
        $data['user_name'] = $data['user']['name'];
        $data['user_last_name'] = $data['user']['last_name'];
        $data['user_status'] = $data['user']['status'];
        $data['user_cedula'] = $data['user']['cedula'];
        $data['user_profile_photo'] = $profilePhoto;

        // Obtener datos de las tablas relacionadas (información personal, académica, laboral y estudios adicionales)
        $personalInfoModel = new PersonalInfoModel();
        $academicInfoModel = new AcademicInfoModel();
        $workExperienceModel = new WorkExperienceModel();
        $additionalStudyModel = new AdditionalStudyModel();
        $teachingExperienceModel = new TeachingWorkExperienceModel();
        $basicInfoModel = new BasicInfoModel();  // Agregamos el modelo de idiomas
        // Obtener la información relacionada
        $personalInfo = $personalInfoModel->where('cedula', $cedula)->first();
        $academicInfo = $academicInfoModel->where('cedula', $cedula)->findAll();
        $workExperience = $workExperienceModel->where('cedula', $cedula)->findAll();
        $additionalStudies = $additionalStudyModel->where('cedula', $cedula)->findAll();
        $teachingExperience = $teachingExperienceModel->where('cedula', $cedula)->findAll();

        // Asegurarse de que teachingExperience esté definido y pasarla a la vista
        $data['teachingExperience'] = $teachingExperience ?? [];  // Si no hay datos, pasar un arreglo vacío
        $data['personalInfo'] = $personalInfo ?? null;  // Si no hay info, pasar null
        $data['academicInfo'] = $academicInfo;
        $data['workExperience'] = $workExperience;
        $data['additionalStudies'] = $additionalStudies;

        // Recopilar archivos
        $files = [];

        // Para cada tipo de información, obtenemos los archivos correspondientes
        if ($academicInfo) {
            $files['academicInfo'] = $academicInfo;
        }
        if ($workExperience) {
            $files['workExperience'] = $workExperience;
        }
        if ($additionalStudies) {
            $files['additionalStudies'] = $additionalStudies;
        }
        if ($personalInfo && isset($personalInfo['cedula_file'])) {
            $files['personalInfo'] = [$personalInfo['cedula_file']];
        }

        // Obtener idiomas del usuario
        $userLanguages = $basicInfoModel->where('cedula', $cedula)->findAll();  // Obtener todos los idiomas del usuario
        $data['userLanguages'] = $userLanguages;  // Asignamos la variable de idiomas a los datos
        // Pasar todos los datos a la vista
        $data['files'] = $files; // Agregar los archivos a los datos
        // Pasar todos los datos a la vista para editar
        return view('basic_info_form', $data); // Vista para mostrar los datos
    }

    public function updateBasicInfo() {
        $userId = $this->request->getPost('cedula');

        // Obtener los datos del formulario de información básica
        $data = [
            'obtained_title' => $this->request->getPost('obtained_title'),
            'max_level_academic' => $this->request->getPost('max_level_academic'), 
            'graduation_date' => $this->request->getPost('graduation_date'),
            'title_date' => $this->request->getPost('title_date'),
        ];

        // Actualizar la información personal del usuario
        $updateStatus = $this->userInfoModel->update($userId, $data);

        if ($updateStatus) {
            // Procesar los idiomas
            $languages = $this->request->getPost('languages');
            $speaks = $this->request->getPost('speaks');
            $reads = $this->request->getPost('reads');
            $writes = $this->request->getPost('writes');

            if ($languages) {
                // Convertir la cadena de idiomas a un array
                $languagesArray = explode(',', $languages);
                $languagesArray = array_map('trim', $languagesArray);

                foreach ($languagesArray as $language) {
                    // Asignar NULL si no hay valores para los campos
                    $speaksValue = ($speaks && isset($speaks[$language])) ? $speaks[$language] : NULL;
                    $readsValue = ($reads && isset($reads[$language])) ? $reads[$language] : NULL;
                    $writesValue = ($writes && isset($writes[$language])) ? $writes[$language] : NULL;

                    // Insertar o actualizar el idioma
                    $this->insertUserLanguage($userId, $language, $speaksValue, $readsValue, $writesValue);
                }
            }

            // Actualizar los idiomas del usuario
            if ($speaks && $reads && $writes) {
                foreach ($speaks as $id => $speak) {
                    $this->basicInfoModel->update($id, [
                        'speaks' => $speak ? $speak : NULL,
                        'reads' => isset($reads[$id]) ? $reads[$id] : NULL,
                        'writes' => isset($writes[$id]) ? $writes[$id] : NULL,
                    ]);
                }
            }

            return redirect()->to('user/basic-info')->with('success', 'Datos actualizados correctamente');
        } else {
            return redirect()->to('error')->with('error', 'Hubo un problema al actualizar los datos');
        }
    }

    /**
     * Función para insertar un nuevo idioma en la base de datos.
     */
    private function insertUserLanguage($userId, $language, $speaks, $reads, $writes) {
        $this->basicInfoModel->insert([
            'cedula' => $userId,
            'language_name' => $language,
            'speaks' => $speaks,
            'reads' => $reads,
            'writes' => $writes
        ]);
    }

    /**
     * Función para eliminar un idioma del usuario.
     */
    public function deleteUserLanguage($languageId) {
        // Verificar si el idioma existe
        $language = $this->basicInfoModel->find($languageId);

        if ($language) {
            // Eliminar el idioma
            $this->basicInfoModel->delete($languageId);

            return redirect()->to('user/basic-info')->with('success', 'Idioma eliminado correctamente');
        } else {
            return redirect()->to('user/basic-info')->with('error', 'Idioma no encontrado');
        }
    }
}
