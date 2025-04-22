<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Obtiene la sesión
        $session = session();

        // Verifica si el usuario está autenticado
        if (!$session->has('cedula') || !$session->get('is_logged_in')) {
            // Si no está autenticado, redirige al login
            return redirect()->to('/')->with('error', 'Debes iniciar sesión');
        }

        // Verifica si el usuario tiene el rol adecuado
        $role = $session->get('role');
        $uri = $request->getUri()->getPath(); // Obtiene la ruta actual

        // Si el rol no es "Administrador" y la ruta contiene "/admin", se redirige a una página de error
        if ($role != 'Administrador' && strpos($uri, '/admin') !== false) {
            return redirect()->to('user/menu')->with('error', 'Usted no tiene los permisos necesarios para acceder a este apartado.');
        }

        // Si el usuario tiene el rol adecuado o la ruta no contiene "/admin", permite el acceso
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Después de la solicitud, no es necesario hacer nada
    }
}
