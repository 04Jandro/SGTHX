<?php include 'admin_header.php'; ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TabPanel con Bootstrap</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    </head>
    <!-- Barra de título y búsqueda -->
    <style>

        input, select {
            text-transform: uppercase;
        }
    </style>

    <!-- Contenedor principal con fondo suave -->
    <div class="container-fluid bg-light py-5">
        <!-- Botón de generación de PDF con animación hover -->
        <div class="d-flex justify-content-center align-items-center mb-5">
            <a href="<?= site_url('pdf/consultar/' . $user['cedula']) ?>" target="_blank" 
               class="btn btn-success btn-lg d-flex align-items-center shadow-lg hover-scale transition-all">
                <i class="bi bi-file-earmark-text-fill me-2"></i>
                <span>Generar Formato Hoja de Vida</span>
            </a>
        </div>

        <!-- Card principal con bordes suaves -->
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Navegación mejorada -->
            <div class="card-header bg-white border-0 p-0">
                <ul class="nav nav-pills nav-fill gap-2 p-3 bg-light rounded-top-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill d-flex align-items-center justify-content-center py-3 px-4" 
                                id="personal-info-tab" data-bs-toggle="tab" data-bs-target="#personal-info" 
                                type="button" role="tab" aria-controls="personal-info" aria-selected="true">
                            <i class="bi bi-person-circle me-2 fs-5"></i>
                            <span class="d-none d-md-inline">Información Personal</span>
                            <span class="d-inline d-md-none">Personal</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill d-flex align-items-center justify-content-center py-3 px-4" 
                                id="academic-info-tab" data-bs-toggle="tab" data-bs-target="#academic-info" 
                                type="button" role="tab" aria-controls="academic-info" aria-selected="false">
                            <i class="bi bi-book me-2 fs-5"></i>
                            <span class="d-none d-md-inline">Información Académica</span>
                            <span class="d-inline d-md-none">Académica</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill d-flex align-items-center justify-content-center py-3 px-4" 
                                id="work-experience-tab" data-bs-toggle="tab" data-bs-target="#work-experience" 
                                type="button" role="tab" aria-controls="work-experience" aria-selected="false">
                            <i class="bi bi-briefcase me-2 fs-5"></i>
                            <span class="d-none d-md-inline">Experiencia Laboral</span>
                            <span class="d-inline d-md-none">Laboral</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill d-flex align-items-center justify-content-center py-3 px-4" 
                                id="teaching-experience-tab" data-bs-toggle="tab" data-bs-target="#teaching-experience" 
                                type="button" role="tab" aria-controls="teaching-experience" aria-selected="false">
                            <i class="bi bi-easel me-2 fs-5"></i>
                            <span class="d-none d-md-inline">Experiencia Docente</span>
                            <span class="d-inline d-md-none">Docente</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill d-flex align-items-center justify-content-center py-3 px-4" 
                                id="additional-studies-tab" data-bs-toggle="tab" data-bs-target="#additional-studies" 
                                type="button" role="tab" aria-controls="additional-studies" aria-selected="false">
                            <i class="bi bi-journal-text me-2 fs-5"></i>
                            <span class="d-none d-md-inline">Estudios Adicionales</span>
                            <span class="d-inline d-md-none">Estudios</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill d-flex align-items-center justify-content-center py-3 px-4" 
                                id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" 
                                type="button" role="tab" aria-controls="documents" aria-selected="false">
                            <i class="bi bi-file-earmark-pdf-fill me-2 fs-5 text-danger"></i>
                            <span class="d-none d-md-inline">Archivos PDF</span>
                            <span class="d-inline d-md-none">PDF</span>
                        </button>
                    </li>
                </ul>



                <form id="userUpdate" action="<?= site_url('index.php/admin/security/update/') . $user['cedula'] ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="tab-content" id="myTabContent">


                        <div class="tab-pane fade show active" id="personal-info" role="tabpanel" aria-labelledby="personal-info-tab">
                            <h2 class="text-primary mb-3"><i class="bi bi-person me-2"></i>Información Personal</h2>

                            <!-- Tarjeta Documento de Identidad -->
                            <div class="card p-4 shadow-sm mb-3">
                                <h3 class="mb-3"><i class="bi bi-card-text me-2"></i>Documento de Identidad</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-card-text me-2"></i>Cédula</label>
                                        <input type="text" class="form-control" name="cedula" value="<?= $personalInfo['cedula'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-file-earmark-text me-2"></i>Tipo de Documento</label>
                                        <select id="document_type" name="document_type" class="form-select">
                                            <option value="Cédula de Ciudadanía" <?= ($personalInfo['document_type'] ?? '') == 'Cédula de Ciudadanía' ? 'selected' : '' ?>>Cédula de Ciudadanía</option>
                                            <option value="Cédula de Extranjería" <?= ($personalInfo['document_type'] ?? '') == 'Cédula de Extranjería' ? 'selected' : '' ?>>Cédula de Extranjería</option>
                                            <option value="Pasaporte" <?= ($personalInfo['document_type'] ?? '') == 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta Lugar y Fecha de Expedición -->
                            <div class="card p-4 shadow-sm mb-3">
                                <h3 class="mb-3"><i class="bi bi-geo-alt me-2"></i>Lugar y Fecha de Expedición</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-geo-alt me-2"></i>Lugar de Expedición</label>
                                        <input type="text" class="form-control" name="place_of_issue" value="<?= $personalInfo['place_of_issue'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-calendar-check me-2"></i>Fecha de Expedición</label>
                                        <input type="date" class="form-control" name="date_of_issue" value="<?= $personalInfo['date_of_issue'] ?? '' ?>" >
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta Nombre Completo -->
                            <div class="card p-4 shadow-sm mb-3">
                                <h3 class="mb-3"><i class="bi bi-person-badge me-2"></i>Nombre Completo</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-person-badge me-2"></i>Primer Nombre</label>
                                        <input type="text" class="form-control" name="first_name" value="<?= $personalInfo['first_name'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-person-badge me-2"></i>Segundo Nombre</label>
                                        <input type="text" class="form-control" name="middle_name" value="<?= $personalInfo['middle_name'] ?? '' ?>" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-person-fill me-2"></i>Primer Apellido</label>
                                        <input type="text" class="form-control" name="last_name" value="<?= $personalInfo['last_name'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-person-fill me-2"></i>Segundo Apellido</label>
                                        <input type="text" class="form-control" name="second_last_name" value="<?= $personalInfo['second_last_name'] ?? '' ?>" >
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta Información de Nacimiento con Género -->
                            <div class="card p-4 shadow-sm mb-3">
                                <h3 class="mb-3"><i class="bi bi-globe me-2"></i>Información de Nacimiento</h3>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="bi bi-globe me-2"></i>País de Nacimiento</label>
                                        <select id="birth_country" name="birth_country" class="form-select">
                                            <?php
                                            $countries = [
                                                "Afganistán", "Albania", "Alemania", "Andorra", "Angola", "Antigua y Barbuda", "Arabia Saudita", "Argelia", "Argentina", "Armenia", "Australia", "Austria",
                                                "Azerbaiyán", "Bahamas", "Bangladés", "Barbados", "Baréin", "Bélgica", "Belice", "Benín", "Bielorrusia", "Birmania", "Bolivia", "Bosnia y Herzegovina",
                                                "Botsuana", "Brasil", "Brunéi", "Bulgaria", "Burkina Faso", "Burundi", "Bután", "Cabo Verde", "Camboya", "Camerún", "Canadá", "Catar", "Chad", "Chile", "China",
                                                "Chipre", "Colombia", "Comoras", "Corea del Norte", "Corea del Sur", "Costa de Marfil", "Costa Rica", "Croacia", "Cuba", "Dinamarca", "Dominica", "Ecuador",
                                                "Egipto", "El Salvador", "Emiratos Árabes Unidos", "Eritrea", "Eslovaquia", "Eslovenia", "España", "Estados Unidos", "Estonia", "Etiopía", "Filipinas",
                                                "Finlandia", "Fiyi", "Francia", "Gabón", "Gambia", "Georgia", "Ghana", "Granada", "Grecia", "Guatemala", "Guinea", "Guinea-Bisáu", "Guinea Ecuatorial",
                                                "Guyana", "Haití", "Honduras", "Hungría", "India", "Indonesia", "Irak", "Irán", "Irlanda", "Islandia", "Islas Marshall", "Islas Salomón", "Israel", "Italia",
                                                "Jamaica", "Japón", "Jordania", "Kazajistán", "Kenia", "Kirguistán", "Kiribati", "Kuwait", "Laos", "Lesoto", "Letonia", "Líbano", "Liberia", "Libia",
                                                "Liechtenstein", "Lituania", "Luxemburgo", "Madagascar", "Malasia", "Malaui", "Maldivas", "Malí", "Malta", "Marruecos", "Mauricio", "Mauritania", "México",
                                                "Micronesia", "Moldavia", "Mónaco", "Mongolia", "Montenegro", "Mozambique", "Namibia", "Nauru", "Nepal", "Nicaragua", "Níger", "Nigeria", "Noruega",
                                                "Nueva Zelanda", "Omán", "Países Bajos", "Pakistán", "Palaos", "Panamá", "Papúa Nueva Guinea", "Paraguay", "Perú", "Polonia", "Portugal", "Reino Unido",
                                                "República Centroafricana", "República Checa", "República del Congo", "República Democrática del Congo", "República Dominicana", "Ruanda", "Rumania",
                                                "Rusia", "Samoa", "San Cristóbal y Nieves", "San Marino", "San Vicente y las Granadinas", "Santa Lucía", "Santo Tomé y Príncipe", "Senegal", "Serbia",
                                                "Seychelles", "Sierra Leona", "Singapur", "Siria", "Somalia", "Sri Lanka", "Suazilandia", "Sudáfrica", "Sudán", "Sudán del Sur", "Suecia", "Suiza", "Surinam",
                                                "Tailandia", "Tanzania", "Tayikistán", "Timor Oriental", "Togo", "Tonga", "Trinidad y Tobago", "Túnez", "Turkmenistán", "Turquía", "Tuvalu", "Ucrania",
                                                "Uganda", "Uruguay", "Uzbekistán", "Vanuatu", "Vaticano", "Venezuela", "Vietnam", "Yemen", "Yibuti", "Zambia", "Zimbabue"
                                            ];
                                            foreach ($countries as $country) {
                                                $selected = ($personalInfo['birth_country'] ?? '') == $country ? 'selected' : '';
                                                echo "<option value=\"$country\" $selected>$country</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="bi bi-house-door me-2"></i>Departamento de Nacimiento</label>
                                        <select id="birth_department" name="birth_department" class="form-select" >
                                            <option value="">Seleccione un departamento</option>
                                            <?php if (!empty($personalInfo['birth_department'])): ?>
                                                <option value="<?= $personalInfo['birth_department']; ?>" selected><?= $personalInfo['birth_department']; ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="bi bi-building me-2"></i>Ciudad de Nacimiento</label>
                                        <select id="birth_city" name="birth_city" class="form-select" >
                                            <option value="">Seleccione una ciudad</option>
                                            <?php if (!empty($personalInfo['birth_city'])): ?>
                                                <option value="<?= $personalInfo['birth_city']; ?>" selected><?= $personalInfo['birth_city']; ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-calendar me-2"></i>Fecha de Nacimiento</label>
                                        <input type="date" class="form-control" name="birth_date" value="<?= $personalInfo['birth_date'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-clock me-2"></i>Edad</label>
                                        <input type="text" class="form-control" name="age" value="<?= $personalInfo['age'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-gender-trans me-2"></i>Género</label>
                                        <select class="form-control" name="gender" >
                                            <option value="" disabled selected>Selecciona tu género</option>
                                            <option value="Femenino" <?= isset($personalInfo['gender']) && $personalInfo['gender'] == 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                                            <option value="Masculino" <?= isset($personalInfo['gender']) && $personalInfo['gender'] == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                                        </select>
                                    </div>


                                </div>
                            </div>

                            <!-- Tarjeta Contacto -->
                            <div class="card p-4 shadow-sm mb-3">
                                <h3 class="mb-3"><i class="bi bi-house-door me-2"></i>Contacto</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-house-door me-2"></i>Dirección</label>
                                        <input type="text" class="form-control" name="address" value="<?= $personalInfo['address'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-phone me-2"></i>Teléfono</label>
                                        <input type="text" class="form-control" name="phone" value="<?= $personalInfo['phone'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-cell me-2"></i>Móvil</label>
                                        <input type="text" class="form-control" name="mobile" value="<?= $personalInfo['mobile'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-envelope me-2"></i>Correo Electrónico</label>
                                        <input type="email" class="form-control" name="email" value="<?= $personalInfo['email'] ?? '' ?>" >
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta Información Militar -->
                            <div class="card p-4 shadow-sm mb-3">
                                <h3 class="mb-3"><i class="bi bi-shield-lock me-2"></i>Información Militar</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-shield-lock me-2"></i>Tipo de Carnet Militar</label>
                                        <select class="form-control" name="military_card_type" >
                                            <option value="" disabled selected>Selecciona el tipo de carnet</option>
                                            <option value="Primera clase" <?= isset($personalInfo['military_card_type']) && $personalInfo['military_card_type'] == 'Primera clase' ? 'selected' : '' ?>>Primera clase</option>
                                            <option value="Segunda clase" <?= isset($personalInfo['military_card_type']) && $personalInfo['military_card_type'] == 'Segunda clase' ? 'selected' : '' ?>>Segunda clase</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-card-checklist me-2"></i>Número de Carnet Militar</label>
                                        <input type="text" class="form-control" name="military_card_number" value="<?= $personalInfo['military_card_number'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-map me-2"></i>Distrito Militar</label>
                                        <input type="text" class="form-control" name="military_district" value="<?= $personalInfo['military_district'] ?? '' ?>" >
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta Información del Cónyuge -->
                            <div class="card p-4 shadow-sm mb-3">
                                <h3 class="mb-3"><i class="bi bi-person-fill me-2"></i>Información del Cónyuge</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-card-text me-2"></i>Tipo de Documento del Cónyuge</label>
                                        <select class="form-control" name="spouse_document_type">
                                            <option value="" disabled selected>Selecciona el tipo de documento</option>
                                            <option value="Cédula de ciudadanía" <?= isset($personalInfo['spouse_document_type']) && $personalInfo['spouse_document_type'] == 'Cédula de ciudadanía' ? 'selected' : '' ?>>Cédula de ciudadanía</option>
                                            <option value="Cédula de extranjería" <?= isset($personalInfo['spouse_document_type']) && $personalInfo['spouse_document_type'] == 'Cédula de extranjería' ? 'selected' : '' ?>>Cédula de extranjería</option>
                                            <option value="Pasaporte" <?= isset($personalInfo['spouse_document_type']) && $personalInfo['spouse_document_type'] == 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-file-earmark-text me-2"></i>Cédula del Cónyuge</label>
                                        <input type="text" class="form-control" name="spouse_id_number" value="<?= $personalInfo['spouse_id_number'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-person-fill me-2"></i>Primer Nombre del Cónyuge</label>
                                        <input type="text" class="form-control" name="spouse_first_name" value="<?= $personalInfo['spouse_first_name'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-person-fill me-2"></i>Primer Apellido del Cónyuge</label>
                                        <input type="text" class="form-control" name="spouse_last_name" value="<?= $personalInfo['spouse_last_name'] ?? '' ?>" >
                                    </div>
                                </div>
                            </div>
                            <!-- Nuevos Campos -->
                            <div class="card p-4 shadow-sm mb-3">
                                <h3 class="mb-3"><i class="bi bi-person-check me-2"></i>Información Académica y Residencia</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-pencil me-2"></i>Nivel Académico Máximo</label>
                                        <select class="form-control" name="max_level_academic">
                                            <option value="" disabled selected>Selecciona el nivel</option>
                                            <?php for ($i = 1; $i <= 11; $i++): ?>
                                                <option value="<?= $i ?>" <?= isset($personalInfo['max_level_academic']) && $personalInfo['max_level_academic'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-geo-alt me-2"></i>País de Residencia</label>
                                        <select id="mailing_country" class="form-select" name="mailing_country">
                                            <option value="" disabled selected>Selecciona un país</option>
                                            <?php
                                            $countries = [
                                                "Afganistán", "Alemania", "Argentina", "Australia", "Brasil", "Canadá", "Chile", "China",
                                                "Colombia", "Corea del Sur", "Cuba", "Dinamarca", "Ecuador", "Egipto", "El Salvador",
                                                "España", "Estados Unidos", "Francia", "Guatemala", "Honduras", "India", "Italia", "Japón",
                                                "México", "Nicaragua", "Noruega", "Panamá", "Paraguay", "Perú", "Portugal", "Reino Unido",
                                                "Rusia", "Sudáfrica", "Uruguay", "Venezuela", "Vietnam"
                                            ];

                                            foreach ($countries as $country) {
                                                $selected = ($personalInfo['mailing_country'] ?? '') == $country ? 'selected' : '';
                                                echo "<option value=\"$country\" $selected>$country</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-geo-alt me-2"></i>Departamento de Residencia</label>
                                        <select id="mailing_state" class="form-select" name="mailing_state" disabled>
                                            <option value="">Seleccione un departamento</option>
                                            <?php if (!empty($personalInfo['mailing_state'])): ?>
                                                <option value="<?= $personalInfo['mailing_state']; ?>" selected><?= $personalInfo['mailing_state']; ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-geo-alt me-2"></i>Ciudad de Residencia</label>
                                        <select id="mailing_city" class="form-select" name="mailing_city" disabled>
                                            <option value="">Seleccione una ciudad</option>
                                            <?php if (!empty($personalInfo['mailing_city'])): ?>
                                                <option value="<?= $personalInfo['mailing_city']; ?>" selected><?= $personalInfo['mailing_city']; ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-award me-2"></i>Título Obtenido</label>
                                        <input type="text" class="form-control" name="obtained_title" value="<?= $personalInfo['obtained_title'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-calendar-check me-2"></i>Fecha de Graduación</label>
                                        <input type="date" class="form-control" name="graduation_date" value="<?= $personalInfo['graduation_date'] ?? '' ?>" >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="bi bi-calendar-check me-2"></i>Fecha del Título</label>
                                        <input type="date" class="form-control" name="title_date" value="<?= $personalInfo['title_date'] ?? '' ?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="academic-info" role="tabpanel" aria-labelledby="academic-info-tab">
                            <?php if (!empty($academicInfo)): ?>
                                <?php foreach ($academicInfo as $info): ?>
                                    <h2 class="text-primary mb-4"><i class="bi bi-person me-2"></i>Información Académica en <?= strtoupper($info['institution'] ?? '') ?></h2>
                                    <div class="card p-4 shadow-sm">
                                        <input type="hidden" name="academic[<?= $info['id'] ?>][id]" value="<?= $info['id'] ?>">
                                        <div class="card mb-4 p-3 border-0 shadow-sm">
                                            <div class="row">
                                                <!-- Cédula y Nivel Académico -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="bi bi-person me-2"></i>Cédula</label>
                                                        <input type="text" class="form-control" value="<?= $info['cedula'] ?? '' ?>" name="academic[<?= $info['id'] ?>][cedula]" readonly>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="bi bi-mortarboard me-2"></i>Nivel Académico</label>
                                                        <select class="form-select" name="academic[<?= $info['id'] ?>][academic_level]" id="academic_level_<?= $info['id'] ?>">
                                                            <option value="" disabled <?= !isset($info['academic_level']) ? 'selected' : '' ?>>Selecciona tu nivel Académico</option>
                                                            <option value="Básica primaria" <?= isset($info['academic_level']) && $info['academic_level'] == 'Básica primaria' ? 'selected' : '' ?>>Básica primaria</option>
                                                            <option value="Básica secundaria" <?= isset($info['academic_level']) && $info['academic_level'] == 'Básica secundaria' ? 'selected' : '' ?>>Básica secundaria</option>
                                                            <option value="Educación media" <?= isset($info['academic_level']) && $info['academic_level'] == 'Educación media' ? 'selected' : '' ?>>Educación media</option>
                                                            <option value="Pregrado" <?= isset($info['academic_level']) && $info['academic_level'] == 'Pregrado' ? 'selected' : '' ?>>Pregrado</option>
                                                            <option value="Postgrado" <?= isset($info['academic_level']) && $info['academic_level'] == 'Postgrado' ? 'selected' : '' ?>>Postgrado</option>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Nivel de Educación y Área de Conocimiento -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="bi bi-book me-2"></i>Nivel de Educación</label>
                                                    <input type="text" class="form-control" value="<?= $info['level_education'] ?? '' ?>" name="academic[<?= $info['id'] ?>][level_education]">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="area_knowledge" class="form-label"><i class="bi bi-globe"></i> Área de Conocimiento</label>
                                                <div class="input-group">
                                                    <select id="area_knowledge_<?= $info['id'] ?>" name="academic[<?= $info['id'] ?>][area_knowledge]" class="form-select form-control" <?= in_array($info['academic_level'] ?? '', ['Pregrado', 'Postgrado']) ? '' : 'disabled' ?>>
                                                        <option value="" disabled selected>Selecciona el área de conocimiento</option>
                                                        <option value="Agronomia veterinario afines" <?= ($info['area_knowledge'] ?? '') == 'Agronomia veterinario afines' ? 'selected' : '' ?>>Agronomía, Veterinario y Afines</option>
                                                        <option value="Bellas artes" <?= ($info['area_knowledge'] ?? '') == 'Bellas artes' ? 'selected' : '' ?>>Bellas Artes</option>
                                                        <option value="Ciencias educacion" <?= ($info['area_knowledge'] ?? '') == 'Ciencias educacion' ? 'selected' : '' ?>>Ciencias de la Educación</option>
                                                        <option value="Ciencias salud" <?= ($info['area_knowledge'] ?? '') == 'Ciencias salud' ? 'selected' : '' ?>>Ciencias de la Salud</option>
                                                        <option value="Ciencias sociales_humanas" <?= ($info['area_knowledge'] ?? '') == 'Ciencias sociales_humanas' ? 'selected' : '' ?>>Ciencias Sociales y Humanas</option>
                                                        <option value="Ciencias sociales_derecho" <?= ($info['area_knowledge'] ?? '') == 'Ciencias sociales_derecho' ? 'selected' : '' ?>>Ciencias Sociales, Derecho, Ciencias Políticas</option>
                                                        <option value="Ciencias humanidades_personales" <?= ($info['area_knowledge'] ?? '') == 'Ciencias humanidades_personales' ? 'selected' : '' ?>>Ciencias y Humanidades Personales</option>
                                                        <option value="Economia administracion contaduria" <?= ($info['area_knowledge'] ?? '') == 'Economia administracion contaduria' ? 'selected' : '' ?>>Economía, Administración, Contaduría y Afines</option>
                                                        <option value="Generica" <?= ($info['area_knowledge'] ?? '') == 'Generica' ? 'selected' : '' ?>>Genérica</option>
                                                        <option value="Humanidades ciencias religiosas" <?= ($info['area_knowledge'] ?? '') == 'Humanidades ciencias religiosas' ? 'selected' : '' ?>>Humanidades y Ciencias Religiosas</option>
                                                        <option value="Ingenieria arquitectura urbanismo" <?= ($info['area_knowledge'] ?? '') == 'Ingenieria arquitectura urbanismo' ? 'selected' : '' ?>>Ingeniería, Arquitectura, Urbanismo y Afines</option>
                                                        <option value="Matematicas ciencias naturales" <?= ($info['area_knowledge'] ?? '') == 'Matematicas ciencias naturales' ? 'selected' : '' ?>>Matemáticas y Ciencias Naturales</option>
                                                        <option value="Tecnologia informatica" <?= ($info['area_knowledge'] ?? '') == 'Tecnologia informatica' ? 'selected' : '' ?>>Tecnología Informática</option>
                                                        <option value="No aplica" <?= ($info['area_knowledge'] ?? '') == 'No aplica' ? 'selected' : '' ?>>No Aplica</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Institución y Título Obtenido -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="bi bi-building me-2"></i>Institución</label>
                                                    <input type="text" class="form-control" value="<?= $info['institution'] ?? '' ?>" name="academic[<?= $info['id'] ?>][institution]">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="bi bi-award me-2"></i>Título Obtenido</label>
                                                    <input type="text" class="form-control" value="<?= $info['title_obtained'] ?? '' ?>" name="academic[<?= $info['id'] ?>][title_obtained]">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Fecha de Inicio y Fecha de Finalización -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="bi bi-calendar me-2"></i>Fecha de Inicio</label>
                                                    <input type="text" class="form-control" value="<?= $info['start_date'] ?? '' ?>" name="academic[<?= $info['id'] ?>][start_date]">
                                                </div>


                                                <!-- Nuevo campo: Número de tarjeta profesional -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="bi bi-credit-card me-2"></i>Número de Tarjeta Profesional</label>
                                                        <input type="text" class="form-control" value="<?= $info['professional_card_number'] ?? '' ?>" name="academic[<?= $info['id'] ?>][professional_card_number]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="bi bi-calendar-check me-2"></i>Fecha de Finalización</label>
                                                    <input type="text" class="form-control" value="<?= $info['end_date'] ?? '' ?>" name="academic[<?= $info['id'] ?>][end_date]">
                                                </div>
                                                <!-- Nuevo campo: Graduado -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="bi bi-check-circle me-2"></i>¿Graduado?</label>
                                                        <select class="form-control" name="academic[<?= $info['id'] ?>][graduated]">
                                                            <option value="si" <?= ($info['graduated'] ?? '') == 'si' ? 'selected' : '' ?>>Sí</option>
                                                            <option value="no" <?= ($info['graduated'] ?? '') == 'no' ? 'selected' : '' ?>>No</option>
                                                            <option value="" <?= empty($info['graduated']) ? 'selected' : '' ?>>No especificado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4 border border-3 border-primary"> <!-- Línea de separación entre experiencias -->
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-warning text-center" role="alert">
                                    <i class="bi bi-exclamation-circle me-2"></i>No hay información académica disponible.
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Experiencia Laboral -->
                        <div class="tab-pane fade" id="work-experience" role="tabpanel" aria-labelledby="work-experience-tab">
                            <?php if (!empty($workExperience)): ?>
                                <?php foreach ($workExperience as $experience): ?>
                                    <h2 class="mb-4 text-primary">
                                        <input type="hidden" name="work_experience[<?= $experience['id'] ?>][id]" value="<?= $experience['id'] ?>">
                                        <i class="fas fa-chalkboard-teacher me-2"></i>Experiencia Laboral en <?= strtoupper($experience['current_employer']) ?? 'Entidad Desconocida' ?>
                                    </h2>
                                    <div class="card p-4 shadow-sm">
                                        <div class="card mb-4 p-3 border-0 shadow-sm">
                                            <div class="row">
                                                <!-- Cédula -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-person me-2"></i>Cédula
                                                        </label>
                                                        <input type="text" class="form-control" value="<?= $experience['cedula'] ?? '' ?>" name="cedula">
                                                    </div>
                                                </div>

                                                <!-- Empleador Actual -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-person-check me-2"></i>Empleador Actual
                                                        </label>
                                                        <input type="text" class="form-control" name="work_experience[<?= $experience['id'] ?>][current_employer]" value="<?= $experience['current_employer'] ?? '' ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- ¿Es trabajo actual? -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-briefcase me-2"></i>¿Es trabajo actual?
                                                        </label>
                                                        <select class="form-control" name="work_experience[<?= $experience['id'] ?>][is_current_job]">
                                                            <option value="si" <?= ($experience['is_current_job'] ?? '') == 'si' ? 'selected' : '' ?>>Sí</option>
                                                            <option value="no" <?= ($experience['is_current_job'] ?? '') == 'no' ? 'selected' : '' ?>>No</option>

                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- País -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-globe me-2"></i>País
                                                        </label>
                                                        <select class="form-select" name="work_experience[<?= $experience['id'] ?>][country_employ]">
                                                            <option value="" disabled selected>Selecciona tu país</option>
                                                            <option value="Afganistán" <?= ($experience['country_employ'] ?? '') == 'Afganistán' ? 'selected' : '' ?>>Afganistán</option>
                                                            <option value="Albania" <?= ($experience['country_employ'] ?? '') == 'Albania' ? 'selected' : '' ?>>Albania</option>
                                                            <option valueoy'] ?? '') == 'Bangladesh' ? 'selected' : '' ?>>Bangladesh</option>
                                                            <option value="Barbados" <?= ($experience['country_employ'] ?? '') == 'Barbados' ? 'selected' : '' ?>>Barbados</option>
                                                            <option value="Baréin" <?= ($experience['country_employ'] ?? '') == 'Baréin' ? 'selected' : '' ?>>Baréin</option>
                                                            <option value="Bélgica" <?= ($experience['country_employ'] ?? '') == 'Bélgica' ? 'selected' : '' ?>>Bélgica</option>
                                                            <option value="Belice" <?= ($experience['country_employ'] ?? '') == 'Belice' ? 'selected' : '' ?>>Belice</option>
                                                            <option value="Benín" <?= ($experience['country_employ'] ?? '') == 'Benín' ? 'selected' : '' ?>>Benín</option>
                                                            <option value="Bielorrusia" <?= ($experience['country_employ'] ?? '') == 'Bielorrusia' ? 'selected' : '' ?>>Bielorrusia</option>
                                                            <option value="Bolivia" <?= ($experience['country_employ'] ?? '') == 'Bolivia' ? 'selected' : '' ?>>Bolivia</option>
                                                            <option value="Bosnia y Herzegovina" <?= ($experience['country_employ'] ?? '') == 'Bosnia y Herzegovina' ? 'selected' : '' ?>>Bosnia y Herzegovina</option>
                                                            <option value="Botsuana" <?= ($experience['country_employ'] ?? '') == 'Botsuana' ? 'selected' : '' ?>>Botsuana</option>
                                                            <option value="Brasil" <?= ($experience['country_employ'] ?? '') == 'Brasil' ? 'selected' : '' ?>>Brasil</option>
                                                            <option value="Brunéi" <?= ($experience['country_employ'] ?? '') == 'Brunéi' ? 'selected' : '' ?>>Brunéi</option>
                                                            <option value="Bulgaria" <?= ($experience['country_employ'] ?? '') == 'Bulgaria' ? 'selected' : '' ?>>Bulgaria</option>
                                                            <option value="Burkina Faso" <?= ($experience['country_employ'] ?? '') == 'Burkina Faso' ? 'selected' : '' ?>>Burkina Faso</option>
                                                            <option value="Burundi" <?= ($experience['country_employ'] ?? '') == 'Burundi' ? 'selected' : '' ?>>Burundi</option>
                                                            <option value="Bután" <?= ($experience['country_employ'] ?? '') == 'Bután' ? 'selected' : '' ?>>Bután</option>
                                                            <option value="Cabo Verde" <?= ($experience['country_employ'] ?? '') == 'Cabo Verde' ? 'selected' : '' ?>>Cabo Verde</option>
                                                            <option value="Camboya" <?= ($experience['country_employ'] ?? '') == 'Camboya' ? 'selected' : '' ?>>Camboya</option>
                                                            <option value="Camerún" <?= ($experience['country_employ'] ?? '') == 'Camerún' ? 'selected' : '' ?>>Camerún</option>
                                                            <option value="Canadá" <?= ($experience['country_employ'] ?? '') == 'Canadá' ? 'selected' : '' ?>>Canadá</option>
                                                            <option value="Catar" <?= ($experience['country_employ'] ?? '') == 'Catar' ? 'selected' : '' ?>>Catar</option>
                                                            <option value="Chile" <?= ($experience['country_employ'] ?? '') == 'Chile' ? 'selected' : '' ?>>Chile</option>
                                                            <option value="China" <?= ($experience['country_employ'] ?? '') == 'China' ? 'selected' : '' ?>>China</option>
                                                            <option value="Chipre" <?= ($experience['country_employ'] ?? '') == 'Chipre' ? 'selected' : '' ?>>Chipre</option>
                                                            <option value="Colombia" <?= ($experience['country_employ'] ?? '') == 'Colombia' ? 'selected' : '' ?>>Colombia</option>
                                                            <option value="Comoras" <?= ($experience['country_employ'] ?? '') == 'Comoras' ? 'selected' : '' ?>>Comoras</option>
                                                            <option value="Corea del Norte" <?= ($experience['country_employ'] ?? '') == 'Corea del Norte' ? 'selected' : '' ?>>Corea del Norte</option>
                                                            <option value="Corea del Sur" <?= ($experience['country_employ'] ?? '') == 'Corea del Sur' ? 'selected' : '' ?>>Corea del Sur</option>
                                                            <option value="Costa de Marfil" <?= ($experience['country_employ'] ?? '') == 'Costa de Marfil' ? 'selected' : '' ?>>Costa de Marfil</option>
                                                            <option value="Costa Rica" <?= ($experience['country_employ'] ?? '') == 'Costa Rica' ? 'selected' : '' ?>>Costa Rica</option>
                                                            <option value="Croacia" <?= ($experience['country_employ'] ?? '') == 'Croacia' ? 'selected' : '' ?>>Croacia</option>
                                                            <option value="Cuba" <?= ($experience['country_employ'] ?? '') == 'Cuba' ? 'selected' : '' ?>>Cuba</option>
                                                            <option value="Curazao" <?= ($experience['country_employ'] ?? '') == 'Curazao' ? 'selected' : '' ?>>Curazao</option>
                                                            <option value="Chipre" <?= ($experience['country_employ'] ?? '') == 'Chipre' ? 'selected' : '' ?>>Chipre</option>
                                                            <option value="Chequia" <?= ($experience['country_employ'] ?? '') == 'Chequia' ? 'selected' : '' ?>>Chequia</option>
                                                            <option value="Dinamarca" <?= ($experience['country_employ'] ?? '') == 'Dinamarca' ? 'selected' : '' ?>>Dinamarca</option>
                                                            <option value="Dominica" <?= ($experience['country_employ'] ?? '') == 'Dominica' ? 'selected' : '' ?>>Dominica</option>
                                                            <option value="Ecuador" <?= ($experience['country_employ'] ?? '') == 'Ecuador' ? 'selected' : '' ?>>Ecuador</option>
                                                            <option value="Egipto" <?= ($experience['country_employ'] ?? '') == 'Egipto' ? 'selected' : '' ?>>Egipto</option>
                                                            <option value="El Salvador" <?= ($experience['country_employ'] ?? '') == 'El Salvador' ? 'selected' : '' ?>>El Salvador</option>
                                                            <option value="Emiratos Árabes Unidos" <?= ($experience['country_employ'] ?? '') == 'Emiratos Árabes Unidos' ? 'selected' : '' ?>>Emiratos Árabes Unidos</option>
                                                            <option value="Eritrea" <?= ($experience['country_employ'] ?? '') == 'Eritrea' ? 'selected' : '' ?>>Eritrea</option>
                                                            <option value="Eslovaquia" <?= ($experience['country_employ'] ?? '') == 'Eslovaquia' ? 'selected' : '' ?>>Eslovaquia</option>
                                                            <option value="Eslovenia" <?= ($experience['country_employ'] ?? '') == 'Eslovenia' ? 'selected' : '' ?>>Eslovenia</option>
                                                            <option value="España" <?= ($experience['country_employ'] ?? '') == 'España' ? 'selected' : '' ?>>España</option>
                                                            <option value="Estados Unidos" <?= ($experience['country_employ'] ?? '') == 'Estados Unidos' ? 'selected' : '' ?>>Estados Unidos</option>
                                                            <option value="Estonia" <?= ($experience['country_employ'] ?? '') == 'Estonia' ? 'selected' : '' ?>>Estonia</option>
                                                            <option value="Eswatini" <?= ($experience['country_employ'] ?? '') == 'Eswatini' ? 'selected' : '' ?>>Eswatini</option>
                                                            <option value="Etiopía" <?= ($experience['country_employ'] ?? '') == 'Etiopía' ? 'selected' : '' ?>>Etiopía</option>
                                                            <option value="Fiyi" <?= ($experience['country_employ'] ?? '') == 'Fiyi' ? 'selected' : '' ?>>Fiyi</option>
                                                            <option value="Filipinas" <?= ($experience['country_employ'] ?? '') == 'Filipinas' ? 'selected' : '' ?>>Filipinas</option>
                                                            <option value="Finlandia" <?= ($experience['country_employ'] ?? '') == 'Finlandia' ? 'selected' : '' ?>>Finlandia</option>
                                                            <option value="Francia" <?= ($experience['country_employ'] ?? '') == 'Francia' ? 'selected' : '' ?>>Francia</option>
                                                            <option value="Gabón" <?= ($experience['country_employ'] ?? '') == 'Gabón' ? 'selected' : '' ?>>Gabón</option>
                                                            <option value="Gambia" <?= ($experience['country_employ'] ?? '') == 'Gambia' ? 'selected' : '' ?>>Gambia</option>
                                                            <option value="Georgia" <?= ($experience['country_employ'] ?? '') == 'Georgia' ? 'selected' : '' ?>>Georgia</option>
                                                            <option value="Ghana" <?= ($experience['country_employ'] ?? '') == 'Ghana' ? 'selected' : '' ?>>Ghana</option>
                                                            <option value="Granada" <?= ($experience['country_employ'] ?? '') == 'Granada' ? 'selected' : '' ?>>Granada</option>
                                                            <option value="Grecia" <?= ($experience['country_employ'] ?? '') == 'Grecia' ? 'selected' : '' ?>>Grecia</option>
                                                            <option value="Guatemala" <?= ($experience['country_employ'] ?? '') == 'Guatemala' ? 'selected' : '' ?>>Guatemala</option>
                                                            <option value="Guinea" <?= ($experience['country_employ'] ?? '') == 'Guinea' ? 'selected' : '' ?>>Guinea</option>
                                                            <option value="Guinea Ecuatorial" <?= ($experience['country_employ'] ?? '') == 'Guinea Ecuatorial' ? 'selected' : '' ?>>Guinea Ecuatorial</option>
                                                            <option value="Guinea-Bisáu" <?= ($experience['country_employ'] ?? '') == 'Guinea-Bisáu' ? 'selected' : '' ?>>Guinea-Bisáu</option>
                                                            <option value="Guyana" <?= ($experience['country_employ'] ?? '') == 'Guyana' ? 'selected' : '' ?>>Guyana</option>
                                                            <option value="Haití" <?= ($experience['country_employ'] ?? '') == 'Haití' ? 'selected' : '' ?>>Haití</option>
                                                            <option value="Honduras" <?= ($experience['country_employ'] ?? '') == 'Honduras' ? 'selected' : '' ?>>Honduras</option>
                                                            <option value="Hungría" <?= ($experience['country_employ'] ?? '') == 'Hungría' ? 'selected' : '' ?>>Hungría</option>
                                                            <option value="India" <?= ($experience['country_employ'] ?? '') == 'India' ? 'selected' : '' ?>>India</option>
                                                            <option value="Indonesia" <?= ($experience['country_employ'] ?? '') == 'Indonesia' ? 'selected' : '' ?>>Indonesia</option>
                                                            <option value="Irak" <?= ($experience['country_employ'] ?? '') == 'Irak' ? 'selected' : '' ?>>Irak</option>
                                                            <option value="Irlanda" <?= ($experience['country_employ'] ?? '') == 'Irlanda' ? 'selected' : '' ?>>Irlanda</option>
                                                            <option value="Islandia" <?= ($experience['country_employ'] ?? '') == 'Islandia' ? 'selected' : '' ?>>Islandia</option>
                                                            <option value="Islas Cook" <?= ($experience['country_employ'] ?? '') == 'Islas Cook' ? 'selected' : '' ?>>Islas Cook</option>
                                                            <option value="Islas Malvinas" <?= ($experience['country_employ'] ?? '') == 'Islas Malvinas' ? 'selected' : '' ?>>Islas Malvinas</option>
                                                            <option value="Islas Marshall" <?= ($experience['country_employ'] ?? '') == 'Islas Marshall' ? 'selected' : '' ?>>Islas Marshall</option>
                                                            <option value="Islas Salomón" <?= ($experience['country_employ'] ?? '') == 'Islas Salomón' ? 'selected' : '' ?>>Islas Salomón</option>
                                                            <option value="Israel" <?= ($experience['country_employ'] ?? '') == 'Israel' ? 'selected' : '' ?>>Israel</option>
                                                            <option value="Italia" <?= ($experience['country_employ'] ?? '') == 'Italia' ? 'selected' : '' ?>>Italia</option>
                                                            <option value="Jamaica" <?= ($experience['country_employ'] ?? '') == 'Jamaica' ? 'selected' : '' ?>>Jamaica</option>
                                                            <option value="Japón" <?= ($experience['country_employ'] ?? '') == 'Japón' ? 'selected' : '' ?>>Japón</option>
                                                            <option value="Jordania" <?= ($experience['country_employ'] ?? '') == 'Jordania' ? 'selected' : '' ?>>Jordania</option>
                                                            <option value="Kazajistán" <?= ($experience['country_employ'] ?? '') == 'Kazajistán' ? 'selected' : '' ?>>Kazajistán</option>
                                                            <option value="Kenia" <?= ($experience['country_employ'] ?? '') == 'Kenia' ? 'selected' : '' ?>>Kenia</option>
                                                            <option value="Kirguistán" <?= ($experience['country_employ'] ?? '') == 'Kirguistán' ? 'selected' : '' ?>>Kirguistán</option>
                                                            <option value="Kiribati" <?= ($experience['country_employ'] ?? '') == 'Kiribati' ? 'selected' : '' ?>>Kiribati</option>
                                                            <option value="Kuwait" <?= ($experience['country_employ'] ?? '') == 'Kuwait' ? 'selected' : '' ?>>Kuwait</option>
                                                            <option value="Laos" <?= ($experience['country_employ'] ?? '') == 'Laos' ? 'selected' : '' ?>>Laos</option>
                                                            <option value="Lesoto" <?= ($experience['country_employ'] ?? '') == 'Lesoto' ? 'selected' : '' ?>>Lesoto</option>
                                                            <option value="Letonia" <?= ($experience['country_employ'] ?? '') == 'Letonia' ? 'selected' : '' ?>>Letonia</option>
                                                            <option value="Líbano" <?= ($experience['country_employ'] ?? '') == 'Líbano' ? 'selected' : '' ?>>Líbano</option>
                                                            <option value="Liberia" <?= ($experience['country_employ'] ?? '') == 'Liberia' ? 'selected' : '' ?>>Liberia</option>
                                                            <option value="Libia" <?= ($experience['country_employ'] ?? '') == 'Libia' ? 'selected' : '' ?>>Libia</option>
                                                            <option value="Liechtenstein" <?= ($experience['country_employ'] ?? '') == 'Liechtenstein' ? 'selected' : '' ?>>Liechtenstein</option>
                                                            <option value="Lituania" <?= ($experience['country_employ'] ?? '') == 'Lituania' ? 'selected' : '' ?>>Lituania</option>
                                                            <option value="Luxemburgo" <?= ($experience['country_employ'] ?? '') == 'Luxemburgo' ? 'selected' : '' ?>>Luxemburgo</option>
                                                            <option value="Madagascar" <?= ($experience['country_employ'] ?? '') == 'Madagascar' ? 'selected' : '' ?>>Madagascar</option>
                                                            <option value="Malasia" <?= ($experience['country_employ'] ?? '') == 'Malasia' ? 'selected' : '' ?>>Malasia</option>
                                                            <option value="Malaui" <?= ($experience['country_employ'] ?? '') == 'Malaui' ? 'selected' : '' ?>>Malaui</option>
                                                            <option value="Maldivas" <?= ($experience['country_employ'] ?? '') == 'Maldivas' ? 'selected' : '' ?>>Maldivas</option>
                                                            <option value="Malí" <?= ($experience['country_employ'] ?? '') == 'Malí' ? 'selected' : '' ?>>Malí</option>
                                                            <option value="Malta" <?= ($experience['country_employ'] ?? '') == 'Malta' ? 'selected' : '' ?>>Malta</option>
                                                            <option value="Marruecos" <?= ($experience['country_employ'] ?? '') == 'Marruecos' ? 'selected' : '' ?>>Marruecos</option>
                                                            <option value="Mauricio" <?= ($experience['country_employ'] ?? '') == 'Mauricio' ? 'selected' : '' ?>>Mauricio</option>
                                                            <option value="Mauritania" <?= ($experience['country_employ'] ?? '') == 'Mauritania' ? 'selected' : '' ?>>Mauritania</option>
                                                            <option value="México" <?= ($experience['country_employ'] ?? '') == 'México' ? 'selected' : '' ?>>México</option>
                                                            <option value="Micronesia" <?= ($experience['country_employ'] ?? '') == 'Micronesia' ? 'selected' : '' ?>>Micronesia</option>
                                                            <option value="Moldavia" <?= ($experience['country_employ'] ?? '') == 'Moldavia' ? 'selected' : '' ?>>Moldavia</option>
                                                            <option value="Mónaco" <?= ($experience['country_employ'] ?? '') == 'Mónaco' ? 'selected' : '' ?>>Mónaco</option>
                                                            <option value="Mongolia" <?= ($experience['country_employ'] ?? '') == 'Mongolia' ? 'selected' : '' ?>>Mongolia</option>
                                                            <option value="Montenegro" <?= ($experience['country_employ'] ?? '') == 'Montenegro' ? 'selected' : '' ?>>Montenegro</option>
                                                            <option value="Mozambique" <?= ($experience['country_employ'] ?? '') == 'Mozambique' ? 'selected' : '' ?>>Mozambique</option>
                                                            <option value="Namibia" <?= ($experience['country_employ'] ?? '') == 'Namibia' ? 'selected' : '' ?>>Namibia</option>
                                                            <option value="Nauru" <?= ($experience['country_employ'] ?? '') == 'Nauru' ? 'selected' : '' ?>>Nauru</option>
                                                            <option value="Nepal" <?= ($experience['country_employ'] ?? '') == 'Nepal' ? 'selected' : '' ?>>Nepal</option>
                                                            <option value="Nicaragua" <?= ($experience['country_employ'] ?? '') == 'Nicaragua' ? 'selected' : '' ?>>Nicaragua</option>
                                                            <option value="Níger" <?= ($experience['country_employ'] ?? '') == 'Níger' ? 'selected' : '' ?>>Níger</option>
                                                            <option value="Nigeria" <?= ($experience['country_employ'] ?? '') == 'Nigeria' ? 'selected' : '' ?>>Nigeria</option>
                                                            <option value="Noruega" <?= ($experience['country_employ'] ?? '') == 'Noruega' ? 'selected' : '' ?>>Noruega</option>
                                                            <!-- Sigue agregando más países según sea necesario -->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Departamento -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-house-door me-2"></i>Departamento
                                                        </label>
                                                        <input type="text" class="form-control" name="work_experience[<?= $experience['id'] ?>][department]" value="<?= $experience['department'] ?? '' ?>">
                                                    </div>
                                                </div>

                                                <!-- Municipio -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-map me-2"></i>Municipio
                                                        </label>
                                                        <input type="text" class="form-control" name="work_experience[<?= $experience['id'] ?>][municipality]" value="<?= $experience['municipality'] ?? '' ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Teléfonos -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-telephone me-2"></i>Teléfonos
                                                        </label>
                                                        <input type="text" class="form-control" name="work_experience[<?= $experience['id'] ?>][phones]" value="<?= $experience['phones'] ?? '' ?>">
                                                    </div>
                                                </div>

                                                <!-- Correo electrónico -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-envelope me-2"></i>Correo Electrónico
                                                        </label>
                                                        <input type="emails" class="form-control" name="work_experience[<?= $experience['id'] ?>][emails]" value="<?= $experience['emails'] ?? '' ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Fecha de inicio -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-check me-2"></i>Fecha de Inicio
                                                        </label>
                                                        <input type="date" class="form-control" name="work_experience[<?= $experience['id'] ?>][start_date]" value="<?= $experience['start_date'] ?? '' ?>">
                                                    </div>
                                                </div>

                                                <!-- Fecha de fin -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-x me-2"></i>Fecha de Fin
                                                        </label>
                                                        <input type="date" class="form-control" name="work_experience[<?= $experience['id'] ?>][end_date]" value="<?= $experience['end_date'] ?? '' ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Cargo -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-briefcase me-2"></i>Cargo
                                                        </label>
                                                        <input type="text" class="form-control" name="work_experience[<?= $experience['id'] ?>][position]" value="<?= $experience['position'] ?? '' ?>">
                                                    </div>
                                                </div>

                                                <!-- Dependencia -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-link me-2"></i>Dependencia
                                                        </label>
                                                        <input type="text" class="form-control" name="work_experience[<?= $experience['id'] ?>][dependency]" value="<?= $experience['dependency'] ?? '' ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Dirección -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-house-door me-2"></i>Dirección
                                                        </label>
                                                        <input type="text" class="form-control" name="work_experience[<?= $experience['id'] ?>][address_employ]" value="<?= $experience['address_employ'] ?? '' ?>">
                                                    </div>
                                                </div>



                                                <!-- Tipo de Empresa -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-house-door me-2"></i>Tipo de Empresa
                                                        </label>
                                                        <select class="form-control" name="work_experience[<?= $experience['id'] ?>][company_type]">
                                                            <option value="Publica" <?= ($experience['company_type'] ?? '') == 'Publica' ? 'selected' : '' ?>>Pública</option>
                                                            <option value="Privada" <?= ($experience['company_type'] ?? '') == 'Privada' ? 'selected' : '' ?>>Privada</option>
                                                            <option value="" <?= empty($experience['company_type']) ? 'selected' : '' ?>>No especificado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr class="my-4 border border-3 border-primary"> <!-- Línea de separación entre experiencias -->
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-warning text-center" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>No hay experiencia laboral disponible.
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="tab-pane fade" id="teaching-experience" role="tabpanel" aria-labelledby="teaching-experience-tab">
                            <?php if (empty($teachingExperience)): ?>
                                <div class="alert alert-warning" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i> Aún no se ha registrado experiencia laboral docente.
                                </div>
                            <?php else: ?>
                                <?php foreach ($teachingExperience as $experience): ?>
                                    <h2 class="mb-4 text-primary">
                                        <i class="fas fa-chalkboard-teacher me-2"></i>Experiencia Laboral Docente en <?= $experience['educational_institution'] ?? 'Entidad Desconocida' ?>
                                    </h2>
                                    <div class="card shadow-sm p-3 mb-4">
                                        <div class="row">
                                            <!-- Cédula -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-id-card me-2"></i> Cédula</label>
                                                    <input type="text" class="form-control" value="<?= $experience['cedula'] ?? '' ?>" readonly name="cedula">
                                                </div>
                                            </div>

                                            <!-- Institución Educativa -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-school me-2"></i> Institución Educativa</label>
                                                    <input type="text" class="form-control" value="<?= $experience['educational_institution'] ?? '' ?>" name="teaching_experience[<?= $experience['id'] ?>][educational_institution]">
                                                </div>
                                            </div>

                                            <!-- Nivel Académico -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-graduation-cap me-2"></i> Nivel Académico</label>
                                                    <input type="text" class="form-control" value="<?= $experience['teaching_academic_level'] ?? '' ?>" name="teaching_experience[<?= $experience['id'] ?>][teaching_academic_level]">
                                                </div>
                                            </div>

                                            <!-- Área de Conocimiento -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-book me-2"></i> Área de Conocimiento</label>
                                                    <input type="text" class="form-control" value="<?= $experience['teaching_area_of_knowledge'] ?? '' ?>" name="teaching_experience[<?= $experience['id'] ?>][teaching_area_of_knowledge]">
                                                </div>
                                            </div>

                                            <!-- País -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-globe me-2"></i> País</label>
                                                    <input type="text" class="form-control" value="<?= $experience['country'] ?? '' ?>" name="teaching_experience[<?= $experience['id'] ?>][country]">
                                                </div>
                                            </div>

                                            <!-- Fecha de Inicio -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-calendar-alt me-2"></i> Fecha de Inicio</label>
                                                    <input type="text" class="form-control" value="<?= $experience['start_date'] ?? '' ?>" name="teaching_experience[<?= $experience['id'] ?>][start_date]">
                                                </div>
                                            </div>

                                            <!-- Fecha de Finalización -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-calendar-check me-2"></i> Fecha de Finalización</label>
                                                    <input type="text" class="form-control" value="<?= $experience['end_date'] ?? '' ?>" name="teaching_experience[<?= $experience['id'] ?>][end_date]">
                                                </div>
                                            </div>

                                            <!-- Verificado -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-check-circle me-2"></i> Verificado</label>
                                                    <input type="text" class="form-control" value="<?= isset($experience['verified']) && $experience['verified'] ? 'Sí' : 'No' ?>" name="teaching_experience[<?= $experience['id'] ?>][verified]" readonly>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- Tab Estudios Adicionales -->
                        <div class="tab-pane fade" id="additional-studies" role="tabpanel" aria-labelledby="additional-studies-tab">


                            <!-- Comprobación si hay estudios adicionales -->
                            <?php if (isset($additionalStudies) && !empty($additionalStudies)): ?>
                                <?php foreach ($additionalStudies as $study): ?>
                                    <!-- Tarjeta Información de Estudios Adicionales -->
                                    <h2 class="text-primary mb-3"><i class="bi bi-book me-2"></i>Estudios Adicionales en <?= $study['institution_name'] ?></h2>
                                    <div class="card p-4 shadow-sm mb-3">
                                        <input type="hidden" name="additional_study[<?= $study['id'] ?>][id]" value="<?= $study['id'] ?>">
                                        <h3 class="mb-3"><i class="bi bi-journal-text me-2"></i>Información de Estudios Adicionales</h3>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="bi bi-bookmark-fill me-2"></i>Tipo de Estudio</label>
                                                <input type="text" class="form-control" id="study_type_<?= $study['id'] ?>" value="<?= $study['study_type'] ?? '' ?>" name="additional_study[<?= $study['id'] ?>][study_type]">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="bi bi-award me-2"></i>Nombre de la institución</label>
                                                <input type="text" class="form-control" id="institution_name_<?= $study['id'] ?>" value="<?= $study['institution_name'] ?? '' ?>" name="additional_study[<?= $study['id'] ?>][institution_name]">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tarjeta Institución y Fechas -->
                                    <div class="card p-4 shadow-sm mb-3">
                                        <h3 class="mb-3"><i class="bi bi-building me-2"></i>Fechas</h3>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="bi bi-calendar-range me-2"></i>Fecha de Inicio</label>
                                                <input type="text" class="form-control" id="start_date_<?= $study['id'] ?>" value="<?= $study['start_date'] ?? '' ?>" name="additional_study[<?= $study['id'] ?>][start_date]">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="bi bi-calendar-check me-2"></i>Fecha de Finalización</label>
                                                <input type="text" class="form-control" id="end_date_<?= $study['id'] ?>" value="<?= $study['end_date'] ?? '' ?>" name="additional_study[<?= $study['id'] ?>][end_date]">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tarjeta Duración y Modalidad -->
                                    <div class="card p-4 shadow-sm mb-3">
                                        <h3 class="mb-3"><i class="bi bi-clock me-2"></i>Duración y Modalidad</h3>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="bi bi-clock-fill me-2"></i>Duración (Horas)</label>
                                                <input type="number" class="form-control" id="duration_hours_<?= $study['id'] ?>" value="<?= $study['duration_hours'] ?? '' ?>" name="additional_study[<?= $study['id'] ?>][duration_hours]">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill me-2"></i>Modalidad</label>
                                                <input type="text" class="form-control" id="modality_<?= $study['id'] ?>" value="<?= $study['modality'] ?? '' ?>" name="additional_study[<?= $study['id'] ?>][modality]">
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Tarjeta Estado del Estudio -->
                                    <div class="card p-4 shadow-sm mb-3">
                                        <h3 class="mb-3"><i class="bi bi-check-circle me-2"></i>Estado</h3>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="bi bi-clipboard-check me-2"></i>Estado del Estudio</label>
                                                <select class="form-control" id="status_<?= $study['id'] ?>" name="additional_study[<?= $study['id'] ?>][status]">
                                                    <option value="" disabled <?= empty($study['status']) ? 'selected' : '' ?>>Selecciona un estado</option>
                                                    <option value="Activo" <?= ($study['status'] == 'Activo') ? 'selected' : '' ?>>Activo</option>
                                                    <option value="Inactivo" <?= ($study['status'] == 'Inactivo') ? 'selected' : '' ?>>Inactivo</option>
                                                </select>


                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-warning" role="alert">
                                    <i class="bi bi-info-circle me-2"></i>No tiene estudios adicionales registrados.
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Archivos PDF -->
                        <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                            <h4 class="text-primary mb-4"><i class="bi bi-file-earmark-text me-2"></i> Archivos Subidos</h4>

                            <div class="card shadow border-0">
                                <div class="card-body">
                                    <div class="row gy-4">
                                        <?php if (!empty($files['personalInfo'])): ?>
                                            <?php foreach ($files['personalInfo'] as $personal): ?>
                                                <?php if (!empty($personal['cedula_file'])): ?>
                                                    <div class="col-lg-4 col-md-6 mb-4">
                                                        <div class="card shadow border-0 h-100">
                                                            <div class="card-body text-center">
                                                                <i class="bi bi-person-badge text-warning fs-1 mb-3"></i>
                                                                <h5 class="card-title fw-bold">Identificación</h5>
                                                                <p class="text-muted"><?= esc($personal['cedula'] ?? 'Identificación Desconocida') ?></p>
                                                                <a href="<?= base_url('/' . esc($personal['cedula_file'])) ?>" target="_blank" class="btn btn-outline-primary">
                                                                    <i class="bi bi-file-earmark-pdf me-2"></i> Ver PDF
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <!-- Archivos de Información Académica -->
                                        <?php if (!empty($files['academicInfo'])): ?>
                                            <?php foreach ($files['academicInfo'] as $academic): ?>
                                                <?php if (!empty($academic['academic_file'])): ?>
                                                    <div class="col-lg-4 col-md-6 mb-4">
                                                        <div class="card shadow border-0 h-100">
                                                            <div class="card-body text-center">
                                                                <i class="bi bi-mortarboard text-primary fs-1 mb-3"></i>
                                                                <h5 class="card-title fw-bold">Información Académica</h5>
                                                                <p class="text-muted"><?= esc($academic['institution'] ?? 'Institución Desconocida') ?></p>
                                                                <a href="<?= base_url('/' . esc($academic['academic_file'])) ?>" target="_blank" class="btn btn-outline-primary">
                                                                    <i class="bi bi-file-earmark-pdf me-2"></i> Ver PDF
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                        <!-- Archivos de Estudios Adicionales -->
                                        <?php if (!empty($files['additionalStudies'])): ?>
                                            <?php foreach ($files['additionalStudies'] as $study): ?>
                                                <?php if (!empty($study['study_file'])): ?>
                                                    <div class="col-lg-4 col-md-6 mb-4">
                                                        <div class="card shadow border-0 h-100">
                                                            <div class="card-body text-center">
                                                                <i class="bi bi-book-half text-success fs-1 mb-3"></i>
                                                                <h5 class="card-title fw-bold">Estudios Adicionales</h5>
                                                                <a href="<?= base_url('/' . esc($study['study_file'])) ?>" target="_blank" class="btn btn-outline-success">
                                                                    <i class="bi bi-file-earmark-pdf me-2"></i> Ver PDF
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>


                                        <!-- Archivos de Experiencia Laboral -->
                                        <?php if (!empty($files['workExperience'])): ?>
                                            <?php foreach ($files['workExperience'] as $work): ?>
                                                <?php if (!empty($work['workexperience_file'])): ?>
                                                    <div class="col-lg-4 col-md-6 mb-4">
                                                        <div class="card shadow border-0 h-100">
                                                            <div class="card-body text-center">
                                                                <i class="bi bi-briefcase text-info fs-1 mb-3"></i>
                                                                <h5 class="card-title fw-bold">Experiencia Laboral</h5>
                                                                <p class="text-muted"><?= esc($work['current_employer'] ?? 'Empleador Desconocido') ?></p>
                                                                <a href="<?= base_url('/' . esc($work['workexperience_file'])) ?>" target="_blank" class="btn btn-outline-info">
                                                                    <i class="bi bi-file-earmark-pdf me-2"></i> Ver PDF
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                        <!-- Archivos de Experiencia Docente -->
                                        <?php if (!empty($files['teachingExperience'])): ?>
                                            <?php foreach ($files['teachingExperience'] as $teaching): ?>
                                                <?php if (!empty($teaching['teachingexperience_file'])): ?>
                                                    <div class="col-lg-4 col-md-6 mb-4">
                                                        <div class="card shadow border-0 h-100">
                                                            <div class="card-body text-center">
                                                                <i class="bi bi-easel text-danger fs-1 mb-3"></i>
                                                                <h5 class="card-title fw-bold">Experiencia Docente</h5>
                                                                <p class="text-muted"><?= esc($teaching['educational_institution'] ?? 'Institución Desconocida') ?></p>
                                                                <a href="<?= base_url('/' . esc($teaching['teachingexperience_file'])) ?>" target="_blank" class="btn btn-outline-danger">
                                                                    <i class="bi bi-file-earmark-pdf me-2"></i> Ver PDF
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                        <!-- Archivos de Documentos Subidos -->
                                        <?php if (!empty($documents)): ?>
                                            <?php foreach ($documents as $document): ?>
                                                <?php if (!empty($document['file_path'])): ?>
                                                    <div class="col-lg-4 col-md-6 mb-4">
                                                        <div class="card shadow border-0 h-100">
                                                            <div class="card-body text-center">
                                                                <i class="bi bi-file-earmark-text text-primary fs-1 mb-3"></i>
                                                                <h5 class="card-title fw-bold"><?= esc($document['document_type'] ?? 'Tipo Desconocido') ?></h5>
                                                                <p class="text-muted">Cédula: <?= esc($document['cedula'] ?? 'No Disponible') ?></p>
                                                                <a href="<?= base_url('/' . esc($document['file_path'])) ?>" target="_blank" class="btn btn-outline-primary">
                                                                    <i class="bi bi-file-earmark-pdf me-2"></i> Ver Documento
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p class="text-muted text-center">No hay documentos disponibles.</p>
                                        <?php endif; ?>




                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg rounded-pill px-4 py-2 shadow-sm d-flex align-items-center justify-content-center mt-4">
                            <i class="fas fa-save me-2"></i>
                            <span>Guardar Información</span>
                        </button>



                </form>

                <!-- Success Modal --> 
                <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="successModalLabel">
                                    <i class="bi bi-check-circle-fill me-2"></i>Gracias <?php echo htmlspecialchars($user_name . '!', ENT_QUOTES, 'UTF-8'); ?>
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p class="fs-4">
                                    <i class="bi bi-clipboard-check text-success me-2" style="font-size: 3rem;"></i>
                                </p>
                                <h4>Información Guardada</h4>
                                <p>Tu información general se ha guardado correctamente.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="refreshPageButton">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // Manejar el envío del formulario para mostrar el modal de éxito
                    document.getElementById('userUpdate').addEventListener('submit', function (e) {
                        e.preventDefault(); // Prevenir el envío normal del formulario

                        // Aquí generalmente harías un envío AJAX
                        // Para este ejemplo, simularemos una respuesta exitosa
                        fetch('<?= base_url('index.php/admin/security/update/') . $user['cedula'] ?>', {
                            method: 'POST',
                            body: new FormData(this)
                        })
                                .then(response => {
                                    if (response.ok) {
                                        // Mostrar el modal de éxito
                                        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                                        successModal.show();
                                    } else {
                                        // Manejar el error (mostrar la respuesta completa en la consola)
                                        response.text().then(text => console.log(text));  // Ver el cuerpo de la respuesta
                                        alert('Hubo un error al guardar la información');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Hubo un error al guardar la información');
                                });
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var academicLevel = document.getElementById('academic_level');
                        var areaOfKnowledge = document.getElementById('area_knowledge');

                        // Verifica que los elementos existan antes de intentar usarlos
                        if (academicLevel && areaOfKnowledge) {
                            // Habilitar o deshabilitar el área de conocimiento según el nivel académico
                            academicLevel.addEventListener('change', function () {
                                if (this.value == 'Pregrado' || this.value == 'Postgrado') {
                                    areaOfKnowledge.disabled = false;
                                } else {
                                    areaOfKnowledge.disabled = true;
                                }
                            });

                            // Establecer el estado inicial de la área de conocimiento al cargar
                            if (academicLevel.value == 'Pregrado' || academicLevel.value == 'Postgrado') {
                                areaOfKnowledge.disabled = false;
                            } else {
                                areaOfKnowledge.disabled = true;
                            }
                        }
                    });
                </script>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        // Seleccionar todas las pestañas
                        const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
                        const pdfContent = document.querySelector('#documents'); // Contenido de Archivos PDF

                        // Función para verificar la pestaña activa
                        function togglePDFVisibility(tabId) {
                            if (tabId === "documents-tab") {
                                // Mostrar contenido de Archivos PDF si estás en su pestaña
                                pdfContent.style.display = "block";
                            } else {
                                // Ocultar contenido de Archivos PDF si no estás en su pestaña
                                pdfContent.style.display = "none";
                            }
                        }

                        // Escuchar el evento de cambio de pestañas
                        tabs.forEach(tab => {
                            tab.addEventListener("shown.bs.tab", function (event) {
                                const tabId = event.target.id; // Obtener el ID de la pestaña activa
                                togglePDFVisibility(tabId);
                            });
                        });

                        // Al cargar la página, verificar la pestaña activa
                        const activeTab = document.querySelector('.nav-link.active');
                        if (activeTab) {
                            togglePDFVisibility(activeTab.id);
                        }
                    });

                </script>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const colombiaData = {
                            "Amazonas": ["Leticia", "Puerto Nariño"],
                            "Antioquia": ["Medellín", "Bello", "Envigado", "Itagüí", "Apartadó", "Turbo", "Rionegro", "Caucasia", "Sabaneta", "La Ceja"],
                            "Arauca": ["Arauca", "Saravena", "Tame", "Arauquita", "Cravo Norte", "Fortul", "Puerto Rondón"],
                            "Atlántico": ["Barranquilla", "Soledad", "Malambo", "Galapa", "Sabanalarga", "Puerto Colombia", "Baranoa", "Polonuevo"],
                            "Bogotá D.C.": ["Bogotá"],
                            "Bolívar": ["Cartagena", "Magangué", "Turbaco", "Arjona", "El Carmen de Bolívar", "Mompós", "San Juan Nepomuceno"],
                            "Boyacá": ["Tunja", "Duitama", "Sogamoso", "Chiquinquirá", "Paipa", "Villa de Leyva", "Puerto Boyacá", "Soatá"],
                            "Caldas": ["Manizales", "Chinchiná", "Villamaría", "La Dorada", "Anserma", "Riosucio", "Aguadas"],
                            "Caquetá": ["Florencia", "San Vicente del Caguán", "Puerto Rico", "Cartagena del Chairá", "Solano"],
                            "Casanare": ["Yopal", "Aguazul", "Villanueva", "Tauramena", "Monterrey", "Orocué"],
                            "Cauca": ["Popayán", "Santander de Quilichao", "Puerto Tejada", "Patía", "El Tambo", "Cajibío"],
                            "Cesar": ["Valledupar", "Aguachica", "Codazzi", "La Jagua de Ibirico", "Bosconia", "El Copey"],
                            "Chocó": ["Quibdó", "Istmina", "Condoto", "Tadó", "Bahía Solano", "Riosucio"],
                            "Córdoba": ["Montería", "Cereté", "Sahagún", "Lorica", "Tierralta", "Planeta Rica"],
                            "Cundinamarca": ["Bogotá", "Soacha", "Chía", "Zipaquirá", "Facatativá", "Girardot", "Funza"],
                            "Guainía": ["Inírida"],
                            "Guaviare": ["San José del Guaviare", "Calamar", "Miraflores"],
                            "Huila": ["Neiva", "Pitalito", "Garzón", "La Plata", "Campoalegre", "Algeciras"],
                            "La Guajira": ["Riohacha", "Maicao", "Fonseca", "San Juan del Cesar", "Villanueva"],
                            "Magdalena": ["Santa Marta", "Ciénaga", "Fundación", "Plato", "El Banco"],
                            "Meta": ["Villavicencio", "Acacías", "Granada", "Puerto Gaitán", "Puerto López"],
                            "Nariño": ["Pasto", "Ipiales", "Tumaco", "Túquerres", "Samaniego"],
                            "Norte de Santander": ["Cúcuta", "Ocaña", "Pamplona", "Villa del Rosario", "Los Patios"],
                            "Putumayo": ["Mocoa", "Puerto Asís", "Orito", "La Hormiga", "Sibundoy"],
                            "Quindío": ["Armenia", "Calarcá", "La Tebaida", "Montenegro", "Circasia"],
                            "Risaralda": ["Pereira", "Dosquebradas", "Santa Rosa de Cabal", "La Virginia"],
                            "San Andrés y Providencia": ["San Andrés", "Providencia"],
                            "Santander": ["Bucaramanga", "Floridablanca", "Girón", "Piedecuesta", "Barrancabermeja", "San Gil"],
                            "Sucre": ["Sincelejo", "Corozal", "Sampués", "San Marcos", "Tolú"],
                            "Tolima": ["Ibagué", "Espinal", "Melgar", "Honda", "Líbano"],
                            "Valle del Cauca": ["Cali", "Palmira", "Buenaventura", "Tuluá", "Cartago", "Buga", "Yumbo", "Jamundí"],
                            "Vaupés": ["Mitú"],
                            "Vichada": ["Puerto Carreño", "La Primavera", "Cumaribo"]
                        };


                        function setupCountrySelectors(countrySelectId, departmentSelectId, citySelectId, defaultDept, defaultCity) {
                            const countrySelect = document.getElementById(countrySelectId);
                            const departmentSelect = document.getElementById(departmentSelectId);
                            const citySelect = document.getElementById(citySelectId);

                            function loadDepartments() {
                                if (countrySelect.value === "Colombia") {
                                    departmentSelect.disabled = false;
                                    citySelect.disabled = false;
                                    departmentSelect.innerHTML = '<option value="">Seleccione un departamento</option>';
                                    for (let department in colombiaData) {
                                        let option = document.createElement('option');
                                        option.value = department;
                                        option.textContent = department;
                                        if (option.value === defaultDept) {
                                            option.selected = true;
                                        }
                                        departmentSelect.appendChild(option);
                                    }

                                    if (defaultDept) {
                                        populateCities(defaultDept);
                                    }
                                } else {
                                    departmentSelect.disabled = true;
                                    citySelect.disabled = true;
                                    departmentSelect.innerHTML = '<option value="">Seleccione un departamento</option>';
                                    citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
                                }
                            }

                            function populateCities(department) {
                                citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
                                if (colombiaData[department]) {
                                    colombiaData[department].forEach(city => {
                                        let option = document.createElement('option');
                                        option.value = city;
                                        option.textContent = city;
                                        if (option.value === defaultCity) {
                                            option.selected = true;
                                        }
                                        citySelect.appendChild(option);
                                    });
                                }
                            }

                            // Cargar datos iniciales si hay valores por defecto
                            loadDepartments();

                            // Eventos de cambio
                            countrySelect.addEventListener('change', loadDepartments);
                            departmentSelect.addEventListener('change', function () {
                                populateCities(this.value);
                            });
                        }

                        // Configuración para lugar de nacimiento
                        setupCountrySelectors(
                                'birth_country',
                                'birth_department',
                                'birth_city',
                                "<?= $personalInfo['birth_department'] ?? '' ?>",
                                "<?= $personalInfo['birth_city'] ?? '' ?>"
                                );

                        // Configuración para lugar de residencia
                        setupCountrySelectors(
                                'mailing_country',
                                'mailing_state',
                                'mailing_city',
                                "<?= $personalInfo['mailing_state'] ?? '' ?>",
                                "<?= $personalInfo['mailing_city'] ?? '' ?>"
                                );
                    });
                </script>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        // Seleccionar todas las pestañas
                        const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
                        const additionalStudiesContent = document.querySelector('#additional-studies'); // Contenido de "Additional Studies"

                        // Función para verificar la pestaña activa
                        function toggleAdditionalStudiesVisibility(tabId) {
                            if (tabId === "additional-studies-tab") {
                                // Mostrar contenido de "Additional Studies" si estás en su pestaña
                                additionalStudiesContent.style.display = "block";
                            } else {
                                // Ocultar contenido de "Additional Studies" si no estás en su pestaña
                                additionalStudiesContent.style.display = "none";
                            }
                        }

                        // Escuchar el evento de cambio de pestañas
                        tabs.forEach(tab => {
                            tab.addEventListener("shown.bs.tab", function (event) {
                                const tabId = event.target.id; // Obtener el ID de la pestaña activa
                                toggleAdditionalStudiesVisibility(tabId);
                            });
                        });

                        // Al cargar la página, verificar la pestaña activa
                        const activeTab = document.querySelector('.nav-link.active');
                        if (activeTab) {
                            toggleAdditionalStudiesVisibility(activeTab.id);
                        }
                    });
                </script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                </body>
                </html>