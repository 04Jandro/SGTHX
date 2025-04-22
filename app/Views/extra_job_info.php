<?php echo view('user_header'); ?>

<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white py-3">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                <h2 class="mb-0 text-center">
                    <i class="bi bi-briefcase-fill me-2"></i>Información de Experiencia Laboral
                </h2>
            </div>
            <div class="card-body p-4">
                <form id="workExperienceForm" action="<?= base_url('index.php/user/extra-job-info/save') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="row g-4">
                        <!-- Public Sector Experience -->
                        <div class="col-md-4">
                            <div class="card h-100 border-primary">
                                <div class="card-header bg-primary-subtle">
                                    <h4 class="card-title text-primary mb-0">
                                        <i class="bi bi-building me-2"></i>Experiencia en el Sector Público
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label for="public_servant_years" class="form-label">Años</label>
                                            <input type="number" class="form-control" name="public_servant_years" id="public_servant_years" 
                                                   value="<?= isset($experience['public_servant_years']) ? $experience['public_servant_years'] : '' ?>" 
                                                   min="0" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="public_servant_months" class="form-label">Meses</label>
                                            <input type="number" class="form-control" name="public_servant_months" id="public_servant_months" 
                                                   value="<?= isset($experience['public_servant_months']) ? $experience['public_servant_months'] : '' ?>" 
                                                   min="0" max="11" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Private Sector Experience -->
                        <div class="col-md-4">
                            <div class="card h-100 border-success">
                                <div class="card-header bg-success-subtle">
                                    <h4 class="card-title text-success mb-0">
                                        <i class="bi bi-briefcase me-2"></i>Experiencia en el Sector Privado
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label for="private_sector_years" class="form-label">Años</label>
                                            <input type="number" class="form-control" name="private_sector_years" id="private_sector_years" 
                                                   value="<?= isset($experience['private_sector_years']) ? $experience['private_sector_years'] : '' ?>" 
                                                   min="0" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="private_sector_months" class="form-label">Meses</label>
                                            <input type="number" class="form-control" name="private_sector_months" id="private_sector_months" 
                                                   value="<?= isset($experience['private_sector_months']) ? $experience['private_sector_months'] : '' ?>" 
                                                   min="0" max="11" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Independent Worker Experience -->
                        <div class="col-md-4">
                            <div class="card h-100 border-warning">
                                <div class="card-header bg-warning-subtle">
                                    <h4 class="card-title text-warning mb-0">
                                        <i class="bi bi-person-workspace me-2"></i>Experiencia como Trabajador Independiente
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label for="independent_worker_years" class="form-label">Años</label>
                                            <input type="number" class="form-control" name="independent_worker_years" id="independent_worker_years" 
                                                   value="<?= isset($experience['independent_worker_years']) ? $experience['independent_worker_years'] : '' ?>" 
                                                   min="0" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="independent_worker_months" class="form-label">Meses</label>
                                            <input type="number" class="form-control" name="independent_worker_months" id="independent_worker_months" 
                                                   value="<?= isset($experience['independent_worker_months']) ? $experience['independent_worker_months'] : '' ?>" 
                                                   min="0" max="11" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Experience -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card border-dark">
                                <div class="card-header bg-dark text-white">
                                    <h4 class="mb-0 text-center">
                                        <i class="bi bi-clock-history me-2"></i>Experiencia Total
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3 justify-content-center">
                                        <div class="col-md-4">
                                            <label for="total_years" class="form-label">Años Totales</label>
                                            <input type="number" class="form-control" name="total_years" id="total_years" 
                                                   value="<?= isset($experience['total_years']) ? $experience['total_years'] : '' ?>" 
                                                   readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="total_months" class="form-label">Meses Totales</label>
                                            <input type="number" class="form-control" name="total_months" id="total_months" 
                                                   value="<?= isset($experience['total_months']) ? $experience['total_months'] : '' ?>" 
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg shadow">
                            <i class="bi bi-save me-2"></i>Guardar o Actualizar Experiencia Laboral
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="bi bi-check-circle-fill me-2"></i>Éxito
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fs-4">
                    <i class="bi bi-clipboard-check text-success me-2" style="font-size: 3rem;"></i>
                </p>
                <h4>Experiencia Laboral Guardada</h4>
                <p>Tu información de experiencia laboral se ha guardado correctamente.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 CSS and JS, and Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function calculateTotalExperience() {
        const publicServantYears = parseInt(document.getElementById('public_servant_years').value) || 0;
        const publicServantMonths = parseInt(document.getElementById('public_servant_months').value) || 0;
        const privateSectorYears = parseInt(document.getElementById('private_sector_years').value) || 0;
        const privateSectorMonths = parseInt(document.getElementById('private_sector_months').value) || 0;
        const independentWorkerYears = parseInt(document.getElementById('independent_worker_years').value) || 0;
        const independentWorkerMonths = parseInt(document.getElementById('independent_worker_months').value) || 0;

        let totalYears = publicServantYears + privateSectorYears + independentWorkerYears;
        let totalMonths = publicServantMonths + privateSectorMonths + independentWorkerMonths;

        // Convert months to years if 12 or more
        totalYears += Math.floor(totalMonths / 12);
        totalMonths = totalMonths % 12;

        document.getElementById('total_years').value = totalYears;
        document.getElementById('total_months').value = totalMonths;
    }

    // Add event listeners for total experience calculation
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', calculateTotalExperience);
    });

    // Handle form submission to show success modal
    document.getElementById('workExperienceForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        // Here you would typically add AJAX form submission
        // For this example, we'll simulate a successful submission
        fetch('<?= base_url('index.php/user/extra-job-info/save') ?>', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => {
            if (response.ok) {
                // Show success modal
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            } else {
                // Handle error (you might want to show an error modal instead)
                alert('Hubo un error al guardar la información');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al guardar la información');
        });
    });
</script>