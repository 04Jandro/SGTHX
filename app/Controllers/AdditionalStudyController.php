<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AdditionalStudyModel;
use CodeIgniter\Controller;

class AdditionalStudyController extends BaseController {

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

        // Asignar los datos del usuario a la vista
        $data = [
            'user_cedula' => $userData['cedula'],
            'user_name' => $userData['name'],
            'user_last_name' => $userData['last_name'],
            'user_status' => $userData['status'],
            'profilePhoto' => $profilePhoto, // Agregar la foto de perfil a los datos
        ];

        return view('additional_study_form', $data);  // Pasar los datos a la vista
    }

    // Guardar estudios adicionales
    public function save() {
        // Validación de los datos (asegúrate de validar según sea necesario)
        $validation = \Config\Services::validation();
        $validation->setRules([
            'cedula' => 'required|max_length[20]',
            'study_type' => 'required|max_length[255]',
            'institution_name' => 'required|max_length[255]',
            'study_name' => 'required|max_length[255]',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
            'duration_hours' => 'permit_empty|integer',
            'modality' => 'max_length[50]',
            'study_file' => 'permit_empty',
            'status' => 'permit_empty'
        ]);

        // Si la validación falla, redirige de vuelta con los errores
        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $cedula = $this->request->getPost('cedula');
        // Subir el archivo
        $file = $this->request->getFile('study_file');

        if ($file->isValid() && !$file->hasMoved()) {
            // Definir el directorio donde guardar el archivo
            $uploadPath = FCPATH . 'uploads/study_files/';  // Asegúrate de tener este directorio creado
            // Generar un nombre único para el archivo
            $randomFileName = uniqid($cedula . '_', true) . '.' . $file->getExtension(); // Nombre aleatorio con la extensión del archivo
            // Mover el archivo al directorio con el nombre generado
            $file->move($uploadPath, $randomFileName);

            // Usar la ruta relativa para guardar en la base de datos
            $relativeFilePath = 'uploads/study_files/' . $randomFileName;
        } else {
            // Si el archivo no es válido o no se puede mover, asignar null
            $relativeFilePath = null;
        }

        // Crear un nuevo modelo para insertar los datos
        $additionalStudyModel = new AdditionalStudyModel();

        // Obtener los datos del formulario
        $data = [
            'cedula' => $this->request->getPost('cedula'),
            'study_type' => $this->request->getPost('study_type'),
            'institution_name' => $this->request->getPost('institution_name'),
            'study_name' => $this->request->getPost('study_name'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'duration_hours' => $this->request->getPost('duration_hours'),
            'modality' => $this->request->getPost('modality'),
            'study_file' => $relativeFilePath, // Guardamos la ruta relativa del archivo
            'status' => $this->request->getPost('status'),
        ];

        // Insertar los datos en la base de datos
        $additionalStudyModel->insert($data);

        // Redirigir con un mensaje de éxito
        return redirect()->to('/user/additional-study-info')->with('message', 'Estudio adicional guardado con éxito');
    }

    // Mostrar el formulario para editar un estudio adicional
    public function edit($id) {
        $additionalStudyModel = new AdditionalStudyModel();
        $study = $additionalStudyModel->find($id); // Obtener el estudio por ID
        return view('additional_study_edit', ['study' => $study]);
    }

    // Actualizar los estudios adicionales
    public function update($id) {
        // Validación de los datos (asegúrate de validar según sea necesario)
        $validation = \Config\Services::validation();
        $validation->setRules([
            'cedula' => 'required|max_length[20]',
            'study_type' => 'required|max_length[255]',
            'institution_name' => 'required|max_length[255]',
            'study_name' => 'required|max_length[255]',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
            'duration_hours' => 'required|integer',
            'modality' => 'max_length[50]',
            'study_file' => 'max_length[255]',
            'status' => 'max_length[50]'
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $additionalStudyModel = new AdditionalStudyModel();

        // Obtener los datos del formulario
        $data = [
            'cedula' => $this->request->getPost('cedula'),
            'study_type' => $this->request->getPost('study_type'),
            'institution_name' => $this->request->getPost('institution_name'),
            'study_name' => $this->request->getPost('study_name'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'duration_hours' => $this->request->getPost('duration_hours'),
            'modality' => $this->request->getPost('modality'),
            'study_file' => $this->request->getPost('study_file'),
            'status' => $this->request->getPost('status'),
        ];

        // Actualizar los datos en la base de datos
        $additionalStudyModel->update($id, $data);

        // Redirigir con un mensaje de éxito
        return redirect()->to('/additional-studies')->with('message', 'Estudio adicional actualizado con éxito');
    }

    // Eliminar un estudio adicional
    public function delete($id) {
        $additionalStudyModel = new AdditionalStudyModel();
        $additionalStudyModel->delete($id); // Eliminar el estudio por ID
        // Redirigir con un mensaje de éxito
        return redirect()->to('/additional-studies')->with('message', 'Estudio adicional eliminado con éxito');
    }
}
