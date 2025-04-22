<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PersonalInfoModel;
use App\Models\AcademicInfoModel;
use App\Models\BasicInfoModel;
use App\Models\WorkExperienceModel;
use App\Models\ExperienceModel;

require_once APPPATH . 'ThirdParty/FPDI/FPDF/fpdf.php';
require_once APPPATH . 'ThirdParty/FPDI/autoload.php';

use setasign\Fpdi\Fpdi;

class PdfController extends BaseController {

    // Método para consultar los datos del usuario por cédula
    public function consultar($cedula) {
        // Crear una instancia del modelo UserModel
        $userModel = new UserModel();
        $personalInfoModel = new PersonalInfoModel();
        $academicInfoModel = new AcademicInfoModel();
        $basicInfoModel = new BasicInfoModel();
        $experienceInfoModel = new WorkExperienceModel();
        $experienceJobModel = new ExperienceModel();

        // Buscar al usuario utilizando la cédula recibida en la URL
        $user = $userModel->where('cedula', $cedula)->first();

        // Verificar si se encontraron los datos del usuario
        if (!$user) {
            throw new \RuntimeException("Usuario no encontrado.");
        }

        // Obtener los datos de la tabla personal_info usando la cédula
        $personalInfo = $personalInfoModel->where('cedula', $cedula)->first();
        $workExperience = $experienceInfoModel->where('cedula', $cedula)->findAll();
        // Obtener los datos de la tabla academic_info usando la cédula
        $academicInfo = $academicInfoModel->where('cedula', $cedula)->first();
        $academicInfos = $academicInfoModel->findAll(); // Consulta los datos académicos
        // Obtener los datos de la tabla languages usando la cédula (Información básica de idiomas)
        $basicInfo = $basicInfoModel->getLanguageInfoByCedula($cedula);  // Consulta los datos básicos de idiomas
        $experienceInfo = $experienceJobModel->where('cedula', $cedula)->first();
        // Limpiar cualquier salida de buffer previa
        ob_clean();

        // Establecer encabezados HTTP explícitamente para PDF
        header('Content-Type: application/pdf');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        // Crear un nuevo documento PDF
        $pdf = new Fpdi();

        // Verificar si el archivo existe
        $filePath = FCPATH . 'templates/pdfs/template.pdf';
        if (!file_exists($filePath)) {
            throw new \RuntimeException("El archivo PDF no existe: " . $filePath);
        }

        // Agregar página y configurar plantilla
        $pdf->AddPage();
        $pdf->setSourceFile($filePath);

        // Importar la primera página del PDF
        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId);

