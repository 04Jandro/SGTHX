<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\PersonalInfoModel;
use App\Models\AcademicInfoModel;
use App\Models\WorkExperienceModel;
use App\Models\AdditionalStudyModel;
use App\Models\TeachingWorkExperienceModel;
use App\Models\DocumentUploadModel;

class UserController extends BaseController {

    public function __construct() {
        parent::__construct(); // Asegura que se ejecute el constructor de BaseController
    }

    public function index() {
        $cedula = session()->get('cedula');

// Verificar si el usuario ha iniciado sesión
        if (!$cedula) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('cedula', $cedula)->first(); // Obtener el usuario por su cédula
// Verificar si el usuario existe
        if (!$user) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }

// Obtener la foto de perfil desde el usuario
        $ProfilePhoto = $user['profile_photo'] ?? null;

// Datos del usuario en la sesión
        $data['user_name'] = $user['name'];
        $data['user_last_name'] = $user['last_name'];
        $data['user_status'] = $user['status'];
        $data['user_cedula'] = $user['cedula'];
        $data['profilePhoto'] = $ProfilePhoto;
// Obtener todos los usuarios para la vista
        $data['users'] = $userModel->findAll();

// Retornar la vista 'security_panel' con los datos del usuario y otros datos
        return view('security_panel', $data); // Vista para mostrar los detalles del usuario
    }

    public function users() {
        $userModel = new UserModel();

// Obtiene todos los usuarios
        $data['users'] = $userModel->findAll();

// Obtener el ID del usuario autenticado desde la sesión
        $cedula = session()->get('cedula');

// Verificar si el usuario está autenticado
        if ($cedula) {
// Buscar los datos del usuario autenticado
            $user = $userModel->where('cedula', $cedula)->first();

            if ($user) {
// Obtener la foto de perfil desde el usuario
                $ProfilePhoto = $user['profile_photo'] ?? null;

// Asignar datos del usuario autenticado a la variable $data
                $data['user_name'] = $user['name'];
                $data['user_last_name'] = $user['last_name'];
                $data['user_status'] = $user['status'];
                $data['user_cedula'] = $user['cedula'];
                $data['user_profile_photo'] = $ProfilePhoto; // Foto de perfil
            }
        }

// Asegúrate de pasar también la foto de perfil en $data
        $data['profilePhoto'] = $ProfilePhoto;

// Itera sobre los usuarios y agrega el índice 'has_personal_info' si no existe
        foreach ($data['users'] as &$user) {
// Asegúrate de que cada usuario tenga el índice 'has_personal_info'
            $user['has_personal_info'] = isset($user['has_personal_info']) ? $user['has_personal_info'] : false;
        }

// Retorna la vista 'user_list' con los datos
        return view('user_list', $data); // Vista para mostrar usuarios
    }

