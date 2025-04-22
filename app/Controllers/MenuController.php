<?php

namespace App\Controllers;

use App\Models\UserModel; // Importar el modelo UserModel
use App\Models\PersonalInfoModel; // Importar el modelo PersonalInfoModel
use App\Models\AcademicInfoModel; // Importar el modelo AcademicInfoModel
use CodeIgniter\Controller;

class MenuController extends BaseController {

    protected $userModel;
    protected $personalInfoModel;
    protected $academicInfoModel;

    public function __construct() {
        parent::__construct(); // Llama al constructor del controlador base
        // Instanciar los modelos
        $this->userModel = new UserModel();
        $this->personalInfoModel = new PersonalInfoModel();
        $this->academicInfoModel = new AcademicInfoModel();
    }

    public function index() {
        $session = session();
        $cedula = $session->get('cedula');
        $user_cedula = $user_cedula ?? null;

        // Validar que la cédula esté disponible
        if (!$cedula) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
        }

        // Obtener los datos del usuario desde la base de datos
        $user = $this->userModel->where('cedula', $cedula)->first();

        // Verificar que el usuario exista
        if (!$user) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }



        // Obtener la foto de perfil del usuario
        $profilePhoto = $user['profile_photo'] ?? null;

        // Obtener el rol y otros datos desde la base de datos
        $data = [
            'user_cedula' => $cedula,
            'user_name' => $user['name'],
            'user_last_name' => $user['last_name'],
            'user_status' => $user['status'],
            'profilePhoto' => $profilePhoto,
            'user_count' => $this->userModel->countAll(),
            'formulario_count' => $this->personalInfoModel->countAll(),
            'academic_count' => $this->academicInfoModel->countAll(),
        ];

        // Redirigir según el rol
        return ($user['role'] === 'Administrador') ? view('admin_menu', $data) : view('menu', $data);
    }

    public function adminMenu() {
        $cedula = session()->get('cedula');

        if (!$cedula) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
        }

        $user = $this->userModel->where('cedula', $cedula)->first();

        if (!$user) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }

        $profilePhoto = $user['profile_photo'] ?? null;

        // Obtener conteos
        $userCount = $this->userModel->countAll();
        $formularioCount = $this->personalInfoModel->countAll();
        $academicCount = $this->academicInfoModel->countAll();

