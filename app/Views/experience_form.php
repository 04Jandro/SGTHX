<?php include 'user_header.php'; ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario de Experiencia Laboral</title>

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
            .form-check{
                display:none;
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
                        <i class="fas fa-briefcase me-2"></i>Formulario de Experiencia Profesional
                    </h2>

                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step active">Experiencia Laboral</div>
                        <div class="step">Experiencia Docente</div>
                    </div>

                    <form id="experienceSave" action="experience/save" method="post" id="multiStepForm" enctype="multipart/form-data">
                        <!-- Step 1: Experiencia Laboral General -->
                        <div class="form-step active" id="step-1">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="cedula" class="form-label">Cédula</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input type="text" id="cedula" name="cedula" class="form-control" value="<?= esc($user_cedula) ?>" readonly>
                                    </div>
                                    <small class="form-text text-muted">
                                        Cédula (Obligatorio)
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="current_employer" class="form-label">Entidad o Empresa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        <input type="text" class="form-control" name="current_employer" id="current_employer" >
                                    </div>
                                    <small class="form-text text-muted">
                                        Obligatorio
                                    </small>
                                </div>
                                <!-- New select for Type of Company -->
                                <div class="col-md-6">
                                    <label for="company_type" class="form-label">Tipo de Empresa</label>
                                    <select name="company_type" id="company_type" class="form-select" >
                                        <option value="" disabled selected>Seleccione el tipo de empresa</option>
                                        <option value="Publica">Pública</option>
                                        <option value="Privada">Privada</option>
                                    </select>
                                    <small class="form-text text-muted">
                                        Obligatorio
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="is_current_job" class="form-label">¿Es empleo actual?</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        <select class="form-control" name="is_current_job" id="is_current_job" >
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="si" <?= isset($personalInfo['is_current_job']) && $personalInfo['is_current_job'] == 'si' ? 'selected' : '' ?>>Sí</option>
                                            <option value="no" <?= isset($personalInfo['is_current_job']) && $personalInfo['is_current_job'] == 'no' ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>

                                    <small class="form-text text-muted">
                                        Especifica si es un empleo actual (Ej: 'sí' o 'no')
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="country_employ" class="form-label">País</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                        <select id="country_employ" name="country_employ" class="form-select">
                                            <option value="" disabled selected>Selecciona un país</option>
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
                                        Obligatorio
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="department" class="form-label">Departamento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                                        <select id="department" name="department" class="form-select" disabled>
                                            <option value="" disabled selected>Selecciona un departamento</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-muted">
                                        Obligatorio
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="municipality" class="form-label">Municipio</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                                        <select id="municipality" name="municipality" class="form-select" disabled>
                                            <option value="" disabled selected>Selecciona un municipio</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-muted">
                                        Obligatorio
                                    </small>
                                </div>


                                <div class="col-md-6">
                                    <label for="phones" class="form-label">Teléfonos</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="text" class="form-control" name="phones" id="phones" >
                                    </div>
                                    <small class="form-text text-muted">
                                        Obligatorio
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="emails" class="form-label">Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="emails" class="form-control" name="emails" id="emails" >
                                    </div>
                                    <small class="form-text text-muted">
                                        Obligatorio
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">Fecha de Inicio</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control" name="start_date" id="start_date"  >
                                    </div>
                                    <small class="form-text text-muted">
                                        Obligatorio
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">Fecha de Fin</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control" name="end_date" id="end_date" >
                                    </div>
                                    <small class="form-text text-muted">
                                        Obligatorio
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="position" class="form-label">Cargo o Puesto</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                        <input type="text" class="form-control" name="position" id="position" >
                                    </div>
                                    <small class="form-text text-muted">
                                        Obligatorio
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="dependency" class="form-label">Dependencia o Unidad Administrativa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                                        <input type="text" class="form-control" name="dependency" id="dependency" >
                                    </div>
                                    <small class="form-text text-muted">
                                        Obligatorio
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="address" class="form-label">Dirección</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" class="form-control" name="address_employ" id="address_employ" >
                                    </div>
                                    <small class="form-text text-muted">
                                        Obligatorio
                                    </small>
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="verified" id="verified" disabled>
                                        <label class="form-check-label" for="verified">Verificado</label>
                                    </div>
                                </div>

                                <!-- Archivo del Certificado -->
                                <div class="col-12">
                                    <label for="workexperience_file" class="form-label">Certificado Laboral</label>
                                    <div class="input-group">
                                        <input type="file" id="workexperience_file" name="workexperience_file" 
                                               class="form-control" accept=".pdf,.doc,.docx,.png,.jpg">
                                        <span class="input-group-text"><i class="bi bi-upload"></i></span>
                                    </div>
                                    <small class="form-text text-muted">
                                        Formatos permitidos: PDF, DOC, DOCX, PNG, JPG (máximo 5MB)
                                    </small>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Guardar Información (en caso de no tener experiencia docente)
                                </button>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary next-step">
                                    Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>



                        <!-- Step 2: Experiencia Docente -->
                        <div class="form-step" id="step-2">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="educational_institution" class="form-label">Institución Educativa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-school"></i></span>
                                        <input type="text" class="form-control" name="educational_institution" id="educational_institution" >
                                    </div>

                                </div>


                                <div class="col-md-6">
                                    <label for="academic_level" class="form-label">Nivel Académico</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                        <input type="text" class="form-control" name="teaching_academic_level" id="academic_level" >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="teaching_area_of_knowledge" class="form-label">Área de Conocimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-book"></i></span>
                                        <input type="text" class="form-control" name="teaching_area_of_knowledge" id="area_of_knowledge" >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="country" class="form-label">País</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        <select class="form-control" name="country" id="country">
                                            <option value="" disabled selected>Selecciona un país</option>
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
                                        <!-- Agrega más opciones de países si es necesario -->
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <label for="teaching_start_date" class="form-label">Fecha de Inicio</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control" name="teaching_start_date" id="teaching_start_date" >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="teaching_end_date" class="form-label">Fecha de Fin</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control" name="teaching_end_date" id="teaching_end_date">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="teaching_verified" id="teaching_verified" disabled>
                                        <label class="form-check-label" for="teaching_verified">Verificado</label>
                                    </div>
                                </div>
                                <!-- Archivo del Certificado -->
                                <div class="col-12">
                                    <label for="certificate_file" class="form-label">Certificado Laboral Docente</label>
                                    <div class="input-group">
                                        <input type="file" id="teachingexperience_file" name="teachingexperience_file" 
                                               class="form-control" accept=".pdf,.doc,.docx,.png,.jpg">
                                        <span class="input-group-text"><i class="bi bi-upload"></i></span>
                                    </div>
                                    <small class="form-text text-muted">
                                        Formatos permitidos: PDF, DOC, DOCX, PNG, JPG (máximo 5MB)
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
                </div>
            </div>
        </div>

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
                        <p>Tu información de Experiencia profesional se ha guardado correctamente.</p>
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
            document.getElementById('experienceSave').addEventListener('submit', function (event) {
            event.preventDefault();
                    let errors = [];
                    // Validar cedula
                    const cedula = document.getElementById('cedula');
                    if (!/^\d+$/.test(cedula.value)) {
            errors.push("La cédula debe ser un número válido");
            }

            document.getElementById('experienceSave').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevenir el envío del formulario

                    // Array para almacenar los errores
                    const errors = [];
                    // Validar current_employer
                    const currentEmployer = document.getElementById('current_employer');
                    if (currentEmployer.value.length < 1) {
            errors.push("El empleador actual no puede estar vacío");
            } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(currentEmployer.value)) {
            errors.push("El empleador actual solo puede contener letras y espacios");
            }

            // Validar otros campos de experiencia laboral (si es necesario)

            // Si existen errores, mostrar el modal de error
            if (errors.length > 0) {
            const errorList = document.getElementById('errorList');
                    errorList.innerHTML = errors.map(error => `<p class="mb-2">• ${error}</p>`).join('');
                    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    errorModal.show();
                    return; // No enviar el formulario
            }

            // Crear el objeto FormData
            const formData = new FormData(this);
                    // Si current_employer está vacío, eliminar los datos de work_experience
                    if (currentEmployer.value.length < 1) {
            formData.delete('work_experience'); // Elimina el campo work_experience si current_employer está vacío
            }

            // Enviar la información de experiencia (ya sea teaching_work_experience o work_experience)
            fetch('<?= base_url('index.php/user/experience/save') ?>', {
            method: 'POST',
                    body: formData
            })
                    .then(response => {
                    if (response.ok) {
                    // Mostrar el modal de éxito
                    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                            successModal.show();
                            successModal._element.addEventListener('hidden.bs.modal', function () {
                            // Redirigir a la página deseada (por ejemplo, a experience-info)
                            window.location.href = 'experience-info'; // Redirigir a la página experience-info
                            });
                    } else {
                    // Manejo de errores si la respuesta no es exitosa
                    const errorList = document.getElementById('errorList');
                            errorList.innerHTML = '<p class="mb-2">• Hubo un error al procesar tu solicitud. Por favor, intenta nuevamente.</p>';
                            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                            errorModal.show();
                            response.text().then(text => console.log(text));
                    }
                    })
                    .catch(error => {
                    console.error('Error:', error);
                            const errorList = document.getElementById('errorList');
                            errorList.innerHTML = '<p class="mb-2">• Error de conexión. Por favor, verifica tu conexión a internet e intenta nuevamente.</p>';
                            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                            errorModal.show();
                    });
                    });
        </script>


        <!-- Scripts de Bootstrap y jQuery -->




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
                            document.getElementById('country_employ').addEventListener('change', function () {
                    const country = this.value;
                            const departmentSelect = document.getElementById('department');
                            const municipalitySelect = document.getElementById('municipality');
                            // Limpia los campos de departamento y municipio
                            departmentSelect.innerHTML = '<option value="" disabled selected>Selecciona un departamento</option>';
                            municipalitySelect.innerHTML = '<option value="" disabled selected>Selecciona un municipio</option>';
                            // Deshabilita los campos si el país no es Colombia
                            if (country !== "Colombia") {
                    departmentSelect.disabled = true;
                            municipalitySelect.disabled = true;
                            return; // Sale de la función si el país no es Colombia
                    }

                    // Habilita el campo de departamento
                    departmentSelect.disabled = false;
                            // Datos de ejemplo para departamentos y municipios (puedes obtenerlos de un servidor o API)
                            const data = {
                            "Colombia": {
                            "departments": [
                                    "Antioquia", "Cundinamarca", "Valle del Cauca", "Atlántico", "Bolívar", "Boyacá", "Caldas", "Caquetá",
                                    "Casanare", "Cauca", "Huila", "La Guajira", "Magdalena", "Meta", "Nariño", "Norte de Santander", "Putumayo",
                                    "Quindío", "Risaralda", "San Andrés y Providencia", "Santander", "Sucre", "Tolima", "Cesar", "Chocó",
                                    "Córdoba", "Vaupés", "Vichada"
                            ],
                                    "municipalities": {
                                    "Valle del Cauca": [
                                            "Cali", "Palmira", "Buenaventura", "Tuluá", "Buga", "Yumbo", "Candelaria", "Roldanillo", "Cerrito",
                                            "El Águila", "La Victoria", "Obando", "Pradera", "Restrepo", "Zarzal", "Versalles", "El Dovio",
                                            "Ginebra", "San Pedro", "Ansermanuevo", "Alcalá", "Dagua", "Florida", "La Unión", "Vijes", "La Cumbre",
                                            "El Cairo", "Riofrío", "Andalucía"
                                    ],
                                            "Antioquia": [
                                                    "Abejorral", "Abreo", "Amagá", "Andes", "Angostura", "Anorí", "Aparte", "Apartadó", "Aranjuez", "Arboletes",
                                                    "Barbosa", "Belmira", "Bello", "Betania", "Betulia", "Bucaramanga", "Cáceres", "Caldas", "Campamento",
                                                    "Carolina del Príncipe", "Caucasia", "Chigorodó", "Cisneros", "Cocorná", "Concordia", "Copacabana", "Dabeiba",
                                                    "Donmatías", "El Carmen de Viboral", "El Retiro", "El Santuario", "Fredonia", "Giraldo", "Girardota", "Guarne",
                                                    "Guatapé", "Heliconia", "La Ceja", "La Estrella", "La Pintada", "Liborina", "Llanos de Cuivá", "Marinilla",
                                                    "Medellín", "Montebello", "Murindó", "Nechí", "Neiva", "Peñol", "Puerto Berrío", "Puerto Nare", "Rionegro",
                                                    "San Andrés", "San Carlos", "San Francisco", "San Jerónimo", "San José de la Montaña", "San Juan de Urabá",
                                                    "San Luis", "San Pedro de los Milagros", "San Vicente de Ferrer", "Sabaneta", "Santo Domingo", "Segovia",
                                                    "Sonson", "Valdivia", "Venecia", "Vélez"
                                            ],
                                            "Cundinamarca": [
                                                    "Agua de Dios", "Albán", "Anapoima", "Anolaima", "Apulo", "Arbeláez", "Beltrán", "Bituima", "Bojacá",
                                                    "Cabrera", "Cajicá", "Caparrapí", "Cáqueza", "Carmen de Carupa", "Chaguaní", "Chía", "Chipaque", "Choachí",
                                                    "Cicuy", "Cota", "El Colegio", "El Peñón", "El Rosal", "Facatativá", "Fómeque", "Fosca", "Funza", "Fúquene",
                                                    "Girardot", "Granada", "Guachetá", "Guaduas", "Guasca", "Guataquí", "La Calera", "La Mesa", "La Palma",
                                                    "La Vega", "Lenguazaque", "Macheta", "Madrid", "Manta", "Mesitas del Colegio", "Mochales", "Montebello",
                                                    "Mosquera", "Nariño", "Nemocón", "Nilo", "Nocaima", "Pacho", "Pandi", "Paratebueno", "Pasca", "Puerto Salgar",
                                                    "Pulí", "Quetame", "Quipile", "Ricaurte", "San Antonio del Tequendama", "San Bernardo", "San Cayetano",
                                                    "San Juan de Rioseco", "Sasaima", "Sesquilé", "Sibaté", "Silvania", "Subachoque", "Suesca", "Supatá", "Tena",
                                                    "Tenjo", "Tibasosa", "Toca", "Tocancipá", "Topaipí", "Ubate", "Une", "Venecia", "Vianí", "Villagómez", "Villarica"
                                            ],
                                            "Atlántico": [
                                                    "Barranquilla", "Soledad", "Puerto Colombia", "Malambo", "Galapa", "Sabanalarga", "Baranoa", "Juan de Acosta",
                                                    "Luruaco", "Piohacha", "Sabanagrande", "Candelaria", "Cesar", "Suán"
                                            ],
                                            "Bolívar": [
                                                    "Cartagena", "Magangué", "Turbaná", "María la Baja", "Clemencia", "Santa Rosa", "San Juan Nepomuceno", "Arjona",
                                                    "Sincé", "Mompox", "El Carmen de Bolívar", "San Jacinto", "Barranco de Loba", "Regidor", "Tiquisio",
                                                    "San Basilio de Palenque"
                                            ],
                                            "Boyacá": [
                                                    "Tunja", "Duitama", "Sogamoso", "Paipa", "Chiquinquirá", "Villa de Leyva", "Tuta", "Nobsa", "Ramiriquí",
                                                    "Oicatá", "Mongua", "Santa Rosa de Viterbo", "Tibasosa", "Sutamarchán", "Vélez"
                                            ],
                                            "Caldas": [
                                                    "Manizales", "Chinchiná", "Neira", "Villamaría", "La Dorada", "Supía", "Riosucio", "San Félix", "San José",
                                                    "Marquetalia", "La Merced", "Viterbo", "Pensilvania", "Manzanares"
                                            ],
                                            "Caquetá": [
                                                    "Florencia", "San Vicente del Caguán", "Curillo", "Solano", "Puerto Rico", "Valparaíso", "La Montañita",
                                                    "Milán", "El Doncello", "Belén de los Andaquíes"
                                            ],
                                            "Casanare": [
                                                    "Yopal", "Aguazul", "Hato Corozal", "Tauramena", "Sácama", "Maní", "Villanueva", "Nunchía", "Chámeza",
                                                    "Támara", "La Salina", "Morichal", "Tauramena"
                                            ],
                                            "Cauca": [
                                                    "Popayán", "Santander de Quilichao", "Pasto", "Cauca", "El Tambo", "Patía", "La Vega", "Totoró", "Piendamó",
                                                    "Puracé", "Inzá", "Jambaló", "Mercaderes", "Almaguer"
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
                                                    "Villavicencio", "Acacías", "Restrepo", "Granada", "Puerto López", "Puerto Gaitán", "San Martín", "Cumaral",
                                                    "Vista Hermosa"
                                            ],
                                            "Nariño": [
                                                    "Pasto", "Tumaco", "Ipiales", "Sandona", "Pupiales", "La Florida", "Taminango", "El Rosario", "Samaniego"
                                            ],
                                            "Norte de Santander": [
                                                    "Cúcuta", "Ocaña", "Villa del Rosario", "Los Patios", "La Playa", "Cúcuta", "Ragonvalia", "San Cayetano",
                                                    "Bochalema"
                                            ],
                                            "Putumayo": [
                                                    "Mocoa", "Villagarzón", "Puerto Asís", "La Hormiga", "Orito", "San Francisco", "Santiago", "Los Andes",
                                                    "Valle del Guamuez"
                                            ],
                                            "Quindío": [
                                                    "Armenia", "Montenegro", "Quimbaya", "Calarcá", "Salento", "Circasia", "Pijao", "La Tebaida", "Buenavista"
                                            ],
                                            "Risaralda": [
                                                    "Pereira", "Dosquebradas", "Santa Rosa de Cabal", "La Virginia", "Apía", "Marsella", "Balboa", "Santuario",
                                                    "Belén de Umbría"
                                            ],
                                            "San Andrés y Providencia": [
                                                    "San Andrés", "Providencia"
                                            ],
                                            "Santander": [
                                                    "Bucaramanga", "Cúcuta", "Barrancabermeja", "Floridablanca", "Girón", "Piedecuesta", "Málaga", "Vélez"
                                            ],
                                            "Sucre": [
                                                    "Sincelejo", "Corozal", "Sampués", "Chalán", "Ovejas", "San Benito Abad", "Morroa", "San Marcos",
                                                    "Los Palmitos"
                                            ],
                                            "Tolima": [
                                                    "Ibagué", "Espinal", "Flandes", "Melgar", "Honda", "Chaparral", "Líbano", "Alvarado", "Mariquita", "Armero"
                                            ],
                                            "Cesar": [
                                                    "Valledupar", "Aguachica", "La Paz", "Becerril", "El Copey", "Codazzi", "Pueblo Bello", "San Diego"
                                            ]
                                    }
                            }
                            };
                            if (data[country]) {
                    // Agregar departamentos al select
                    data[country].departments.forEach(function (department) {
                    const option = document.createElement('option');
                            option.value = department;
                            option.textContent = department;
                            departmentSelect.appendChild(option);
                    });
                            // Habilitar el campo de municipios cuando se seleccione un departamento
                            departmentSelect.addEventListener('change', function () {
                            const department = this.value;
                                    municipalitySelect.innerHTML = '<option value="" disabled selected>Selecciona un municipio</option>';
                                    if (data[country].municipalities[department]) {
                            data[country].municipalities[department].forEach(function (municipality) {
                            const option = document.createElement('option');
                                    option.value = municipality;
                                    option.textContent = municipality;
                                    municipalitySelect.appendChild(option);
                            });
                                    municipalitySelect.disabled = false; // Habilitar el campo municipio
                            }
                            });
                    }
                    });
        </script>

    </body>
</html>