// Guardar un nuevo usuario
    public function save() {
        $userModel = new UserModel();

// Recibe los datos del formulario
        $data = [
            'cedula' => $this->request->getPost('cedula'),
            'name' => $this->request->getPost('name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
        ];

// Guarda el nuevo usuario
        if ($userModel->save($data)) {
            return redirect()->to('/admin/security')->with('success', 'Usuario creado correctamente');
        } else {
            return redirect()->to('/admin/security/create')->with('error', 'Error al crear el usuario');
        }
    }

// Mostrar formulario para editar un usuario
public function edit($id) {
    $userModel = new UserModel();
    $documentUploadModel = new DocumentUploadModel();

    // Obtiene los datos del usuario por ID
    $data['user'] = $userModel->find($id);

    if (!$data['user']) {
        return redirect()->to('/')->with('error', 'Usuario no encontrado.');
    }

    // Obtener la cédula directamente desde el usuario obtenido por ID
    $cedula = $data['user']['cedula'] ?? null;

    if (!$cedula) {
        return redirect()->to('/')->with('error', 'Cédula no encontrada.');
    }

    // Verificar si existe el usuario con esa cédula
    $user = $userModel->where('cedula', $cedula)->first();
    if (!$user) {
        return redirect()->to('/')->with('error', 'Usuario no encontrado.');
    }

    // Obtener la foto de perfil
    $data['profilePhoto'] = $user['profile_photo'] ?? null;

    // Asignar datos del usuario
    $data['user_name'] = $user['name'] ?? 'N/A';
    $data['user_last_name'] = $user['last_name'] ?? 'N/A';
    $data['user_status'] = $user['status'] ?? 'No definido';
    $data['user_cedula'] = $user['cedula'] ?? 'N/A';
    $data['user_profile_photo'] = $data['profilePhoto'];

    // Obtener información adicional de otras tablas relacionadas
    $personalInfoModel = new PersonalInfoModel();
    $academicInfoModel = new AcademicInfoModel();
    $workExperienceModel = new WorkExperienceModel();
    $additionalStudyModel = new AdditionalStudyModel();
    $teachingExperienceModel = new TeachingWorkExperienceModel();

    $data['personalInfo'] = $personalInfoModel->asArray()->where('cedula', $cedula)->first() ?? [];
    $data['academicInfo'] = $academicInfoModel->asArray()->where('cedula', $cedula)->findAll() ?? [];
    $data['workExperience'] = $workExperienceModel->asArray()->where('cedula', $cedula)->findAll() ?? [];
    $data['additionalStudies'] = $additionalStudyModel->asArray()->where('cedula', $cedula)->findAll() ?? [];
    $data['teachingExperience'] = $teachingExperienceModel->asArray()->where('cedula', $cedula)->findAll() ?? [];

    // Verificar sesión de usuario
    if (!session()->get('cedula')) {
        return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
    }

    // Obtener documentos subidos relacionados con la cédula del usuario
    $documents = $documentUploadModel->asArray()->where('cedula', $cedula)->findAll();
    
    $data['documents'] = $documents;

    // Pasar los archivos adicionales a la vista
    $files = [];

    if (!empty($data['academicInfo'])) {
        $files['academicInfo'] = $data['academicInfo'];
    }
    if (!empty($data['workExperience'])) {
        $files['workExperience'] = $data['workExperience'];
    }
    if (!empty($data['additionalStudies'])) {
        $files['additionalStudies'] = $data['additionalStudies'];
    }
    if (!empty($data['personalInfo']) && isset($data['personalInfo']['cedula_file'])) {
        $files['personalInfo'][] = [
            'cedula_file' => $data['personalInfo']['cedula_file'],
            'cedula' => $data['personalInfo']['cedula'] ?? 'No disponible'
        ];
    }

    $data['files'] = $files;

    return view('user_edit', $data);
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

            return redirect()->to("admin/security/edit/$cedula")->with('success', 'Información actualizada correctamente.');
        } catch (\Exception $e) {
            // Manejar excepciones si es necesario
        }
    }