// Obtener usuarios nuevos este mes
        $currentMonth = date('Y-m');  // Formato: '2024-12'
        $lastDayOfMonth = date('Y-m-t'); // Obtiene el último día del mes actual

        $newUsersThisMonth = $this->userModel
                ->where('created_at >=', "$currentMonth-01 00:00:00")
                ->where('created_at <=', "$lastDayOfMonth 23:59:59")
                ->countAllResults();

        $data = [
            'user_name' => $user['name'],
            'user_cedula' => $user['cedula'],
            'user_last_name' => $user['last_name'],
            'user_status' => $user['status'],
            'profilePhoto' => $profilePhoto,
            'user_count' => $userCount,
            'formulario_count' => $formularioCount,
            'academic_count' => $academicCount,
            'new_users_this_month' => $newUsersThisMonth, // Pasar el conteo de nuevos usuarios
        ];

        return view('admin_menu', $data);  // Pasa los datos a la vista admin_menu
    }

        public function userMenu() {
            $session = session();
            $cedula = $session->get('cedula');

            if (!$cedula) {
                return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
            }

            $user = $this->userModel->where('cedula', $cedula)->first();

            if (!$user) {
                return redirect()->to('/')->with('error', 'Usuario no encontrado.');
            }

            // Enviar correo de inicio de sesión solo si no se ha enviado en esta sesión
            if (!$session->get('login_email_sent')) {
                $emailService = new \App\Libraries\Email();
                $destinatario = $user['email'] ?? null;
                $asunto = 'Inicio de sesión exitoso';
                $mensaje = "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Inicio de Sesión Exitoso - UTEDÉ</title>
</head>
<body style='margin: 0; padding: 0; background-color: #f6f9fc; font-family: Segoe UI, Arial, sans-serif;'>
    <div style='max-width: 600px; margin: 20px auto; background: white; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
        <!-- Encabezado -->
        <div style='text-align: center; padding: 30px 20px; background: linear-gradient(135deg, #2d89ef 0%, #1a6cbd 100%); border-radius: 15px 15px 0 0;'>
             <img src='https://sgth.utede.com.co/img/utede_fondo.png' alt='UTEDÉ' style='width: 180px; height: auto;'>
        </div>

        <!-- Contenido Principal -->
        <div style='padding: 40px 30px; color: #333;'>
            <div style='text-align: center; margin-bottom: 30px;'>
                <svg style='width: 60px; height: 60px; color: #28a745;' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' />
                </svg>
                <h1 style='color: #2d89ef; font-size: 24px; margin: 15px 0;'>¡Inicio de Sesión Exitoso!</h1>
            </div>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                Hola <strong>" . htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') . "</strong>,
            </p>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                Te informamos que se ha registrado un inicio de sesión exitoso en tu cuenta de <strong>UTEDÉ</strong> en:
            </p>

            <div style='background-color: #f8f9fa; border-radius: 8px; padding: 20px; margin: 25px 0;'>
                <p style='margin: 0; color: #666;'>
                    📅 Fecha: " . date('d/m/Y H:i:s') . "<br>
                    🌐 Sistema: UTEDÉ<br>
                    📱 Dispositivo: " . htmlspecialchars($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8') . "
                </p>
            </div>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 30px; color: #dc3545;'>
                ⚠️ Si no reconoces esta actividad, te recomendamos cambiar tu contraseña inmediatamente:
            </p>

            <div style='text-align: center; margin: 35px 0;'>
                <a href='https://www.utede.com.co/cambiar-contraseña' 
                   style='display: inline-block; background-color: #2d89ef; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; transition: background-color 0.3s;'>
                   🔐 Cambiar Contraseña
                </a>
            </div>

            <div style='background-color: #e9ecef; padding: 20px; border-radius: 8px; margin-top: 30px;'>
                <p style='margin: 0; font-size: 14px; color: #666; text-align: center;'>
                    <strong>Consejos de Seguridad:</strong><br>
                    • Nunca compartas tu contraseña<br>
                    • Utiliza una contraseña única y segura<br>
                    • Activa la autenticación de dos factores
                </p>
            </div>
        </div>

        <!-- Pie de Página -->
        <div style='padding: 20px; background-color: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 15px 15px; text-align: center;'>
            <p style='margin: 0; color: #666; font-size: 13px;'>
                Este es un mensaje automático, por favor no respondas a este correo.
            </p>
            <div style='margin-top: 15px;'>
                <a href='https://www.utede.com.co' style='color: #2d89ef; text-decoration: none; margin: 0 10px;'>Sitio Web</a> |
                <a href='https://www.utede.com.co/ayuda' style='color: #2d89ef; text-decoration: none; margin: 0 10px;'>Centro de Ayuda</a>
            </div>
            <p style='margin: 15px 0 0; color: #666; font-size: 12px;'>
                © " . date('Y') . " UTEDÉ. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>
</html>";

                if ($destinatario) {
                    $emailService->enviarCorreo($destinatario, $asunto, $mensaje);
                    $session->set('login_email_sent', true); // Evita reenviar el correo en la misma sesión
                }
            }

            $db = \Config\Database::connect();
            $personalInfo = $db->table('personal_info')->where('cedula', $cedula)->get();

            // Si el usuario no tiene registro en personal_info, enviar un correo de advertencia
            if ($personalInfo->getNumRows() === 0 && !$session->get('missing_info_email_sent')) {
                $emailService = new \App\Libraries\Email();
                $destinatario = $user['email'] ?? null;
                $asunto = 'Registro de Información Personal Pendiente';
                $mensaje = "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Falta Información Personal - UTEDÉ</title>
    </head>
    <body style='margin: 0; padding: 0; background-color: #f6f9fc; font-family: Segoe UI, Arial, sans-serif;'>
        <div style='max-width: 600px; margin: 20px auto; background: white; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
            <div style='text-align: center; padding: 30px 20px; background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); border-radius: 15px 15px 0 0;'>
                 <img src='https://sgth.utede.com.co/img/utede_fondo.png' alt='UTEDÉ' style='width: 180px; height: auto;'>
            </div>

            <div style='padding: 40px 30px; color: #333;'>
                <div style='text-align: center; margin-bottom: 30px;'>
                    <svg style='width: 60px; height: 60px; color: #dc3545;' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' />
                    </svg>
                    <h1 style='color: #dc3545; font-size: 24px; margin: 15px 0;'>¡Información Incompleta!</h1>
                </div>

                <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                    Hola <strong>" . htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') . "</strong>,
                </p>

                <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                    Notamos que aún no has completado tu información personal en el sistema <strong>UTEDÉ</strong>. Es importante que lo hagas para poder acceder a todos los servicios.
                </p>

                <div style='background-color: #f8d7da; border-radius: 8px; padding: 20px; margin: 25px 0;'>
                    <p style='margin: 0; color: #721c24; font-size: 16px;'>
                        ⚠️ Información faltante: Datos personales, dirección, contacto, etc.
                    </p>
                </div>

                <div style='text-align: center; margin: 35px 0;'>
                    <a href='https://sgth.utede.com.co/index.php/user/personal-info' 
                       style='display: inline-block; background-color: #dc3545; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; transition: background-color 0.3s;'>
                       ✍️ Completar Información
                    </a>
                </div>

                <div style='background-color: #e9ecef; padding: 20px; border-radius: 8px; margin-top: 30px;'>
                    <p style='margin: 0; font-size: 14px; color: #666; text-align: center;'>
                        <strong>Recuerda:</strong><br>
                        • La información personal es obligatoria.<br>
                        • No podrás continuar sin completar estos datos.<br>
                        • Cualquier duda, contacta con soporte.
                    </p>
                </div>
            </div>

            <div style='padding: 20px; background-color: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 15px 15px; text-align: center;'>
                <p style='margin: 0; color: #666; font-size: 13px;'>
                    Este es un mensaje automático, por favor no respondas a este correo.
                </p>
                <div style='margin-top: 15px;'>
                    <a href='https://www.utede.com.co' style='color: #dc3545; text-decoration: none; margin: 0 10px;'>Sitio Web</a> |
                    <a href='https://www.utede.com.co/ayuda' style='color: #dc3545; text-decoration: none; margin: 0 10px;'>Centro de Ayuda</a>
                </div>
                <p style='margin: 15px 0 0; color: #666; font-size: 12px;'>
                    © " . date('Y') . " UTEDÉ. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </body>
    </html>";

                if ($destinatario) {
                    $emailService->enviarCorreo($destinatario, $asunto, $mensaje);
                    $session->set('missing_info_email_sent', true); // Evita reenviar el correo en la misma sesión
                }
            }
$db = \Config\Database::connect();
$academicInfo = $db->table('academic_info')->where('cedula', $cedula)->get();

// Si el usuario no tiene registro en academic_info, enviar un correo de advertencia
if ($academicInfo->getNumRows() === 0 && !$session->get('missing_academic_email_sent')) {
    $emailService = new \App\Libraries\Email();
    $destinatario = $user['email'] ?? null;
    $asunto = 'Registro de Información Académica Pendiente';
    $mensaje = "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Falta Información Académica - UTEDÉ</title>
    </head>
    <body style='margin: 0; padding: 0; background-color: #f6f9fc; font-family: Segoe UI, Arial, sans-serif;'>
        <div style='max-width: 600px; margin: 20px auto; background: white; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
            <div style='text-align: center; padding: 30px 20px; background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); border-radius: 15px 15px 0 0;'>
                 <img src='https://sgth.utede.com.co/img/utede_fondo.png' alt='UTEDÉ' style='width: 180px; height: auto;'>
            </div>

            <div style='padding: 40px 30px; color: #333;'>
                <div style='text-align: center; margin-bottom: 30px;'>
                    <svg style='width: 60px; height: 60px; color: #dc3545;' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' />
                    </svg>
                    <h1 style='color: #dc3545; font-size: 24px; margin: 15px 0;'>¡Información Académica Incompleta!</h1>
                </div>

                <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                    Hola <strong>" . htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') . "</strong>,
                </p>

                <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                    Hemos detectado que aún no has registrado tu información académica en UTEDÉ. Es importante que completes este proceso para evitar inconvenientes con la gestión de tu perfil.
                </p>

                <div style='text-align: center; margin: 35px 0;'>
                    <a href='https://sgth.utede.com.co/index.php/user/academic-info' 
                       style='display: inline-block; background-color: #2d89ef; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; transition: background-color 0.3s;'>
                       📄 Completar Información Académica
                    </a>
                </div>

                <p style='margin-top: 20px; text-align: center; font-size: 14px; color: #666;'>
                    Si ya has completado esta información, ignora este mensaje.
                </p>
            </div>

            <div style='padding: 20px; background-color: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 15px 15px; text-align: center;'>
                <p style='margin: 0; color: #666; font-size: 13px;'>
                    Este es un mensaje automático, por favor no respondas a este correo.
                </p>
                <div style='margin-top: 15px;'>
                    <a href='https://www.utede.com.co' style='color: #2d89ef; text-decoration: none; margin: 0 10px;'>Sitio Web</a> |
                    <a href='https://www.utede.com.co/ayuda' style='color: #2d89ef; text-decoration: none; margin: 0 10px;'>Centro de Ayuda</a>
                </div>
                <p style='margin: 15px 0 0; color: #666; font-size: 12px;'>
                    © " . date('Y') . " UTEDÉ. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </body>
    </html>";

    if ($destinatario) {
        $emailService->enviarCorreo($destinatario, $asunto, $mensaje);
        $session->set('missing_academic_email_sent', true); // Evita reenviar el correo en la misma sesión
    }
}
    $db = \Config\Database::connect();
    $languages = $db->table('languages')->where('cedula', $cedula)->get();

    // Si el usuario no tiene registro en languages, enviar un correo de advertencia
    if ($languages->getNumRows() === 0 && !$session->get('missing_languages_email_sent')) {
        $emailService = new \App\Libraries\Email();
        $destinatario = $user['email'] ?? null;
        $asunto = 'Registro de Idiomas Pendiente';
        $mensaje = "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Falta Información de Idiomas - UTEDÉ</title>
</head>
<body style='margin: 0; padding: 0; background-color: #f6f9fc; font-family: Segoe UI, Arial, sans-serif;'>
    <div style='max-width: 600px; margin: 20px auto; background: white; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
        <div style='text-align: center; padding: 30px 20px; background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); border-radius: 15px 15px 0 0;'>
            <img src='https://sgth.utede.com.co/img/utede_fondo.png' alt='UTEDÉ' style='width: 180px; height: auto;'>
        </div>

        <div style='padding: 40px 30px; color: #333;'>
            <div style='text-align: center; margin-bottom: 30px;'>
                <svg style='width: 60px; height: 60px; color: #dc3545;' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' />
                </svg>
                <h1 style='color: #dc3545; font-size: 24px; margin: 15px 0;'>¡Información de Idiomas Incompleta!</h1>
            </div>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                Hola <strong>" . htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') . "</strong>,
            </p>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                Notamos que aún no has registrado información sobre los idiomas que manejas en tu cuenta de <strong>UTEDÉ</strong>.
            </p>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 30px; color: #dc3545;'>
                ⚠️ Es importante completar esta información para un mejor registro en el sistema.
            </p>

            <div style='text-align: center; margin: 35px 0;'>
                <a href='https://sgth.utede.com.co/index.php/user/basic-info' 
                   style='display: inline-block; background-color: #2d89ef; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; transition: background-color 0.3s;'>
                   🌍 Registrar Idiomas
                </a>
            </div>

            <div style='background-color: #e9ecef; padding: 20px; border-radius: 8px; margin-top: 30px;'>
                <p style='margin: 0; font-size: 14px; color: #666; text-align: center;'>
                    Si ya completaste esta información, por favor ignora este mensaje.
                </p>
            </div>
        </div>

        <div style='padding: 20px; background-color: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 15px 15px; text-align: center;'>
            <p style='margin: 0; color: #666; font-size: 13px;'>
                Este es un mensaje automático, por favor no respondas a este correo.
            </p>
            <div style='margin-top: 15px;'>
                <a href='https://www.utede.com.co' style='color: #2d89ef; text-decoration: none; margin: 0 10px;'>Sitio Web</a> |
                <a href='https://www.utede.com.co/ayuda' style='color: #2d89ef; text-decoration: none; margin: 0 10px;'>Centro de Ayuda</a>
            </div>
            <p style='margin: 15px 0 0; color: #666; font-size: 12px;'>
                © " . date('Y') . " UTEDÉ. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>
</html>";

        if ($destinatario) {
            $emailService->enviarCorreo($destinatario, $asunto, $mensaje);
            $session->set('missing_languages_email_sent', true);
        }
    }
        $db = \Config\Database::connect();
    $workExperience = $db->table('work_experience')->where('cedula', $cedula)->get();

    // Si el usuario no tiene registros en work_experience, enviar un correo de advertencia
    if ($workExperience->getNumRows() === 0 && !$session->get('missing_work_experience_email_sent')) {
        $emailService = new \App\Libraries\Email();
        $destinatario = $user['email'] ?? null;
        $asunto = 'Registro de Experiencia Laboral Pendiente';
        $mensaje = "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Falta Información de Experiencia Laboral - UTEDÉ</title>
</head>
<body style='margin: 0; padding: 0; background-color: #f6f9fc; font-family: Segoe UI, Arial, sans-serif;'>
    <div style='max-width: 600px; margin: 20px auto; background: white; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
        <div style='text-align: center; padding: 30px 20px; background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); border-radius: 15px 15px 0 0;'>
            <img src='https://sgth.utede.com.co/img/utede_fondo.png' alt='UTEDÉ' style='width: 180px; height: auto;'>
        </div>

        <div style='padding: 40px 30px; color: #333;'>
            <div style='text-align: center; margin-bottom: 30px;'>
                <svg style='width: 60px; height: 60px; color: #dc3545;' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' />
                </svg>
                <h1 style='color: #dc3545; font-size: 24px; margin: 15px 0;'>¡Información de Experiencia Laboral Incompleta!</h1>
            </div>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                Hola <strong>" . htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') . "</strong>,
            </p>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                Notamos que aún no has registrado información sobre tu experiencia laboral en tu cuenta de <strong>UTEDÉ</strong>.
            </p>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 30px; color: #dc3545;'>
                ⚠️ Es importante completar esta información para un mejor registro en el sistema.
            </p>

            <div style='text-align: center; margin: 35px 0;'>
                <a href='https://sgth.utede.com.co/index.php/user/experience-info' 
                   style='display: inline-block; background-color: #2d89ef; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; transition: background-color 0.3s;'>
                   💼 Registrar Experiencia
                </a>
            </div>

            <div style='background-color: #e9ecef; padding: 20px; border-radius: 8px; margin-top: 30px;'>
                <p style='margin: 0; font-size: 14px; color: #666; text-align: center;'>
                    Si ya completaste esta información, por favor ignora este mensaje.
                </p>
            </div>
        </div>

        <div style='padding: 20px; background-color: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 15px 15px; text-align: center;'>
            <p style='margin: 0; color: #666; font-size: 13px;'>
                Este es un mensaje automático, por favor no respondas a este correo.
            </p>
            <div style='margin-top: 15px;'>
                <a href='https://www.utede.com.co' style='color: #2d89ef; text-decoration: none; margin: 0 10px;'>Sitio Web</a> |
                <a href='https://www.utede.com.co/ayuda' style='color: #2d89ef; text-decoration: none; margin: 0 10px;'>Centro de Ayuda</a>
            </div>
            <p style='margin: 15px 0 0; color: #666; font-size: 12px;'>
                © " . date('Y') . " UTEDÉ. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>
</html>";

        if ($destinatario) {
            $emailService->enviarCorreo($destinatario, $asunto, $mensaje);
            $session->set('missing_work_experience_email_sent', true);
        }
    }
        $db = \Config\Database::connect();
    $experience = $db->table('experience')->where('cedula', $cedula)->get();

    // Si el usuario no tiene registros en experience, enviar un correo de advertencia
    if ($experience->getNumRows() === 0 && !$session->get('missing_experience_email_sent')) {
        $emailService = new \App\Libraries\Email();
        $destinatario = $user['email'] ?? null;
        $asunto = 'Registro de Tiempo Laboral Trabajado Pendiente';
        $mensaje = "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Falta Información de Experiencia - UTEDÉ</title>
</head>
<body style='margin: 0; padding: 0; background-color: #f6f9fc; font-family: Segoe UI, Arial, sans-serif;'>
    <div style='max-width: 600px; margin: 20px auto; background: white; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
        <div style='text-align: center; padding: 30px 20px; background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); border-radius: 15px 15px 0 0;'>
            <img src='https://sgth.utede.com.co/img/utede_fondo.png' alt='UTEDÉ' style='width: 180px; height: auto;'>
        </div>

        <div style='padding: 40px 30px; color: #333;'>
            <div style='text-align: center; margin-bottom: 30px;'>
                <svg style='width: 60px; height: 60px; color: #dc3545;' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' />
                </svg>
                <h1 style='color: #dc3545; font-size: 24px; margin: 15px 0;'>¡Información de Experiencia Incompleta!</h1>
            </div>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                Hola <strong>" . htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') . "</strong>,
            </p>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                Notamos que aún no has registrado información sobre tu experiencia laboral en el sector público, privado o independiente en tu cuenta de <strong>UTEDÉ</strong>.
            </p>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 30px; color: #dc3545;'>
                ⚠️ Es importante completar esta información para un mejor registro en el sistema.
            </p>

            <div style='text-align: center; margin: 35px 0;'>
                <a href='https://sgth.utede.com.co/index.php/user/extra-job-info' 
                   style='display: inline-block; background-color: #2d89ef; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; transition: background-color 0.3s;'>
                   ⏳ Registrar Experiencia
                </a>
            </div>

            <div style='background-color: #e9ecef; padding: 20px; border-radius: 8px; margin-top: 30px;'>
                <p style='margin: 0; font-size: 14px; color: #666; text-align: center;'>
                    Si ya completaste esta información, por favor ignora este mensaje.
                </p>
            </div>
        </div>

        <div style='padding: 20px; background-color: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 15px 15px; text-align: center;'>
            <p style='margin: 0; color: #666; font-size: 13px;'>
                Este es un mensaje automático, por favor no respondas a este correo.
            </p>
            <div style='margin-top: 15px;'>
                <a href='https://www.utede.com.co' style='color: #2d89ef; text-decoration: none; margin: 0 10px;'>Sitio Web</a> |
                <a href='https://www.utede.com.co/ayuda' style='color: #2d89ef; text-decoration: none; margin: 0 10px;'>Centro de Ayuda</a>
            </div>
            <p style='margin: 15px 0 0; color: #666; font-size: 12px;'>
                © " . date('Y') . " UTEDÉ. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>
</html>";

        if ($destinatario) {
            $emailService->enviarCorreo($destinatario, $asunto, $mensaje);
            $session->set('missing_experience_email_sent', true);
        }
    }
    $db = \Config\Database::connect();
    $additionalStudies = $db->table('additional_studies')->where('cedula', $cedula)->get();

    // Si el usuario no tiene registros en additional_studies, enviar un correo de advertencia
    if ($additionalStudies->getNumRows() === 0 && !$session->get('missing_additional_studies_email_sent')) {
        $emailService = new \App\Libraries\Email();
        $destinatario = $user['email'] ?? null;
        $asunto = 'Registro de Estudios Adicionales Pendiente';
        $mensaje = "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Falta Información de Estudios Adicionales - UTEDÉ</title>
</head>
<body style='margin: 0; padding: 0; background-color: #f6f9fc; font-family: Segoe UI, Arial, sans-serif;'>
    <div style='max-width: 600px; margin: 20px auto; background: white; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
        <div style='text-align: center; padding: 30px 20px; background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); border-radius: 15px 15px 0 0;'>
            <img src='https://sgth.utede.com.co/img/utede_fondo.png' alt='UTEDÉ' style='width: 180px; height: auto;'>
        </div>

        <div style='padding: 40px 30px; color: #333;'>
            <div style='text-align: center; margin-bottom: 30px;'>
                <svg style='width: 60px; height: 60px; color: #dc3545;' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' />
                </svg>
                <h1 style='color: #dc3545; font-size: 24px; margin: 15px 0;'>¡Información de Estudios Adicionales Incompleta!</h1>
            </div>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                Hola <strong>" . htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') . "</strong>,
            </p>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'>
                Notamos que aún no has registrado información sobre estudios adicionales en tu cuenta de <strong>UTEDÉ</strong>.
            </p>

            <p style='font-size: 16px; line-height: 1.6; margin-bottom: 30px; color: #dc3545;'>
                ⚠️ Es importante completar esta información para un mejor registro en el sistema.
            </p>

            <div style='text-align: center; margin: 35px 0;'>
                <a href='https://sgth.utede.com.co/index.php/user/additional-study-info' 
                   style='display: inline-block; background-color: #2d89ef; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; transition: background-color 0.3s;'>
                   🎓 Registrar Estudios
                </a>
            </div>

            <div style='background-color: #e9ecef; padding: 20px; border-radius: 8px; margin-top: 30px;'>
                <p style='margin: 0; font-size: 14px; color: #666; text-align: center;'>
                    Si ya completaste esta información, por favor ignora este mensaje.
                </p>
            </div>
        </div>

        <div style='padding: 20px; background-color: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 15px 15px; text-align: center;'>
            <p style='margin: 0; color: #666; font-size: 13px;'>
                Este es un mensaje automático, por favor no respondas a este correo.
            </p>
            <div style='margin-top: 15px;'>
                <a href='https://www.utede.com.co' style='color: #2d89ef; text-decoration: none; margin: 0 10px;'>Sitio Web</a> |
                <a href='https://www.utede.com.co/ayuda' style='color: #2d89ef; text-decoration: none; margin: 0 10px;'>Centro de Ayuda</a>
            </div>
            <p style='margin: 15px 0 0; color: #666; font-size: 12px;'>
                © " . date('Y') . " UTEDÉ. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>
</html>";

        if ($destinatario) {
            $emailService->enviarCorreo($destinatario, $asunto, $mensaje);
            $session->set('missing_additional_studies_email_sent', true);
        }
    }
            $profilePhoto = $user['profile_photo'] ?? null;

            $data = [
                'user_cedula' => $cedula,
                'user_name' => $user['name'],
                'user_last_name' => $user['last_name'],
                'user_status' => $user['status'],
                'profilePhoto' => $profilePhoto,
            ];

            return view('menu', $data);
        }


    public function logout() {
        session()->destroy(); // Destruir la sesión
        return redirect()->to('/'); // Redirigir al inicio de sesión
    }
    
    public function tutoriales() {
        $session = session();
        $cedula = $session->get('cedula');

        // Validar que la cédula esté disponible
        if (!$cedula) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión.');
        }

        // Obtener los datos del usuario desde la base de datos
        $user = $this->userModel->where('cedula', $cedula)->first();

        // Verificar que el usuario exista
        if (!$user) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }

        // Obtener la foto de perfil del usuario
        $profilePhoto = $user['profile_photo'] ?? null;

        // Preparar datos para la vista
        $data = [
            'user_cedula'       => $cedula,
            'user_name'         => $user['name'],
            'user_last_name'    => $user['last_name'],
            'user_status'       => $user['status'],
            'profilePhoto'      => $profilePhoto,
            'user_count'        => $this->userModel->countAll(),
            'formulario_count'  => $this->personalInfoModel->countAll(),
            'academic_count'    => $this->academicInfoModel->countAll(),
            'titulo'            => 'Tutoriales'
        ];

        return view('tutoriales', $data);
    }
}
