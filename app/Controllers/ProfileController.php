<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PersonalInfoModel;

class ProfileController extends BaseController {

    public function __construct() {
        parent::__construct(); // Asegura que se ejecute el constructor de BaseController
    }

    public function index() {
        // Obtener el ID del usuario desde la sesión
        $cedula = session()->get('cedula');

        // Verificar si el usuario está autenticado
        if (!$cedula) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
        }

        // Instancia del modelo de usuarios
        $userModel = new UserModel();
        $user = $userModel->where('cedula', $cedula)->first();

        // Verificar si el usuario existe
        if (!$user) {
            return redirect()->to('error')->with('message', 'Usuario no encontrado.');
        }

        // Obtener la foto de perfil (si existe)
        $profilePhoto = $user['profile_photo'] ?? 'ruta/default.jpg';

        // Instancia del modelo de información personal
        $personalInfoModel = new PersonalInfoModel();
        $personalInfo = $personalInfoModel->where('cedula', $cedula)->first();

        // Si no hay información personal, asignar valores por defecto
        $address = $personalInfo['address'] ?? 'Sin dirección registrada';

        // Pasar los datos a la vista de usuario
        $data = [
            'user_name' => $user['name'],
            'address' => $address,
            'user' => $user,
            'profilePhoto' => $profilePhoto,
        ];
        return view('user_profile', $data);
    }

public function update() {
    // Obtener el ID del usuario desde la sesión
    $cedula = session()->get('cedula');
    if (!$cedula) {
        return redirect()->to('/');
    }

    // Cargar el modelo UserModel
    $userModel = new UserModel();

    // Obtener los datos del formulario
    $data = [
        'name' => $this->request->getPost('name'),
        'last_name' => $this->request->getPost('last_name'),
        'document_type' => $this->request->getPost('document_type'),
        'cedula' => $this->request->getPost('cedula'),
        'email' => $this->request->getPost('email'),
        'phone' => $this->request->getPost('phone'),
        'password' => $this->request->getPost('password'),
        'confirm_password' => $this->request->getPost('confirm_password'),
    ];

    // Validación de contraseñas
    if ($data['password'] && $data['password'] !== $data['confirm_password']) {
        return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
    }

    // Cifrado de la nueva contraseña si se proporciona
    if ($data['password']) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
    } else {
        unset($data['password']);  // No actualizar la contraseña si no se proporciona
    }

    // Manejo de la foto de perfil
    $profilePhoto = $this->request->getFile('profile_photo');
    if ($profilePhoto && $profilePhoto->isValid() && !$profilePhoto->hasMoved()) {
        // Obtener los datos actuales del usuario
        $currentUser = $userModel->find($cedula);

        // Eliminar la foto anterior si existe
        if (isset($currentUser['profile_photo']) && file_exists(FCPATH . $currentUser['profile_photo'])) {
            unlink(FCPATH . $currentUser['profile_photo']);
        }

        // Usar la cédula como nombre de archivo y mantener la extensión original
        $newName = $cedula . '.' . $profilePhoto->getExtension();

        // Mover el archivo a la carpeta de destino
        $profilePhoto->move(FCPATH . 'uploads/profile_photos', $newName);

        // Guardar la ruta de la nueva foto
        $data['profile_photo'] = 'uploads/profile_photos/' . $newName;
    }

    // Actualizar los datos del usuario en la base de datos
    $userModel->update($cedula, $data);

    return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
}
}