// Actualizar los datos de un usuario
    public function update($id) {
        $userModel = new UserModel();
        $personalInfoModel = new PersonalInfoModel();
        $academicInfoModel = new AcademicInfoModel();
        $workExperienceModel = new WorkExperienceModel();
        $additionalStudyModel = new AdditionalStudyModel();

// Verifica si el usuario existe antes de actualizar
        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

// Obtén los datos del formulario
        $data = [
            'cedula' => $this->request->getPost('cedula'),
            'name' => $this->request->getPost('name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
            'document_type' => $this->request->getPost('document_type'),
            'phone' => $this->request->getPost('phone'),
        ];

// Manejo especial para la contraseña: solo actualizar si no está vacía
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

// Intentar actualizar la información básica del usuario
        if ($userModel->update($id, $data)) {
            try {
// Actualizar la información relacionada (personal, académico, experiencia, estudios adicionales)
// Actualizar los datos de la información personal
                $personalData = [
                    'cedula' => $this->request->getPost('cedula'),
                    'address' => $this->request->getPost('address'),
                    'phone' => $this->request->getPost('phone'),
                    'document_type' => $this->request->getPost('document_type'),
                    'place_of_issue' => $this->request->getPost('place_of_issue'),
                    'date_of_issue' => $this->request->getPost('date_of_issue'),
                    'gender' => $this->request->getPost('gender'),
                    'nationality' => $this->request->getPost('nationality'),
                    'first_name' => $this->request->getPost('first_name'),
                    'middle_name' => $this->request->getPost('middle_name'),
                    'last_name' => $this->request->getPost('last_name'),
                    'second_last_name' => $this->request->getPost('second_last_name'),
                    'birth_country' => $this->request->getPost('birth_country'),
                    'birth_department' => $this->request->getPost('birth_department'),
                    'birth_city' => $this->request->getPost('birth_city'),
                    'birth_date' => $this->request->getPost('birth_date'),
                    'age' => $this->request->getPost('age'),
                    'mobile' => $this->request->getPost('mobile'),
                    'military_card_type' => $this->request->getPost('military_card_type'),
                    'military_card_number' => $this->request->getPost('military_card_number'),
                    'military_district' => $this->request->getPost('military_district'),
                    'marital_status' => $this->request->getPost('marital_status'),
                    'spouse_document_type' => $this->request->getPost('spouse_document_type'),
                    'spouse_id_number' => $this->request->getPost('spouse_id_number'),
                    'spouse_first_name' => $this->request->getPost('spouse_first_name'),
                    'spouse_last_name' => $this->request->getPost('spouse_last_name'),
                ];
                $personalInfoModel->update($id, $personalData);

// Actualizar los datos de la información académica
                $academicData = [
                    'cedula' => $this->request->getPost('cedula'),
                    'academic_level' => $this->request->getPost('academic_level'),
                    'level_education' => $this->request->getPost('level_education'),
                    'area_knowledge' => $this->request->getPost('area_knowledge'),
                    'institution' => $this->request->getPost('institution'),
                    'title_obtained' => $this->request->getPost('title_obtained'),
                    'start_date' => $this->request->getPost('start_date'),
                    'end_date' => $this->request->getPost('end_date'),
                ];
                $academicInfoModel->update($id, $academicData);

// Actualizar experiencia laboral y otros modelos relacionados
// Repetir para los demás modelos (workExperienceModel, additionalStudyModel, etc.)

                return redirect()->to('admin/security/users')->with('success', 'Usuario actualizado correctamente');
            } catch (\Exception $e) {
                return redirect()->to('admin/security/edit/' . $id)->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
            }
        } else {
            return redirect()->to('admin/security/edit/' . $id)->with('error', 'Error al actualizar el usuario');
        }
    }

// Eliminar un usuario
    public function delete($id) {
        $userModel = new UserModel();

        if ($userModel->delete($id)) {
            return redirect()->to('admin/security/users')->with('success', 'Usuario eliminado correctamente');
        } else {
            return redirect()->to('admin/security/users')->with('error', 'Error al eliminar el usuario');
        }
    }

    public function indexhelp() {
// Obtener la cédula desde la sesión
        $cedula = session()->get('cedula');

// Verificar si no está autenticado
        if (!$cedula) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
        }

// Cargar el modelo de usuario
        $userModel = new UserModel();
        $user = $userModel->where('cedula', $cedula)->first(); // Obtener el usuario por cédula
// Verificar si el usuario existe
        if (!$user) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }

// Datos del usuario en la sesión
        $data = [
            'user_name' => $user['name'],
            'user_last_name' => $user['last_name'],
            'user_status' => $user['status'],
            'user_cedula' => $user['cedula']
        ];

// Obtener la foto de perfil del usuario (si existe)
        $data['profilePhoto'] = $user['profile_photo'] ?? null;

// Obtiene todos los usuarios, si necesitas mostrar todos los usuarios
        $data['users'] = $userModel->findAll();

// Retorna la vista con los datos
        return view('user_help', $data); // Vista para mostrar usuarios
    }

    public function indexHelpAdmin() {
// Obtener la cédula desde la sesión
        $cedula = session()->get('cedula');

// Verificar si no está autenticado
        if (!$cedula) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
        }

// Cargar el modelo de usuario
        $userModel = new UserModel();
        $user = $userModel->where('cedula', $cedula)->first(); // Obtener el usuario por cédula
// Verificar si el usuario existe
        if (!$user) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }

// Datos del usuario en la sesión
        $data = [
            'user_name' => $user['name'],
            'user_last_name' => $user['last_name'],
            'user_status' => $user['status'],
            'user_cedula' => $user['cedula']
        ];

// Obtener la foto de perfil del usuario (si existe)
        $data['profilePhoto'] = $user['profile_photo'] ?? null;

// Obtiene todos los usuarios, si necesitas mostrar todos los usuarios
        $data['users'] = $userModel->findAll();

// Retorna la vista con los datos
        return view('admin_help', $data); // Vista para mostrar usuarios
    }

    public function error() {
        $cedula = session()->get('cedula');

        if (!$cedula) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
        }

        $userModel = new UserModel();
        $cedula = session()->get('cedula');

        if (!$cedula) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('cedula', $cedula)->first(); // Obtiene el usuario por su cédula

        if (!$user) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }

// Datos del usuario en la sesión
        $data['user_name'] = $user['name'];
        $data['user_last_name'] = $user['last_name'];
        $data['user_status'] = $user['status'];
        $data['user_cedula'] = $user['cedula'];

