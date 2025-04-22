<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rutas principales (login y registro)
$routes->get('/', 'LoginController::index'); // Muestra el formulario de inicio de sesión
$routes->post('/login/access', 'LoginController::access'); // Procesa el inicio de sesión
$routes->get('/logout', 'LoginController::logout'); // Cierra la sesión
// Rutas Registro usuario (Register)
$routes->get('/register', 'RegisterController::index');
$routes->post('/register/save', 'RegisterController::save');

// Rutas para manejo de menú
$routes->get('/admin/ask_role', 'LoginController::askRole');
$routes->get('/menu', 'MenuController::index'); // Ruta principal que determina el rol
$routes->get('/user/menu', 'MenuController::userMenu'); // Ruta para el menú del usuario normal
$routes->get('/admin/menu', 'MenuController::adminMenu'); // Ruta para el menú del administrador
// Rutas para cerrar sesión
$routes->get('user/menu/logout', 'MenuController::logout');
$routes->get('admin/menu/logout', 'MenuController::logout');

// Rutas para la sección de Usuario
$routes->group('user', function ($routes) {
    // Manejo de información personal
    $routes->get('personal-info', 'PersonalInfoController::index'); // Muestra el formulario
    $routes->post('personal-info/save', 'PersonalInfoController::save'); // Guarda los datos del formulario
    $routes->get('personal-info/success', 'PersonalInfoController::success'); // Página de éxito
    $routes->post('personal-info/update/(:num)', 'PersonalInfoController::update/$1');
    $routes->get('personal-info/(:num)', 'PersonalInfoController::viewPersonalInfo/$1');

    // Manejo de perfil
    $routes->get('profile', 'ProfileController::index');
    $routes->post('profile/update', 'ProfileController::update');

    // Información académica
    $routes->get('academic-info', 'AcademicInfoController::index');
    $routes->post('academic-info/save', 'AcademicInfoController::save');
    $routes->get('academic-info/success', 'AcademicInfoController::success');
    $routes->get('academic-info/edit/(:num)', 'AcademicInfoController::edit/$1');
    $routes->post('academic-info/update/(:num)', 'AcademicInfoController::update/$1');
    $routes->get('academic-info/view-file/(:any)', 'AcademicInfoController::viewFile/$1');

    // Información de experiencia
    $routes->get('experience-info', 'ExperienceController::index');
    $routes->post('experience/save', 'ExperienceController::save');
    $routes->get('success', 'ExperienceController::success');

    // Información de estudios adicionales
    $routes->get('additional-study-info', 'AdditionalStudyController::index');
    $routes->post('additional-study/save', 'AdditionalStudyController::save');

    // Generación de PDF
    // Página de no acceso
    $routes->get('no-access', 'NoAccessController::index');

    // Página de error
    $routes->get('error', 'UserController::error');

    // Mi información
    $routes->get('my-information', 'UserInfoController::index'); // Ruta para "Mi Información"
    $routes->post('my-information/update/(:num)', 'UserInfoController::updateData/$1');

    //
    // Rutas para PDF de usuario específico
    $routes->get('pdf/(:segment)', 'AcademicInfoController::viewPdf/$1');    // Ruta para ver el PDF de un usuario específico

    $routes->get('basic-info', 'BasicInfoController::index');
    $routes->post('basic-info/update', 'BasicInfoController::updateBasicInfo');
    $routes->get('basic-info/delete-language/(:num)', 'BasicInfoController::deleteUserLanguage/$1');

    $routes->get('extra-job-info', 'ExtraInfoJobController::index'); // Mostrar la información extra del trabajo
    $routes->post('extra-job-info/save', 'ExtraInfoJobController::saveExperience'); // Guardar la experiencia laboral


    $routes->get('documents', 'DocumentsController::index'); // Cambié 'upload' por '/' para hacer de esta la página principal del grupo
    // Ruta para procesar la carga de documentos (POST)
    $routes->post('documents/upload', 'DocumentsController::upload');

    // Ruta para listar los documentos
    $routes->get('document/list', 'DocumentsController::list');

    // Ruta para eliminar un documento
    $routes->get('document/delete/(:any)', 'DocumentsController::delete/$1');
    $routes->get('tutoriales', 'MenuController::tutoriales');

});

// Rutas para la sección de Administrador
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    // Seguridad y usuarios
    $routes->get('security', 'UserController::index');
    $routes->get('security/users', 'UserController::users');
    $routes->get('security/create', 'UserController::create');
    $routes->post('security/save', 'UserController::save');
    $routes->get('security/edit/(:num)', 'UserController::edit/$1');
    $routes->post('security/update/(:num)', 'UserController::updateData/$1');

    $routes->post('security/update/(:num)', 'UserController::update/$1');
    $routes->get('security/delete/(:num)', 'UserController::delete/$1');
    $routes->get('security/view/(:num)', 'UserController::view/1');
    $routes->get('help', 'UserController::indexhelpAdmin');
    $routes->get('security/profile/(:num)', 'ProfileControllerAdmin::index/$1');
    $routes->post('security/profile/update/(:num)', 'ProfileControllerAdmin::update/$1');

    // Información académica de los usuarios
    $routes->get('academic-info/list', 'AcademicInfoController::view');
    $routes->get('academic/download/(:segment)', 'AcademicInfoController::downloadFile/$1');
    $routes->get('pdf/(:segment)', 'AcademicInfoController::viewPdf/$1');

    // Información de estudios adicionales
    $routes->get('additional-study/list', 'AdditionalStudyController::list');
    $routes->get('additional-study/show/(:num)', 'AdditionalStudyController::show/$1');
    $routes->get('additional-study/edit/(:num)', 'AdditionalStudyController::edit/$1');
    $routes->post('additional-study/update/(:num)', 'AdditionalStudyController::update/$1');
    $routes->get('additional-study/delete/(:num)', 'AdditionalStudyController::delete/$1');

    // Manejo de perfil
    $routes->get('profile/(:num)', 'ProfileControllerAdmin::index');
    $routes->post('profile/update', 'ProfileControllerAdmin::update');
});
    

// Rutas de ayuda y mantener la sesión activa
$routes->get('user/help', 'UserController::indexhelp');
$routes->post('/keep-active', 'Home::keepActive');

$routes->get('pdf/consultar/(:num)', 'PdfController::consultar/$1');
$routes->get('admin/export', 'ExportController::exportExcel');
$routes->get('/test-export', 'ExportController::test');