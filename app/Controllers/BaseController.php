<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    // Constructor
    public function __construct()
    {
        // Llamar al validador de sesión
        $this->checkSession();
    }

    // Método para verificar si la sesión está iniciada
    public function checkSession()
    {
        // Cargar la librería de sesión
        $session = \Config\Services::session();

        // Verificar si el usuario tiene la sesión iniciada
        if (!$session->get('isLoggedIn')) {
            // Si no está logueado, redirigir a la página principal
            return redirect()->to('/');
        }
    }

    /**
     * Instance of the main Request object.
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }
}
