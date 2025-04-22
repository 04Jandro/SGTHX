<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

public function keepActive()
{
    $session = session();
    $session->set('last_activity', time()); // Actualiza la actividad
    return redirect()->back(); // Redirige a la página anterior (restaura la sesión)
}
}