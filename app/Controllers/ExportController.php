<?php

namespace App\Controllers;

require_once APPPATH . 'ThirdParty/SimpleXLSXGen/src/SimpleXLSXGen.php';

use App\Models\PersonalInfoModel;
use App\Models\AcademicInfoModel;
use App\Models\UserModel;
use App\Models\BasicInfoModel;
use Shuchkin\SimpleXLSXGen;
use App\Models\WorkExperienceModel;

class ExportController extends BaseController {

    public function exportExcel() {
        // Instanciar los modelos
        $personalInfoModel = new PersonalInfoModel();
        $academicInfoModel = new AcademicInfoModel();
        $userModel = new UserModel();
        $workExperienceModel = new WorkExperienceModel();
        $basicInfoModel = new BasicInfoModel();

        // Obtener todos los usuarios de la tabla 'users'
        $users = $userModel->findAll();

        // Obtener todos los datos de la tabla personal_info
        $personalInfoList = $personalInfoModel->findAll();

        // Verificar si se encontraron datos
        if (empty($users)) {
            return "No se encontraron usuarios en la tabla users.";
        }

        // Preparar los datos para el archivo Excel
        $data = [];

        // Agregar la tabla de usuarios con la información básica
        $data[] = ['Información Básica de Usuarios'];
        $data[] = [
            'Cédula',
            'Nombres',
            'Apellidos',
            'Tipo de Documento',
            'Correo Electrónico',
            'Teléfono',
            'Estado',
            'Rol'
        ];

        // Agregar los datos de los usuarios
        foreach ($users as $user) {
            $data[] = [
                strtoupper($user['cedula']),
                strtoupper($user['name']),
                strtoupper($user['last_name']),
                strtoupper($user['document_type']),
                strtoupper($user['email']),
                strtoupper($user['phone']),
                strtoupper($user['status']),
                strtoupper($user['role'])
            ];
        }


        // Agregar una fila vacía para separación entre secciones
        $data[] = [];
        /*
          // Agregar encabezados para la información personal (en negrita simulada)
          $data[] = ['Información Personal '];
          $data[] = [
          'Tipo de Documento', 'Cédula', 'Lugar de Emisión', 'Fecha de Emisión', 'Género',
          'Nacionalidad', 'Primer Nombre', 'Segundo Nombre', 'Primer Apellido', 'Segundo Apellido',
          'País de Nacimiento', 'Departamento de Nacimiento', 'Ciudad de Nacimiento', 'Fecha de Nacimiento',
          'Edad', 'Dirección', 'Teléfono', 'Móvil', 'Email', 'Tipo de Tarjeta Militar',
          'Número de Tarjeta Militar', 'Distrito Militar', 'Estado Civil',
          'Tipo de Documento del Cónyuge', 'Número de Documento del Cónyuge',
          'Nombre del Cónyuge', 'Apellido del Cónyuge', 'Archivo de Cédula',
          'País de Correspondencia', 'Estado de Correspondencia', 'Ciudad de Correspondencia', 'Maximo nivel Acádemico', 'Título obtenido', 'Fecha de Graduación', 'Fecha de Título'
          ];

          // Agregar la información personal (dejando celdas vacías si no hay información)
          foreach ($personalInfoList as $personalInfo) {
          $data[] = [
          $personalInfo['document_type'] ?? '',
          $personalInfo['cedula'] ?? '',
          $personalInfo['place_of_issue'] ?? '',
          $personalInfo['date_of_issue'] ?? '',
          $personalInfo['gender'] ?? '',
          $personalInfo['nationality'] ?? '',
          $personalInfo['first_name'] ?? '',
          $personalInfo['middle_name'] ?? '',
          $personalInfo['last_name'] ?? '',
          $personalInfo['second_last_name'] ?? '',
          $personalInfo['birth_country'] ?? '',
          $personalInfo['birth_department'] ?? '',
          $personalInfo['birth_city'] ?? '',
          $personalInfo['birth_date'] ?? '',
          $personalInfo['age'] ?? '',
          $personalInfo['address'] ?? '',
          $personalInfo['phone'] ?? '',
          $personalInfo['mobile'] ?? '',
          $personalInfo['email'] ?? '',
          $personalInfo['military_card_type'] ?? '',
          $personalInfo['military_card_number'] ?? '',
          $personalInfo['military_district'] ?? '',
          $personalInfo['marital_status'] ?? '',
          $personalInfo['spouse_document_type'] ?? '',
          $personalInfo['spouse_id_number'] ?? '',
          $personalInfo['spouse_first_name'] ?? '',
          $personalInfo['spouse_last_name'] ?? '',
          $personalInfo['cedula_file'] ?? '',
          $personalInfo['mailing_country'] ?? '',
          $personalInfo['mailing_state'] ?? '',
          $personalInfo['mailing_city'] ?? '',
          $personalInfo['max_level_academic'] ?? '',
          $personalInfo['obtained_title'] ?? '',
          $personalInfo['graduation_date'] ?? '',
          $personalInfo['title_date'] ?? '',
          ];
          }

          // Agregar una fila vacía para separación entre secciones
          $data[] = [];

          // Agregar encabezados para la información académica (en negrita simulada)
          $data[] = ['Información Académica'];
          $data[] = [
          'Número de identificación', 'Nivel Académico', 'Nivel de Educación', 'Área de Conocimiento',
          'Institución', 'Número de Tarjeta Profesional', 'Semestres Aprobados', 'Graduado',
          'Título Obtenido en el Curso', 'Fecha Inicio', 'Fecha Fin'
          ];

          // Agregar la información académica
          foreach ($personalInfoList as $personalInfo) {
          // Obtener los registros académicos correspondientes a la cédula
          $academicInfoList = $academicInfoModel->where('cedula', $personalInfo['cedula'])->findAll();

          if (empty($academicInfoList)) {
          $data[] = [
          $personalInfo['cedula'] ?? '',

          '', // academic_level
          '', // level_education
          '', // area_knowledge
          '', // institution
          '', // professional_card_number
          '', // semesters_passed
          '', // graduated
          '', // title_obtained
          '', // start_date
          ''  // end_date
          ];
          } else {
          foreach ($academicInfoList as $academicInfo) {
          $data[] = [
          $personalInfo['cedula'],
          $academicInfo['academic_level'] ?? '',
          $academicInfo['level_education'] ?? '',
          $academicInfo['area_knowledge'] ?? '',
          $academicInfo['institution'] ?? '',
          $academicInfo['professional_card_number'] ?? '',
          $academicInfo['semesters_passed'] ?? '',
          $academicInfo['graduated'] ?? '',
          $academicInfo['title_obtained'] ?? '',
          $academicInfo['start_date'] ?? '',
          $academicInfo['end_date'] ?? ''
          ];
          }
          }
          }

          // Agregar una fila vacía para separación entre secciones
          $data[] = [];

          // Agregar encabezados para la información de idiomas
          $data[] = ['Información de Idiomas'];
          $data[] = ['Número de identificación', 'Idioma', 'Habla', 'Lee', 'Escribe'];

          // Agregar la información de idiomas
          foreach ($personalInfoList as $personalInfo) {
          $languageInfoList = $basicInfoModel->where('cedula', $personalInfo['cedula'])->findAll();

          if (empty($languageInfoList)) {
          $data[] = [
          $personalInfo['cedula'],
          '', // language_name
          '', // speaks
          '', // reads
          ''  // writes
          ];
          } else {
          foreach ($languageInfoList as $languageInfo) {
          $data[] = [
          $personalInfo['cedula'],
          $languageInfo['language_name'] ?? '',
          $languageInfo['speaks'] ?? '',
          $languageInfo['reads'] ?? '',
          $languageInfo['writes'] ?? ''
          ];
          }
          }
          }

          // Agregar una fila vacía para separación entre secciones
          $data[] = [];

          // Agregar encabezados para la información de experiencia laboral
          $data[] = ['Información de Experiencia Laboral'];
          $data[] = [
          'Número de identificación', 'Empleador Actual', '¿Es Trabajo Actual?', 'País',
          'Departamento', 'Municipio', 'Teléfonos', 'Emails', 'Fecha de Inicio',
          'Fecha de Fin', 'Cargo', 'Dependencia', 'Dirección del Empleo',
          'Verificado', 'Archivo de Experiencia Laboral', 'Tipo de Empresa'
          ];

          // Agregar la información de experiencia laboral
          foreach ($personalInfoList as $personalInfo) {
          $workExperienceList = $workExperienceModel->where('cedula', $personalInfo['cedula'])->findAll();

          if (empty($workExperienceList)) {
          $data[] = [
          $personalInfo['cedula'],
          '', // current_employer
          '', // is_current_job
          '', // country_employ
          '', // department
          '', // municipality
          '', // phones
          '', // emails
          '', // start_date
          '', // end_date
          '', // position
          '', // dependency
          '', // address_employ
          '', // verified
          '', // workexperience_file
          ''  // company_type
          ];
          } else {
          foreach ($workExperienceList as $workExperience) {
          $data[] = [
          $personalInfo['cedula'],
          $workExperience['current_employer'],
          $workExperience['is_current_job'],
          $workExperience['country_employ'],
          $workExperience['department'],
          $workExperience['municipality'],
          $workExperience['phones'],
          $workExperience['emails'],
          $workExperience['start_date'],
          $workExperience['end_date'],
          $workExperience['position'],
          $workExperience['dependency'],
          $workExperience['address_employ'],
          $workExperience['verified'],
          $workExperience['workexperience_file'],
          $workExperience['company_type']
          ];
          }
          }
          }
         */
        // Crear el archivo Excel
        $xlsx = SimpleXLSXGen::fromArray($data);

        // Configurar las cabeceras para la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="reporte_personal_academico.xlsx"');

        // Enviar el archivo al navegador
        $xlsx->download();
        exit;
    }
}
