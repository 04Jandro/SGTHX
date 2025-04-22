<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SessionTimeout implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Verificar si la sesión está activa
        $lastActivity = $session->get('last_activity');
        $currentTime = time();
        
        // Verificar si el usuario hizo clic en "Seguir activo" y si tiene un token para ello
        if ($request->getPost('keep_active')) {
            // Actualizar la última actividad si el usuario ha hecho clic en "Seguir activo"
            $session->set('last_activity', $currentTime);
            return; // No hacer nada más, sigue con la solicitud
        }

        // Si la sesión ha expirado
        if ($lastActivity && ($currentTime - $lastActivity) > 1200) {  // 1200 segundos = 20 minutos
            // Cerrar sesión si ha pasado más de 15 minutos
            $session->destroy();
            return redirect()->to('/');  // Redirigir a login
        }

        // Si la sesión no ha expirado, actualizamos la última actividad
        $session->set('last_activity', $currentTime);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita ninguna acción después
    }
}