        $pdf->Image(ROOTPATH . 'public/img/utede_fondo.png', 145, 16.1, 55);
        $pdf->Image(ROOTPATH . 'public/img/linea.png', 135, 116, 55);
        $pdf->Image(ROOTPATH . 'public/img/linea3.png', 152, 116, 45);
        $pdf->Image(ROOTPATH . 'public/img/linea3.png', 119, 118, 25);
        // Establecer la fuente
        $pdf->SetFont('Arial', 'B', 9);

// 1. Datos Personales
        $pdf->SetXY(20, 61); // Posición X=50, Y=60
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['last_name'] ?? '')), 0, 1);

        $pdf->SetXY(79, 61);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['second_last_name'] ?? '')), 0, 1);

        $pdf->SetXY(140, 61);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($user['name'] ?? '')), 0, 1);

        if ($user['document_type'] == "Cédula de Ciudadanía") {
            $pdf->SetXY(28, 71); // Posición para Cédula de Ciudadanía
            $pdf->Cell(0, 10, 'X', 0, 1);
        } elseif ($user['document_type'] == "Cédula de Extranjería") {
            $pdf->SetXY(39, 71); // Posición para Cédula de Extranjería
            $pdf->Cell(0, 10, 'X', 0, 1);
        } elseif ($user['document_type'] == "Pasaporte") {
            $pdf->SetXY(51, 71); // Posición para Pasaporte
            $pdf->Cell(0, 10, 'X', 0, 1);
        }

        $pdf->SetXY(65, 71);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($user['cedula'] ?? '')), 0, 1);

        if ($personalInfo['gender'] ?? '' == "Masculino") {
            $pdf->SetXY(119.5, 71); // Posición para Masculino
            $pdf->Cell(0, 10, 'X', 0, 1);
        } elseif ($personalInfo['gender'] ?? '' == "Femenino") {
            $pdf->SetXY(110.5, 71); // Posición para Femenino
            $pdf->Cell(0, 10, 'X', 0, 1);
        }

        if ($personalInfo['birth_country'] ?? '' == "Colombia") {
            $pdf->SetXY(134.2, 71); // Posición específica para la "X"
            $pdf->Cell(0, 10, 'X', 0, 1);
        } else {
            $pdf->SetXY(166, 71); // Posición para el nombre del país
            $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['birth_country'] ?? '')), 0, 1);
            $pdf->SetXY(160, 71); // Ajusta esta posición a donde quieres la "X" en el else
            $pdf->Cell(0, 10, 'X', 0, 1); // Coloca la "X" en la nueva posición
        }

        if ($personalInfo['military_card_type'] ?? '' == "Primera clase") {
            $pdf->SetXY(50, 81.8); // Posición para Primera clase
            $pdf->Cell(0, 10, 'X', 0, 1);
        } elseif ($personalInfo['military_card_type'] ?? '' == "Segunda clase") {
            $pdf->SetXY(91, 81.8); // Posición para Segunda clase
            $pdf->Cell(0, 10, 'X', 0, 1);
        }

        $pdf->SetXY(118, 81.7);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['military_card_number'] ?? '')), 0, 1);

        $pdf->SetXY(174, 81.7);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['military_district'] ?? '')), 0, 1);

        $birth_date = $personalInfo['birth_date'] ?? '';
        $date_parts = explode('-', $birth_date);
        $year = $date_parts[0] ?? '';
        $month = $date_parts[1] ?? '';
        $day = $date_parts[2] ?? '';

        $pdf->SetXY(48, 94.5);
        $pdf->Cell(10, 10, $day, 0, 1);
        $pdf->SetXY(65, 94.5);
        $pdf->Cell(10, 10, $month, 0, 1);
        $pdf->SetXY(84, 94.5);
        $pdf->Cell(10, 10, $year, 0, 1);

        $pdf->SetXY(40, 100.5);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['birth_country'] ?? '')), 0, 1);

        $pdf->SetXY(40, 106.4);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['birth_department'] ?? '')), 0, 1);

        $pdf->SetXY(40, 112.9);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['birth_city'] ?? '')), 0, 1);

        $pdf->SetXY(103, 94);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['address'] ?? '')), 0, 1);

        $pdf->SetXY(112, 100.5);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['mailing_country'] ?? '')), 0, 1);

        $pdf->SetXY(167, 100.5);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['mailing_state'] ?? '')), 0, 1);

        $pdf->SetXY(121, 106.5);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['mailing_city'] ?? '')), 0, 1);

        $pdf->SetXY(120, 113);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['phone'] ?? '')), 0, 1);

        $pdf->SetXY(152, 113);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(0, 10, utf8_decode(strtoupper($personalInfo['email'] ?? '')), 0, 1);