// Obtiene todos los usuarios
        $data['users'] = $userModel->findAll();
// Carga la vista de error
        return view('error_page', $data);
    }

    public function view() {
// Obtener la cédula desde la sesión
        $cedula = session()->get('cedula');

// Verificar si la cédula no está en la sesión
        if (!$cedula) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
        }

// Cargar el modelo de usuario
        $userModel = new UserModel();
// Obtener la información académica
        $academicInfoModel = new AcademicInfoModel();
        $academicInfo = $academicInfoModel->getAcademicInfo($cedula);  // Usamos getAcademicInfo para obtener todos los registros
// Obtener la información del usuario
        $user = $userModel->where('cedula', $cedula)->first();

// Verificar si no se encontró al usuario
        if (!$user) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }

// Datos del usuario en la sesión
        $data['user_name'] = $user['name'];
        $data['user_last_name'] = $user['last_name'];
        $data['user_status'] = $user['status'];
        $data['user_cedula'] = $user['cedula'];
        $data['user_document_type'] = $user['document_type'];
        $data['user_email'] = $user['email'];
        $data['user_phone'] = $user['phone'];
        $data['user_role'] = $user['role'];
        $data['user_date_joined'] = $user['date_joined'];
        $data['user_date_left'] = $user['date_left'];
        $data['user_created_at'] = $user['created_at'];
        $data['user_updated_at'] = $user['updated_at'];

// Traer los datos de las tablas relacionadas
        $personalInfoModel = new PersonalInfoModel();
        $workExperienceModel = new WorkExperienceModel();
        $additionalStudyModel = new AdditionalStudyModel();

// Obtener la información relacionada
        $personalInfo = $personalInfoModel->where('cedula', $user['cedula'])->first();
        $workExperience = $workExperienceModel->where('cedula', $user['cedula'])->findAll();
        $additionalStudies = $additionalStudyModel->where('cedula', $user['cedula'])->findAll();

// Verificar si no se encontró información de usuario
        if (!$personalInfo) {
            return redirect()->to('/user/personal-info')->with('error', 'Información personal no encontrada.');
        }

// Verificar si existe foto de perfil
        $user_profile_photo = $user['profile_photo']; // Asumiendo que la columna en la base de datos es 'profile_photo'
// Pasar todos los datos a la vista
        $data['personalInfo'] = $personalInfo;
        $data['academicInfo'] = $academicInfo; // Ahora academicInfo contiene todos los registros
        $data['workExperience'] = $workExperience;
        $data['additionalStudies'] = $additionalStudies;

        return view('view_user', [
            'user_name' => $data['user_name'],
            'user_last_name' => $data['user_last_name'],
            'user_status' => $data['user_status'],
            'user_cedula' => $data['user_cedula'],
            'user_document_type' => $data['user_document_type'],
            'user_email' => $data['user_email'],
            'user_phone' => $data['user_phone'],
            'user_role' => $data['user_role'],
            'user_date_joined' => $data['user_date_joined'],
            'user_date_left' => $data['user_date_left'],
            'user_created_at' => $data['user_created_at'],
            'user_updated_at' => $data['user_updated_at'],
            'user_profile_photo' => $user_profile_photo,
            'personalInfo' => $personalInfo,
            'academicInfo' => $academicInfo, // Aquí pasas todos los registros de academicInfo
            'workExperience' => $workExperience,
            'additionalStudies' => $additionalStudies
        ]);
    }

    public function showFilesByCedula($cedula) {
// Cargar el modelo que interactúa con la base de datos
        $this->load->model('UserModel'); // Asegúrate de tener un modelo adecuado
// Obtener los archivos relacionados con la cédula desde diferentes tablas
        $files = $this->UserModel->getFilesByCedula($cedula);

// Cargar la vista con los archivos obtenidos
        return view('user_files_view', ['files' => $files]);
    }

    public function showTeachingExperience($cedula) {
        $model = new \App\Models\TeachingWorkExperienceModel();

// Llamar al modelo para obtener la experiencia docente por cédula
        $teachingexperience = $model->getTeachingExperience($cedula);

// Depuración para asegurarse de que los datos se están recuperando correctamente
        var_dump($teachingexperience);
        die;

// Pasar los datos a la vista
        return view('your_view_file', ['teachingexperience' => $teachingexperience]);
    }
}
