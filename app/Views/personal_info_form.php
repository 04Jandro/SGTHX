<?php include 'user_header.php'; ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario de Información Personal</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <style>
            body {
                background-color: #f4f6f9;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            }
            .form-container {
                background-color: white;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                padding: 30px;
                margin-top: 3rem;
            }
            .form-label {
                font-weight: 600;
                color: #495057;
            }
            .form-control, .form-select {
                border-radius: 8px;
                padding: 0.75rem 1rem;
                border-color: #ced4da;
                transition: all 0.3s ease;
            }
            .form-control:focus, .form-select:focus {
                border-color: #6c757d;
                box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
            }
            .btn-primary, .btn-secondary, .btn-success {
                border-radius: 8px;
                padding: 0.75rem 1.5rem;
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #004085;
            }
            .form-step {
                display: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .form-step.active {
                display: block;
                opacity: 1;
            }
            .step-indicator {
                display: flex;
                justify-content: space-between;
                margin-bottom: 20px;
            }
            .step-indicator .step {
                flex: 1;
                text-align: center;
                padding: 10px;
                background-color: #e9ecef;
                color: #6c757d;
                position: relative;
            }
            .step-indicator .step.active {
                background-color: #007bff;
                color: white;
            }
            .step-indicator .step:not(:first-child)::before {
                content: '';
                position: absolute;
                top: 50%;
                left: -50%;
                width: 100%;
                height: 2px;
                background-color: #e9ecef;
                z-index: -1;
            }
            .step-indicator .step.active:not(:first-child)::before {
                background-color: #007bff;
            }
            .col-12{
                margin-top:20px;
            }
            .form-control[readonly] {
                background-color: #e9ecef; /* Aplica un gris claro */
                opacity: 1;
            }
            input, select {
                text-transform: uppercase;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 form-container">
                    <h2 class="text-center mb-4 text-dark">
                        <i class="fas fa-user-edit me-2"></i>Formulario de Información Personal
                    </h2>

                    <!-- Step Indicator -->

                    <div class="step-indicator d-flex justify-content-center mb-4">
                        <div class="step active" id="personal-info">
                            <i class="bi bi-person-circle me-2"></i> Información Personal
                        </div>
                        <div class="step" id="additional-details">
                            <i class="bi bi-info-circle me-2"></i> Detalles Adicionales
                        </div>
                        <div class="step" id="more-info">
                            <i class="bi bi-list-check me-2"></i> Más Información
                        </div>
                    </div>
                    <form id="personalSave" action="personal-info/save" method="POST" id="multiStepForm" enctype="multipart/form-data">
                        <!-- Step 1: Personal Information -->
                        <div class="form-step active" id="step-1">
                            <div class="row g-3">
                                <!-- Tipo de Documento y Cédula -->
                                <div class="col-md-6">
                                    <label for="document_type" class="form-label">Tipo de Identificación</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <select id="document_type" name="document_type" class="form-select " value="<?= esc($user_document_type) ?>">
                                            <option value="Cédula de Ciudadanía">Cédula de Ciudadanía</option>
                                            <option value="Cédula de Extranjería">Cédula de Extranjería</option>
                                            <option value="Pasaporte">Pasaporte</option>
                                            <option value="Otro">Otro</option>

                                        </select>    
                                    </div>
                                    <small class="form-text text-muted">
                                        Tipo de Identificación
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label for="cedula" class="form-label">Número de Identificación</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" id="cedula" name="cedula" class="form-control " value="<?= esc($user_cedula) ?>" readonly>
                                    </div>
                                    <small class="form-text text-muted">
                                        Número de Identificación
                                    </small>
                                </div>

                                <!-- Fecha y Lugar de Expedición -->
                                <div class="col-md-6">
                                    <label for="date_of_issue" class="form-label">Fecha de Expedición</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control" id="date_of_issue" name="date_of_issue" >
                                    </div>
                                    <small class="form-text text-muted">
                                        Fecha de Expedición (Obligatorio)
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label for="place_of_issue" class="form-label">Lugar de Expedición</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" class="form-control" id="place_of_issue" name="place_of_issue"
                                               ">
                                    </div>
                                    <small class="form-text text-muted">
                                        Lugar de Expedición (Obligatorio)
                                    </small>
                                </div>

                                <!-- Género y Nacionalidad -->
                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Género</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                        <select class="form-select" id="gender" name="gender" >
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                            <option value="Otro">Otro</option>
                                            <option value="Prefiero no decirlo">Prefiero no decirlo</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-muted">
                                        Género (Obligatorio)
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label for="nationality" class="form-label">Nacionalidad</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        <select name="nationality" id="nationality" class="form-select">
                                            <option value="">Selecciona un país</option>
                                            <option value="Afghanistan" <?= (esc($personalInfo['nationality'] ?? '') == 'Afghanistan') ? 'selected' : '' ?>>Afganistán</option>
                                            <option value="Albania" <?= (esc($personalInfo['nationality'] ?? '') == 'Albania') ? 'selected' : '' ?>>Albania</option>
                                            <option value="Algeria" <?= (esc($personalInfo['nationality'] ?? '') == 'Algeria') ? 'selected' : '' ?>>Argelia</option>
                                            <option value="Andorra" <?= (esc($personalInfo['nationality'] ?? '') == 'Andorra') ? 'selected' : '' ?>>Andorra</option>
                                            <option value="Angola" <?= (esc($personalInfo['nationality'] ?? '') == 'Angola') ? 'selected' : '' ?>>Angola</option>
                                            <option value="Antigua and Barbuda" <?= (esc($personalInfo['nationality'] ?? '') == 'Antigua and Barbuda') ? 'selected' : '' ?>>Antigua y Barbuda</option>
                                            <option value="Argentina" <?= (esc($personalInfo['nationality'] ?? '') == 'Argentina') ? 'selected' : '' ?>>Argentina</option>
                                            <option value="Armenia" <?= (esc($personalInfo['nationality'] ?? '') == 'Armenia') ? 'selected' : '' ?>>Armenia</option>
                                            <option value="Australia" <?= (esc($personalInfo['nationality'] ?? '') == 'Australia') ? 'selected' : '' ?>>Australia</option>
                                            <option value="Austria" <?= (esc($personalInfo['nationality'] ?? '') == 'Austria') ? 'selected' : '' ?>>Austria</option>
                                            <option value="Azerbaijan" <?= (esc($personalInfo['nationality'] ?? '') == 'Azerbaijan') ? 'selected' : '' ?>>Azerbaiyán</option>
                                            <option value="Bahamas" <?= (esc($personalInfo['nationality'] ?? '') == 'Bahamas') ? 'selected' : '' ?>>Bahamas</option>
                                            <option value="Bahrain" <?= (esc($personalInfo['nationality'] ?? '') == 'Bahrain') ? 'selected' : '' ?>>Baréin</option>
                                            <option value="Bangladesh" <?= (esc($personalInfo['nationality'] ?? '') == 'Bangladesh') ? 'selected' : '' ?>>Bangladesh</option>
                                            <option value="Barbados" <?= (esc($personalInfo['nationality'] ?? '') == 'Barbados') ? 'selected' : '' ?>>Barbados</option>
                                            <option value="Belarus" <?= (esc($personalInfo['nationality'] ?? '') == 'Belarus') ? 'selected' : '' ?>>Bielorrusia</option>
                                            <option value="Belgium" <?= (esc($personalInfo['nationality'] ?? '') == 'Belgium') ? 'selected' : '' ?>>Bélgica</option>
                                            <option value="Belize" <?= (esc($personalInfo['nationality'] ?? '') == 'Belize') ? 'selected' : '' ?>>Belice</option>
                                            <option value="Benin" <?= (esc($personalInfo['nationality'] ?? '') == 'Benin') ? 'selected' : '' ?>>Benín</option>
                                            <option value="Bhutan" <?= (esc($personalInfo['nationality'] ?? '') == 'Bhutan') ? 'selected' : '' ?>>Bután</option>
                                            <option value="Bolivia" <?= (esc($personalInfo['nationality'] ?? '') == 'Bolivia') ? 'selected' : '' ?>>Bolivia</option>
                                            <option value="Bosnia and Herzegovina" <?= (esc($personalInfo['nationality'] ?? '') == 'Bosnia and Herzegovina') ? 'selected' : '' ?>>Bosnia y Herzegovina</option>
                                            <option value="Botswana" <?= (esc($personalInfo['nationality'] ?? '') == 'Botswana') ? 'selected' : '' ?>>Botsuana</option>
                                            <option value="Brazil" <?= (esc($personalInfo['nationality'] ?? '') == 'Brazil') ? 'selected' : '' ?>>Brasil</option>
                                            <option value="Brunei" <?= (esc($personalInfo['nationality'] ?? '') == 'Brunei') ? 'selected' : '' ?>>Brunéi</option>
                                            <option value="Bulgaria" <?= (esc($personalInfo['nationality'] ?? '') == 'Bulgaria') ? 'selected' : '' ?>>Bulgaria</option>
                                            <option value="Burkina Faso" <?= (esc($personalInfo['nationality'] ?? '') == 'Burkina Faso') ? 'selected' : '' ?>>Burkina Faso</option>
                                            <option value="Burundi" <?= (esc($personalInfo['nationality'] ?? '') == 'Burundi') ? 'selected' : '' ?>>Burundi</option>
                                            <option value="Cabo Verde" <?= (esc($personalInfo['nationality'] ?? '') == 'Cabo Verde') ? 'selected' : '' ?>>Cabo Verde</option>
                                            <option value="Cambodia" <?= (esc($personalInfo['nationality'] ?? '') == 'Cambodia') ? 'selected' : '' ?>>Camboya</option>
                                            <option value="Cameroon" <?= (esc($personalInfo['nationality'] ?? '') == 'Cameroon') ? 'selected' : '' ?>>Camerún</option>
                                            <option value="Canada" <?= (esc($personalInfo['nationality'] ?? '') == 'Canada') ? 'selected' : '' ?>>Canadá</option>
                                            <option value="Central African Republic" <?= (esc($personalInfo['nationality'] ?? '') == 'Central African Republic') ? 'selected' : '' ?>>República Centroafricana</option>
                                            <option value="Chad" <?= (esc($personalInfo['nationality'] ?? '') == 'Chad') ? 'selected' : '' ?>>Chad</option>
                                            <option value="Chile" <?= (esc($personalInfo['nationality'] ?? '') == 'Chile') ? 'selected' : '' ?>>Chile</option>
                                            <option value="China" <?= (esc($personalInfo['nationality'] ?? '') == 'China') ? 'selected' : '' ?>>China</option>
                                            <option value="Colombia" <?= (esc($personalInfo['nationality'] ?? '') == 'Colombia') ? 'selected' : '' ?>>Colombia</option>
                                            <option value="Comoros" <?= (esc($personalInfo['nationality'] ?? '') == 'Comoros') ? 'selected' : '' ?>>Comoras</option>
                                            <option value="Congo (Congo-Brazzaville)" <?= (esc($personalInfo['nationality'] ?? '') == 'Congo (Congo-Brazzaville)') ? 'selected' : '' ?>>Congo (República del Congo)</option>
                                            <option value="Congo (Democratic Republic of the Congo)" <?= (esc($personalInfo['nationality'] ?? '') == 'Congo (Democratic Republic of the Congo)') ? 'selected' : '' ?>>Congo (República Democrática del Congo)</option>
                                            <option value="Costa Rica" <?= (esc($personalInfo['nationality'] ?? '') == 'Costa Rica') ? 'selected' : '' ?>>Costa Rica</option>
                                            <option value="Croatia" <?= (esc($personalInfo['nationality'] ?? '') == 'Croatia') ? 'selected' : '' ?>>Croacia</option>
                                            <option value="Cuba" <?= (esc($personalInfo['nationality'] ?? '') == 'Cuba') ? 'selected' : '' ?>>Cuba</option>
                                            <option value="Cyprus" <?= (esc($personalInfo['nationality'] ?? '') == 'Cyprus') ? 'selected' : '' ?>>Chipre</option>
                                            <option value="Czechia (Czech Republic)" <?= (esc($personalInfo['nationality'] ?? '') == 'Czechia (Czech Republic)') ? 'selected' : '' ?>>Chequia (República Checa)</option>
                                            <option value="Denmark" <?= (esc($personalInfo['nationality'] ?? '') == 'Denmark') ? 'selected' : '' ?>>Dinamarca</option>
                                            <option value="Djibouti" <?= (esc($personalInfo['nationality'] ?? '') == 'Djibouti') ? 'selected' : '' ?>>Yibuti</option>
                                            <option value="Dominica" <?= (esc($personalInfo['nationality'] ?? '') == 'Dominica') ? 'selected' : '' ?>>Dominica</option>
                                            <option value="Dominican Republic" <?= (esc($personalInfo['nationality'] ?? '') == 'Dominican Republic') ? 'selected' : '' ?>>República Dominicana</option>
                                            <option value="Ecuador" <?= (esc($personalInfo['nationality'] ?? '') == 'Ecuador') ? 'selected' : '' ?>>Ecuador</option>
                                            <option value="Egypt" <?= (esc($personalInfo['nationality'] ?? '') == 'Egypt') ? 'selected' : '' ?>>Egipto</option>
                                            <option value="El Salvador" <?= (esc($personalInfo['nationality'] ?? '') == 'El Salvador') ? 'selected' : '' ?>>El Salvador</option>
                                            <option value="Equatorial Guinea" <?= (esc($personalInfo['nationality'] ?? '') == 'Equatorial Guinea') ? 'selected' : '' ?>>Guinea Ecuatorial</option>
                                            <option value="Eritrea" <?= (esc($personalInfo['nationality'] ?? '') == 'Eritrea') ? 'selected' : '' ?>>Eritrea</option>
                                            <option value="Estonia" <?= (esc($personalInfo['nationality'] ?? '') == 'Estonia') ? 'selected' : '' ?>>Estonia</option>
                                            <option value="Eswatini" <?= (esc($personalInfo['nationality'] ?? '') == 'Eswatini') ? 'selected' : '' ?>>Esuatini</option>
                                            <option value="Ethiopia" <?= (esc($personalInfo['nationality'] ?? '') == 'Ethiopia') ? 'selected' : '' ?>>Etiopía</option>
                                            <option value="Fiji" <?= (esc($personalInfo['nationality'] ?? '') == 'Fiji') ? 'selected' : '' ?>>Fiyi</option>
                                            <option value="Finland" <?= (esc($personalInfo['nationality'] ?? '') == 'Finland') ? 'selected' : '' ?>>Finlandia</option>
                                            <option value="France" <?= (esc($personalInfo['nationality'] ?? '') == 'France') ? 'selected' : '' ?>>Francia</option>
                                            <option value="Gabon" <?= (esc($personalInfo['nationality'] ?? '') == 'Gabon') ? 'selected' : '' ?>>Gabón</option>
                                            <option value="Gambia" <?= (esc($personalInfo['nationality'] ?? '') == 'Gambia') ? 'selected' : '' ?>>Gambia</option>
                                            <option value="Georgia" <?= (esc($personalInfo['nationality'] ?? '') == 'Georgia') ? 'selected' : '' ?>>Georgia</option>
                                            <option value="Germany" <?= (esc($personalInfo['nationality'] ?? '') == 'Germany') ? 'selected' : '' ?>>Alemania</option>
                                            <option value="Ghana" <?= (esc($personalInfo['nationality'] ?? '') == 'Ghana') ? 'selected' : '' ?>>Ghana</option>
                                            <option value="Greece" <?= (esc($personalInfo['nationality'] ?? '') == 'Greece') ? 'selected' : '' ?>>Grecia</option>
                                            <option value="Grenada" <?= (esc($personalInfo['nationality'] ?? '') == 'Grenada') ? 'selected' : '' ?>>Granada</option>
                                            <option value="Guatemala" <?= (esc($personalInfo['nationality'] ?? '') == 'Guatemala') ? 'selected' : '' ?>>Guatemala</option>
                                            <option value="Guinea" <?= (esc($personalInfo['nationality'] ?? '') == 'Guinea') ? 'selected' : '' ?>>Guinea</option>
                                            <option value="Guinea-Bissau" <?= (esc($personalInfo['nationality'] ?? '') == 'Guinea-Bissau') ? 'selected' : '' ?>>Guinea-Bisáu</option>
                                            <option value="Guyana" <?= (esc($personalInfo['nationality'] ?? '') == 'Guyana') ? 'selected' : '' ?>>Guyana</option>
                                            <option value="Haiti" <?= (esc($personalInfo['nationality'] ?? '') == 'Haiti') ? 'selected' : '' ?>>Haití</option>
                                            <option value="Honduras" <?= (esc($personalInfo['nationality'] ?? '') == 'Honduras') ? 'selected' : '' ?>>Honduras</option>
                                            <option value="Hungary" <?= (esc($personalInfo['nationality'] ?? '') == 'Hungary') ? 'selected' : '' ?>>Hungría</option>
                                        </select>

                                    </div>
                                    <small class="form-text text-muted">
                                        Nacionalidad (Obligatorio)
                                    </small>
                                </div>

                                <!-- Nombres -->
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">Primer Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="first_name" name="first_name">
                                    </div>
                                    <small class="form-text text-muted">
                                        Primer Nombre
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label for="middle_name" class="form-label">Segundo Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="middle_name" name="middle_name">
                                    </div>
                                    <small class="form-text text-muted">
                                        Segundo Nombre
                                    </small>
                                </div>

                                <!-- Apellidos -->
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Primer Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <input type="text" class="form-control" id="last_name" name="last_name">

                                    </div>
                                    <small class="form-text text-muted">
                                        Primer Apellido
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label for="second_last_name" class="form-label">Segundo Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <input type="text" class="form-control" id="second_last_name" name="second_last_name">

                                    </div>
                                    <small class="form-text text-muted">
                                        Segundo Apellido
                                    </small>
                                </div>
                                <div class="col-md-4">
                                    <label for="last_name" class="form-label">País de Residencia</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <select name="mailing_country" id="mailing_country" class="form-select">
                                            <option value="">Selecciona un país</option>
                                            <option value="Afganistán" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Afganistán') ? 'selected' : '' ?>>Afganistán</option>
                                            <option value="Albania" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Albania') ? 'selected' : '' ?>>Albania</option>
                                            <option value="Argelia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Argelia') ? 'selected' : '' ?>>Argelia</option>
                                            <option value="Andorra" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Andorra') ? 'selected' : '' ?>>Andorra</option>
                                            <option value="Angola" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Angola') ? 'selected' : '' ?>>Angola</option>
                                            <option value="Antigua y Barbuda" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Antigua y Barbuda') ? 'selected' : '' ?>>Antigua y Barbuda</option>
                                            <option value="Argentina" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Argentina') ? 'selected' : '' ?>>Argentina</option>
                                            <option value="Armenia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Armenia') ? 'selected' : '' ?>>Armenia</option>
                                            <option value="Australia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Australia') ? 'selected' : '' ?>>Australia</option>
                                            <option value="Austria" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Austria') ? 'selected' : '' ?>>Austria</option>
                                            <option value="Azerbaiyán" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Azerbaiyán') ? 'selected' : '' ?>>Azerbaiyán</option>
                                            <option value="Bahamas" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Bahamas') ? 'selected' : '' ?>>Bahamas</option>
                                            <option value="Baréin" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Baréin') ? 'selected' : '' ?>>Baréin</option>
                                            <option value="Bangladesh" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Bangladesh') ? 'selected' : '' ?>>Bangladesh</option>
                                            <option value="Barbados" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Barbados') ? 'selected' : '' ?>>Barbados</option>
                                            <option value="Bielorrusia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Bielorrusia') ? 'selected' : '' ?>>Bielorrusia</option>
                                            <option value="Bélgica" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Bélgica') ? 'selected' : '' ?>>Bélgica</option>
                                            <option value="Belice" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Belice') ? 'selected' : '' ?>>Belice</option>
                                            <option value="Benín" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Benín') ? 'selected' : '' ?>>Benín</option>
                                            <option value="Bután" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Bután') ? 'selected' : '' ?>>Bután</option>
                                            <option value="Bolivia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Bolivia') ? 'selected' : '' ?>>Bolivia</option>
                                            <option value="Bosnia y Herzegovina" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Bosnia y Herzegovina') ? 'selected' : '' ?>>Bosnia y Herzegovina</option>
                                            <option value="Botsuana" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Botsuana') ? 'selected' : '' ?>>Botsuana</option>
                                            <option value="Brasil" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Brasil') ? 'selected' : '' ?>>Brasil</option>
                                            <option value="Brunéi" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Brunéi') ? 'selected' : '' ?>>Brunéi</option>
                                            <option value="Bulgaria" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Bulgaria') ? 'selected' : '' ?>>Bulgaria</option>
                                            <option value="Burkina Faso" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Burkina Faso') ? 'selected' : '' ?>>Burkina Faso</option>
                                            <option value="Burundi" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Burundi') ? 'selected' : '' ?>>Burundi</option>
                                            <option value="Cabo Verde" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Cabo Verde') ? 'selected' : '' ?>>Cabo Verde</option>
                                            <option value="Camboya" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Camboya') ? 'selected' : '' ?>>Camboya</option>
                                            <option value="Camerún" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Camerún') ? 'selected' : '' ?>>Camerún</option>
                                            <option value="Canadá" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Canadá') ? 'selected' : '' ?>>Canadá</option>
                                            <option value="República Centroafricana" <?= (esc($personalInfo['mailing_country'] ?? '') == 'República Centroafricana') ? 'selected' : '' ?>>República Centroafricana</option>
                                            <option value="Chad" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Chad') ? 'selected' : '' ?>>Chad</option>
                                            <option value="Chile" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Chile') ? 'selected' : '' ?>>Chile</option>
                                            <option value="China" <?= (esc($personalInfo['mailing_country'] ?? '') == 'China') ? 'selected' : '' ?>>China</option>
                                            <option value="Colombia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Colombia') ? 'selected' : '' ?>>Colombia</option>
                                            <option value="Comoras" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Comoras') ? 'selected' : '' ?>>Comoras</option>
                                            <option value="Congo" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Congo') ? 'selected' : '' ?>>Congo</option>
                                            <option value="República Democrática del Congo" <?= (esc($personalInfo['mailing_country'] ?? '') == 'República Democrática del Congo') ? 'selected' : '' ?>>República Democrática del Congo</option>
                                            <option value="Costa Rica" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Costa Rica') ? 'selected' : '' ?>>Costa Rica</option>
                                            <option value="Croacia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Croacia') ? 'selected' : '' ?>>Croacia</option>
                                            <option value="Cuba" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Cuba') ? 'selected' : '' ?>>Cuba</option>
                                            <option value="Chipre" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Chipre') ? 'selected' : '' ?>>Chipre</option>
                                            <option value="República Checa" <?= (esc($personalInfo['mailing_country'] ?? '') == 'República Checa') ? 'selected' : '' ?>>República Checa</option>
                                            <option value="Dinamarca" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Dinamarca') ? 'selected' : '' ?>>Dinamarca</option>
                                            <option value="Yibuti" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Yibuti') ? 'selected' : '' ?>>Yibuti</option>
                                            <option value="Dominica" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Dominica') ? 'selected' : '' ?>>Dominica</option>
                                            <option value="República Dominicana" <?= (esc($personalInfo['mailing_country'] ?? '') == 'República Dominicana') ? 'selected' : '' ?>>República Dominicana</option>
                                            <option value="Ecuador" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Ecuador') ? 'selected' : '' ?>>Ecuador</option>
                                            <option value="Egipto" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Egipto') ? 'selected' : '' ?>>Egipto</option>
                                            <option value="España" <?= (esc($personalInfo['mailing_country'] ?? '') == 'España') ? 'selected' : '' ?>>España</option>
                                            <option value="El Salvador" <?= (esc($personalInfo['mailing_country'] ?? '') == 'El Salvador') ? 'selected' : '' ?>>El Salvador</option>
                                            <option value="Guinea Ecuatorial" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Guinea Ecuatorial') ? 'selected' : '' ?>>Guinea Ecuatorial</option>
                                            <option value="Eritrea" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Eritrea') ? 'selected' : '' ?>>Eritrea</option>
                                            <option value="Estonia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Estonia') ? 'selected' : '' ?>>Estonia</option>
                                            <option value="Esuatini" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Esuatini') ? 'selected' : '' ?>>Esuatini</option>
                                            <option value="Etiopía" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Etiopía') ? 'selected' : '' ?>>Etiopía</option>
                                            <option value="Fiyi" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Fiyi') ? 'selected' : '' ?>>Fiyi</option>
                                            <option value="Finlandia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Finlandia') ? 'selected' : '' ?>>Finlandia</option>
                                            <option value="Francia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Francia') ? 'selected' : '' ?>>Francia</option>
                                            <option value="Gabón" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Gabón') ? 'selected' : '' ?>>Gabón</option>
                                            <option value="Gambia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Gambia') ? 'selected' : '' ?>>Gambia</option>
                                            <option value="Georgia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Georgia') ? 'selected' : '' ?>>Georgia</option>
                                            <option value="Alemania" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Alemania') ? 'selected' : '' ?>>Alemania</option>
                                            <option value="Ghana" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Ghana') ? 'selected' : '' ?>>Ghana</option>
                                            <option value="Grecia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Grecia') ? 'selected' : '' ?>>Grecia</option>
                                            <option value="Granada" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Granada') ? 'selected' : '' ?>>Granada</option>
                                            <option value="Guatemala" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Guatemala') ? 'selected' : '' ?>>Guatemala</option>
                                            <option value="Guinea" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Guinea') ? 'selected' : '' ?>>Guinea</option>
                                            <option value="Guinea-Bisáu" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Guinea-Bisáu') ? 'selected' : '' ?>>Guinea-Bisáu</option>
                                            <option value="Guyana" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Guyana') ? 'selected' : '' ?>>Guyana</option>
                                            <option value="Haití" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Haití') ? 'selected' : '' ?>>Haití</option>
                                            <option value="Honduras" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Honduras') ? 'selected' : '' ?>>Honduras</option>
                                            <option value="Hungría" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Hungría') ? 'selected' : '' ?>>Hungría</option>
                                            <option value="Islandia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Islandia') ? 'selected' : '' ?>>Islandia</option>
                                            <option value="India" <?= (esc($personalInfo['mailing_country'] ?? '') == 'India') ? 'selected' : '' ?>>India</option>
                                            <option value="Indonesia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Indonesia') ? 'selected' : '' ?>>Indonesia</option>
                                            <option value="Irán" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Irán') ? 'selected' : '' ?>>Irán</option>
                                            <option value="Irak" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Irak') ? 'selected' : '' ?>>Irak</option>
                                            <option value="Irlanda" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Irlanda') ? 'selected' : '' ?>>Irlanda</option>
                                            <option value="Israel" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Israel') ? 'selected' : '' ?>>Israel</option>
                                            <option value="Italia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Italia') ? 'selected' : '' ?>>Italia</option>
                                            <option value="Jamaica" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Jamaica') ? 'selected' : '' ?>>Jamaica</option>
                                            <option value="Japón" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Japón') ? 'selected' : '' ?>>Japón</option>
                                            <option value="Jordania" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Jordania') ? 'selected' : '' ?>>Jordania</option>
                                            <option value="Kazajistán" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Kazajistán') ? 'selected' : '' ?>>Kazajistán</option>
                                            <option value="Kenia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Kenia') ? 'selected' : '' ?>>Kenia</option>
                                            <option value="Kiribati" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Kiribati') ? 'selected' : '' ?>>Kiribati</option>
                                            <option value="Kuwait" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Kuwait') ? 'selected' : '' ?>>Kuwait</option>
                                            <option value="Kirguistán" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Kirguistán') ? 'selected' : '' ?>>Kirguistán</option>
                                            <option value="Laos" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Laos') ? 'selected' : '' ?>>Laos</option>
                                            <option value="Letonia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Letonia') ? 'selected' : '' ?>>Letonia</option>
                                            <option value="Líbano" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Líbano') ? 'selected' : '' ?>>Líbano</option>
                                            <option value="Lesoto" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Lesoto') ? 'selected' : '' ?>>Lesoto</option>
                                            <option value="Liberia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Liberia') ? 'selected' : '' ?>>Liberia</option>
                                            <option value="Libia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Libia') ? 'selected' : '' ?>>Libia</option>
                                            <option value="Liechtenstein" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Liechtenstein') ? 'selected' : '' ?>>Liechtenstein</option>
                                            <option value="Lituania" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Lituania') ? 'selected' : '' ?>>Lituania</option>
                                            <option value="Luxemburgo" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Luxemburgo') ? 'selected' : '' ?>>Luxemburgo</option>
                                            <option value="Madagascar" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Madagascar') ? 'selected' : '' ?>>Madagascar</option>
                                            <option value="Malaui" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Malaui') ? 'selected' : '' ?>>Malaui</option>
                                            <option value="Malasia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Malasia') ? 'selected' : '' ?>>Malasia</option>
                                            <option value="Maldivas" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Maldivas') ? 'selected' : '' ?>>Maldivas</option>
                                            <option value="Malí" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Malí') ? 'selected' : '' ?>>Malí</option>
                                            <option value="Malta" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Malta') ? 'selected' : '' ?>>Malta</option>
                                            <option value="Islas Marshall" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Islas Marshall') ? 'selected' : '' ?>>Islas Marshall</option>
                                            <option value="Mauritania" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Mauritania') ? 'selected' : '' ?>>Mauritania</option>
                                            <option value="Mauricio" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Mauricio') ? 'selected' : '' ?>>Mauricio</option>
                                            <option value="México" <?= (esc($personalInfo['mailing_country'] ?? '') == 'México') ? 'selected' : '' ?>>México</option>
                                            <option value="Micronesia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Micronesia') ? 'selected' : '' ?>>Micronesia</option>
                                            <option value="Moldavia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Moldavia') ? 'selected' : '' ?>>Moldavia</option>
                                            <option value="Mónaco" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Mónaco') ? 'selected' : '' ?>>Mónaco</option>
                                            <option value="Mongolia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Mongolia') ? 'selected' : '' ?>>Mongolia</option>
                                            <option value="Montenegro" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Montenegro') ? 'selected' : '' ?>>Montenegro</option>
                                            <option value="Marruecos" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Marruecos') ? 'selected' : '' ?>>Marruecos</option>
                                            <option value="Mozambique" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Mozambique') ? 'selected' : '' ?>>Mozambique</option>
                                            <option value="Birmania" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Birmania') ? 'selected' : '' ?>>Birmania</option>
                                            <option value="Namibia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Namibia') ? 'selected' : '' ?>>Namibia</option>
                                            <option value="Nauru" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Nauru') ? 'selected' : '' ?>>Nauru</option>
                                            <option value="Nepal" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Nepal') ? 'selected' : '' ?>>Nepal</option>
                                            <option value="Países Bajos" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Países Bajos') ? 'selected' : '' ?>>Países Bajos</option>
                                            <option value="Nueva Zelanda" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Nueva Zelanda') ? 'selected' : '' ?>>Nueva Zelanda</option>
                                            <option value="Nicaragua" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Nicaragua') ? 'selected' : '' ?>>Nicaragua</option>
                                            <option value="Níger" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Níger') ? 'selected' : '' ?>>Níger</option>
                                            <option value="Nigeria" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Nigeria') ? 'selected' : '' ?>>Nigeria</option>
                                            <option value="Corea del Norte" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Corea del Norte') ? 'selected' : '' ?>>Corea del Norte</option>
                                            <option value="Macedonia del Norte" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Macedonia del Norte') ? 'selected' : '' ?>>Macedonia del Norte</option>
                                            <option value="Noruega" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Noruega') ? 'selected' : '' ?>>Noruega</option>
                                            <option value="Omán" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Omán') ? 'selected' : '' ?>>Omán</option>
                                            <option value="Pakistán" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Pakistán') ? 'selected' : '' ?>>Pakistán</option>
                                            <option value="Palaos" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Palaos') ? 'selected' : '' ?>>Palaos</option>
                                            <option value="Palestina" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Palestina') ? 'selected' : '' ?>>Palestina</option>
                                            <option value="Panamá" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Panamá') ? 'selected' : '' ?>>Panamá</option>
                                            <option value="Papúa Nueva Guinea" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Papúa Nueva Guinea') ? 'selected' : '' ?>>Papúa Nueva Guinea</option>
                                            <option value="Paraguay" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Paraguay') ? 'selected' : '' ?>>Paraguay</option>
                                            <option value="Perú" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Perú') ? 'selected' : '' ?>>Perú</option>
                                            <option value="Filipinas" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Filipinas') ? 'selected' : '' ?>>Filipinas</option>
                                            <option value="Polonia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Polonia') ? 'selected' : '' ?>>Polonia</option>
                                            <option value="Portugal" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Portugal') ? 'selected' : '' ?>>Portugal</option>
                                            <option value="Catar" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Catar') ? 'selected' : '' ?>>Catar</option>
                                            <option value="Rumanía" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Rumanía') ? 'selected' : '' ?>>Rumanía</option>
                                            <option value="Rusia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Rusia') ? 'selected' : '' ?>>Rusia</option>
                                            <option value="Ruanda" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Ruanda') ? 'selected' : '' ?>>Ruanda</option>
                                            <option value="San Cristóbal y Nieves" <?= (esc($personalInfo['mailing_country'] ?? '') == 'San Cristóbal y Nieves') ? 'selected' : '' ?>>San Cristóbal y Nieves</option>
                                            <option value="Santa Lucía" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Santa Lucía') ? 'selected' : '' ?>>Santa Lucía</option>
                                            <option value="San Vicente y las Granadinas" <?= (esc($personalInfo['mailing_country'] ?? '') == 'San Vicente y las Granadinas') ? 'selected' : '' ?>>San Vicente y las Granadinas</option>
                                            <option value="Samoa" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Samoa') ? 'selected' : '' ?>>Samoa</option>
                                            <option value="San Marino" <?= (esc($personalInfo['mailing_country'] ?? '') == 'San Marino') ? 'selected' : '' ?>>San Marino</option>
                                            <option value="Santo Tomé y Príncipe" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Santo Tomé y Príncipe') ? 'selected' : '' ?>>Santo Tomé y Príncipe</option>
                                            <option value="Arabia Saudita" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Arabia Saudita') ? 'selected' : '' ?>>Arabia Saudita</option>
                                            <option value="Senegal" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Senegal') ? 'selected' : '' ?>>Senegal</option>
                                            <option value="Serbia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Serbia') ? 'selected' : '' ?>>Serbia</option>
                                            <option value="Seychelles" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Seychelles') ? 'selected' : '' ?>>Seychelles</option>
                                            <option value="Sierra Leona" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Sierra Leona') ? 'selected' : '' ?>>Sierra Leona</option>
                                            <option value="Singapur" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Singapur') ? 'selected' : '' ?>>Singapur</option>
                                            <option value="Eslovaquia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Eslovaquia') ? 'selected' : '' ?>>Eslovaquia</option>
                                            <option value="Eslovenia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Eslovenia') ? 'selected' : '' ?>>Eslovenia</option>
                                            <option value="Islas Salomón" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Islas Salomón') ? 'selected' : '' ?>>Islas Salomón</option>
                                            <option value="Somalia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Somalia') ? 'selected' : '' ?>>Somalia</option>
                                            <option value="Sudáfrica" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Sudáfrica') ? 'selected' : '' ?>>Sudáfrica</option>
                                            <option value="Corea del Sur" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Corea del Sur') ? 'selected' : '' ?>>Corea del Sur</option>
                                            <option value="Sudán del Sur" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Sudán del Sur') ? 'selected' : '' ?>>Sudán del Sur</option>
                                            <option value="Sri Lanka" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Sri Lanka') ? 'selected' : '' ?>>Sri Lanka</option>
                                            <option value="Sudán" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Sudán') ? 'selected' : '' ?>>Sudán</option>
                                            <option value="Surinam" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Surinam') ? 'selected' : '' ?>>Surinam</option>
                                            <option value="Suecia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Suecia') ? 'selected' : '' ?>>Suecia</option>
                                            <option value="Suiza" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Suiza') ? 'selected' : '' ?>>Suiza</option>
                                            <option value="Siria" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Siria') ? 'selected' : '' ?>>Siria</option>
                                            <option value="Taiwán" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Taiwán') ? 'selected' : '' ?>>Taiwán</option>
                                            <option value="Tayikistán" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Tayikistán') ? 'selected' : '' ?>>Tayikistán</option>
                                            <option value="Tanzania" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Tanzania') ? 'selected' : '' ?>>Tanzania</option>
                                            <option value="Tailandia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Tailandia') ? 'selected' : '' ?>>Tailandia</option>
                                            <option value="Timor Oriental" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Timor Oriental') ? 'selected' : '' ?>>Timor Oriental</option>
                                            <option value="Togo" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Togo') ? 'selected' : '' ?>>Togo</option>
                                            <option value="Tonga" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Tonga') ? 'selected' : '' ?>>Tonga</option>
                                            <option value="Trinidad y Tobago" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Trinidad y Tobago') ? 'selected' : '' ?>>Trinidad y Tobago</option>
                                            <option value="Túnez" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Túnez') ? 'selected' : '' ?>>Túnez</option>
                                            <option value="Turquía" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Turquía') ? 'selected' : '' ?>>Turquía</option>
                                            <option value="Turkmenistán" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Turkmenistán') ? 'selected' : '' ?>>Turkmenistán</option>
                                            <option value="Tuvalu" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Tuvalu') ? 'selected' : '' ?>>Tuvalu</option>
                                            <option value="Uganda" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Uganda') ? 'selected' : '' ?>>Uganda</option>
                                            <option value="Ucrania" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Ucrania') ? 'selected' : '' ?>>Ucrania</option>
                                            <option value="Emiratos Árabes Unidos" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Emiratos Árabes Unidos') ? 'selected' : '' ?>>Emiratos Árabes Unidos</option>
                                            <option value="Reino Unido" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Reino Unido') ? 'selected' : '' ?>>Reino Unido</option>
                                            <option value="Estados Unidos" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Estados Unidos') ? 'selected' : '' ?>>Estados Unidos</option>
                                            <option value="Uruguay" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Uruguay') ? 'selected' : '' ?>>Uruguay</option>
                                            <option value="Uzbekistán" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Uzbekistán') ? 'selected' : '' ?>>Uzbekistán</option>
                                            <option value="Vanuatu" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Vanuatu') ? 'selected' : '' ?>>Vanuatu</option>
                                            <option value="Ciudad del Vaticano" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Ciudad del Vaticano') ? 'selected' : '' ?>>Ciudad del Vaticano</option>
                                            <option value="Venezuela" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Venezuela') ? 'selected' : '' ?>>Venezuela</option>
                                            <option value="Vietnam" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Vietnam') ? 'selected' : '' ?>>Vietnam</option>
                                            <option value="Yemen" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Yemen') ? 'selected' : '' ?>>Yemen</option>
                                            <option value="Zambia" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Zambia') ? 'selected' : '' ?>>Zambia</option>
                                            <option value="Zimbabue" <?= (esc($personalInfo['mailing_country'] ?? '') == 'Zimbabue') ? 'selected' : '' ?>>Zimbabue</option>
                                        </select>



                                    </div>
                                    <small class="form-text text-muted">
                                        País de Residencia
                                    </small>
                                </div>
                                <div class="col-md-4">
                                    <label for="mailing_state" class="form-label">Departamento de Residencia</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <select name="mailing_state" id="mailing_state" class="form-select" style="display:none;">
                                            <option value="">Selecciona un departamento</option>
                                            <option value="Antioquia">Antioquia</option>
                                            <option value="Cundinamarca">Cundinamarca</option>
                                            <option value="Valle del Cauca">Valle del Cauca</option>
                                            <option value="Atlántico">Atlántico</option>
                                            <option value="Bolívar">Bolívar</option>
                                            <option value="Boyacá">Boyacá</option>
                                            <option value="Caldas">Caldas</option>
                                            <option value="Caquetá">Caquetá</option>
                                            <option value="Casanare">Casanare</option>
                                            <option value="Cauca">Cauca</option>
                                            <option value="Huila">Huila</option>
                                            <option value="La Guajira">La Guajira</option>
                                            <option value="Magdalena">Magdalena</option>
                                            <option value="Meta">Meta</option>
                                            <option value="Nariño">Nariño</option>
                                            <option value="Norte de Santander">Norte de Santander</option>
                                            <option value="Putumayo">Putumayo</option>
                                            <option value="Quindío">Quindío</option>
                                            <option value="Risaralda">Risaralda</option>
                                            <option value="San Andrés y Providencia">San Andrés y Providencia</option>
                                            <option value="Santander">Santander</option>
                                            <option value="Sucre">Sucre</option>
                                            <option value="Tolima">Tolima</option>
                                            <option value="Cesar">Cesar</option>
                                            <option value="Chocó">Chocó</option>
                                            <option value="Córdoba">Córdoba</option>
                                            <option value="La Guajira">La Guajira</option>
                                            <option value="Magdalena">Magdalena</option>
                                            <option value="Putumayo">Putumayo</option>
                                            <option value="Guaviare">Guaviare</option>
                                            <option value="Guainía">Guainía</option>
                                            <option value="Vaupés">Vaupés</option>
                                            <option value="Amazonas">Amazonas</option>
                                            
                                        </select>
                                        <input type="text" name="mailing_state_input" id="mailing_state_input" class="form-control">
                                    </div>
                                    <small class="form-text text-muted">
                                        Departamento de Residencia
                                    </small>
                                </div>
                                <div class="col-md-4">
                                    <label for="mailing_city" class="form-label">Municipio de Residencia</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <select name="mailing_city" id="mailing_city" class="form-select">
                                            <option value="">Selecciona un municipio</option>
                                        </select>
                                        <input type="text" name="mailing_city_input" id="mailing_city_input" class="form-control" style="display:none;">
                                    </div>
                                    <small class="form-text text-muted">
                                        Municipio de Residencia
                                    </small>
                                </div>
                            </div>
                            <!-- Archivo Académico -->

                            <div class="col-12">
                                <label for="file_path" class="form-label">Subir Documento de Identidad</label>
                                <div class="input-group">
                                    <input type="file" id="cedula_file" name="cedula_file" 
                                           class="form-control" accept=".pdf,.doc,.docx,.png,.jpg">
                                    <span class="input-group-text"><i class="bi bi-upload"></i></span>
                                </div>
                                <small class="form-text text-muted">
                                    Formatos permitidos: PDF, DOC, DOCX, PNG, JPG (máximo 5MB)
                                </small>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary next-step">
                                    Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Additional Personal Details -->
                        <div class="form-step" id="step-2">
                            <div class="row g-3">
                                <!-- País y Departamento de nacimiento -->
                                <div class="col-md-6">
                                    <label for="birth_country" class="form-label">País de Nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                        <select name="birth_country" id="birth_country" class="form-select">
                                            <option value="">Selecciona un país</option>
                                            <option value="Afghanistan">Afganistán</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Algeria">Argelia</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Antigua and Barbuda">Antigua y Barbuda</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Armenia">Armenia</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Azerbaijan">Azerbaiyán</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bahrain">Baréin</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belarus">Bielorrusia</option>
                                            <option value="Belgium">Bélgica</option>
                                            <option value="Belize">Belice</option>
                                            <option value="Benin">Benín</option>
                                            <option value="Bhutan">Bután</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Bosnia and Herzegovina">Bosnia y Herzegovina</option>
                                            <option value="Botswana">Botsuana</option>
                                            <option value="Brazil">Brasil</option>
                                            <option value="Brunei">Brunéi</option>
                                            <option value="Bulgaria">Bulgaria</option>
                                            <option value="Burkina Faso">Burkina Faso</option>
                                            <option value="Burundi">Burundi</option>
                                            <option value="Cabo Verde">Cabo Verde</option>
                                            <option value="Cambodia">Camboya</option>
                                            <option value="Cameroon">Camerún</option>
                                            <option value="Canada">Canadá</option>
                                            <option value="Central African Republic">República Centroafricana</option>
                                            <option value="Chad">Chad</option>
                                            <option value="Chile">Chile</option>
                                            <option value="China">China</option>
                                            <option value="Colombia">Colombia</option>
                                            <option value="Comoros">Comoras</option>
                                            <option value="Congo">Congo</option>
                                            <option value="Congo, Democratic Republic of the">República Democrática del Congo</option>
                                            <option value="Costa Rica">Costa Rica</option>
                                            <option value="Croatia">Croacia</option>
                                            <option value="Cuba">Cuba</option>
                                            <option value="Cyprus">Chipre</option>
                                            <option value="Czech Republic">República Checa</option>
                                            <option value="Denmark">Dinamarca</option>
                                            <option value="Djibouti">Yibuti</option>
                                            <option value="Dominica">Dominica</option>
                                            <option value="Dominican Republic">República Dominicana</option>
                                            <option value="Ecuador">Ecuador</option>
                                            <option value="Egypt">Egipto</option>
                                            <option value="El Salvador">El Salvador</option>
                                            <option value="Equatorial Guinea">Guinea Ecuatorial</option>
                                            <option value="Eritrea">Eritrea</option>
                                            <option value="Estonia">Estonia</option>
                                            <option value="Eswatini">Esuatini</option>
                                            <option value="Ethiopia">Etiopía</option>
                                            <option value="Fiji">Fiyi</option>
                                            <option value="Finland">Finlandia</option>
                                            <option value="France">Francia</option>
                                            <option value="Gabon">Gabón</option>
                                            <option value="Gambia">Gambia</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Germany">Alemania</option>
                                            <option value="Ghana">Ghana</option>
                                            <option value="Greece">Grecia</option>
                                            <option value="Grenada">Granada</option>
                                            <option value="Guatemala">Guatemala</option>
                                            <option value="Guinea">Guinea</option>
                                            <option value="Guinea-Bissau">Guinea-Bisáu</option>
                                            <option value="Guyana">Guyana</option>
                                            <option value="Haiti">Haití</option>
                                            <option value="Honduras">Honduras</option>
                                            <option value="Hungary">Hungría</option>
                                            <option value="Iceland">Islandia</option>
                                            <option value="India">India</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="Iran">Irán</option>
                                            <option value="Iraq">Irak</option>
                                            <option value="Ireland">Irlanda</option>
                                            <option value="Israel">Israel</option>
                                            <option value="Italy">Italia</option>
                                            <option value="Jamaica">Jamaica</option>
                                            <option value="Japan">Japón</option>
                                            <option value="Jordan">Jordania</option>
                                            <option value="Kazakhstan">Kazajistán</option>
                                            <option value="Kenya">Kenia</option>
                                            <option value="Kiribati">Kiribati</option>
                                            <option value="Kuwait">Kuwait</option>
                                            <option value="Kyrgyzstan">Kirguistán</option>
                                            <option value="Laos">Laos</option>
                                            <option value="Latvia">Letonia</option>
                                            <option value="Lebanon">Líbano</option>
                                            <option value="Lesotho">Lesoto</option>
                                            <option value="Liberia">Liberia</option>
                                            <option value="Libya">Libia</option>
                                            <option value="Liechtenstein">Liechtenstein</option>
                                            <option value="Lithuania">Lituania</option>
                                            <option value="Luxembourg">Luxemburgo</option>
                                            <option value="Madagascar">Madagascar</option>
                                            <option value="Malawi">Malaui</option>
                                            <option value="Malaysia">Malasia</option>
                                            <option value="Maldives">Maldivas</option>
                                            <option value="Mali">Malí</option>
                                            <option value="Malta">Malta</option>
                                            <option value="Marshall Islands">Islas Marshall</option>
                                            <option value="Mauritania">Mauritania</option>
                                            <option value="Mauritius">Mauricio</option>
                                            <option value="Mexico">México</option>
                                            <option value="Micronesia">Micronesia</option>
                                            <option value="Moldova">Moldavia</option>
                                            <option value="Monaco">Mónaco</option>
                                            <option value="Mongolia">Mongolia</option>
                                            <option value="Montenegro">Montenegro</option>
                                            <option value="Morocco">Marruecos</option>
                                            <option value="Mozambique">Mozambique</option>
                                            <option value="Myanmar">Birmania</option>
                                            <option value="Namibia">Namibia</option>
                                            <option value="Nauru">Nauru</option>
                                            <option value="Nepal">Nepal</option>
                                            <option value="Netherlands">Países Bajos</option>
                                            <option value="New Zealand">Nueva Zelanda</option>
                                            <option value="Nicaragua">Nicaragua</option>
                                            <option value="Niger">Níger</option>
                                            <option value="Nigeria">Nigeria</option>
                                            <option value="North Korea">Corea del Norte</option>
                                            <option value="North Macedonia">Macedonia del Norte</option>
                                            <option value="Norway">Noruega</option>
                                            <option value="Oman">Omán</option>
                                            <option value="Pakistan">Pakistán</option>
                                            <option value="Palau">Palaos</option>
                                            <option value="Palestine">Palestina</option>
                                            <option value="Panama">Panamá</option>
                                            <option value="Papua New Guinea">Papúa Nueva Guinea</option>
                                            <option value="Paraguay">Paraguay</option>
                                            <option value="Peru">Perú</option>
                                            <option value="Philippines">Filipinas</option>
                                            <option value="Poland">Polonia</option>
                                            <option value="Portugal">Portugal</option>
                                            <option value="Qatar">Catar</option>
                                            <option value="Romania">Rumanía</option>
                                            <option value="Russia">Rusia</option>
                                            <option value="Rwanda">Ruanda</option>
                                            <option value="Saint Kitts and Nevis">San Cristóbal y Nieves</option>
                                            <option value="Saint Lucia">Santa Lucía</option>
                                            <option value="Saint Vincent and the Grenadines">San Vicente y las Granadinas</option>
                                            <option value="Samoa">Samoa</option>
                                            <option value="San Marino">San Marino</option>
                                            <option value="Sao Tome and Principe">Santo Tomé y Príncipe</option>
                                            <option value="Saudi Arabia">Arabia Saudita</option>
                                            <option value="Senegal">Senegal</option>
                                            <option value="Serbia">Serbia</option>
                                            <option value="Seychelles">Seychelles</option>
                                            <option value="Sierra Leone">Sierra Leona</option>
                                            <option value="Singapore">Singapur</option>
                                            <option value="Slovakia">Eslovaquia</option>
                                            <option value="Slovenia">Eslovenia</option>
                                            <option value="Solomon Islands">Islas Salomón</option>
                                            <option value="Somalia">Somalia</option>
                                            <option value="South Africa">Sudáfrica</option>
                                            <option value="South Korea">Corea del Sur</option>
                                            <option value="South Sudan">Sudán del Sur</option>
                                            <option value="Spain">España</option>
                                            <option value="Sri Lanka">Sri Lanka</option>
                                            <option value="Sudan">Sudán</option>
                                            <option value="Suriname">Surinam</option>
                                            <option value="Sweden">Suecia</option>
                                            <option value="Switzerland">Suiza</option>
                                            <option value="Syria">Siria</option>
                                            <option value="Taiwan">Taiwán</option>
                                            <option value="Tajikistan">Tayikistán</option>
                                            <option value="Tanzania">Tanzania</option>
                                            <option value="Thailand">Tailandia</option>
                                            <option value="Timor-Leste">Timor Oriental</option>
                                            <option value="Togo">Togo</option>
                                            <option value="Tonga">Tonga</option>
                                            <option value="Trinidad and Tobago">Trinidad y Tobago</option>
                                            <option value="Tunisia">Túnez</option>
                                            <option value="Turkey">Turquía</option>
                                            <option value="Turkmenistan">Turkmenistán</option>
                                            <option value="Tuvalu">Tuvalu</option>
                                            <option value="Uganda">Uganda</option>
                                            <option value="Ukraine">Ucrania</option>
                                            <option value="United Arab Emirates">Emiratos Árabes Unidos</option>
                                            <option value="United Kingdom">Reino Unido</option>
                                            <option value="United States">Estados Unidos</option>
                                            <option value="Uruguay">Uruguay</option>
                                            <option value="Uzbekistan">Uzbekistán</option>
                                            <option value="Vanuatu">Vanuatu</option>
                                            <option value="Vatican City">Ciudad del Vaticano</option>
                                            <option value="Venezuela">Venezuela</option>
                                            <option value="Vietnam">Vietnam</option>
                                            <option value="Yemen">Yemen</option>
                                            <option value="Zambia">Zambia</option>
                                            <option value="Zimbabwe">Zimbabue</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-muted">
                                        País de Nacimiento
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label for="birth_department" class="form-label">Departamento de Nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map"></i></span>
                                        <select class="form-control" id="birth_department" name="birth_department">
                                            <option value="">Selecciona un departamento</option>
                                            <option value="Antioquia">Antioquia</option>
                                            <option value="Cundinamarca">Cundinamarca</option>
                                            <option value="Valle del Cauca">Valle del Cauca</option>
                                            <option value="Atlántico">Atlántico</option>
                                            <option value="Bolívar">Bolívar</option>
                                            <option value="Boyacá">Boyacá</option>
                                            <option value="Caldas">Caldas</option>
                                            <option value="Caquetá">Caquetá</option>
                                            <option value="Casanare">Casanare</option>
                                            <option value="Cauca">Cauca</option>
                                            <option value="Huila">Huila</option>
                                            <option value="La Guajira">La Guajira</option>
                                            <option value="Magdalena">Magdalena</option>
                                            <option value="Meta">Meta</option>
                                            <option value="Nariño">Nariño</option>
                                            <option value="Norte de Santander">Norte de Santander</option>
                                            <option value="Putumayo">Putumayo</option>
                                            <option value="Quindío">Quindío</option>
                                            <option value="Risaralda">Risaralda</option>
                                            <option value="San Andrés y Providencia">San Andrés y Providencia</option>
                                            <option value="Santander">Santander</option>
                                            <option value="Sucre">Sucre</option>
                                            <option value="Tolima">Tolima</option>
                                            <option value="Cesar">Cesar</option>
                                            <option value="Chocó">Chocó</option>
                                            <option value="Córdoba">Córdoba</option>
                                            <option value="Guaviare">Guaviare</option>
                                            <option value="Guainía">Guainía</option>
                                            <option value="Vaupés">Vaupés</option>
                                            <option value="Amazonas">Amazonas</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-muted">
                                        Departamento de Nacimiento
                                    </small>
                                </div>

                                <!-- Ciudad y Fecha de nacimiento -->
                                <div class="col-md-6">
                                    <label for="birth_city" class="form-label">Ciudad de Nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                                        <select class="form-control" id="birth_city" name="birth_city">
                                            <option value="">Seleccione una ciudad</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-muted">
                                        Ciudad de Nacimiento
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="birth_date" class="form-label">Fecha de Nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                        <input type="date" class="form-control" id="birth_date" name="birth_date" >
                                    </div>
                                    <small class="form-text text-muted">
                                        Fecha de Nacimiento
                                    </small>
                                </div>

                                <!-- Edad y Dirección -->
                                <div class="col-md-6">
                                    <label for="age" class="form-label">Edad</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                                        <input type="number" class="form-control" id="age" name="age" readonly">


                                    </div>
                                    <small class="form-text text-muted">
                                        Edad
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label for="address" class="form-label">Dirección</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                                        <input type="text" class="form-control" id="address" name="address">

                                    </div>
                                    <small class="form-text text-muted">
                                        Dirección
                                    </small>
                                </div>

                                <!-- Contacto -->
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="text" id="phone" name="phone" class="form-control " value="<?= esc($user_phone) ?>" >
                                    </div>
                                    <small class="form-text text-muted">
                                        Teléfono
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label for="mobile" class="form-label">Móvil</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                        <input type="text" id="mobile" name="mobile" class="form-control " value="<?= esc($user_phone) ?>" >
                                    </div>
                                    <small class="form-text text-muted">
                                        Móvil
                                    </small>
                                </div>

                                <!-- Correo Electrónico -->
                                <div class="col-12">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" id="email" name="email" class="form-control " value="<?= esc($user_email) ?>" readonly>
                                    </div>
                                    <small class="form-text text-muted">
                                        Correo Electrónico
                                    </small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary prev-step">
                                    <i class="fas fa-arrow-left me-2"></i>Anterior
                                </button>
                                <button type="button" class="btn btn-primary next-step">
                                    Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Military and Marital Information -->

                        <div class="form-step" id="step-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="military_card_type" class="form-label">Tipo de tarjeta militar</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                        <select class="form-control" id="military_card_type" name="military_card_type">
                                            <option value="" disabled selected>Seleccione un tipo</option>
                                            <option value="Primera clase">Primera Clase</option>
                                            <option value="Segunda clase">Segunda Clase</option>
                                            <option value ="No aplica">No aplica</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-muted">
                                        Tipo de tarjeta militar (Opcional)
                                    </small>
                                </div>

                                <!-- Distrito militar y Estado civil -->
                                <div class="col-md-6">
                                    <label for="military_district" class="form-label">Distrito Militar</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                                        <input type="text" class="form-control" id="military_district" name="military_district">

                                    </div>
                                    <small class="form-text text-muted">
                                        Distrito militar (Opcional)
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label for="military_district" class="form-label">Número de Tarjeta Militar</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input type="text" class="form-control" id="military_card_number" name="military_card_number">
                                    </div>
                                    <small class="form-text text-muted">
                                        Número Tarjeta Militar (Opcional)
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label for="marital_status" class="form-label">Estado Civil</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-heart"></i></span>
                                        <select class="form-select" id="marital_status" name="marital_status" >
                                            <option value="Soltero">Soltero</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Divorciado">Divorciado</option>
                                            <option value="Viudo">Viudo</option>
                                            <option value="Union libre">Unión libre</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-muted">
                                        Estado civil (Opcional)
                                    </small>
                                </div>

                                <!-- Tipo de documento del cónyuge -->
                                <div class="col-md-6">
                                    <label for="spouse_document_type" class="form-label">Tipo de Documento Cónyuge</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <select class="form-control" id="spouse_document_type" name="spouse_document_type">
                                            <option value="" disabled selected>Seleccione un tipo de documento</option>
                                            <option value="Cédula de Ciudadanía">Cédula de Ciudadanía</option>
                                            <option value="Cédula de Extranjería">Cédula de Extranjería</option>
                                            <option value="Pasaporte">Pasaporte</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-muted">
                                        Tipo de documento Cónyuge (Opcional)
                                    </small>
                                </div>


                                <!-- Documento del cónyuge -->
                                <div class="col-md-6">
                                    <label for="spouse_id_number" class="form-label">Documento del Cónyuge</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="spouse_id_number" name="spouse_id_number">

                                    </div>
                                    <small class="form-text text-muted">
                                        Documento del Cónyuge (Opcional)
                                    </small>
                                </div>

                                <!-- Primer nombre del cónyuge -->
                                <div class="col-md-6">
                                    <label for="spouse_first_name" class="form-label">Nombres del Cónyuge</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="spouse_first_name" name="spouse_first_name">

                                    </div>
                                    <small class="form-text text-muted">
                                        Primer nombre del cónyuge (Opcional)
                                    </small>
                                </div>


                                <!-- Apellido del cónyuge -->
                                <div class="col-md-6">
                                    <label for="spouse_last_name" class="form-label">Apellido del Cónyuge</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <input type="text" class="form-control" id="spouse_last_name" name="spouse_last_name">

                                    </div>
                                    <small class="form-text text-muted">
                                        Apellido del cónyuge (Opcional)
                                    </small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary prev-step">
                                    <i class="fas fa-arrow-left me-2"></i>Anterior
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Guardar Información
                                </button>
                            </div>
                        </div>

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
                                    <p>Tu información personal se ha guardado correctamente.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Error Modal -->
                    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="errorModalLabel">
                                        <i class="bi bi-exclamation-circle-fill me-2"></i>Error en el Formulario
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <p class="fs-4">
                                        <i class="bi bi-x-circle text-danger me-2" style="font-size: 3rem;"></i>
                                    </p>
                                    <h4>Por favor, corrige los siguientes errores:</h4>
                                    <div id="errorList" class="text-start mt-3">
                                        <!-- Los errores se insertarán aquí -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.getElementById('personalSave').addEventListener('submit', function (e) {
                            e.preventDefault();

                            // Array para almacenar los errores
                            const errors = [];

                            // Validar cédula (solo números, al menos 5 caracteres)
                            const cedula = document.getElementById('cedula');
                            if (!/^\d{5,}$/.test(cedula.value)) {
                                errors.push("La cédula debe contener solo números y al menos 5 dígitos");
                            }

                            // Validar tipo de documento
                            const documentType = document.getElementById('document_type');
                            if (!documentType.value) {
                                errors.push("Debes seleccionar un tipo de documento");
                            }

                            // Validar lugar de expedición
                            const placeOfIssue = document.getElementById('place_of_issue');
                            if (placeOfIssue.value.length < 2) {
                                errors.push("El lugar de expedición debe tener al menos 2 caracteres");
                            }

                            // Validar fecha de expedición
                            const dateOfIssue = document.getElementById('date_of_issue');
                            if (!dateOfIssue.value) {
                                errors.push("Debes seleccionar una fecha de expedición válida");
                            }

                            // Validar género
                            const gender = document.getElementById('gender');
                            if (!gender.value) {
                                errors.push("Debes seleccionar un género");
                            }

                            // Validar nacionalidad
                            const nationality = document.getElementById('nationality');
                            if (nationality.value.length < 2) {
                                errors.push("La nacionalidad debe tener al menos 2 caracteres");
                            }

                            // Validar primer nombre
                            const firstName = document.getElementById('first_name');
                            if (firstName.value.length < 2) {
                                errors.push("El primer nombre debe tener al menos 2 caracteres");
                            }

                            // Validar segundo nombre (opcional)
                            const middleName = document.getElementById('middle_name');
                            if (middleName.value && middleName.value.length < 2) {
                                errors.push("El segundo nombre, si se proporciona, debe tener al menos 2 caracteres");
                            }

                            // Validar apellido
                            const lastName = document.getElementById('last_name');
                            if (lastName.value.length < 2) {
                                errors.push("El apellido debe tener al menos 2 caracteres");
                            }

                            // Validar segundo apellido (opcional)
                            const secondLastName = document.getElementById('second_last_name');
                            if (secondLastName.value && secondLastName.value.length < 2) {
                                errors.push("El segundo apellido, si se proporciona, debe tener al menos 2 caracteres");
                            }

                            // Validar país de nacimiento
                            const birthCountry = document.getElementById('birth_country');
                            if (!birthCountry.value) {
                                errors.push("Debes seleccionar un país de nacimiento");
                            }

                            // Validar departamento de nacimiento
                            const birthDepartment = document.getElementById('birth_department');
                            if (!birthDepartment.value) {
                                errors.push("Debes seleccionar un departamento de nacimiento");
                            }

                            // Validar ciudad de nacimiento
                            const birthCity = document.getElementById('birth_city');
                            if (!birthCity.value) {
                                errors.push("Debes seleccionar una ciudad de nacimiento");
                            }

                            // Validar fecha de nacimiento
                            const birthDate = document.getElementById('birth_date');
                            if (!birthDate.value) {
                                errors.push("Debes proporcionar una fecha de nacimiento válida");
                            }

                            // Validar edad
                            const age = document.getElementById('age');
                            if (!/^\d+$/.test(age.value)) {
                                errors.push("La edad debe ser un número válido");
                            }

                            // Validar dirección
                            const address = document.getElementById('address');
                            if (address.value.length < 5) {
                                errors.push("La dirección debe tener al menos 5 caracteres");
                            }

                            // Validar teléfono (solo números, al menos 10 dígitos)
                            const phone = document.getElementById('phone');
                            if (!/^\d{10,}$/.test(phone.value)) {
                                errors.push("El teléfono debe contener solo números y al menos 10 dígitos");
                            }

                            // Validar móvil (solo números, al menos 10 dígitos)
                            const mobile = document.getElementById('mobile');
                            if (!/^\d{10,}$/.test(mobile.value)) {
                                errors.push("El móvil debe contener solo números y al menos 10 dígitos");
                            }

                            // Validar correo electrónico
                            const email = document.getElementById('email');
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!emailRegex.test(email.value)) {
                                errors.push("El correo electrónico no es válido");
                            }

                            // Validar tipo de tarjeta militar (opcional)
                            const militaryCardType = document.getElementById('military_card_type');
                            if (militaryCardType.value && militaryCardType.value.length < 2) {
                                errors.push("El tipo de tarjeta militar, si se proporciona, debe tener al menos 2 caracteres");
                            }

                            // Validar número de tarjeta militar (opcional, solo números)
                            const militaryCardNumber = document.getElementById('military_card_number');
                            if (militaryCardNumber.value && !/^\d+$/.test(militaryCardNumber.value)) {
                                errors.push("El número de tarjeta militar, si se proporciona, debe contener solo números");
                            }

                            // Validar distrito militar (opcional)
                            const militaryDistrict = document.getElementById('military_district');
                            if (militaryDistrict.value && militaryDistrict.value.length < 2) {
                                errors.push("El distrito militar, si se proporciona, debe tener al menos 2 caracteres");
                            }

                            // Validar estado civil
                            const maritalStatus = document.getElementById('marital_status');
                            if (!maritalStatus.value) {
                                errors.push("Debes seleccionar un estado civil");
                            }

                            // Validar tipo de documento del cónyuge (opcional)
                            const spouseDocumentType = document.getElementById('spouse_document_type');
                            if (spouseDocumentType.value && spouseDocumentType.value.length < 2) {
                                errors.push("El tipo de documento del cónyuge, si se proporciona, debe tener al menos 2 caracteres");
                            }

                            // Validar número de documento del cónyuge (opcional, solo números)
                            const spouseIdNumber = document.getElementById('spouse_id_number');
                            if (spouseIdNumber.value && !/^\d+$/.test(spouseIdNumber.value)) {
                                errors.push("El número de documento del cónyuge, si se proporciona, debe contener solo números");
                            }

                            // Validar nombre del cónyuge (opcional)
                            const spouseFirstName = document.getElementById('spouse_first_name');
                            if (spouseFirstName.value && spouseFirstName.value.length < 2) {
                                errors.push("El nombre del cónyuge, si se proporciona, debe tener al menos 2 caracteres");
                            }

                            // Validar apellido del cónyuge (opcional)
                            const spouseLastName = document.getElementById('spouse_last_name');
                            if (spouseLastName.value && spouseLastName.value.length < 2) {
                                errors.push("El apellido del cónyuge, si se proporciona, debe tener al menos 2 caracteres");
                            }

                            // Validar archivo de cédula (opcional, debe ser un archivo válido)
                            const cedulaFile = document.getElementById('cedula_file');
                            if (cedulaFile.files.length > 0) {
                                const file = cedulaFile.files[0];
                                if (file.size > 2 * 1024 * 1024) { // Limite de 2 MB
                                    errors.push("El archivo de cédula no debe superar los 2 MB");
                                }
                            }


                            // Validar país de correspondencia
                            const mailingCountry = document.getElementById('mailing_country');
                            if (!mailingCountry.value) {
                                errors.push("Debes seleccionar un país de correspondencia");
                            }

                            // Validar estado de correspondencia
                            const mailingState = document.getElementById('mailing_state');
                            if (!mailingState.value) {
                                errors.push("Debes seleccionar un estado de correspondencia");
                            }

                            // Validar ciudad de correspondencia
                            const mailingCity = document.getElementById('mailing_city');
                            if (!mailingCity.value) {
                                errors.push("Debes seleccionar una ciudad de correspondencia");
                            }

                            // Mostrar errores si existen
                            if (errors.length > 0) {
                                const errorList = document.getElementById('errorList');
                                errorList.innerHTML = errors.map(error => `<p class=\"mb-2\">• ${error}</p>`).join('');
                                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                                errorModal.show();
                                return;
                            }

                            // Si no hay errores, proceder con el envío
                            fetch('<?= base_url('index.php/user/personal-info/save') ?>', {
                                method: 'POST',
                                body: new FormData(this)
                            })
                                    .then(response => {
                                        if (response.ok) {
                                            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                                            successModal.show();
                                            successModal._element.addEventListener('hidden.bs.modal', function () {
                                                window.location.href = 'https://sgth.utede.com.co/index.php/user/menu';

                                            });
                                        } else {
                                            response.text().then(text => console.log(text));
                                            const errorList = document.getElementById('errorList');
                                            errorList.innerHTML = '<p class=\"mb-2\">• Hubo un error al procesar tu solicitud. Por favor, intenta nuevamente.</p>';
                                            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                                            errorModal.show();
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        const errorList = document.getElementById('errorList');
                                        errorList.innerHTML = '<p class=\"mb-2\">• Error de conexión. Por favor, verifica tu conexión a internet e intenta nuevamente.</p>';
                                        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                                        errorModal.show();
                                    });
                        });
                    </script>



                    <!-- Scripts de Bootstrap y jQuery -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>



                    <script>
                        // Variables para los pasos y botones
                        const steps = document.querySelectorAll('.form-step');
                        const stepIndicators = document.querySelectorAll('.step');
                        const nextBtns = document.querySelectorAll('.next-step');
                        const prevBtns = document.querySelectorAll('.prev-step');

                        let currentStep = 0;

                        // Mostrar el paso actual
                        function showStep(stepIndex) {
                            steps.forEach((step, index) => {
                                step.classList.toggle('active', index === stepIndex);
                            });
                            stepIndicators.forEach((indicator, index) => {
                                indicator.classList.toggle('active', index === stepIndex);
                            });
                        }

                        // Manejo del botón "Siguiente"
                        nextBtns.forEach(button => {
                            button.addEventListener('click', () => {
                                if (currentStep < steps.length - 1) {
                                    currentStep++;
                                    showStep(currentStep);
                                }
                            });
                        });

                        // Manejo del botón "Anterior"
                        prevBtns.forEach(button => {
                            button.addEventListener('click', () => {
                                if (currentStep > 0) {
                                    currentStep--;
                                    showStep(currentStep);
                                }
                            });
                        });

                        // Inicializar el formulario mostrando el primer paso
                        showStep(currentStep);
                    </script>

                    <script>
                        document.getElementById('birth_date').addEventListener('change', function () {
                            const birthDate = new Date(this.value); // Convertir fecha de nacimiento
                            const today = new Date(); // Obtener fecha actual

                            let age = today.getFullYear() - birthDate.getFullYear(); // Diferencia de años

                            // Ajuste basado en mes y día
                            if (
                                    today.getMonth() < birthDate.getMonth() ||
                                    (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())
                                    ) {
                                age--; // Restar 1 año si no ha llegado su cumpleaños
                            }

                            // Validar y asignar edad
                            document.getElementById('age').value = age >= 0 ? age : '';
                        });
                    </script>
                    <script>
                        document.getElementById('military_card_type').addEventListener('change', function () {
                            const districtField = document.getElementById('military_district');
                            const cardNumberField = document.getElementById('military_card_number');
                            if (this.value === 'No aplica') {
                                districtField.disabled = true;
                                districtField.value = ''; // Limpia el campo si se desactiva
                                cardNumberField.disabled = true;
                                cardNumberField.value = ''; // Limpia el campo si se desactiva
                            } else {
                                districtField.disabled = false;
                                cardNumberField.disabled = false;
                            }
                        });
                    </script>
                    <script>
                        document.getElementById('mailing_country').addEventListener('change', function () {
                            var country = this.value;

                            // Mostrar select si es Colombia, de lo contrario mostrar input
                            if (country === "Colombia") {
                                document.getElementById('mailing_state').style.display = 'block';
                                document.getElementById('mailing_state_input').style.display = 'none';
                                document.getElementById('mailing_city').style.display = 'block';
                                document.getElementById('mailing_city_input').style.display = 'none';
                            } else {
                                document.getElementById('mailing_state').style.display = 'none';
                                document.getElementById('mailing_state_input').style.display = 'block';
                                document.getElementById('mailing_city').style.display = 'none';
                                document.getElementById('mailing_city_input').style.display = 'block';
                            }
                        });
                    </script>

                    <script>
                        const municipios = {
                            "Valle del Cauca": [
                                "Cali", "Palmira", "Buenaventura", "Tuluá", "Buga", "Yumbo", "Candelaria",
                                "Roldanillo", "Cerrito", "El Águila", "La Victoria", "Obando", "Pradera", "Restrepo",
                                "Zarzal", "Versalles", "El Dovio", "Ginebra", "San Pedro", "Ansermanuevo", "Ginebra",
                                "Alcalá", "Dagua", "Florida", "La Unión", "Vijes", "La Cumbre", "El Cairo", "Riofrío",
                                "Andalucía", "El Cerrito", "Riofrío", "Alcalá", "Dagua", "Calima"
                                        // Agregar más municipios del Valle aquí
                            ],
                            "Antioquia": [
                                "Abejorral", "Abreo", "Amagá", "Andes", "Angostura", "Anorí", "Aparte", "Apartadó",
                                "Aranjuez", "Arboletes", "Barbosa", "Belmira", "Bello", "Betania", "Betulia", "Bucaramanga",
                                "Cáceres", "Caldas", "Campamento", "Carolina del Príncipe", "Caucasia", "Chigorodó", "Cisneros",
                                "Cocorná", "Concordia", "Copacabana", "Dabeiba", "Donmatías", "El Carmen de Viboral", "El Retiro",
                                "El Santuario", "Fredonia", "Giraldo", "Girardota", "Guarne", "Guatapé", "Heliconia", "La Ceja",
                                "La Estrella", "La Pintada", "Liborina", "Llanos de Cuivá", "Marinilla", "Medellín", "Montebello",
                                "Murindó", "Nechí", "Neiva", "Peñol", "Puerto Berrío", "Puerto Nare", "Rionegro", "San Andrés",
                                "San Carlos", "San Francisco", "San Jerónimo", "San José de la Montaña", "San Juan de Urabá",
                                "San Luis", "San Pedro de los Milagros", "San Vicente de Ferrer", "Sabaneta", "Santo Domingo",
                                "Segovia", "Sonson", "Valdivia", "Venecia", "Vélez"
                                        // Agregar más municipios de Antioquia aquí
                            ],
                            "Cundinamarca": [
                                "Agua de Dios", "Albán", "Anapoima", "Anolaima", "Apulo", "Arbeláez", "Beltrán", "Bituima",
                                "Bojacá", "Cabrera", "Cajicá", "Caparrapí", "Cáqueza", "Carmen de Carupa", "Chaguaní", "Chía",
                                "Chipaque", "Choachí", "Cicuy", "Cota", "El Colegio", "El Peñón", "El Rosal", "Facatativá",
                                "Fómeque", "Fosca", "Funza", "Fúquene", "Girardot", "Granada", "Guachetá", "Guaduas", "Guasca",
                                "Guataquí", "La Calera", "La Mesa", "La Palma", "La Vega", "Lenguazaque", "Macheta", "Madrid",
                                "Manta", "Mesitas del Colegio", "Mochales", "Montebello", "Mosquera", "Nariño", "Nemocón",
                                "Nilo", "Nocaima", "Pacho", "Pandi", "Paratebueno", "Pasca", "Puerto Salgar", "Pulí", "Quetame",
                                "Quipile", "Ricaurte", "San Antonio del Tequendama", "San Bernardo", "San Cayetano", "San Juan de Rioseco",
                                "Sasaima", "Sesquilé", "Sibaté", "Silvania", "Subachoque", "Suesca", "Supatá", "Tena", "Tenjo", "Tibasosa",
                                "Toca", "Tocancipá", "Topaipí", "Ubate", "Une", "Venecia", "Vianí", "Villagómez", "Villarica"
                            ],

                            "Atlántico": [
                                "Barranquilla", "Soledad", "Puerto Colombia", "Malambo", "Galapa", "Sabanalarga", "Baranoa",
                                "Juan de Acosta", "Luruaco", "Piohacha", "Sabanagrande", "Candelaria", "Cesar", "Suán"
                            ],
                            "Bolívar": [
                                "Cartagena", "Magangué", "Turbaná", "María la Baja", "Clemencia", "Santa Rosa", "San Juan Nepomuceno",
                                "Arjona", "Sincé", "Mompox", "El Carmen de Bolívar", "San Jacinto", "Barranco de Loba", "Regidor",
                                "Tiquisio", "San Basilio de Palenque"
                            ],
                            "Boyacá": [
                                "Tunja", "Duitama", "Sogamoso", "Paipa", "Chiquinquirá", "Villa de Leyva", "Tuta", "Nobsa", "Ramiriquí",
                                "Oicatá", "Mongua", "Santa Rosa de Viterbo", "Tibasosa", "Sutamarchán", "Vélez"
                            ],
                            "Caldas": [
                                "Manizales", "Chinchiná", "Neira", "Villamaría", "La Dorada", "Supía", "Riosucio", "San Félix",
                                "San José", "Marquetalia", "La Merced", "Viterbo", "Pensilvania", "Manzanares"
                            ],
                            "Caquetá": [
                                "Florencia", "San Vicente del Caguán", "Curillo", "Solano", "Puerto Rico", "Valparaíso", "La Montañita",
                                "Milán", "El Doncello", "Belén de los Andaquíes"
                            ],
                            "Casanare": [
                                "Yopal", "Aguazul", "Hato Corozal", "Tauramena", "Sácama", "Maní", "Villanueva", "Nunchía",
                                "Chámeza", "Támara", "La Salina", "Morichal", "Tauramena"
                            ],
                            "Cauca": [
                                "Popayán", "Santander de Quilichao", "Pasto", "Cauca", "El Tambo", "Patía", "La Vega", "Totoró",
                                "Piendamó", "Puracé", "Inzá", "Jambaló", "Mercaderes", "Almaguer"
                            ],
                            "Huila": [
                                "Neiva", "Pitalito", "La Plata", "Campoalegre", "Algeciras", "Elías", "Suaza", "Teruel", "Baraya"
                            ],
                            "La Guajira": [
                                "Riohacha", "Maicao", "Fonseca", "Albania", "Barrancas", "Hatonuevo", "Dibulla", "Distracción", "La Jagua del Pilar"
                            ],
                            "Magdalena": [
                                "Santa Marta", "Ciénaga", "Fundación", "Aracataca", "El Banco", "Santa Ana", "Pivijay", "Zona Bananera", "Chivolo"
                            ],
                            "Meta": [
                                "Villavicencio", "Acacías", "Restrepo", "Granada", "Puerto López", "Puerto Gaitán", "San Martín", "Cumaral", "Vista Hermosa"
                            ],
                            "Nariño": [
                                "Pasto", "Tumaco", "Ipiales", "Sandona", "Pupiales", "La Florida", "Taminango", "El Rosario", "Samaniego"
                            ],
                            "Norte de Santander": [
                                "Cúcuta", "Ocaña", "Villa del Rosario", "Los Patios", "La Playa", "Cúcuta", "Ragonvalia", "San Cayetano", "Bochalema"
                            ],
                            "Putumayo": [
                                "Mocoa", "Villagarzón", "Puerto Asís", "La Hormiga", "Orito", "San Francisco", "Santiago", "Los Andes", "Valle del Guamuez"
                            ],
                            "Quindío": [
                                "Armenia", "Montenegro", "Quimbaya", "Calarcá", "Salento", "Circasia", "Pijao", "La Tebaida", "Buenavista"
                            ],
                            "Risaralda": [
                                "Pereira", "Dosquebradas", "Santa Rosa de Cabal", "La Virginia", "Apía", "Marsella", "Balboa", "Santuario", "Belén de Umbría"
                            ],
                            "San Andrés y Providencia": [
                                "San Andrés", "Providencia"
                            ],
                            "Santander": [
                                "Bucaramanga", "Cúcuta", "Barrancabermeja", "Floridablanca", "Girón", "Piedecuesta", "Vélez", "Zapatoca", "Rionegro", "Málaga"
                            ],
                            "Sucre": [
                                "Sincelejo", "Corozal", "Sampués", "Montería", "Coveñas", "Morales", "Los Palmitos", "La Unión", "Sucre"
                            ],
                            "Tolima": [
                                "Ibagué", "Melgar", "Espinal", "Honda", "Flandes", "Mariquita", "Cajamarca", "Chaparral", "San Sebastián de Mariquita"
                            ],
                            "Cesar": [
                                "Valledupar", "Agustín Codazzi", "La Jagua de Ibirico", "Pailitas", "San Martín", "Gamarra", "Bosconia", "Chiriguaná", "La Paz"
                            ],
                            "Chocó": [
                                "Quibdó", "Medio Atrato", "Bajo Baudó", "Río Quito", "Condoto", "Bagadó", "Certeguí", "Istmina", "Nuquí"
                            ],
                            "Córdoba": [
                                "Montería", "Lorica", "Cereté", "Planeta Rica", "Montelíbano", "Tuchín", "San Bernardo del Viento", "San Antero", "Sahagún"
                            ],
                            "La Guajira": [
                                "Riohacha", "Maicao", "Fonseca", "Albania", "Barrancas", "Hatonuevo", "Dibulla", "Distracción", "La Jagua del Pilar"
                            ],
                            "Vaupés": [
                                "Mitú", "Carurú", "Taraira", "Pacoa", "Caucasia", "La Victoria", "Yavaraté"
                            ],
                            "Vichada": [
                                "Puerto Carreño", "La Primavera", "Cumaribo", "Santa Rosalía", "Pto. Rondón", "Venezuela"
                            ]






                                    // Puedes agregar más departamentos y sus municipios aquí
                        };

                        document.getElementById('mailing_country').addEventListener('change', function () {
                            const country = this.value;

                            // Mostrar select si es Colombia, de lo contrario mostrar input
                            if (country === "Colombia") {
                                document.getElementById('mailing_state').style.display = 'block';
                                document.getElementById('mailing_state_input').style.display = 'none';
                                document.getElementById('mailing_city').style.display = 'block';
                                document.getElementById('mailing_city_input').style.display = 'none';
                            } else {
                                document.getElementById('mailing_state').style.display = 'none';
                                document.getElementById('mailing_state_input').style.display = 'block';
                                document.getElementById('mailing_city').style.display = 'none';
                                document.getElementById('mailing_city_input').style.display = 'block';
                            }
                        });

                        document.getElementById('mailing_state').addEventListener('change', function () {
                            const selectedDepartment = this.value;
                            const citySelect = document.getElementById('mailing_city');

                            // Limpiar municipios previos
                            citySelect.innerHTML = '<option value="">Selecciona un municipio</option>';

                            if (municipios[selectedDepartment]) {
                                // Agregar los municipios correspondientes al departamento
                                municipios[selectedDepartment].forEach(function (municipio) {
                                    const option = document.createElement('option');
                                    option.value = municipio;
                                    option.textContent = municipio;
                                    citySelect.appendChild(option);
                                });
                            }
                        });
                    </script>




                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var birthCountrySelect = document.getElementById('birth_country');
                            var birthDepartmentSelect = document.getElementById('birth_department');
                            var birthCitySelect = document.getElementById('birth_city');

                            birthCountrySelect.addEventListener('change', function () {
                                var country = this.value;

                                if (country === "Colombia") {
                                    birthDepartmentSelect.style.display = 'block';
                                    birthCitySelect.style.display = 'block';
                                } else {
                                    birthDepartmentSelect.style.display = 'none';
                                    birthCitySelect.style.display = 'none';
                                }
                            });

                            birthDepartmentSelect.addEventListener('change', function () {
                                var department = this.value;

                                // Limpiar las opciones de ciudad anteriores
                                birthCitySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';

                                // Agregar nuevas opciones basadas en el departamento seleccionado
                                if (department && municipios[department]) {
                                    municipios[department].forEach(function (city) {
                                        var option = document.createElement('option');
                                        option.value = city;
                                        option.textContent = city;
                                        birthCitySelect.appendChild(option);
                                    });
                                }
                            });
                        });
                    </script>


                    <script>


                        document.addEventListener("DOMContentLoaded", function () {
                            // Evento para el cambio de país
                            document.getElementById('birth_country').addEventListener('change', function () {
                                var country = this.value;

                                if (country === "Colombia") {
                                    document.getElementById('birth_department_container').style.display = 'block';
                                    document.getElementById('birth_city_container').style.display = 'block';
                                } else {
                                    document.getElementById('birth_department_container').style.display = 'none';
                                    document.getElementById('birth_city_container').style.display = 'none';
                                }
                            });

                            // Evento para el cambio de departamento
                            document.getElementById('birth_department').addEventListener('change', function () {
                                var department = this.value;

                                // Limpiar las opciones de la ciudad
                                var citySelect = document.getElementById('birth_city');
                                citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';

                                // Agregar las ciudades correspondientes
                                if (department && municipios[department]) {
                                    municipios[department].forEach(function (city) {
                                        var option = document.createElement('option');
                                        option.value = city;
                                        option.textContent = city;
                                        citySelect.appendChild(option);
                                    });
                                }
                            });
                        });
                    </script>          


                    </body>

                    </html>