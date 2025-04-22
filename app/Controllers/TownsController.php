<?php

namespace App\Controllers;

use App\Models\TownsModel;

class SomeController extends BaseController
{
    public function showCityForm()
    {
        // Instanciar el modelo TownsModel
        $townsModel = new TownsModel();
        
        // Obtener todas las ciudades de la base de datos
        $cities = $townsModel->findAll(); // Esto obtiene todas las ciudades

        // Pasar las ciudades a la vista 'personal-info-form'
        return view('personal-info-form', ['cities' => $cities]);
    }
}
