<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ExperienceModel;  // Agregar el modelo de experiencia laboral
use CodeIgniter\Controller;

class ExtraInfoJobController extends BaseController {

    public function __construct() {
        parent::__construct(); // Asegura que se ejecute el constructor de BaseController
    }

    public function index() {
        $cedula = session()->get('cedula');

        // Verificar si el usuario ha iniciado sesión
        if (!$cedula) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('cedula', $cedula)->first(); // Obtener el usuario por su cédula
        // Verificar si el usuario existe
        if (!$user) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }

        // Obtener la foto de perfil desde el usuario
        $ProfilePhoto = $user['profile_photo'] ?? null;

        // Datos del usuario en la sesión
        $data['user_name'] = $user['name'];
        $data['user_last_name'] = $user['last_name'];
        $data['user_status'] = $user['status'];
        $data['user_cedula'] = $user['cedula'];
        $data['profilePhoto'] = $ProfilePhoto;

        // Obtener la experiencia laboral del usuario
        $experienceModel = new ExperienceModel();
        $experience = $experienceModel->where('cedula', $cedula)->first(); // Obtener la experiencia laboral por cédula
        // Si no hay experiencia registrada, la experiencia se establece como vacía
        $data['experience'] = $experience ?? null;

        // Retornar la vista 'extra_job_info' con los datos del usuario y su experiencia laboral
        return view('extra_job_info', $data); // Vista para mostrar los detalles del usuario y la experiencia
    }

    // Método para guardar o actualizar la experiencia laboral
    public function saveExperience() {
    $cedula = session()->get('cedula');

    // Verificar si el usuario ha iniciado sesión
    if (!$cedula) {
        return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
    }

    $experienceModel = new ExperienceModel();

    // Verificar si ya existe un registro de experiencia para la cédula
    $existingExperience = $experienceModel->where('cedula', $cedula)->first();

    // Datos recibidos del formulario
    $publicServantYears = $this->request->getPost('public_servant_years');
    $publicServantMonths = $this->request->getPost('public_servant_months');
    $privateSectorYears = $this->request->getPost('private_sector_years');
    $privateSectorMonths = $this->request->getPost('private_sector_months');
    $independentWorkerYears = $this->request->getPost('independent_worker_years');
    $independentWorkerMonths = $this->request->getPost('independent_worker_months');

    // Cálculo de totales
    $totalYears = $publicServantYears + $privateSectorYears + $independentWorkerYears;
    $totalMonths = $publicServantMonths + $privateSectorMonths + $independentWorkerMonths;

    // Si el total de meses supera los 12, sumamos los años correspondientes
    if ($totalMonths >= 12) {
        $totalYears += floor($totalMonths / 12);  // Agregar los años extra
        $totalMonths = $totalMonths % 12;         // Dejar solo los meses restantes
    }

    // Preparar los datos a guardar o actualizar
    $data = [
        'cedula' => $cedula,
        'public_servant_years' => $publicServantYears,
        'public_servant_months' => $publicServantMonths,
        'private_sector_years' => $privateSectorYears,
        'private_sector_months' => $privateSectorMonths,
        'independent_worker_years' => $independentWorkerYears,
        'independent_worker_months' => $independentWorkerMonths,
        'total_years' => $totalYears,
        'total_months' => $totalMonths,
    ];

    if ($existingExperience) {
        // Si ya existe el registro, se actualiza
        $experienceModel->update($existingExperience['id'], $data);
        return redirect()->to('user/extra-job-info')->with('success', 'Experiencia laboral actualizada con éxito.');
    } else {
        // Si no existe, se crea un nuevo registro
        $experienceModel->save($data);
        return redirect()->to('user/extra-job-info')->with('success', 'Experiencia laboral guardada con éxito.');
    }
}
} 