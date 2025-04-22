<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AcademicInfoModel; // Modelo de la tabla academic_info
use App\Models\WorkExperienceModel; // Modelo de la tabla work_experience
use App\Models\AdditionalStudyModel; // Modelo de la tabla additional_study
use CodeIgniter\Controller;

class RegisterController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); // Asegura que se ejecute el constructor de BaseController
    }

    public function index()
    {
        return view('register');
    }

    public function save()
    {
        $session = session();
        $userModel = new UserModel();
        $academicInfoModel = new AcademicInfoModel(); // Modelo de la tabla academic_info
        $workExperienceModel = new WorkExperienceModel(); // Modelo de la tabla work_experience
        $additionalStudyModel = new AdditionalStudyModel(); // Modelo de la tabla additional_study

        // Validación de los campos del formulario
        $validation = $this->validate([
            'document_type' => 'required',
            'cedula' => 'required|numeric|is_unique[users.cedula]',
            'name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ]);

        // Si la validación falla
        if (!$validation) {
            // Almacenar errores de validación en la sesión
            $session->setFlashdata('errors', $this->validator->getErrors());
            // Redirigir de vuelta al formulario con los datos de entrada
            return redirect()->back()->withInput();
        }

        // Preparar datos para guardar
        $data = [
            'document_type' => $this->request->getVar('document_type'),
            'cedula' => $this->request->getVar('cedula'),
            'name' => $this->request->getVar('name'),
            'last_name' => $this->request->getVar('last_name'),
            'phone' => $this->request->getVar('phone'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        try {
            // Intentar insertar el nuevo usuario
            $userModel->insert($data);
            $cedula = $this->request->getVar('cedula');  // Obtener la cédula que se acaba de registrar

            // Verificar si la cédula se ha insertado
            if ($userModel->insertID()) {
                // Insertar en la tabla academic_info
                $academicInfoModel->insert(['cedula' => $cedula]);

                // Insertar en la tabla work_experience
                $workExperienceModel->insert(['cedula' => $cedula]);

                // Insertar en la tabla additional_study
                $additionalStudyModel->insert(['cedula' => $cedula]);

                return redirect()->to(base_url('/'))->with('success', 'Registro exitoso');
            } else {
                // Error en la inserción
                $session->setFlashdata('error', 'No se pudo completar el registro');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            // Capturar cualquier excepción
            $session->setFlashdata('error', 'Error inesperado: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