// Añade la función utf8_decode en los demás valores según sea necesario


        $pdf->SetXY(21, 180);  // Ajusta la posición para colocar la información
        $pdf->SetFont('Arial', 'B', 17);
        // Verificar el valor de max_level_academic
        switch ($personalInfo['max_level_academic'] ?? '') {
            case 1:
                $pdf->SetXY(35, 160);
                $pdf->Cell(0, 10, 'X', 0, 1);
                break;
            case 2:
                $pdf->SetXY(40.5, 160);  // Cambiar la posición según sea necesario
                $pdf->Cell(0, 10, 'X', 0, 1);
                break;
            case 3:
                $pdf->SetXY(46.5, 160);
                $pdf->Cell(0, 10, 'X', 0, 1);
                break;
            case 4:
                $pdf->SetXY(52, 160);
                $pdf->Cell(0, 10, 'X', 0, 1);
                break;
            case 5:
                $pdf->SetXY(58, 160);
                $pdf->Cell(0, 10, 'X', 0, 1);
                break;
            case 6:
                $pdf->SetXY(64, 160);
                $pdf->Cell(0, 10, 'X', 0, 1);
                break;
            case 7:
                $pdf->SetXY(70, 160);
                $pdf->Cell(0, 10, 'X', 0, 1);
                break;
            case 8:
                $pdf->SetXY(76, 160);
                $pdf->Cell(0, 10, 'X', 0, 1);
                break;
            case 9:
                $pdf->SetXY(82.5, 160);
                $pdf->Cell(0, 10, 'X', 0, 1);
                break;
            case 10:
                $pdf->SetXY(89, 160);
                $pdf->Cell(0, 10, 'X', 0, 1);
                break;
            case 11:
                $pdf->SetXY(94.5, 160);
                $pdf->Cell(0, 10, 'X', 0, 1);
                break;
            default:
                // Si no es un valor válido, puedes manejarlo de alguna manera
                break;
        }

        $pdf->SetXY(126, 150);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 10, strtoupper($personalInfo['obtained_title'] ?? ''), 0, 1);

        $graduationDate = $personalInfo['graduation_date'] ?? '';

        $month = date('m', strtotime($graduationDate));
        $year = date('Y', strtotime($graduationDate));
        $pdf->SetXY(123.5, 160.5);
        $pdf->SetFont('Arial', 'B', 10);
        if (!empty($month)) {  // Verifica si $month no está vacío
            $pdf->Cell(0, 10, strtoupper($month), 0, 1);
        }

        $pdf->SetXY(146.2, 160.5);
        $pdf->SetFont('Arial', 'B', 10);
        if (!empty($year)) {  // Verifica si $year no está vacío
            $pdf->Cell(0, 10, strtoupper($year), 0, 1);
        }


        $idiomas = $basicInfoModel->getLanguageInfoByCedula($user['cedula']);
        $posY = 248; // Posición inicial en Y

        if (is_array($idiomas) && !empty($idiomas)) {
            foreach ($idiomas as $idioma) {
                // Mostrar el nombre del idioma
                $pdf->SetXY(55, $posY);
                $pdf->Cell(0, 10, utf8_decode(strtoupper($idioma['language_name'])), 0, 1);

                // Speaks
                if ($idioma['speaks'] === 'bien') {
                    $pdf->SetXY(112, $posY);
                    $pdf->Cell(0, 10, 'X', 0, 1);
                } elseif ($idioma['speaks'] === 'regular') {
                    $pdf->SetXY(106, $posY);
                    $pdf->Cell(0, 10, 'X', 0, 1);
                } elseif ($idioma['speaks'] === 'muy bien') {
                    $pdf->SetXY(118, $posY);
                    $pdf->Cell(0, 10, 'X', 0, 1);
                }

                // Reads
                if ($idioma['reads'] === 'bien') {
                    $pdf->SetXY(130, $posY);
                    $pdf->Cell(0, 10, 'X', 0, 1);
                } elseif ($idioma['reads'] === 'regular') {
                    $pdf->SetXY(124, $posY);
                    $pdf->Cell(0, 10, 'X', 0, 1);
                } elseif ($idioma['reads'] === 'muy bien') {
                    $pdf->SetXY(136, $posY);
                    $pdf->Cell(0, 10, 'X', 0, 1);
                }

                // Writes
                if ($idioma['writes'] === 'bien') {
                    $pdf->SetXY(148, $posY);
                    $pdf->Cell(0, 10, 'X', 0, 1);
                } elseif ($idioma['writes'] === 'regular') {
                    $pdf->SetXY(142, $posY);
                    $pdf->Cell(0, 10, 'X', 0, 1);
                } elseif ($idioma['writes'] === 'muy bien'
                        . '') {
                    $pdf->SetXY(155, $posY);
                    $pdf->Cell(0, 10, 'X', 0, 1);
                }

                $posY += 6; // Incrementa la posición en Y para el siguiente idioma
            }
        } else {
            $pdf->SetXY(55, $posY);
            $pdf->Cell(0, 10, "No se encontraron idiomas.", 0, 1);
        }




        $cedula = $user['cedula']; // Suponiendo que esta es la cédula que estás buscando
        $posY = 203; // Posición inicial en Y
