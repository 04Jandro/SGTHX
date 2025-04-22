<?php

namespace App\Controllers;

use App\Models\UserModel; // Importar el modelo
use App\Models\PersonalInfoModel;

class PersonalInfoController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

public function index() {
    // Instancia del modelo de usuario
    $userModel = new UserModel();
    $personalInfoModel = new PersonalInfoModel();

    // Obtener el ID del usuario desde la sesión
    $userId = session()->get('cedula'); // Asegúrate de que este dato esté en la sesión

    if (!$userId) {
        return redirect()->to('/')->with('error', 'Debe iniciar sesión para acceder a esta página.');
    }

    // Obtener los datos del usuario
    $userData = $userModel->where('cedula', $userId)->first();

    // Validar si se encontraron los datos
    if (!$userData) {
        return redirect()->to('/')->with('error', 'No se encontró información para este usuario.');
    }

    // Obtener la información personal del modelo PersonalInfoModel
    $personalInfo = $personalInfoModel->where('cedula', $userId)->first();

    // Obtener la foto de perfil desde el usuario
    $profilePhoto = $userData['profile_photo'] ?? null;

    // Preparar los datos para la vista
    $data = [
        'user_cedula' => $userData['cedula'] ?? '',
        'user_name' => $userData['name'] ?? '',
        'user_last_name' => $userData['last_name'] ?? '',
        'user_status' => $userData['status'] ?? 'Sin estado',
        'user_document_type' => $userData['document_type'] ?? '',
        'user_email' => $userData['email'] ?? '',
        'user_phone' => $userData['phone'] ?? '',
        'profilePhoto' => $profilePhoto, // Agregar la foto de perfil a los datos
        'personalInfo' => $personalInfo // Pasar toda la información del modelo PersonalInfoModel
    ];

    return view('personal_info_form', $data);
}

    public function save() {
        $personalInfoModel = new PersonalInfoModel();

        // Debugging: Log all received POST data
        log_message('info', 'Datos recibidos: ' . json_encode($this->request->getPost()));

        // Updated validation rules (PDF upload is now optional)
        $validationRules = [
            'cedula' => 'required|is_unique[personal_info.cedula]',
            'email' => 'required|valid_email',
            'cedula_file' => 'permit_empty|mime_in[cedula_file,application/pdf]|max_size[cedula_file,2048]'
        ];

        // Validate form data
        if (!$this->validate($validationRules)) {
            // Log validation errors
            log_message('error', 'Validation Errors: ' . json_encode($this->validator->getErrors()));

            return redirect()->back()->withInput()->with('error', 'Hubo errores de validación');
        }

        // Handle cedula file upload
        $cedulaFile = $this->request->getFile('cedula_file');
        $cedulaFilePath = null;

        // Check if file is provided and handle it
        if ($cedulaFile && $cedulaFile->isValid()) {
            // Check if the file already exists
            $uploadPath = FCPATH . 'uploads/cedulas/';

            // Create upload directory if it doesn't exist
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $fileName = $cedulaFile->getRandomName();

            // Check if file exists, generate a new random name
            while (file_exists($uploadPath . $fileName)) {
                $fileName = $cedulaFile->getRandomName();
            }

            try {
                // Move file to the directory
                $cedulaFile->move($uploadPath, $fileName);
                $cedulaFilePath = 'uploads/cedulas/' . $fileName;
            } catch (\Exception $e) {
                // Log error if the file cannot be moved
                log_message('error', 'Error al mover el archivo: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'No se pudo guardar el archivo de cédula.');
            }
        }

        // Collect all form data
        $data = [
            'document_type' => $this->request->getPost('document_type'),
            'cedula' => $this->request->getPost('cedula'),
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
            'address' => $this->request->getPost('address'),
            'phone' => $this->request->getPost('phone'),
            'mobile' => $this->request->getPost('mobile'),
            'email' => $this->request->getPost('email'),
            'military_card_type' => $this->request->getPost('military_card_type'),
            'military_card_number' => $this->request->getPost('military_card_number'),
            'military_district' => $this->request->getPost('military_district'),
            'marital_status' => $this->request->getPost('marital_status'),
            'spouse_document_type' => $this->request->getPost('spouse_document_type'),
            'spouse_id_number' => $this->request->getPost('spouse_id_number'),
            'spouse_first_name' => $this->request->getPost('spouse_first_name'),
            'spouse_last_name' => $this->request->getPost('spouse_last_name'),
            'mailing_country' => $this->request->getPost('mailing_country'),
            'mailing_state' => $this->request->getPost('mailing_state'),
            'mailing_city' => $this->request->getPost('mailing_city'),
            'cedula_file' => $cedulaFilePath  // Path of uploaded file
        ];

        // Attempt to save data
        if (!$personalInfoModel->save($data)) {
            // Get database errors
            $errors = $personalInfoModel->errors();
            log_message('error', 'Errores al guardar: ' . json_encode($errors));

            return redirect()->back()->withInput()->with('error', 'Error al guardar: ' . implode(', ', $errors));
        }

        // If everything is successful
        return redirect()->to('user/personal-info')->with('success', 'Información guardada con éxito.');
    }

    public function update($userId) {
        $personalInfoModel = new PersonalInfoModel();

        // Debugging: Log all received POST data
        log_message('info', 'Datos recibidos: ' . json_encode($this->request->getPost()));

        // Validation rules (including email unique check if needed)
        $validationRules = [
            'email' => 'required|valid_email|is_unique[personal_info.email,cedula,' . $userId . ']', // Adjust validation rule for unique email
        ];

        // Validate form data
        if (!$this->validate($validationRules)) {
            // Log validation errors
            log_message('error', 'Validation Errors: ' . json_encode($this->validator->getErrors()));

            return redirect()->back()->withInput()->with('error', 'Hubo errores de validación');
        }

        // Collect all form data
        $data = [
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
            'address' => $this->request->getPost('address'),
            'phone' => $this->request->getPost('phone'),
            'mobile' => $this->request->getPost('mobile'),
            'email' => $this->request->getPost('email'),
            'military_card_type' => $this->request->getPost('military_card_type'),
            'military_card_number' => $this->request->getPost('military_card_number'),
            'military_district' => $this->request->getPost('military_district'),
            'marital_status' => $this->request->getPost('marital_status'),
            'spouse_document_type' => $this->request->getPost('spouse_document_type'),
            'spouse_id_number' => $this->request->getPost('spouse_id_number'),
            'spouse_first_name' => $this->request->getPost('spouse_first_name'),
            'spouse_last_name' => $this->request->getPost('spouse_last_name'),
            'mailing_address' => $this->request->getPost('mailing_address'),
            'mailing_country' => $this->request->getPost('mailing_country'),
            'mailing_state' => $this->request->getPost('mailing_state'),
            'mailing_city' => $this->request->getPost('mailing_city'),
            'role' => $this->request->getPost('role')
        ];

        // Attempt to find the record
        $personalInfo = $personalInfoModel->find($userId);

        if (!$personalInfo) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        // Attempt to update the data
        if (!$personalInfoModel->update($userId, $data)) {
            // Get database errors
            $errors = $personalInfoModel->errors();
            log_message('error', 'Errores al actualizar: ' . json_encode($errors));

            return redirect()->back()->withInput()->with('error', 'Error al actualizar: ' . implode(', ', $errors));
        }

        // If everything is successful
        return redirect()->to('user/personal-info')->with('success', 'Información actualizada con éxito.');
    }

    public function viewPersonalInfo($userId) {
        $userModel = new UserModel(); // Modelo que gestiona los datos del usuario
        $personalInfoModel = new PersonalInfoModel(); // Modelo para la información personal
        // Buscar información del usuario
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }

        // Buscar información personal asociada al usuario
        $personalInfo = $personalInfoModel->where('cedula', $userId)->first();

        if (!$personalInfo) {
            return redirect()->back()->with('error', 'No se encontró información personal para este usuario.');
        }

        // Obtener el nombre del usuario
        $user_name = $user['name']; // Suponiendo que 'name' es el campo donde está el nombre del usuario
        // Preparar los datos para la vista
        $data = [
            'user' => $user,
            'personalInfo' => $personalInfo,
            'user_name' => $user_name, // Agregar el nombre del usuario
            'cedula' => $personalInfo['cedula'],
            'document_type' => $personalInfo['document_type'],
            'place_of_issue' => $personalInfo['place_of_issue'],
            'date_of_issue' => $personalInfo['date_of_issue'],
            'gender' => $personalInfo['gender'],
            'nationality' => $personalInfo['nationality'],
            'first_name' => $personalInfo['first_name'],
            'middle_name' => $personalInfo['middle_name'],
            'last_name' => $personalInfo['last_name'],
            'second_last_name' => $personalInfo['second_last_name'],
            'birth_country' => $personalInfo['birth_country'],
            'birth_department' => $personalInfo['birth_department'],
            'birth_city' => $personalInfo['birth_city'],
            'birth_date' => $personalInfo['birth_date'],
            'age' => $personalInfo['age'],
            'address' => $personalInfo['address'],
            'phone' => $personalInfo['phone'],
            'mobile' => $personalInfo['mobile'],
            'email' => $personalInfo['email'],
            'military_card_type' => $personalInfo['military_card_type'],
            'military_card_number' => $personalInfo['military_card_number'],
            'military_district' => $personalInfo['military_district'],
            'marital_status' => $personalInfo['marital_status'],
            'spouse_document_type' => $personalInfo['spouse_document_type'],
            'spouse_id_number' => $personalInfo['spouse_id_number'],
            'spouse_first_name' => $personalInfo['spouse_first_name'],
            'spouse_last_name' => $personalInfo['spouse_last_name'],
            'cedula_file' => $personalInfo['cedula_file'],
            'mailing_country' => $personalInfo['mailing_country'],
            'mailing_state' => $personalInfo['mailing_state'],
            'mailing_city' => $personalInfo['mailing_city'],
            'max_level_academic' => $personalInfo['max_level_academic'],
            'obtained_title' => $personalInfo['obtained_title'],
            'graduation_date' => $personalInfo['graduation_date'],
            'title_date' => $personalInfo['title_date']
        ];

        // Cargar la vista con los datos
        return view('personal_info_view', $data);
    }
}
