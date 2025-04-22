<?php

namespace Config;

use App\Filters\AuthFilter;
use App\Filters\SessionTimeout; // Agregar la clase de SessionTimeout
use App\Filters\AdminFilter; // Agregar la clase de AdminFilter

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    // Filtros disponibles
    public $aliases = [
        'auth' => AuthFilter::class,           // El filtro de autenticación
        'sessionTimeout' => SessionTimeout::class, // Agregar el filtro de cierre de sesión
            'admin' => AdminFilter::class,        // Agregar el filtro de administrador
    ];

    // Filtros globales, se ejecutan antes o después de la solicitud
    public $globals = [
        'before' => [
            'auth' => ['except' => ['/', 'register', 'register/save', 'login/access']], // Excluir páginas públicas
            'sessionTimeout' => ['except' => ['/', 'register', 'register/save', 'login/access']], // Excluir rutas del login
        ],
        'after' => [
            // Otros filtros después de la ejecución si es necesario
        ],
    ];

    // Filtros específicos para ciertas rutas
    public $methods = [];

    // Filtros para rutas específicas
    public $filters = [
        'auth' => [
            'before' => [
                'admin/*', // Proteger todas las rutas bajo 'admin'
            ],
        ],
        'sessionTimeout' => [
            'before' => [
                'admin/*',  // Aquí puedes definir las rutas que quieres proteger con este filtro
            ],
        ],
        'admin' => [
            'before' => [
                'admin/*', // Aplicar filtro de administrador a todas las rutas bajo 'admin'
            ],
        ],
    ];
    
}