// Filtrar la información por cédula
        $academicInfos = $academicInfoModel->getAcademicInfo($cedula);

        $counter = 0; // Contador para limitar a 5 registros

        foreach ($academicInfos as $academicInfo) {

            // Verificar si 'academic_level' es "Pregrado" o "Postgrado"
            if ($academicInfo['academic_level'] == 'Pregrado' || $academicInfo['academic_level'] == 'Postgrado') {

                // Mostrar 'academic_level' en mayúsculas, con "Pre" o "Post"
                $level = strtoupper($academicInfo['academic_level']); // Convertir a mayúsculas
                if ($level == 'POSTGRADO') {
                    $level = 'POST'; // Si es Postgrado, mostrar "Post"
                } elseif ($level == 'PREGRADO') {
                    $level = 'PRE'; // Si es Pregrado, mostrar "Pre"
                }

                // Mostrar el nivel académico (Pre o Post)
                $pdf->SetXY(20, $posY);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(0, 10, $level, 0, 1);

                // Mostrar 'semesters_passed'
                $pdf->SetXY(38, $posY);
                $pdf->Cell(0, 10, $academicInfo['semesters_passed'], 0, 1);

                // Mostrar 'graduated'
                $pdf->SetXY(50, $posY);
                if ($academicInfo['graduated'] == 'si') {
                    // Si es "Sí", se pone una X en una posición
                    $pdf->SetXY(64, $posY);
                    $pdf->Cell(0, 10, 'X', 0, 1);
                } elseif ($academicInfo['graduated'] == 'no') {
                    // Si es "No", se pone una X en otra posición
                    $pdf->SetXY(72, $posY);
                    $pdf->Cell(0, 10, 'X', 0, 1);
                } else {
                    // Si no tiene valor
                    $pdf->Cell(0, 10, '', 0, 1);
                }

                // Mostrar 'title_obtained'
                $pdf->SetXY(78.5, $posY);
                $pdf->Cell(0, 10, utf8_decode($academicInfo['title_obtained']), 0, 1);

                // Mostrar fecha de finalización
                $fecha = $academicInfo['end_date'];
                list($year, $month, $day) = explode('-', $fecha);

                // Mostrar mes
                $pdf->SetXY(150, $posY);
                $pdf->Cell(0, 10, $month, 0, 1);

                // Separar cada cifra del año y mostrarla
                $posX = 158; // Posición inicial en X para el año
                foreach (str_split($year) as $cifra) {
                    $pdf->SetXY($posX, $posY);
                    $pdf->Cell(0, 10, $cifra, 0, 1);
                    $posX += 5; // Incrementa la posición en X para la siguiente cifra
                }

                // Mostrar número de tarjeta profesional solo si es Pregrado o Postgrado
                $pdf->SetXY(176, $posY);
                $pdf->Cell(0, 10, $academicInfo['professional_card_number'], 0, 1);

                // Incrementar la posición Y después de cada ciclo de fecha
                $posY += 6; // Baja 5 unidades para la siguiente fecha
                // Contar los registros
                $counter++;

                // Si hemos procesado 5 registros, salir del ciclo
                if ($counter >= 5) {
                    break; // Salir del ciclo 'foreach'
                }
            }
        }





// Función para colocar una experiencia laboral en el PDF
function placeExperience($pdf, $experience, &$posY) {
    // Nombre del empleador
    $pdf->SetXY(21, $posY);
    $pdf->Cell(0, 10, utf8_decode(strtoupper($experience['current_employer'])), 0, 1);

    // Tipo de empresa
    if ($experience['company_type'] === 'Privada') {
        $pdf->SetXY(137, $posY);
        $pdf->Cell(10, 10, 'X', 0, 1);
    } elseif ($experience['company_type'] === 'Publica') {
        $pdf->SetXY(120, $posY);
        $pdf->Cell(10, 10, 'X', 0, 1);
    }

    // País de empleo
    $pdf->SetXY(150, $posY);
    $pdf->Cell(0, 10, utf8_decode(strtoupper($experience['country_employ'])), 0, 1);

    $posY += 12;

    // Ubicación
    $pdf->SetXY(20, $posY);
    $pdf->Cell(0, 10, strtoupper($experience['department']), 0, 1);

    $pdf->SetXY(83, $posY);
    $pdf->Cell(0, 10, strtoupper($experience['municipality']), 0, 1);

    $pdf->SetXY(145, $posY);
    $pdf->Cell(0, 10, strtoupper($experience['emails']), 0, 1);

    $posY += 10;

    // Teléfonos
    $pdf->SetXY(20, $posY);
    $pdf->Cell(0, 10, strtoupper($experience['phones']), 0, 1);

    // Fechas de inicio y fin
    list($startYear, $startMonth, $startDay) = explode('-', $experience['start_date']);
    list($endYear, $endMonth, $endDay) = explode('-', $experience['end_date']);

    $pdf->SetXY(92, $posY);
    $pdf->Cell(10, 10, $startDay, 0, 1);

    $pdf->SetXY(109, $posY);
    $pdf->Cell(10, 10, $startMonth, 0, 1);

    $pdf->SetXY(127, $posY);
    $pdf->Cell(15, 10, $startYear, 0, 1);

    $pdf->SetXY(151, $posY);
    $pdf->Cell(10, 10, $endDay, 0, 1);

    $pdf->SetXY(168, $posY);
    $pdf->Cell(10, 10, $endMonth, 0, 1);

    $pdf->SetXY(186, $posY);
    $pdf->Cell(15, 10, $endYear, 0, 1);

    $posY += 10;

    // Detalles del cargo
    $pdf->SetXY(20, $posY);
    $pdf->Cell(0, 10, strtoupper($experience['position']), 0, 1);

    $pdf->SetXY(83, $posY);
    $pdf->Cell(0, 10, strtoupper($experience['dependency']), 0, 1);

    $pdf->SetXY(143, $posY);
    $pdf->Cell(0, 10, utf8_decode(strtoupper($experience['address_employ'])), 0, 1);

    // Espaciado para el siguiente registro
    $posY += 14;
}

