<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PersonalInfoModel;

class ProfileControllerAdmin extends BaseController {

    public function __construct() {
        parent::__construct(); // Asegura que se ejecute el constructor de BaseController
    }

    public function index($user_cedula = null) {
        // Si no se proporciona cédula, intentar obtenerla de la sesión
        if (!$user_cedula) {
            $user_cedula = session()->get('cedula');
        }

        // Verificar si la cédula aún no está disponible
        if (!$user_cedula) {
            return redirect()->to('/')->with('error', 'Cédula no proporcionada.');
        }

        // Instancia del modelo de usuarios
        $userModel = new UserModel();
        $personalInfoModel = new PersonalInfoModel(); // Agregar este modelo si necesitas información adicional
        // Buscar el usuario específico por cédula
        $user = $userModel->where('cedula', $user_cedula)->first();

        // Verificar si el usuario existe
        if (!$user) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }

        // Obtener información personal adicional si es necesario
        $personalInfo = $personalInfoModel->where('cedula', $user_cedula)->first();

        // Obtener la foto de perfil (si existe)
        $profilePhoto = $user['profile_photo'] ?? null;

        // Crear el arreglo con toda la data que deseas pasar a la vista
        $data = [
            'user' => $user, // Información básica del usuario
            'user_name' => $user['name'], // Nombre del usuario
            'user_cedula' => $user['cedula'], // Cédula del usuario
            'user_email' => $user['email'], // Email del usuario
            'user_phone' => $user['phone'], // Teléfono del usuario
            'user_document_type' => $user['document_type'], // Tipo de documento
            'profilePhoto' => $profilePhoto, // Foto de perfil
            'personalInfo' => $personalInfo, // Información adicional si existe
        ];

        // Cargar la vista de edición de perfil específico
        return view('admin_profile', $data);
    }

    public function update($cedula) {
        // Cargar el modelo de usuario
        $userModel = new UserModel();
        $currentUser = $userModel->where('cedula', $cedula)->first(); // Buscar al usuario por su cédula

        if (!$currentUser) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }

        // Obtener los datos enviados desde el formulario, excluyendo 'cedula' y 'email'
        $formData = [
            'name' => $this->request->getPost('name'),
            'last_name' => $this->request->getPost('last_name'),
            'document_type' => $this->request->getPost('document_type'),
            'phone' => $this->request->getPost('phone'),
            'password' => $this->request->getPost('password'),
            'confirm_password' => $this->request->getPost('confirm_password'),
            'status' => $this->request->getPost('status'), // Nuevo campo 'status'
            'role' => $this->request->getPost('role'), // Nuevo campo 'role'
        ];

        // Comparar datos y preparar actualizaciones
        $updateData = [];
        foreach ($formData as $key => $value) {
            if (isset($currentUser[$key]) && $currentUser[$key] !== $value && $key !== 'confirm_password') {
                $updateData[$key] = $value;
            }
        }

        // Manejo de la contraseña
        if (!empty($formData['password'])) {
            if ($formData['password'] !== $formData['confirm_password']) {
                return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
            }
            $updateData['password'] = password_hash($formData['password'], PASSWORD_BCRYPT);
        } else {
            // Si no se cambia la contraseña, no incluirla en el arreglo de actualización
            unset($updateData['password']);
        }

        // Manejo de la foto de perfil
        $profilePhoto = $this->request->getFile('profile_photo');
        if ($profilePhoto && $profilePhoto->isValid() && !$profilePhoto->hasMoved()) {
            // Eliminar foto anterior si existe
            if (!empty($currentUser['profile_photo']) && file_exists(FCPATH . $currentUser['profile_photo'])) {
                unlink(FCPATH . $currentUser['profile_photo']);
            }

            // Guardar nueva foto de perfil
// Obtener la extensión del archivo
            $fileExtension = $profilePhoto->getExtension();

// Crear el nuevo nombre del archivo
            $newFileName = $cedula . '.' . $fileExtension;

// Mover el archivo al directorio de destino con el nuevo nombre
            $profilePhoto->move(FCPATH . 'uploads/profile_photos', $newFileName);

// Actualizar los datos con la ruta del archivo
            $updateData['profile_photo'] = 'uploads/profile_photos/' . $newFileName;
        }

        // Si no hay cambios, redirigir con mensaje informativo
        if (empty($updateData)) {
            return redirect()->back()->with('info', 'No se realizaron cambios.');
        }

        // Intentar actualizar el usuario
        try {
            $userModel->update($cedula, $updateData); // Usar la cédula para actualizar el usuario específico
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el perfil. Intenta nuevamente.');
        }

        // Redirigir después de una actualización exitosa
        return redirect()->to('admin/security/profile/' . $cedula)->with('success', 'Perfil actualizado correctamente.');
    }
}
