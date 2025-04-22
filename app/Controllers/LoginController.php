<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class LoginController extends BaseController
{
    
        public function __construct()
    {
        parent::__construct(); // Asegura que se ejecute el constructor de BaseController
    }
    public function index()
    {
        $session = session();
        $userRole = $session->get('role');

        // Verificar si el usuario está logueado y tiene un rol de 'Administrador'
        if ($userRole == 'Administrador') {
            return view('login', ['show_modal' => true]); // Mostrar el modal para el administrador
        }

        // Si no está logueado o no tiene el rol de administrador, mostrar el formulario de inicio de sesión
        return view('login');
    }

    public function access()
    {
        $session = session();
        $userModel = new UserModel();

        $credential = $this->request->getPost('credential'); 
        $password = $this->request->getPost('password');

        // Buscar por cédula o correo electrónico
        $user = $userModel->where('email', $credential)
                          ->orWhere('cedula', $credential)
                          ->first();

        if ($user) {
            // Verificar si la contraseña es correcta
            if (password_verify($password, $user['password'])) {
                // Establecer datos del usuario en la sesión
                $session->set([
                    'cedula'        => $user['cedula'],
                    'document_type' => $user['document_type'],
                    'name'          => $user['name'],
                    'role'          => $user['role'],
                    'last_name'     => $user['last_name'],
                    'status'        => $user['status'],
                    'is_logged_in'  => true
                ]);

                // Si el rol es "Administrador", mostrar el modal en la página de inicio
                if ($user['role'] == 'Administrador') {
                    return redirect()->to('/'); // Redirige a la página de inicio para mostrar el modal
                } else {
                    return redirect()->to('/user/menu'); // Redirige al menú de usuario
                }
            } else {
                $session->setFlashdata('error', 'Usuario o Contraseña incorrecta.');
                return redirect()->to('/');
            }
        } else {
            $session->setFlashdata('error', 'Usuario o Contraseña incorrecta.');
            return redirect()->to('/');
        }
    }

    public function logout()
    {
        // Cerrar sesión
        $session = session();
        $session->destroy();
        return redirect()->to('/'); // Redirige al formulario de inicio de sesión
    }
    
    // Verificar acceso para usuarios no administradores
    public function checkAdminAccess()
    {
        // Verificar si el usuario está logueado y si tiene el rol de "Administrador"
        $session = session();
        $userRole = $session->get('role');

        // Si no es administrador, redirigir a la página de acceso o al menú de usuario
        if ($userRole !== 'Administrador') {
            return redirect()->to('/user/menu'); // Redirige al menú de usuario si intenta acceder como administrador
        }
    }
}