// Configurar la plantilla base
$templateId = $pdf->importPage(2);

// Separar trabajos actuales y otros trabajos
$currentJobs = array_filter($workExperience, fn($exp) => strtolower($exp['is_current_job']) === 'si');
$otherJobs = array_filter($workExperience, fn($exp) => strtolower($exp['is_current_job']) === 'no');

// Reindexar los arrays filtrados para facilitar la iteración
$currentJobs = array_values($currentJobs);
$otherJobs = array_values($otherJobs);

// Inicializar variables
$experiencesPerPageWithCurrent = 3; // Número de experiencias adicionales por página si se coloca una actual
$experiencesPerPageWithoutCurrent = 4; // Número de experiencias por página si no hay una actual

// Índices para recorrer las listas
$currentIndex = 0;
$otherIndex = 0;

// Loop hasta que todas las experiencias sean colocadas
while ($currentIndex < count($currentJobs) || $otherIndex < count($otherJobs)) {
    // Agregar una nueva página y aplicar la plantilla
    $pdf->AddPage();
    $pdf->useTemplate($templateId);

    // Variable para contar las experiencias colocadas en esta página
    $experiencesPlaced = 0;

    // Posición Y inicial según si hay una experiencia actual
    if ($currentIndex < count($currentJobs)) {
        // Colocar la experiencia actual en el primer campo
        $posY = 78; // Posición Y para el primer campo
        placeExperience($pdf, $currentJobs[$currentIndex], $posY);
        $currentIndex++;
        $experiencesPlaced++;
    } else {
        // No hay experiencia actual para esta página, dejar el primer campo vacío
        // y empezar desde el segundo campo ajustando posY
        // Asumiendo que cada experiencia ocupa un espacio vertical similar
        // Puedes ajustar este valor según tu diseño
        $posY = 78 + 46; // Ajusta este valor según el espacio que ocupa una experiencia
    }

    // Determinar el número máximo de otras experiencias en esta página
    if ($experiencesPlaced > 0) {
        $maxOtherExperiences = $experiencesPerPageWithCurrent; // 3 si hay una actual
    } else {
        $maxOtherExperiences = $experiencesPerPageWithoutCurrent; // 4 si no hay una actual
    }

    // Colocar otras experiencias
    for ($i = 0; $i < $maxOtherExperiences; $i++) {
        if ($otherIndex >= count($otherJobs)) {
            break; // No hay más experiencias para colocar
        }

        // Colocar la experiencia
        placeExperience($pdf, $otherJobs[$otherIndex], $posY);
        $otherIndex++;
        $experiencesPlaced++;
    }
}

// Manejar el caso donde no hay experiencias laborales (ni actuales ni otras)
if (empty($currentJobs) && empty($otherJobs)) {
    // Agregar una página vacía si es necesario
    $pdf->AddPage();
    $pdf->useTemplate($templateId);
}


        $pdf->AddPage();
        $pdf->setSourceFile($filePath);

        // Importar la primera página del PDF
        $templateId = $pdf->importPage(3);
        $pdf->useTemplate($templateId);

        $pdf->SetXY(136, 63);
        $pdf->Cell(0, 10, strtoupper($experienceInfo['public_servant_years'] ?? ''), 0, 1);

        $pdf->SetXY(162, 63);
        $pdf->Cell(0, 10, strtoupper($experienceInfo['public_servant_months'] ?? ''), 0, 1);

        $pdf->SetXY(136, 73);
        $pdf->Cell(0, 10, strtoupper($experienceInfo['private_sector_years'] ?? ''), 0, 1);

        $pdf->SetXY(162, 73);
        $pdf->Cell(0, 10, strtoupper($experienceInfo['private_sector_months'] ?? ''), 0, 1);

        $pdf->SetXY(136, 83);
        $pdf->Cell(0, 10, strtoupper($experienceInfo['independent_worker_years'] ?? ''), 0, 1);

        $pdf->SetXY(162, 83);
        $pdf->Cell(0, 10, strtoupper($experienceInfo['independent_worker_months'] ?? ''), 0, 1);

        $pdf->SetXY(136, 92);
        $pdf->Cell(0, 10, strtoupper($experienceInfo['total_years'] ?? ''), 0, 1);

        $pdf->SetXY(162, 92);
        $pdf->Cell(0, 10, strtoupper($experienceInfo['total_months'] ?? ''), 0, 1);

// Generar el PDF y mostrarlo
        $pdf->Output('I', 'Documento Hoja de vida.pdf');
        exit();
    }
}
