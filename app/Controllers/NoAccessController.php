<?php

namespace App\Controllers;

class NoAccessController extends BaseController
{
    
        public function __construct()
    {
        parent::__construct(); // Asegura que se ejecute el constructor de BaseController
    }
    
    public function index()
    {
        // Puedes cargar una vista que muestre un mensaje de acceso denegado
        return view('no_access'); // Crear la vista que mostrará el error
    }
}
