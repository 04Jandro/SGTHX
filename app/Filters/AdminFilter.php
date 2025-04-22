<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\UserModel;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $cedula = $session->get('cedula'); // Obtener la cédula del usuario desde la sesión

        log_message('debug', 'Session Cedula: ' . $cedula); // Verificar que la cédula está en la sesión

        if (!$cedula) {
            // Si no hay usuario en la sesión, redirigir
            log_message('debug', 'No se encuentra cédula en sesión, redirigiendo...');
            return redirect()->to('/');
        }

        // Consultar el rol del usuario directamente desde la base de datos
        $userModel = new UserModel();
        $user = $userModel->find($cedula);

        if (!$user) {
            log_message('debug', 'Usuario no encontrado en la base de datos para Cedula: ' . $cedula);
            return redirect()->to('/');
        }

        // Cambiar el rol del usuario en la base de datos si es necesario
        // Si el rol cambia, actualizamos también la sesión
        $user['role'] = $user['role'];  // O el nuevo rol que hayas establecido
        $userModel->save($user);

        // Actualizamos el rol en la sesión
        $session->set('role', $user['role']);  // Actualizamos el rol en la sesión

        log_message('debug', 'User role: ' . $user['role']); // Verificar el rol del usuario

        if ($user['role'] !== 'Administrador') {
            // Si el usuario no tiene el rol de administrador, redirigir
            log_message('debug', 'Acceso denegado para el rol: ' . $user['role']);
            $session->setFlashdata('error', 'Acceso denegado. No tienes permisos de administrador.');
            return redirect()->to('user/menu/logout');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No es necesario hacer nada después de la ejecución
    }
}
